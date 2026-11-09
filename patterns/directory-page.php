<?php
/**
 * Title: Local Directory Page
 * Slug: valley-indian/directory-page
 * Categories: valley-indian, query
 * Description: Local community business and service directory with query loop.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Discover your community</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Local directory</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Example listing categories. Verified businesses and organizations will be added before launch.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":8,"query":{"perPage":12,"pages":0,"offset":0,"postType":"directory_listing","order":"asc","orderBy":"title","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"cards"} -->
<!-- wp:group {"tagName":"article","className":"card","layout":{"type":"default"}} -->
<article class="wp-block-group card"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Listing placeholder</p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":2,"isLink":false} /-->

<!-- wp:post-excerpt {"className":"muted"} /-->

<!-- wp:buttons {"className":"card-actions","style":{"spacing":{"margin":{"top":"auto"},"padding":{"top":"15px"}}}} -->
<div class="wp-block-buttons card-actions" style="margin-top:auto;padding-top:15px"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/submit">Suggest a listing ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">No listings found in the directory.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
