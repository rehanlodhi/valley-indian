<?php
/**
 * Title: Community Stories Grid & Neighbor Callout
 * Slug: valley-indian/community-stories
 * Categories: valley-indian, query
 * Description: Two-column community stories query paired with the From our neighbors callout banner.
 */
?>
<!-- wp:group {"tagName":"section","layout":{"type":"default"}} -->
<section class="wp-block-group"><!-- wp:html -->
<div class="sectionhead">
  <h2>Community stories</h2>
  <a class="read" href="<?php echo esc_url( home_url( '/clark-county' ) ); ?>">View all ↗</a>
</div>
<!-- /wp:html -->

<!-- wp:query {"queryId":5,"query":{"perPage":3,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"cards"} -->
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
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:html -->
<section class="ad">
  <div>
    <span class="eyebrow">From our neighbors</span>
    <h3>Have something to share?</h3>
    <p>A milestone, an event, a business, or a story worth telling.</p>
    <a class="read" href="<?php echo esc_url( home_url( '/submit' ) ); ?>">Send it to the editor ↗</a>
  </div>
</section>
<!-- /wp:html --></section>
<!-- /wp:group -->
