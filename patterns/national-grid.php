<?php
/**
 * Title: Across America Grid
 * Slug: valley-indian/national-grid
 * Categories: valley-indian, query
 * Description: Curated national briefing format with live search & filter.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">The wider conversation</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Across America</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Selected national stories with context for our local community.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="searchrow">
  <input id="archive-search" aria-label="Search stories" placeholder="Search stories…">
  <select id="archive-category" aria-label="Filter category">
    <option value="All">All</option>
    <option value="Community">Community</option>
    <option value="People">People</option>
    <option value="Business">Business</option>
    <option value="Culture">Culture</option>
    <option value="Public records">Public records</option>
    <option value="National">National</option>
  </select>
</div>
<!-- /wp:html -->

<!-- wp:query {"queryId":11,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"asc","orderBy":"date","author":"","search":"","taxQuery":{"category":[13]},"sticky":"","inherit":false}} -->
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
<p class="meta">SAMPLE CONTENT · Summary</p>
<!-- /wp:paragraph --></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">No matching stories found. Try adjusting your query or category filters.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
