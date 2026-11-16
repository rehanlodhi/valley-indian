<?php
/**
 * Custom Post Types & Meta Registration
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Community Events, Directory Listings, and Private Editorial Request CPTs
 */
function valley_indian_register_post_types() {
	// 1. Events CPT
	$event_labels = array(
		'name'                  => _x( 'Events', 'Post Type General Name', 'valley-indian' ),
		'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'valley-indian' ),
		'menu_name'             => __( 'Events', 'valley-indian' ),
		'name_admin_bar'        => __( 'Event', 'valley-indian' ),
		'archives'              => __( 'Event Archives', 'valley-indian' ),
		'all_items'             => __( 'All Events', 'valley-indian' ),
		'add_new_item'          => __( 'Add New Event', 'valley-indian' ),
		'add_new'               => __( 'Add New', 'valley-indian' ),
		'new_item'              => __( 'New Event', 'valley-indian' ),
		'edit_item'             => __( 'Edit Event', 'valley-indian' ),
		'update_item'           => __( 'Update Event', 'valley-indian' ),
		'view_item'             => __( 'View Event', 'valley-indian' ),
		'search_items'          => __( 'Search Events', 'valley-indian' ),
	);

	register_post_type( 'event', array(
		'label'             => __( 'Event', 'valley-indian' ),
		'description'       => __( 'Community events, gatherings and volunteer meetups', 'valley-indian' ),
		'labels'            => $event_labels,
		'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'menu_position'     => 5,
		'menu_icon'         => 'dashicons-calendar-alt',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export'        => true,
		'has_archive'       => false,
		'rewrite'           => array( 'slug' => 'event' ),
		'show_in_rest'      => true,
	) );

	// 2. Directory Listings CPT
	$dir_labels = array(
		'name'                  => _x( 'Directory Listings', 'Post Type General Name', 'valley-indian' ),
		'singular_name'         => _x( 'Directory Listing', 'Post Type Singular Name', 'valley-indian' ),
		'menu_name'             => __( 'Directory', 'valley-indian' ),
		'name_admin_bar'        => __( 'Directory Listing', 'valley-indian' ),
		'archives'              => __( 'Directory Archives', 'valley-indian' ),
		'all_items'             => __( 'All Listings', 'valley-indian' ),
		'add_new_item'          => __( 'Add New Listing', 'valley-indian' ),
		'add_new'               => __( 'Add New', 'valley-indian' ),
		'edit_item'             => __( 'Edit Listing', 'valley-indian' ),
		'view_item'             => __( 'View Listing', 'valley-indian' ),
		'search_items'          => __( 'Search Directory', 'valley-indian' ),
	);

	register_post_type( 'directory_listing', array(
		'label'             => __( 'Directory Listing', 'valley-indian' ),
		'description'       => __( 'Physicians, attorneys, accountants and neighborhood businesses', 'valley-indian' ),
		'labels'            => $dir_labels,
		'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'menu_position'     => 6,
		'menu_icon'         => 'dashicons-businessperson',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export'        => true,
		'has_archive'       => false,
		'rewrite'           => array( 'slug' => 'directory-listing' ),
		'show_in_rest'      => true,
	) );

	// 3. Private Newsletter Requests (editor-only, never public)
	register_post_type( 'vip_subscriber', array(
		'label'               => __( 'Newsletter Requests', 'valley-indian' ),
		'labels'              => array(
			'name'          => __( 'Newsletter Requests', 'valley-indian' ),
			'singular_name' => __( 'Newsletter Request', 'valley-indian' ),
			'menu_name'     => __( 'Newsletter Queue', 'valley-indian' ),
			'all_items'     => __( 'All Requests', 'valley-indian' ),
		),
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-email-alt',
		'supports'            => array( 'title', 'custom-fields' ),
		'show_in_rest'        => false,
	) );

	// 4. Private Advertising Inquiries (editor-only, never public)
	register_post_type( 'vip_inquiry', array(
		'label'               => __( 'Ad Inquiries', 'valley-indian' ),
		'labels'              => array(
			'name'          => __( 'Ad Inquiries', 'valley-indian' ),
			'singular_name' => __( 'Ad Inquiry', 'valley-indian' ),
			'menu_name'     => __( 'Ad Inquiries', 'valley-indian' ),
			'all_items'     => __( 'All Inquiries', 'valley-indian' ),
		),
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 26,
		'menu_icon'           => 'dashicons-megaphone',
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
		'show_in_rest'        => false,
	) );
}
add_action( 'init', 'valley_indian_register_post_types' );

/**
 * Register Post Meta (keeping private contact emails hidden from public REST API)
 */
function valley_indian_register_meta() {
	$editor_auth = function() {
		return current_user_can( 'edit_posts' );
	};

	// Event Meta
	foreach ( array( '_event_date', '_event_day', '_event_month', '_event_venue', '_event_location' ) as $key ) {
		register_post_meta( 'event', $key, array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $editor_auth,
		) );
	}

	// Directory Meta
	register_post_meta( 'directory_listing', '_business_specialty', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => $editor_auth,
	) );

	register_post_meta( 'directory_listing', '_source_url', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback'     => $editor_auth,
	) );

	// Story Meta
	register_post_meta( 'post', '_source_url', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback'     => $editor_auth,
	) );

	register_post_meta( 'post', '_submission_kind', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'default'           => 'Original',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => $editor_auth,
	) );

	register_post_meta( 'post', '_is_court_record', array(
		'show_in_rest'  => true,
		'single'        => true,
		'type'          => 'boolean',
		'default'       => false,
		'auth_callback' => $editor_auth,
	) );

	// Shared Sample Content Flag
	foreach ( array( 'post', 'event', 'directory_listing' ) as $ptype ) {
		register_post_meta( $ptype, '_sample_content', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'default'       => false,
			'auth_callback' => $editor_auth,
		) );
	}

	// Private Contact Email & Inquiry Meta (never exposed on public REST endpoints)
	foreach ( array( 'post', 'event', 'directory_listing', 'vip_subscriber', 'vip_inquiry' ) as $ptype ) {
		register_post_meta( $ptype, '_contact_email', array(
			'show_in_rest'      => false,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_email',
			'auth_callback'     => $editor_auth,
		) );
	}

	register_post_meta( 'vip_inquiry', '_placement_interest', array(
		'show_in_rest'      => false,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => $editor_auth,
	) );
}
add_action( 'init', 'valley_indian_register_meta' );
