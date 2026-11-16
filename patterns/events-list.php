<?php
/**
 * Title: On The Calendar Sidebar Widget
 * Slug: valley-indian/events-list
 * Categories: valley-indian, query
 * Description: Live upcoming community events calendar sidebar widget.
 */
?>
<!-- wp:group {"className":"calendar-widget","layout":{"type":"default"}} -->
<div class="wp-block-group calendar-widget"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">On the calendar</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":17,"query":{"perPage":3,"pages":0,"offset":0,"postType":"event","order":"asc","orderBy":"date","author":"","search":"","sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template -->
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
<a class="read" href="<?php echo esc_url( home_url( '/events' ) ); ?>">Full community calendar ↗</a>
<!-- /wp:html --></div>
<!-- /wp:group -->
