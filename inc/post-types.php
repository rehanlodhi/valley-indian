<?php
/**
 * Custom Post Types Registration
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Community Events CPT
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

	$event_args = array(
		'label'                 => __( 'Event', 'valley-indian' ),
		'description'           => __( 'Community events, gatherings and volunteer meetups', 'valley-indian' ),
		'labels'                => $event_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'rewrite'               => array( 'slug' => 'event' ),
		'show_in_rest'          => true, // Essential for Gutenberg Block Editor
	);
	register_post_type( 'event', $event_args );

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

	$dir_args = array(
		'label'                 => __( 'Directory Listing', 'valley-indian' ),
		'description'           => __( 'Local businesses, professional services, cultural and civic listings', 'valley-indian' ),
		'labels'                => $dir_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-businessperson',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'rewrite'               => array( 'slug' => 'directory-listing' ),
		'show_in_rest'          => true,
	);
	register_post_type( 'directory_listing', $dir_args );
}
add_action( 'init', 'valley_indian_register_post_types' );

/**
 * Register Post Meta with REST API Exposure
 */
function valley_indian_register_meta() {
	// Event Meta Fields
	register_post_meta( 'event', '_event_day', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback' => function() { return current_user_can( 'edit_posts' ); }
	) );

	register_post_meta( 'event', '_event_month', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback' => function() { return current_user_can( 'edit_posts' ); }
	) );

	register_post_meta( 'event', '_event_location', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback' => function() { return current_user_can( 'edit_posts' ); }
	) );

	// Story Meta Fields
	register_post_meta( 'post', '_source_url', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback' => function() { return current_user_can( 'edit_posts' ); }
	) );
}
add_action( 'init', 'valley_indian_register_meta' );
