<?php
/**
 * Sample Data Seeder for The Valley Indian
 *
 * Populates complete demo content matching the prototype for client presentation
 * and WordPress Playground testing.
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Seed all dummy content for The Valley Indian.
 *
 * @param bool $force Whether to re-seed existing posts.
 */
function valley_indian_seed_data( $force = false ) {
	// 1. Site Options
	update_option( 'blogname', 'The Valley Indian' );
	update_option( 'blogdescription', 'OUR COMMUNITY. OUR STORIES. OUR VALLEY.' );
	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'show_on_front', 'posts' );

	// Delete Hello World post if exists
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello ) {
		wp_delete_post( $hello->ID, true );
	}

	$theme_dir = get_template_directory();

	// 2. Sample Stories (Posts)
	$stories = array(
		array(
			'title'    => 'Many roots. One valley. A new home for our community’s stories.',
			'slug'     => 'many-roots-one-valley',
			'category' => 'Community',
			'area'     => 'Clark County',
			'excerpt'  => 'From neighborhood celebrations to small-business milestones, this publication puts the people of our valley at the center.',
			'content'  => "<p>This is a sample welcome story showing the publication’s editorial style. The proposed newsroom covers Indian communities of every region, language and faith across Las Vegas, Henderson, North Las Vegas and the wider Clark County area.</p>\n\n<p>Local reporting, community submissions and attributed summaries of external coverage will sit alongside selected national stories. Every article goes through the editor before publication.</p>",
			'status'   => 'publish',
		),
		array(
			'title'    => 'The next generation of community builders',
			'slug'     => 'the-next-generation-of-community-builders',
			'category' => 'People',
			'area'     => 'Henderson',
			'excerpt'  => 'A sample profile format for students, volunteers and neighbors making a difference.',
			'content'  => "<p>Across Henderson and the broader valley, young people and civic organizers are stepping up to build cultural programs, youth mentorship initiatives, and community service projects that connect generations.</p>\n\n<p>Highlighting volunteer leadership, youth achievements, and collaborative programs bridging neighborhood groups.</p>",
			'status'   => 'publish',
		),
		array(
			'title'    => 'Small businesses, big neighborhood connections',
			'slug'     => 'small-businesses-big-neighborhood-connections',
			'category' => 'Business',
			'area'     => 'Las Vegas',
			'excerpt'  => 'Meet the founders and family enterprises shaping everyday life across the valley.',
			'content'  => "<p>Meet the founders and family enterprises shaping everyday life across the valley. From specialty spice and grocery markets to tech consultancies, healthcare clinics, and regional catering hubs, local entrepreneurship is thriving.</p>",
			'status'   => 'publish',
		),
		array(
			'title'    => 'Beyond Nevada: the stories connecting Indian communities',
			'slug'     => 'beyond-nevada-the-stories-connecting-indian-communities',
			'category' => 'National',
			'area'     => 'Clark County',
			'excerpt'  => 'A curated national briefing format with context, attribution and links to original reporting.',
			'content'  => "<p>A curated national briefing format with context, attribution and links to original reporting. Coverage spans diaspora civic initiatives, national cultural festivals, academic fellowships, and business networks across the United States.</p>",
			'status'   => 'publish',
		),
		array(
			'title'    => 'Diwali Cultural Gala Planned for Henderson Pavilion',
			'slug'     => 'diwali-cultural-gala-planned-for-henderson-pavilion',
			'category' => 'Culture',
			'area'     => 'Henderson',
			'excerpt'  => 'Community submission: Annual festival of lights celebration featuring regional classical performances and culinary artisans.',
			'content'  => "<p>Organizers have submitted a proposal for the annual Diwali cultural showcase at the Henderson Pavilion. The event features regional performing troupes, artisan booths, traditional rangoli exhibitions, and family-friendly workshops.</p>",
			'status'   => 'pending',
		),
	);

	foreach ( $stories as $s ) {
		$existing = get_page_by_path( $s['slug'], OBJECT, 'post' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $s['title'],
				'post_name'    => $s['slug'],
				'post_content' => $s['content'],
				'post_excerpt' => $s['excerpt'],
				'post_status'  => $s['status'],
				'post_type'    => 'post',
				'post_author'  => 1,
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$pid = wp_update_post( $post_data );
			} else {
				$pid = wp_insert_post( $post_data );
			}

			if ( ! is_wp_error( $pid ) ) {
				// Category
				$term = get_term_by( 'name', $s['category'], 'category' );
				if ( ! $term ) {
					$term = wp_insert_term( $s['category'], 'category' );
					$term_id = is_array( $term ) ? $term['term_id'] : 0;
				} else {
					$term_id = $term->term_id;
				}
				if ( $term_id ) {
					wp_set_post_categories( $pid, array( $term_id ) );
				}
				// Area
				wp_set_object_terms( $pid, $s['area'], 'area' );
			}
		}
	}

	// 3. Sample Events
	$events = array(
		array(
			'title'    => 'Community arts afternoon',
			'slug'     => 'community-arts-afternoon',
			'area'     => 'Clark County',
			'date'     => '2025-11-07 10:00:00',
			'excerpt'  => 'Clark County · Sample event',
			'content'  => '<p>Join neighbors and artists for a collaborative visual arts and music showcase celebrating traditions across the Indian diaspora.</p>',
		),
		array(
			'title'    => 'Founders & neighbors meetup',
			'slug'     => 'founders-neighbors-meetup',
			'area'     => 'Las Vegas',
			'date'     => '2025-11-14 10:00:00',
			'excerpt'  => 'Las Vegas · Sample event',
			'content'  => '<p>Informal networking breakfast for local business owners, freelancers, and creative professionals.</p>',
		),
		array(
			'title'    => 'Volunteer connection day',
			'slug'     => 'volunteer-connection-day',
			'area'     => 'Henderson',
			'date'     => '2025-11-21 10:00:00',
			'excerpt'  => 'Henderson · Sample event',
			'content'  => '<p>Connect with local non-profits, student tutoring programs, and community food drives looking for active volunteers.</p>',
		),
	);

	foreach ( $events as $ev ) {
		$existing = get_page_by_path( $ev['slug'], OBJECT, 'event' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $ev['title'],
				'post_name'    => $ev['slug'],
				'post_content' => $ev['content'],
				'post_excerpt' => $ev['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => 'event',
				'post_author'  => 1,
				'post_date'    => $ev['date'],
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$eid = wp_update_post( $post_data );
			} else {
				$eid = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $eid ) ) {
				wp_set_object_terms( $eid, $ev['area'], 'area' );
			}
		}
	}

	// 4. Sample Directory Listings
	$listings = array(
		array(
			'title'    => 'Food & groceries',
			'slug'     => 'food-groceries',
			'category' => 'Food & groceries',
			'area'     => 'Las Vegas',
			'excerpt'  => 'Help readers discover local resources across Clark County.',
			'content'  => '<p>Directory of authentic regional Indian groceries, spices, halal/vegetarian markets, and artisanal sweet shops in Clark County.</p>',
		),
		array(
			'title'    => 'Professional services',
			'slug'     => 'professional-services',
			'category' => 'Professional services',
			'area'     => 'Henderson',
			'excerpt'  => 'Help readers discover local resources across Clark County.',
			'content'  => '<p>Legal, tax, accounting, real estate, and healthcare practices serving the Indian community in Southern Nevada.</p>',
		),
		array(
			'title'    => 'Arts & cultural organizations',
			'slug'     => 'arts-cultural-organizations',
			'category' => 'Arts & cultural organizations',
			'area'     => 'Clark County',
			'excerpt'  => 'Help readers discover local resources across Clark County.',
			'content'  => '<p>Classical dance academies, music associations, language schools, and temple & cultural associations across the valley.</p>',
		),
		array(
			'title'    => 'Community & volunteering',
			'slug'     => 'community-volunteering',
			'category' => 'Community & volunteering',
			'area'     => 'North Las Vegas',
			'excerpt'  => 'Help readers discover local resources across Clark County.',
			'content'  => '<p>Civic groups, student unions, and mutual-aid organizations supporting residents of all generations.</p>',
		),
	);

	foreach ( $listings as $l ) {
		$existing = get_page_by_path( $l['slug'], OBJECT, 'directory_listing' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $l['title'],
				'post_name'    => $l['slug'],
				'post_content' => $l['content'],
				'post_excerpt' => $l['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => 'directory_listing',
				'post_author'  => 1,
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$lid = wp_update_post( $post_data );
			} else {
				$lid = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $lid ) ) {
				wp_set_object_terms( $lid, $l['area'], 'area' );
				wp_set_object_terms( $lid, $l['category'], 'directory_category' );
			}
		}
	}

	// 5. Pages with Block Patterns
	$pages = array(
		array(
			'title'   => 'Community calendar',
			'slug'    => 'events',
			'pattern' => 'events-page.php',
		),
		array(
			'title'   => 'Local directory',
			'slug'    => 'directory',
			'pattern' => 'directory-page.php',
		),
		array(
			'title'   => 'Clark County',
			'slug'    => 'clark-county',
			'pattern' => 'stories-grid.php',
		),
		array(
			'title'   => 'Across America',
			'slug'    => 'across-america',
			'pattern' => 'national-grid.php',
		),
		array(
			'title'   => 'Partner with us',
			'slug'    => 'advertise',
			'pattern' => 'advertise-page.php',
		),
		array(
			'title'   => 'Editorial standards',
			'slug'    => 'standards',
			'pattern' => 'standards-page.php',
		),
		array(
			'title'   => 'Submit a story',
			'slug'    => 'submit',
			'pattern' => 'submit-page.php',
		),
		array(
			'title'   => 'The editor’s desk',
			'slug'    => 'desk',
			'pattern' => 'desk-page.php',
		),
	);

	foreach ( $pages as $p ) {
		$pattern_file = $theme_dir . '/patterns/' . $p['pattern'];
		$content      = '';
		if ( file_exists( $pattern_file ) ) {
			$raw     = file_get_contents( $pattern_file );
			$content = preg_replace( '/^<\\?php.*?\\?>\\s*/s', '', $raw );
		}

		$existing = get_page_by_path( $p['slug'], OBJECT, 'page' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_content' => $content,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$paid = wp_update_post( $post_data );
			} else {
				$paid = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $paid ) ) {
				delete_post_meta( $paid, '_wp_page_template' );
			}
		}
	}

	// 6. Flush caches and rewrite rules
	wp_get_theme()->delete_pattern_cache();
	flush_rewrite_rules();

	return true;
}

/**
 * Auto-seed data upon theme activation if not already seeded.
 */
function valley_indian_maybe_auto_seed() {
	if ( ! get_page_by_path( 'events', OBJECT, 'page' ) ) {
		valley_indian_seed_data( false );
	}
}
add_action( 'after_switch_theme', 'valley_indian_maybe_auto_seed' );

// Register WP-CLI command if WP-CLI is running
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'valley-indian seed', function( $args, $assoc_args ) {
		$force = isset( $assoc_args['force'] );
		valley_indian_seed_data( $force );
		WP_CLI::success( 'The Valley Indian demo content has been successfully seeded!' );
	} );
}
