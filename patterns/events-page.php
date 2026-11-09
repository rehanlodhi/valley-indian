<?php
/**
 * Title: Community Calendar Events Page
 * Slug: valley-indian/events-page
 * Categories: valley-indian, query
 * Description: Community events calendar with query loop and submit event CTA.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Gather. Connect. Belong.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Community calendar</h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">Illustrative events only. Dates, venues and organizers are not confirmed.</p>
<!-- /wp:paragraph -->

<!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"event","order":"asc","orderBy":"title","author":"","search":"","sticky":"","inherit":false},"className":"events-list"} -->
<div class="wp-block-query events-list"><!-- wp:post-template -->
<!-- wp:group {"tagName":"article","className":"event","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<article class="wp-block-group event"><!-- wp:group {"className":"date","layout":{"type":"default"}} -->
<div class="wp-block-group date"><!-- wp:post-date {"format":"d"} /--><!-- wp:post-date {"format":"M"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:post-title {"level":3,"isLink":true} /--><!-- wp:post-excerpt {"className":"muted"} /--></div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">No upcoming events found.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"25px"}}}} -->
<div class="wp-block-buttons" style="margin-top:25px"><!-- wp:button {"className":"primary"} -->
<div class="wp-block-button primary"><a class="wp-block-button__link wp-element-button" href="/submit">Submit an event</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
