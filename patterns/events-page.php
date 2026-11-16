<?php
/**
 * Title: Community Calendar Events Page
 * Slug: valley-indian/events-page
 * Categories: valley-indian, query
 * Description: Community events calendar with query loop, Submit an event CTA, and ad slot.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Gather. Celebrate. Belong.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Community calendar</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Discover what brings our community together. Sample events are illustrative, not confirmed announcements.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"event","order":"asc","orderBy":"date","author":"","search":"","sticky":"","inherit":false},"className":"events-list"} -->
<div class="wp-block-query events-list"><!-- wp:post-template -->
<!-- wp:group {"tagName":"article","className":"event","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<article class="wp-block-group event"><!-- wp:group {"className":"date","layout":{"type":"default"}} -->
<div class="wp-block-group date"><!-- wp:post-date {"format":"d"} /--><!-- wp:post-date {"format":"M","className":"event-month"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Sample content</p>
<!-- /wp:paragraph --><!-- wp:post-title {"level":3,"isLink":true} /--><!-- wp:post-terms {"term":"area","className":"muted"} /--><!-- wp:read-more {"content":"Event details ↗","className":"read"} /--></div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">No approved events yet.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:html -->
<a class="button primary" href="<?php echo esc_url( home_url( '/submit?type=events' ) ); ?>" style="margin-top:25px">Submit an event ↗</a>
<?php echo valley_indian_ad_slot_html( 'Events banner' ); ?>
<!-- /wp:html -->
