<?php
/**
 * Title: Interactive Cards Grid
 * Slug: valley-indian/cards-grid
 * Categories: valley-indian, query
 * Description: Reusable interactive query loop of cards with instant search and taxonomy filtering.
 */
?>
<!-- wp:html -->
<div class="searchrow">
  <input id="archive-search" aria-label="Search stories" placeholder="Search stories…">
  <select id="archive-category" aria-label="Filter category">
    <option value="All">All categories</option>
    <option value="Community">Community</option>
    <option value="People">People</option>
    <option value="Business">Business</option>
    <option value="Culture">Culture</option>
    <option value="National">National</option>
  </select>
</div>
<!-- /wp:html -->

<!-- wp:query {"queryId":20,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query" id="results"><!-- wp:post-template {"className":"cards"} -->
<!-- wp:group {"tagName":"article","className":"card","layout":{"type":"default"}} -->
<article class="wp-block-group card"><!-- wp:group {"className":"card-eyebrows","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group card-eyebrows"><!-- wp:post-terms {"term":"category","className":"eyebrow"} /--><!-- wp:paragraph {"className":"eyebrow-sep"} -->
<p class="eyebrow-sep">·</p>
<!-- /wp:paragraph --><!-- wp:post-terms {"term":"area","className":"eyebrow"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"className":"wp-block-post-title"} /-->

<!-- wp:post-excerpt {"moreText":"Read story ↗","className":"muted"} /-->

<!-- wp:paragraph {"className":"meta"} -->
<p class="meta">SAMPLE CONTENT</p>
<!-- /wp:paragraph --></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">No matching stories found.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
