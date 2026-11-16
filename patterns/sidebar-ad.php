<?php
/**
 * Title: Sidebar Ad Card with Image Placeholder
 * Slug: valley-indian/sidebar-ad
 * Categories: valley-indian
 * Description: Sidebar advertisement card with reserved 16:9 image placeholder box.
 */
?>
<!-- wp:html -->
<div class="card sidebar-ad-card">
  <span class="eyebrow">Advertisement</span>
  <div class="ad-image-placeholder" role="img" aria-label="Reserved space for advertiser image">
    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true">
      <rect x="3" y="5" width="30" height="26" rx="4" stroke="currentColor" stroke-width="1.5"/>
      <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="1.5"/>
      <path d="m5 28 9-9 6 6 5-7 6 10" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
    </svg>
    <strong>Your ad image here</strong>
    <small>Featured business image or logo</small>
  </div>
  <h3>A space for local enterprise.</h3>
  <p>Sidebar placement reserved for an approved advertiser.</p>
  <a class="read" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>">Explore placements ↗</a>
</div>
<!-- /wp:html -->
