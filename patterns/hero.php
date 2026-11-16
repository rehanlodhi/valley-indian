<?php
/**
 * Title: Lead Hero & Around the Valley
 * Slug: valley-indian/hero
 * Categories: valley-indian
 * Description: Dynamic lead story hero paired with Around the valley & beyond editorial briefs.
 */
?>
<!-- wp:group {"className":"hero","layout":{"type":"default"}} -->
<div class="wp-block-group hero"><!-- wp:group {"className":"lead","layout":{"type":"default"}} -->
<div class="wp-block-group lead"><!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"tagName":"article","layout":{"type":"default"}} -->
<article class="wp-block-group"><!-- wp:group {"className":"meta","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group meta"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Sample content</p>
<!-- /wp:paragraph --><!-- wp:paragraph -->
<p>·</p>
<!-- /wp:paragraph --><!-- wp:post-terms {"term":"category"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":1,"isLink":true} /-->

<!-- wp:post-excerpt {"className":"muted"} /-->

<!-- wp:read-more {"content":"Read the story ↗","className":"read"} /--></article>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"aside","layout":{"type":"default"}} -->
<aside class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Around the valley &amp; beyond</p>
<!-- /wp:paragraph -->

<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"tagName":"article","className":"brief","layout":{"type":"default"}} -->
<article class="wp-block-group brief"><!-- wp:group {"className":"card-eyebrows","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group card-eyebrows"><!-- wp:post-terms {"term":"category","className":"eyebrow"} /--><!-- wp:paragraph {"className":"eyebrow-sep"} -->
<p class="eyebrow-sep">·</p>
<!-- /wp:paragraph --><!-- wp:post-terms {"term":"area","className":"eyebrow"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"className":"muted"} /--></article>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></aside>
<!-- /wp:group --></div>
<!-- /wp:group -->
