<?php
/**
 * The Valley Indian Theme Functions & Definitions
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
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// HTML5 markup support
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
	// Theme stylesheet (using filemtime for instant cache refresh)
	wp_enqueue_style( 'valley-indian-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Front-end interactive script
	wp_enqueue_script(
		'valley-indian-app',
		get_template_directory_uri() . '/assets/js/theme-app.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/theme-app.js' ),
		true
	);

	// Pass REST API settings to script
	wp_localize_script( 'valley-indian-app', 'valleyIndianSettings', array(
		'restUrl' => esc_url_raw( rest_url( 'valley-indian/v1/submit' ) ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
		'homeUrl' => esc_url_raw( home_url( '/' ) ),
	) );
}
add_action( 'wp_enqueue_scripts', 'valley_indian_scripts' );

/**
 * Register Block Pattern Categories
 */
function valley_indian_register_pattern_categories() {
	register_block_pattern_category(
		'valley-indian',
		array( 'label' => __( 'The Valley Indian', 'valley-indian' ) )
	);
}
add_action( 'init', 'valley_indian_register_pattern_categories' );

/**
 * Include Helper Modules
 */
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/submission-handler.php';
require_once get_template_directory() . '/inc/seeder.php';
