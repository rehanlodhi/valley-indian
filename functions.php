<?php
/**
 * Vegas Indian Pulse Theme Functions & Definitions
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Setup
 */
function valley_indian_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
}
add_action( 'after_setup_theme', 'valley_indian_setup' );

/**
 * Enqueue Styles and Scripts
 */
function valley_indian_scripts() {
	wp_enqueue_style(
		'valley-indian-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	wp_enqueue_script(
		'valley-indian-app',
		get_template_directory_uri() . '/assets/js/theme-app.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/theme-app.js' ),
		true
	);

	wp_localize_script( 'valley-indian-app', 'valleyIndianSettings', array(
		'restUrl'     => esc_url_raw( rest_url( 'valley-indian/v1/submit' ) ),
		'deskUrl'     => esc_url_raw( rest_url( 'valley-indian/v1/desk' ) ),
		'nonce'       => wp_create_nonce( 'wp_rest' ),
		'homeUrl'     => esc_url_raw( home_url( '/' ) ),
		'canModerate' => current_user_can( 'edit_others_posts' ),
		'loginUrl'    => esc_url_raw( wp_login_url( home_url( '/desk' ) ) ),
	) );
}
add_action( 'wp_enqueue_scripts', 'valley_indian_scripts' );

/**
 * Fallback Favicon using theme icon.webp when no Site Icon is configured.
 */
function valley_indian_favicon_fallback() {
	if ( ! has_site_icon() ) {
		printf(
			'<link rel="icon" href="%s">' . "\n",
			esc_url( get_template_directory_uri() . '/assets/images/icon.webp' )
		);
	}
}
add_action( 'wp_head', 'valley_indian_favicon_fallback', 5 );

/**
 * Output global toast container outside footer CSS grid.
 */
function valley_indian_render_toast() {
	echo '<div id="toast" role="status" aria-live="polite"></div>';
}
add_action( 'wp_footer', 'valley_indian_render_toast' );

/**
 * Register Block Pattern Categories
 */
function valley_indian_register_pattern_categories() {
	register_block_pattern_category(
		'valley-indian',
		array( 'label' => __( 'Vegas Indian Pulse', 'valley-indian' ) )
	);
}
add_action( 'init', 'valley_indian_register_pattern_categories' );

/**
 * Render _event_date meta for event CPT dates so future events stay 'publish'.
 */
function valley_indian_event_get_the_date( $the_date, $format, $post ) {
	$post_obj = get_post( $post );
	if ( ! $post_obj || 'event' !== $post_obj->post_type ) {
		return $the_date;
	}
	$event_date = get_post_meta( $post_obj->ID, '_event_date', true );
	if ( $event_date && strtotime( $event_date ) ) {
		$fmt = $format ? $format : get_option( 'date_format' );
		return wp_date( $fmt, strtotime( $event_date . ' 12:00:00' ) );
	}
	return $the_date;
}
add_filter( 'get_the_date', 'valley_indian_event_get_the_date', 10, 3 );

/**
 * Render helper markup for reusable ad-slot card.
 */
function valley_indian_ad_slot_html( $placement = 'Article placement', $compact = false ) {
	$adv_url = esc_url( home_url( '/advertise' ) );
	$cls     = $compact ? 'ad-slot ad-slot-article' : 'ad-slot';
	return sprintf(
		'<aside class="%1$s" aria-label="Advertisement: %2$s">' .
		'<div class="ad-slot-label">Advertisement <span>· Reserved placement</span></div>' .
		'<div class="ad-slot-content">' .
		'<div><h3>Your business. Part of the community.</h3><p>Connect with Indian readers in Clark County and beyond.</p></div>' .
		'<a class="read" href="%3$s">Advertise with us ↗</a>' .
		'</div><small>%2$s</small></aside>',
		esc_attr( $cls ),
		esc_html( $placement ),
		$adv_url
	);
}

/**
 * Dynamically hydrate native WordPress blocks inside Query Loops & Singles
 * without custom non-core blocks:
 * - Hides .tag Sample content pill if post is explicitly marked non-sample (_sample_content = '0')
 * - Updates .meta story kind ('Original' vs 'Summary') from _submission_kind
 * - Appends source link & in-article ad slot in single posts
 */
function valley_indian_render_block_enhancements( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}

	if ( 'core/paragraph' === $block['blockName'] ) {
		$cls     = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
		$post_id = get_the_ID();
		$ptype   = $post_id ? get_post_type( $post_id ) : '';
		if ( in_array( $ptype, array( 'post', 'event', 'directory_listing' ), true ) ) {
			if ( false !== strpos( $cls, 'tag' ) ) {
				$sample = get_post_meta( $post_id, '_sample_content', true );
				if ( '1' !== (string) $sample ) {
					return '';
				}
			} elseif ( false !== strpos( $cls, 'meta' ) && 'post' === $ptype ) {
				$kind = get_post_meta( $post_id, '_submission_kind', true );
				if ( $kind ) {
					return '<p class="meta">' . esc_html( $kind ) . '</p>';
				}
			}
		}
	}

	if ( 'core/post-content' === $block['blockName'] ) {
		$queried_id = get_queried_object_id();
		$post_id    = get_the_ID() ? get_the_ID() : $queried_id;

		if ( $post_id && (int) $post_id === (int) $queried_id ) {
			if ( is_singular( 'post' ) ) {
				$url    = get_post_meta( $post_id, '_source_url', true );
				$source = $url ? '<p><a class="read" href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">Original source ↗</a></p>' : '';
				return $block_content . $source . valley_indian_ad_slot_html( 'Article placement', true );
			}

			if ( is_singular( 'directory_listing' ) ) {
				$extra     = '';
				$specialty = get_post_meta( $post_id, '_business_specialty', true );
				$url       = get_post_meta( $post_id, '_source_url', true );
				if ( $specialty ) {
					$extra .= '<p class="article-lead">' . esc_html( $specialty ) . '</p>';
				}
				$source = $url ? '<p><a class="read" href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">Official website ↗</a></p>' : '';
				return $extra . $block_content . $source;
			}

			if ( is_singular( 'event' ) ) {
				$event_date  = get_post_meta( $post_id, '_event_date', true );
				$event_venue = get_post_meta( $post_id, '_event_venue', true );
				if ( $event_date || $event_venue ) {
					$meta_line = trim( ( $event_date ? $event_date : '' ) . ( $event_date && $event_venue ? ' · ' : '' ) . ( $event_venue ? $event_venue : 'Venue to be confirmed' ) );
					return '<p class="article-lead">' . esc_html( $meta_line ) . '</p>' . $block_content;
				}
			}
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'valley_indian_render_block_enhancements', 10, 2 );

/**
 * Filter Core Query Loop arguments without hardcoded term IDs.
 * - queryId 10: Clark County (exclude National category)
 * - queryId 11: Across America (National category only)
 * - queryId 7 / 17: Events (ordered chronologically by _event_date)
 */
function valley_indian_filter_query_vars( $query, $block ) {
	if ( empty( $block->context['queryId'] ) ) {
		return $query;
	}
	$qid = (int) $block->context['queryId'];

	if ( 10 === $qid ) {
		$national = get_term_by( 'slug', 'national', 'category' );
		if ( $national && ! is_wp_error( $national ) ) {
			$query['category__not_in'] = array( (int) $national->term_id );
		}
	} elseif ( 11 === $qid ) {
		$query['category_name'] = 'national';
	} elseif ( in_array( $qid, array( 7, 17 ), true ) ) {
		$query['meta_key'] = '_event_date';
		$query['orderby']  = 'meta_value';
		$query['order']    = 'ASC';
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'valley_indian_filter_query_vars', 10, 2 );

/**
 * Include Helper Modules
 */
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/submission-handler.php';
require_once get_template_directory() . '/inc/seeder.php';
