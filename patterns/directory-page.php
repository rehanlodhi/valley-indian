<?php
/**
 * Title: Local Directory Page
 * Slug: valley-indian/directory-page
 * Categories: valley-indian, query
 * Description: Local professionals and business directory with search, category & location filters, and spotlight cards.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">People &amp; businesses you can find locally</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Your community, connected.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Physicians, attorneys, accountants, and neighborhood businesses. Sample listings will be replaced by your verified database.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="searchrow">
  <input id="archive-search" aria-label="Search" placeholder="Search name, specialty, or service…">
  <select id="archive-category" aria-label="Category">
    <option value="All">All</option>
    <option value="Physicians">Physicians</option>
    <option value="Attorneys">Attorneys</option>
    <option value="Accountants">Accountants</option>
    <option value="Other businesses">Other businesses</option>
  </select>
  <select id="archive-area" aria-label="Location">
    <option value="All">All</option>
    <option value="Clark County">Clark County</option>
    <option value="Las Vegas">Las Vegas</option>
    <option value="Henderson">Henderson</option>
    <option value="North Las Vegas">North Las Vegas</option>
    <option value="Summerlin">Summerlin</option>
  </select>
</div>
<!-- /wp:html -->

<!-- wp:query {"queryId":8,"query":{"perPage":12,"pages":0,"offset":0,"postType":"directory_listing","order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query" id="results"><!-- wp:post-template {"className":"cards three"} -->
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
<p class="empty">No matches. Try another category, location, or search.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:html -->
<?php echo valley_indian_ad_slot_html( 'Directory banner' ); ?>
<div class="notice">Own a local business? <a href="<?php echo esc_url( home_url( '/submit?type=businesses' ) ); ?>" class="read">Submit your listing for approval ↗</a></div>
<!-- /wp:html -->
