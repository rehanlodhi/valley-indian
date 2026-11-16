<?php
/**
 * Title: Site Header
 * Slug: valley-indian/header
 * Categories: valley-indian
 * Inserter: false
 * Description: Vegas Indian Pulse dark masthead, tagline, and primary navigation.
 */
?>
<!-- wp:html -->
<div class="topline">
  <span>CLARK COUNTY, NEVADA</span>
  <span>Many roots. One community.</span>
  <a href="<?php echo esc_url( home_url( '/desk' ) ); ?>" class="topline-link">Editor’s desk ↗</a>
</div>

<div class="masthead">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Vegas Indian Pulse home" class="brand-logo">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-tagline.webp' ); ?>" alt="Vegas Indian Pulse — Indian roots. Vegas spirit.">
  </a>
  <a class="button gold" href="<?php echo esc_url( home_url( '/submit' ) ); ?>">Share your story ↗</a>
</div>

<nav class="main-nav" aria-label="Main navigation">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Front page</a>
  <a href="<?php echo esc_url( home_url( '/clark-county' ) ); ?>">Clark County</a>
  <a href="<?php echo esc_url( home_url( '/across-america' ) ); ?>">Across America</a>
  <a href="<?php echo esc_url( home_url( '/events' ) ); ?>">Events</a>
  <a href="<?php echo esc_url( home_url( '/directory' ) ); ?>">Local directory</a>
  <a href="<?php echo esc_url( home_url( '/submit' ) ); ?>">Contribute</a>
</nav>
<!-- /wp:html -->
