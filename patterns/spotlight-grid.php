<?php
/**
 * Title: Local Business Spotlight
 * Slug: valley-indian/spotlight-grid
 * Categories: valley-indian, query
 * Description: Three-column homepage business directory spotlight with gold top accent.
 */
?>
<!-- wp:html -->
<div class="sectionhead">
  <h2>Local business spotlight</h2>
  <a class="read" href="<?php echo esc_url( home_url( '/directory' ) ); ?>">Explore the directory ↗</a>
</div>
<p class="muted">Discover the professionals and small businesses in our neighborhoods. Paid placements will be labeled Sponsored.</p>
<!-- /wp:html -->

<!-- wp:query {"queryId":4,"query":{"perPage":3,"pages":0,"offset":0,"postType":"directory_listing","order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"cards three"} -->
<!-- wp:group {"tagName":"article","className":"card spotlight","layout":{"type":"default"}} -->
<article class="wp-block-group card spotlight"><!-- wp:group {"className":"spotlight-head","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group spotlight-head"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Sample content</p>
<!-- /wp:paragraph --><!-- wp:post-terms {"term":"directory_category","className":"eyebrow"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:group {"className":"listing-meta","layout":{"type":"default"}} -->
<div class="wp-block-group listing-meta"><!-- wp:post-excerpt /--><!-- wp:post-terms {"term":"area","className":"muted"} /--></div>
<!-- /wp:group -->

<!-- wp:read-more {"content":"View profile ↗","className":"read"} /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"empty"} -->
<p class="empty">Your business database will populate this section.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
