<?php
/**
 * REST API Submission & Editor's Desk Handler
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register REST routes for community submissions and authenticated editorial workflow.
 */
function valley_indian_register_submission_route() {
	register_rest_route( 'valley-indian/v1', '/submit', array(
		'methods'             => 'POST',
		'callback'            => 'valley_indian_handle_story_submission',
		'permission_callback' => '__return_true',
	) );

	register_rest_route( 'valley-indian/v1', '/desk', array(
		'methods'             => 'GET',
		'callback'            => 'valley_indian_get_desk_state',
		'permission_callback' => function() {
			return current_user_can( 'edit_others_posts' );
		},
	) );

	register_rest_route( 'valley-indian/v1', '/desk/decide', array(
		'methods'             => 'POST',
		'callback'            => 'valley_indian_desk_decide',
		'permission_callback' => function() {
			return current_user_can( 'edit_others_posts' );
		},
	) );

	register_rest_route( 'valley-indian/v1', '/desk/import', array(
		'methods'             => 'POST',
		'callback'            => 'valley_indian_desk_import',
		'permission_callback' => function() {
			return current_user_can( 'edit_others_posts' );
		},
	) );
}
add_action( 'rest_api_init', 'valley_indian_register_submission_route' );

/**
 * Append entry to editorial audit option.
 */
function valley_indian_record_audit( $action, $title, $notes = '' ) {
	$log = get_option( 'vip_audit_log', array() );
	if ( ! is_array( $log ) ) {
		$log = array();
	}
	$log[] = array(
		'action' => sanitize_text_field( $action ),
		'title'  => sanitize_text_field( $title ),
		'notes'  => sanitize_textarea_field( $notes ),
		'time'   => gmdate( 'Y-m-d\TH:i:s\Z' ),
	);
	if ( count( $log ) > 100 ) {
		$log = array_slice( $log, -100 );
	}
	update_option( 'vip_audit_log', $log, false );
}

/**
 * Handle public community submissions (stories, businesses, events, corrections, subscribers, inquiries).
 */
function valley_indian_handle_story_submission( $request ) {
	$params = $request->get_json_params();
	if ( ! is_array( $params ) ) {
		$params = $request->get_params();
	}

	// Honeypot check
	if ( ! empty( $params['website'] ) ) {
		return new WP_Error( 'spam_rejected', __( 'Submission rejected.', 'valley-indian' ), array( 'status' => 400 ) );
	}

	$raw_type = isset( $params['type'] ) ? sanitize_text_field( $params['type'] ) : 'stories';
	$type_map = array(
		'story'      => 'stories',
		'stories'    => 'stories',
		'correction' => 'correction',
		'business'   => 'businesses',
		'businesses' => 'businesses',
		'event'      => 'events',
		'events'     => 'events',
		'subscriber' => 'subscribers',
		'subscribers'=> 'subscribers',
		'inquiry'    => 'inquiries',
		'inquiries'  => 'inquiries',
	);
	$kind = isset( $type_map[ $raw_type ] ) ? $type_map[ $raw_type ] : 'stories';

	$email = isset( $params['email'] ) ? sanitize_email( strtolower( trim( (string) $params['email'] ) ) ) : '';
	if ( ! is_email( $email ) ) {
		return new WP_Error( 'invalid_email', __( 'Please enter a valid email address.', 'valley-indian' ), array( 'status' => 400 ) );
	}

	// Consent validation for subscribers and public submissions (except ad inquiry where consent box isn't rendered)
	if ( in_array( $kind, array( 'stories', 'correction', 'businesses', 'events', 'subscribers' ), true ) ) {
		$consent = isset( $params['consent'] ) ? $params['consent'] : false;
		if ( ! in_array( $consent, array( true, 'true', 'on', '1', 1 ), true ) ) {
			return new WP_Error( 'consent_required', __( 'Permission consent is required.', 'valley-indian' ), array( 'status' => 400 ) );
		}
	}

	// Newsletter subscription request
	if ( 'subscribers' === $kind ) {
		$post_id = wp_insert_post( array(
			'post_title'  => $email,
			'post_status' => 'pending',
			'post_type'   => 'vip_subscriber',
			'post_author' => 1,
		), true );

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'insert_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
		}

		update_post_meta( $post_id, '_contact_email', $email );
		update_post_meta( $post_id, '_consent_recorded', '1' );

		return rest_ensure_response( array(
			'success' => true,
			'message' => __( 'Subscription request recorded. Email service is pending connection.', 'valley-indian' ),
			'post_id' => $post_id,
		) );
	}

	$title    = isset( $params['title'] ) ? sanitize_text_field( wp_strip_all_tags( (string) $params['title'] ) ) : '';
	$body     = isset( $params['body'] ) ? sanitize_textarea_field( (string) $params['body'] ) : '';
	$area     = isset( $params['area'] ) ? sanitize_text_field( (string) $params['area'] ) : 'Clark County';
	$category = isset( $params['category'] ) ? sanitize_text_field( (string) $params['category'] ) : 'Community';
	$url      = isset( $params['url'] ) ? trim( (string) $params['url'] ) : '';

	if ( empty( $title ) || empty( $body ) ) {
		return new WP_Error( 'missing_fields', __( 'Title and details are required.', 'valley-indian' ), array( 'status' => 400 ) );
	}

	if ( ! empty( $url ) ) {
		$scheme = wp_parse_url( $url, PHP_URL_SCHEME );
		if ( ! in_array( strtolower( (string) $scheme ), array( 'http', 'https' ), true ) ) {
			return new WP_Error( 'invalid_url', __( 'Use a valid http or https URL.', 'valley-indian' ), array( 'status' => 400 ) );
		}
		$url = esc_url_raw( $url );
	}

	// Advertising inquiry
	if ( 'inquiries' === $kind ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => wp_kses_post( wpautop( $body ) ),
			'post_status'  => 'pending',
			'post_type'    => 'vip_inquiry',
			'post_author'  => 1,
		), true );

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'insert_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
		}

		update_post_meta( $post_id, '_contact_email', $email );
		update_post_meta( $post_id, '_placement_interest', $category );

		return rest_ensure_response( array(
			'success' => true,
			'message' => __( 'Inquiry recorded for review. No email sent.', 'valley-indian' ),
			'post_id' => $post_id,
		) );
	}

	// Map public content post types
	$post_type = 'post';
	$excerpt   = wp_trim_words( $body, 28, '…' );

	if ( 'businesses' === $kind ) {
		$allowed_cats = array( 'Physicians', 'Attorneys', 'Accountants', 'Other businesses' );
		if ( ! in_array( $category, $allowed_cats, true ) ) {
			return new WP_Error( 'invalid_category', __( 'Select a valid business category.', 'valley-indian' ), array( 'status' => 400 ) );
		}
		$specialty = isset( $params['specialty'] ) ? sanitize_text_field( (string) $params['specialty'] ) : '';
		if ( empty( $specialty ) ) {
			return new WP_Error( 'missing_specialty', __( 'Specialty or service is required for businesses.', 'valley-indian' ), array( 'status' => 400 ) );
		}
		$post_type = 'directory_listing';
	} elseif ( 'events' === $kind ) {
		$event_date  = isset( $params['date'] ) ? sanitize_text_field( (string) $params['date'] ) : '';
		$event_venue = isset( $params['venue'] ) ? sanitize_text_field( (string) $params['venue'] ) : '';
		if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $event_date ) ) {
			return new WP_Error( 'invalid_date', __( 'Valid event date (YYYY-MM-DD) is required.', 'valley-indian' ), array( 'status' => 400 ) );
		}
		$post_type = 'event';
	}

	$post_id = wp_insert_post( array(
		'post_title'   => $title,
		'post_content' => wp_kses_post( wpautop( $body ) ),
		'post_excerpt' => $excerpt,
		'post_status'  => 'pending',
		'post_type'    => $post_type,
		'post_author'  => 1,
	), true );

	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'insert_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
	}

	// Taxonomies & Meta
	update_post_meta( $post_id, '_contact_email', $email );
	update_post_meta( $post_id, '_sample_content', false );
	if ( ! empty( $url ) ) {
		update_post_meta( $post_id, '_source_url', $url );
	}
	if ( ! empty( $area ) ) {
		wp_set_object_terms( $post_id, $area, 'area' );
	}

	if ( 'directory_listing' === $post_type ) {
		wp_set_object_terms( $post_id, $category, 'directory_category' );
		update_post_meta( $post_id, '_business_specialty', sanitize_text_field( (string) $params['specialty'] ) );
	} elseif ( 'event' === $post_type ) {
		update_post_meta( $post_id, '_event_date', $event_date );
		update_post_meta( $post_id, '_event_venue', $event_venue );
		$ts = strtotime( $event_date . ' 12:00:00' );
		if ( $ts ) {
			update_post_meta( $post_id, '_event_day', gmdate( 'd', $ts ) );
			update_post_meta( $post_id, '_event_month', gmdate( 'M', $ts ) );
		}
		if ( ! empty( $event_venue ) ) {
			update_post_meta( $post_id, '_event_location', $event_venue );
		}
	} else {
		$cat_name = ( 'correction' === $kind ) ? 'Correction' : $category;
		$term     = get_term_by( 'name', $cat_name, 'category' );
		if ( ! $term ) {
			$new_cat = wp_insert_term( $cat_name, 'category' );
			$cat_id  = ( ! is_wp_error( $new_cat ) ) ? $new_cat['term_id'] : 0;
		} else {
			$cat_id = $term->term_id;
		}
		if ( $cat_id ) {
			wp_set_post_categories( $post_id, array( $cat_id ) );
		}
		update_post_meta( $post_id, '_submission_kind', 'Original' );
		update_post_meta( $post_id, '_is_court_record', ( 'Public records' === $cat_name ) );
	}

	return rest_ensure_response( array(
		'success' => true,
		'message' => __( 'Submitted for editorial review. Nothing has been published.', 'valley-indian' ),
		'post_id' => $post_id,
	) );
}

/**
 * Serialize a post row safely for the authenticated Editor's Desk.
 */
function valley_indian_serialize_desk_post( $post, $kind ) {
	$areas = wp_get_object_terms( $post->ID, 'area', array( 'fields' => 'names' ) );
	$area  = ( ! is_wp_error( $areas ) && ! empty( $areas ) ) ? $areas[0] : 'Clark County';
	$cats  = ( 'directory_listing' === $post->post_type )
		? wp_get_object_terms( $post->ID, 'directory_category', array( 'fields' => 'names' ) )
		: wp_get_post_categories( $post->ID, array( 'fields' => 'names' ) );
	$cat   = ( ! is_wp_error( $cats ) && ! empty( $cats ) ) ? $cats[0] : '';

	return array(
		'id'       => $post->ID,
		'kind'     => $kind,
		'title'    => $post->post_title,
		'body'     => wp_strip_all_tags( $post->post_content ),
		'status'   => $post->post_status,
		'category' => $cat,
		'area'     => $area,
		'email'    => get_post_meta( $post->ID, '_contact_email', true ),
		'url'      => get_post_meta( $post->ID, '_source_url', true ),
		'court'    => (bool) get_post_meta( $post->ID, '_is_court_record', true ) || ( 'Public records' === $cat ),
		'sample'   => (bool) get_post_meta( $post->ID, '_sample_content', true ),
		'date'     => get_post_meta( $post->ID, '_event_date', true ),
		'venue'    => get_post_meta( $post->ID, '_event_venue', true ),
		'specialty'=> get_post_meta( $post->ID, '_business_specialty', true ),
	);
}

/**
 * Authenticated GET /desk endpoint returning pending & published editorial queues.
 */
function valley_indian_get_desk_state() {
	$map = array(
		'stories'     => 'post',
		'businesses'  => 'directory_listing',
		'events'      => 'event',
		'subscribers' => 'vip_subscriber',
		'inquiries'   => 'vip_inquiry',
	);

	$out = array(
		'authenticated' => true,
		'stories'       => array(),
		'comments'      => array(),
		'businesses'    => array(),
		'events'        => array(),
		'subscribers'   => array(),
		'inquiries'     => array(),
		'log'           => get_option( 'vip_audit_log', array() ),
	);

	foreach ( $map as $key => $ptype ) {
		$rows = get_posts( array(
			'post_type'      => $ptype,
			'post_status'    => array( 'pending', 'publish' ),
			'posts_per_page' => 50,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		foreach ( $rows as $row ) {
			$out[ $key ][] = valley_indian_serialize_desk_post( $row, $key );
		}
	}

	$comments = get_comments( array(
		'status' => array( 'hold', 'approve' ),
		'number' => 50,
	) );
	foreach ( $comments as $c ) {
		$out['comments'][] = array(
			'id'     => (int) $c->comment_ID,
			'story'  => (int) $c->comment_post_ID,
			'name'   => $c->comment_author,
			'text'   => $c->comment_content,
			'status' => ( '1' === (string) $c->comment_approved ) ? 'approved' : 'pending',
		);
	}

	return rest_ensure_response( $out );
}

/**
 * Authenticated POST /desk/decide endpoint for moderation actions.
 */
function valley_indian_desk_decide( $request ) {
	$params = $request->get_json_params();
	$kind   = isset( $params['kind'] ) ? sanitize_text_field( (string) $params['kind'] ) : '';
	$id     = isset( $params['id'] ) ? absint( $params['id'] ) : 0;
	$action = isset( $params['action'] ) ? sanitize_text_field( (string) $params['action'] ) : '';
	$notes  = isset( $params['notes'] ) ? sanitize_textarea_field( (string) $params['notes'] ) : '';

	if ( ! $id || ! in_array( $action, array( 'approve', 'reject', 'unpublish' ), true ) ) {
		return new WP_Error( 'invalid_request', __( 'Invalid moderation request.', 'valley-indian' ), array( 'status' => 400 ) );
	}

	if ( 'comments' === $kind ) {
		$comment = get_comment( $id );
		if ( ! $comment ) {
			return new WP_Error( 'not_found', __( 'Comment not found.', 'valley-indian' ), array( 'status' => 404 ) );
		}
		if ( 'approve' === $action ) {
			wp_set_comment_status( $id, 'approve' );
		} elseif ( 'unpublish' === $action ) {
			wp_set_comment_status( $id, 'hold' );
		} else {
			wp_trash_comment( $id );
		}
		valley_indian_record_audit( 'comments ' . $action, $comment->comment_content, $notes );
		return rest_ensure_response( array( 'ok' => true ) );
	}

	$post = get_post( $id );
	if ( ! $post ) {
		return new WP_Error( 'not_found', __( 'Item not found.', 'valley-indian' ), array( 'status' => 404 ) );
	}

	if ( 'approve' === $action ) {
		if ( in_array( $kind, array( 'stories', 'businesses', 'events' ), true ) ) {
			$is_court       = (bool) get_post_meta( $id, '_is_court_record', true ) || has_category( 'Public records', $post );
			$required_count = $is_court ? 5 : 2;
			$checks         = isset( $params['checks'] ) && is_array( $params['checks'] ) ? $params['checks'] : array();
			$valid_checks   = ( count( $checks ) === $required_count ) && ! in_array( false, $checks, true ) && count( array_filter( $checks, function( $v ) { return true === $v; } ) ) === $required_count;
			if ( ! $valid_checks ) {
				return new WP_Error( 'checks_required', __( 'All verification checks must be completed before publishing.', 'valley-indian' ), array( 'status' => 400 ) );
			}
			if ( $is_court && empty( trim( $notes ) ) ) {
				return new WP_Error( 'notes_required', __( 'Court verification notes are required before publishing.', 'valley-indian' ), array( 'status' => 400 ) );
			}
		}

		$update = array( 'ID' => $id, 'post_status' => 'publish' );
		if ( ! empty( $params['title'] ) ) {
			$update['post_title'] = sanitize_text_field( (string) $params['title'] );
		}
		if ( ! empty( $params['body'] ) ) {
			$raw_body               = sanitize_textarea_field( (string) $params['body'] );
			$update['post_content'] = wp_kses_post( wpautop( $raw_body ) );
			if ( 'directory_listing' !== $post->post_type ) {
				$update['post_excerpt'] = wp_trim_words( $raw_body, 28, '…' );
			}
		}
		wp_update_post( $update );
	} elseif ( 'unpublish' === $action ) {
		wp_update_post( array( 'ID' => $id, 'post_status' => 'pending' ) );
	} else {
		wp_trash_post( $id );
	}

	valley_indian_record_audit( $kind . ' ' . $action, $post->post_title, $notes );
	return rest_ensure_response( array( 'ok' => true ) );
}

/**
 * Authenticated POST /desk/import endpoint with deduplication on external ID.
 */
function valley_indian_desk_import() {
	$existing = get_posts( array(
		'post_type'      => 'post',
		'post_status'    => array( 'pending', 'publish', 'draft' ),
		'meta_key'       => '_external_import_id',
		'meta_value'     => 'sample-feed-1',
		'posts_per_page' => 1,
	) );

	if ( ! empty( $existing ) ) {
		return rest_ensure_response( array(
			'ok'      => true,
			'created' => false,
			'message' => __( 'Duplicate detected. No new item created.', 'valley-indian' ),
		) );
	}

	$post_id = wp_insert_post( array(
		'post_title'   => 'Sample feed lead: a neighborhood initiative',
		'post_content' => '<p>Simulated intake, not a real news report. Verify the original source and write an independent summary before approval.</p>',
		'post_excerpt' => 'An illustrative incoming news lead.',
		'post_status'  => 'pending',
		'post_type'    => 'post',
		'post_author'  => 1,
	), true );

	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'import_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
	}

	update_post_meta( $post_id, '_external_import_id', 'sample-feed-1' );
	update_post_meta( $post_id, '_submission_kind', 'Summary' );
	update_post_meta( $post_id, '_sample_content', true );
	$term = get_term_by( 'name', 'Community', 'category' );
	if ( $term ) {
		wp_set_post_categories( $post_id, array( $term->term_id ) );
	}
	wp_set_object_terms( $post_id, 'Clark County', 'area' );

	return rest_ensure_response( array(
		'ok'      => true,
		'created' => true,
		'post_id' => $post_id,
		'message' => __( 'Intake processed. Publication still requires approval.', 'valley-indian' ),
	) );
}
