<?php
/**
 * Sample Data Seeder for Vegas Indian Pulse (valley-indian)
 *
 * Populates demo content matching Vegas Indian Pulse (seed.json)
 * for local WordPress Studio and WordPress Playground testing.
 *
 * @package ValleyIndian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Locate an existing seeded post even when pending (pending posts lack post_name in WP).
 *
 * @param string $slug      Seed slug.
 * @param string $title     Post title fallback.
 * @param string $post_type Post type.
 * @return WP_Post|null
 */
function valley_indian_find_seeded_post( $slug, $title, $post_type ) {
	$by_meta = get_posts( array(
		'post_type'      => $post_type,
		'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
		'meta_key'       => '_seed_slug',
		'meta_value'     => $slug,
		'posts_per_page' => 1,
	) );
	if ( ! empty( $by_meta ) ) {
		return $by_meta[0];
	}

	$by_path = get_page_by_path( $slug, OBJECT, $post_type );
	if ( $by_path ) {
		return $by_path;
	}

	$by_title = get_posts( array(
		'post_type'      => $post_type,
		'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
		'title'          => $title,
		'posts_per_page' => 1,
	) );
	return ! empty( $by_title ) ? $by_title[0] : null;
}

/**
 * Seed all demo content.
 *
 * @param bool $force Whether to update existing seeded posts and clean legacy demo items.
 */
function valley_indian_seed_data( $force = false ) {
	if ( function_exists( 'valley_indian_seed_default_terms' ) ) {
		valley_indian_seed_default_terms();
	}

	// 1. Site Options
	update_option( 'blogname', 'Vegas Indian Pulse' );
	update_option( 'blogdescription', 'Indian roots. Vegas spirit.' );
	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'show_on_front', 'posts' );

	// Remove default WordPress sample posts if present
	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $ptype ) {
		$default_item = get_page_by_path( $slug, OBJECT, $ptype );
		if ( $default_item ) {
			wp_delete_post( $default_item->ID, true );
		}
	}

	// Clean up legacy Valley Indian demo entries/terms on forced re-seed
	if ( $force ) {
		$legacy_slugs = array(
			'food-groceries'                                  => 'directory_listing',
			'professional-services'                           => 'directory_listing',
			'arts-cultural-organizations'                     => 'directory_listing',
			'community-volunteering'                          => 'directory_listing',
			'volunteer-connection-day'                        => 'event',
			'diwali-cultural-gala-planned-for-henderson-pavilion' => 'post',
		);
		foreach ( $legacy_slugs as $slug => $ptype ) {
			$legacy_post = get_page_by_path( $slug, OBJECT, $ptype );
			if ( $legacy_post ) {
				wp_delete_post( $legacy_post->ID, true );
			}
		}

		// Delete pending legacy Valley Indian posts (which have blank post_name in WP DB)
		$legacy_pending = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => array( 'pending', 'draft', 'publish' ),
			'title'          => 'Diwali Cultural Gala Planned for Henderson Pavilion',
			'posts_per_page' => -1,
		) );
		foreach ( $legacy_pending as $lp ) {
			wp_delete_post( $lp->ID, true );
		}

		$legacy_dir_cats = array(
			'food-groceries',
			'professional-services',
			'arts-cultural-organizations',
			'community-volunteering',
		);
		foreach ( $legacy_dir_cats as $cat_slug ) {
			$term = get_term_by( 'slug', $cat_slug, 'directory_category' );
			if ( $term && ! is_wp_error( $term ) ) {
				wp_delete_term( $term->term_id, 'directory_category' );
			}
		}
	}

	$theme_dir = get_template_directory();

	// 2. Sample Stories (matching dist/seed.json with newest-first chronological timestamps)
	$stories = array(
		array(
			'title'    => 'Many roots. One valley. A new home for our community’s stories.',
			'slug'     => 'many-roots-one-valley',
			'category' => 'Community',
			'area'     => 'Clark County',
			'kind'     => 'Original',
			'court'    => false,
			'date'     => '2026-11-10 12:00:00',
			'excerpt'  => 'From neighborhood celebrations to small-business milestones, this publication puts the people of our valley at the center.',
			'content'  => "<p>This is a sample welcome story showing the publication’s editorial style. The proposed newsroom covers Indian communities of every region, language and faith across Las Vegas, Henderson, North Las Vegas and the wider Clark County area.</p>\n\n<p>Local reporting, community submissions and attributed summaries of external coverage will sit alongside selected national stories. Every article goes through the editor before publication.</p>",
			'status'   => 'publish',
		),
		array(
			'title'    => 'The next generation of community builders',
			'slug'     => 'the-next-generation-of-community-builders',
			'category' => 'People',
			'area'     => 'Henderson',
			'kind'     => 'Original',
			'court'    => false,
			'date'     => '2026-11-10 11:00:00',
			'excerpt'  => 'A sample profile format for students, volunteers and neighbors making a difference.',
			'content'  => '<p>Illustrative profile only. A real story would include a named reporter, verified interviews, consent for photographs and clear attribution.</p>',
			'status'   => 'publish',
		),
		array(
			'title'    => 'Small businesses, big neighborhood connections',
			'slug'     => 'small-businesses-big-neighborhood-connections',
			'category' => 'Business',
			'area'     => 'Las Vegas',
			'kind'     => 'Original',
			'court'    => false,
			'date'     => '2026-11-10 10:00:00',
			'excerpt'  => 'Meet the founders and family enterprises shaping everyday life across the valley.',
			'content'  => '<p>Illustrative business feature. Editorial selection is independent of advertising. Paid placements must be labeled Sponsored and cannot buy favorable coverage.</p>',
			'status'   => 'publish',
		),
		array(
			'title'    => 'Beyond Nevada: the stories connecting Indian communities',
			'slug'     => 'beyond-nevada-the-stories-connecting-indian-communities',
			'category' => 'National',
			'area'     => 'United States',
			'kind'     => 'Summary',
			'court'    => false,
			'date'     => '2026-11-10 09:00:00',
			'excerpt'  => 'A curated national briefing format with context, attribution and links to original reporting.',
			'content'  => '<p>This is a sample national roundup, not a report of current events. Live coverage will include original-source links and independently written summaries, subject to editorial approval.</p>',
			'status'   => 'publish',
		),
		array(
			'title'    => 'Community arts gathering proposed for the fall calendar',
			'slug'     => 'community-arts-gathering-proposed-for-the-fall-calendar',
			'category' => 'Culture',
			'area'     => 'Clark County',
			'kind'     => 'Original',
			'court'    => false,
			'date'     => '2026-11-10 08:00:00',
			'excerpt'  => 'A sample community submission awaiting verification of the organizer, location and event details.',
			'content'  => '<p>Demo submission. Verify all details before using the Publish action. No real event is being announced.</p>',
			'status'   => 'pending',
		),
		array(
			'title'    => 'Court-record lead: identity and public-interest review required',
			'slug'     => 'court-record-lead-review-required',
			'category' => 'Public records',
			'area'     => 'Clark County',
			'kind'     => 'Summary',
			'court'    => true,
			'date'     => '2026-11-10 07:00:00',
			'excerpt'  => 'An illustrative intake record showing the additional review required for court coverage.',
			'content'  => '<p>Fictional workflow example. No real person, case or allegation is represented. Check the original docket, identity, case status and public-interest basis. Filing an allegation does not establish guilt or liability. Record response outreach and minimize unnecessary personal data.</p>',
			'status'   => 'pending',
		),
	);

	$lead_story_id = 0;
	foreach ( $stories as $s ) {
		$existing = valley_indian_find_seeded_post( $s['slug'], $s['title'], 'post' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $s['title'],
				'post_name'    => $s['slug'],
				'post_content' => $s['content'],
				'post_excerpt' => $s['excerpt'],
				'post_status'  => $s['status'],
				'post_type'    => 'post',
				'post_author'  => 1,
				'post_date'    => $s['date'],
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$pid             = wp_update_post( $post_data );
			} else {
				$pid = wp_insert_post( $post_data );
			}

			if ( ! is_wp_error( $pid ) ) {
				if ( 'many-roots-one-valley' === $s['slug'] ) {
					$lead_story_id = $pid;
				}
				$term = get_term_by( 'name', $s['category'], 'category' );
				if ( ! $term ) {
					$created = wp_insert_term( $s['category'], 'category' );
					$term_id = ( ! is_wp_error( $created ) ) ? $created['term_id'] : 0;
				} else {
					$term_id = $term->term_id;
				}
				if ( $term_id ) {
					wp_set_post_categories( $pid, array( $term_id ) );
				}
				wp_set_object_terms( $pid, $s['area'], 'area' );
				update_post_meta( $pid, '_seed_slug', $s['slug'] );
				update_post_meta( $pid, '_submission_kind', $s['kind'] );
				update_post_meta( $pid, '_is_court_record', $s['court'] );
				update_post_meta( $pid, '_sample_content', '1' );
			}
		} elseif ( 'many-roots-one-valley' === $s['slug'] ) {
			$lead_story_id = $existing->ID;
		}
	}

	// Seed 1 pending sample comment matching dist/seed.json
	if ( $lead_story_id ) {
		$existing_comments = get_comments( array( 'post_id' => $lead_story_id, 'count' => true ) );
		if ( 0 === (int) $existing_comments ) {
			wp_insert_comment( array(
				'comment_post_ID'      => $lead_story_id,
				'comment_author'       => 'Sample reader',
				'comment_author_email' => 'reader@example.com',
				'comment_content'      => 'I would love to see more local volunteer opportunities featured.',
				'comment_approved'     => 0,
			) );
		}
	}

	// 3. Sample Events (publish with past post_date + _event_date meta for future event dates)
	$events = array(
		array(
			'title'      => 'Community arts afternoon',
			'slug'       => 'community-arts-afternoon',
			'area'       => 'Clark County',
			'event_date' => '2026-12-05',
			'post_date'  => '2026-11-09 10:00:00',
			'excerpt'    => 'Clark County',
			'content'    => '<p>Sample event only. Organizer, venue and date are not confirmed.</p>',
		),
		array(
			'title'      => 'Founders & neighbors meetup',
			'slug'       => 'founders-neighbors-meetup',
			'area'       => 'Las Vegas',
			'event_date' => '2026-12-12',
			'post_date'  => '2026-11-09 11:00:00',
			'excerpt'    => 'Las Vegas',
			'content'    => '<p>Sample networking event for the calendar demonstration.</p>',
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
				'post_date'    => $ev['post_date'],
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$eid             = wp_update_post( $post_data );
			} else {
				$eid = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $eid ) ) {
				wp_set_object_terms( $eid, $ev['area'], 'area' );
				update_post_meta( $eid, '_event_date', $ev['event_date'] );
				$ts = strtotime( $ev['event_date'] . ' 12:00:00' );
				if ( $ts ) {
					update_post_meta( $eid, '_event_day', gmdate( 'd', $ts ) );
					update_post_meta( $eid, '_event_month', gmdate( 'M', $ts ) );
				}
				update_post_meta( $eid, '_sample_content', '1' );
			}
		}
	}

	// 4. Sample Directory Listings (matching dist/seed.json)
	$listings = array(
		array(
			'title'     => 'Sample physician practice',
			'slug'      => 'sample-physician-practice',
			'category'  => 'Physicians',
			'specialty' => 'Internal medicine',
			'area'      => 'Henderson',
			'post_date' => '2026-11-10 12:00:00',
			'content'   => '<p>Illustrative listing. Your verified physician database will replace this sample.</p>',
		),
		array(
			'title'     => 'Sample legal practice',
			'slug'      => 'sample-legal-practice',
			'category'  => 'Attorneys',
			'specialty' => 'Business law',
			'area'      => 'Las Vegas',
			'post_date' => '2026-11-10 11:00:00',
			'content'   => '<p>Illustrative listing showing specialty and location filters.</p>',
		),
		array(
			'title'     => 'Sample accounting firm',
			'slug'      => 'sample-accounting-firm',
			'category'  => 'Accountants',
			'specialty' => 'Tax preparation',
			'area'      => 'Summerlin',
			'post_date' => '2026-11-10 10:00:00',
			'content'   => '<p>Illustrative listing. No real professional is represented.</p>',
		),
		array(
			'title'     => 'Your local business here',
			'slug'      => 'your-local-business-here',
			'category'  => 'Other businesses',
			'specialty' => 'Food & retail',
			'area'      => 'North Las Vegas',
			'post_date' => '2026-11-10 09:00:00',
			'content'   => '<p>A place for the neighborhood businesses that bring our community together.</p>',
		),
	);

	foreach ( $listings as $l ) {
		$existing = get_page_by_path( $l['slug'], OBJECT, 'directory_listing' );
		if ( ! $existing || $force ) {
			$post_data = array(
				'post_title'   => $l['title'],
				'post_name'    => $l['slug'],
				'post_content' => $l['content'],
				'post_excerpt' => $l['specialty'],
				'post_status'  => 'publish',
				'post_type'    => 'directory_listing',
				'post_author'  => 1,
				'post_date'    => $l['post_date'],
			);
			if ( $existing && $force ) {
				$post_data['ID'] = $existing->ID;
				$lid             = wp_update_post( $post_data );
			} else {
				$lid = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $lid ) ) {
				wp_set_object_terms( $lid, $l['area'], 'area' );
				wp_set_object_terms( $lid, $l['category'], 'directory_category' );
				update_post_meta( $lid, '_business_specialty', $l['specialty'] );
				update_post_meta( $lid, '_sample_content', '1' );
			}
		}
	}

	// 5. Pages with Block Patterns (evaluating PHP cleanly via output buffering)
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
			'title'   => 'Advertise with us',
			'slug'    => 'advertise',
			'pattern' => 'advertise-page.php',
		),
		array(
			'title'   => 'Editorial standards',
			'slug'    => 'standards',
			'pattern' => 'standards-page.php',
		),
		array(
			'title'   => 'Privacy & corrections',
			'slug'    => 'privacy',
			'pattern' => 'privacy-page.php',
		),
		array(
			'title'   => 'Contribute',
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
			ob_start();
			include $pattern_file;
			$content = trim( ob_get_clean() );
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
				$page_id         = wp_update_post( $post_data );
			} else {
				$page_id = wp_insert_post( $post_data );
			}
			if ( ! is_wp_error( $page_id ) ) {
				delete_post_meta( $page_id, '_wp_page_template' );
			}
		}
	}

	// 6. Flush pattern cache and rewrite rules
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

// Register WP-CLI command
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'valley-indian seed', function( $args, $assoc_args ) {
		$force = isset( $assoc_args['force'] );
		valley_indian_seed_data( $force );
		WP_CLI::success( 'Vegas Indian Pulse demo content seeded successfully.' );
	} );
}
