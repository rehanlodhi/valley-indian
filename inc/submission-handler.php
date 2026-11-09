<?php
/**
 * REST API Story Submission Handler
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register REST API Route for Story Submission
 */
function valley_indian_register_submission_route() {
	register_rest_route( 'valley-indian/v1', '/submit', array(
		'methods'             => 'POST',
		'callback'            => 'valley_indian_handle_story_submission',
		'permission_callback' => '__return_true', // Open for public community submissions
		'args'                => array(
			'title'    => array(
				'required'          => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'body'     => array(
				'required'          => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_textarea_field',
			),
			'area'     => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'Clark County',
			),
			'category' => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'Community',
			),
			'url'      => array(
				'type'              => 'string',
				'sanitize_callback' => 'esc_url_raw',
				'default'           => '',
			),
		),
	) );
}
add_action( 'rest_api_init', 'valley_indian_register_submission_route' );

/**
 * Handle Story Submission Callback
 */
function valley_indian_handle_story_submission( $request ) {
	$title    = $request->get_param( 'title' );
	$body     = $request->get_param( 'body' );
	$area     = $request->get_param( 'area' );
	$category = $request->get_param( 'category' );
	$url      = $request->get_param( 'url' );

	if ( empty( trim( $title ) ) || empty( trim( $body ) ) ) {
		return new WP_Error( 'missing_fields', __( 'Headline and story details are required.', 'valley-indian' ), array( 'status' => 400 ) );
	}

	// Insert post with status 'pending'
	$post_data = array(
		'post_title'   => wp_strip_all_tags( $title ),
		'post_content' => wp_kses_post( $body ),
		'post_excerpt' => wp_trim_words( $body, 30, '…' ),
		'post_status'  => 'pending', // Awaiting editorial desk review
		'post_type'    => 'post',
		'post_author'  => 1, // Default admin user
	);

	$post_id = wp_insert_post( $post_data, true );

	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'insert_failed', $post_id->get_error_message(), array( 'status' => 500 ) );
	}

	// Set Category
	$cat_id = 0;
	$term = get_term_by( 'name', $category, 'category' );
	if ( $term ) {
		$cat_id = $term->term_id;
	} else {
		$new_cat = wp_insert_term( $category, 'category' );
		if ( ! is_wp_error( $new_cat ) ) {
			$cat_id = $new_cat['term_id'];
		}
	}
	if ( $cat_id ) {
		wp_set_post_categories( $post_id, array( $cat_id ) );
	}

	// Set Area Taxonomy
	if ( ! empty( $area ) ) {
		wp_set_object_terms( $post_id, $area, 'area' );
	}

	// Save source url in post meta
	if ( ! empty( $url ) ) {
		update_post_meta( $post_id, '_source_url', esc_url_raw( $url ) );
	}

	return rest_ensure_response( array(
		'success' => true,
		'message' => __( 'Submitted! Your story is waiting in the editor’s queue.', 'valley-indian' ),
		'post_id' => $post_id,
	) );
}
