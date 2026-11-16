<?php
/**
 * Title: Stories Grid (Clark County)
 * Slug: valley-indian/stories-grid
 * Categories: valley-indian, query
 * Description: Three-column local stories archive with search, category filter, and ad slot.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Stories that connect us</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Across Clark County</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Original reporting and source-linked highlights, selected by an editor.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="searchrow">
  <input id="archive-search" aria-label="Search" placeholder="Search stories…">
  <select id="archive-category" aria-label="Category">
    <option value="All">All</option>
    <option value="Community">Community</option>
    <option value="People">People</option>
    <option value="Business">Business</option>
    <option value="Culture">Culture</option>
    <option value="National">National</option>
    <option value="Public records">Public records</option>
  </select>
</div>
<!-- /wp:html -->

<!-- wp:query {"queryId":10,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query" id="results"><!-- wp:post-template {"className":"cards three"} -->
<!-- wp:group {"tagName":"article","className":"card","layout":{"type":"default"}} -->
<article class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Sample content</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"card-eyebrows","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group card-eyebrows"><!-- wp:post-terms {"term":"category","className":"eyebrow"} /--><!-- wp:paragraph {"className":"eyebrow-sep"} -->
<p class="eyebrow-sep">·</p>
<!-- /wp:paragraph --><!-- wp:post-terms {"term":"area","className":"eyebrow"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"className":"muted"} /-->

<!-- wp:paragraph {"className":"meta"} -->
<p class="meta">Original</p>
<!-- /wp:paragraph -->

<!-- wp:read-more {"content":"Read story ↗","className":"read"} /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"empty"} -->
<p class="empty">No matches. Try another category, location, or search.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:html -->
<?php echo valley_indian_ad_slot_html( 'News section banner' ); ?>
<!-- /wp:html -->
