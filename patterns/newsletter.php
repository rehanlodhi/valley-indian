<?php
/**
 * Title: The Valley Brief Newsletter
 * Slug: valley-indian/newsletter
 * Categories: valley-indian
 * Description: Weekly newsletter subscription callout block.
 */
?>
<!-- wp:html -->
<div class="newsletter wp-block-group">
  <span class="eyebrow" style="color:#e5b876">The Valley Brief</span>
  <h2>Your community,<br>in your inbox.</h2>
  <p>A proposed weekly digest of local stories, events and national highlights.</p>
  <form id="newsletter-form" onsubmit="if(window.handleNewsletter){window.handleNewsletter(event);}else{event.preventDefault();}">
    <label for="newsletter-email">Email address</label>
    <input id="newsletter-email" type="email" required placeholder="you@example.com">
    <button type="submit" class="btn">Try newsletter signup ↗</button>
  </form>
  <p><small style="color:#cedbd2">Demo only · Newsletter service not connected</small></p>
</div>
<!-- /wp:html -->
