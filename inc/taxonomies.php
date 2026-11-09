<?php
/**
 * Custom Taxonomies Registration
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Area and Directory Category Taxonomies
 */
function valley_indian_register_taxonomies() {
	// 1. Geographic Area Taxonomy (Clark County, Las Vegas, Henderson, North Las Vegas)
	$area_labels = array(
		'name'              => _x( 'Areas', 'taxonomy general name', 'valley-indian' ),
		'singular_name'     => _x( 'Area', 'taxonomy singular name', 'valley-indian' ),
		'search_items'      => __( 'Search Areas', 'valley-indian' ),
		'all_items'         => __( 'All Areas', 'valley-indian' ),
		'parent_item'       => __( 'Parent Area', 'valley-indian' ),
		'parent_item_colon' => __( 'Parent Area:', 'valley-indian' ),
		'edit_item'         => __( 'Edit Area', 'valley-indian' ),
		'update_item'       => __( 'Update Area', 'valley-indian' ),
		'add_new_item'      => __( 'Add New Area', 'valley-indian' ),
		'new_item_name'     => __( 'New Area Name', 'valley-indian' ),
		'menu_name'         => __( 'Areas', 'valley-indian' ),
	);

	$area_args = array(
		'hierarchical'      => true,
		'labels'            => $area_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'area' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'area', array( 'post', 'event', 'directory_listing' ), $area_args );

	// 2. Directory Categories Taxonomy
	$dir_cat_labels = array(
		'name'              => _x( 'Directory Categories', 'taxonomy general name', 'valley-indian' ),
		'singular_name'     => _x( 'Directory Category', 'taxonomy singular name', 'valley-indian' ),
		'search_items'      => __( 'Search Directory Categories', 'valley-indian' ),
		'all_items'         => __( 'All Categories', 'valley-indian' ),
		'edit_item'         => __( 'Edit Category', 'valley-indian' ),
		'update_item'       => __( 'Update Category', 'valley-indian' ),
		'add_new_item'      => __( 'Add New Category', 'valley-indian' ),
		'new_item_name'     => __( 'New Category Name', 'valley-indian' ),
		'menu_name'         => __( 'Categories', 'valley-indian' ),
	);

	$dir_cat_args = array(
		'hierarchical'      => true,
		'labels'            => $dir_cat_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'directory-category' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'directory_category', array( 'directory_listing' ), $dir_cat_args );
}
add_action( 'init', 'valley_indian_register_taxonomies' );

/**
 * Seed Default Taxonomy Terms
 */
function valley_indian_seed_default_terms() {
	if ( ! term_exists( 'Clark County', 'area' ) ) {
		wp_insert_term( 'Clark County', 'area' );
	}
	if ( ! term_exists( 'Las Vegas', 'area' ) ) {
		wp_insert_term( 'Las Vegas', 'area' );
	}
	if ( ! term_exists( 'Henderson', 'area' ) ) {
		wp_insert_term( 'Henderson', 'area' );
	}
	if ( ! term_exists( 'North Las Vegas', 'area' ) ) {
		wp_insert_term( 'North Las Vegas', 'area' );
	}

	// Directory categories
	$dir_cats = array(
		'Food & groceries',
		'Professional services',
		'Arts & cultural organizations',
		'Community & volunteering',
	);
	foreach ( $dir_cats as $cat ) {
		if ( ! term_exists( $cat, 'directory_category' ) ) {
			wp_insert_term( $cat, 'directory_category' );
		}
	}
}
add_action( 'after_switch_theme', 'valley_indian_seed_default_terms' );
