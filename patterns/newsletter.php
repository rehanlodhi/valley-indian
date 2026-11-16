<?php
/**
 * Title: The Pulse Weekly Newsletter
 * Slug: valley-indian/newsletter
 * Categories: valley-indian
 * Description: Midnight charcoal newsletter request callout with gold top border and consent checkbox.
 */
?>
<!-- wp:html -->
<section class="newsletter wp-block-group">
  <span class="eyebrow">The Pulse Weekly</span>
  <h2>Your community,<br>in your inbox.</h2>
  <p>Local stories, upcoming events, and national highlights worth your time.</p>
  <form id="newsletter-form">
    <label for="newsletter-email">Email address
      <input id="newsletter-email" name="email" type="email" required maxlength="200" placeholder="you@example.com">
    </label>
    <label class="honeypot" aria-hidden="true">Leave blank
      <input name="website" tabindex="-1" autocomplete="off">
    </label>
    <label>
      <input name="consent" type="checkbox" required>I agree to receive the weekly newsletter.
    </label>
    <button type="submit" class="button gold">Request subscription ↗</button>
  </form>
  <small>Request recorded; email confirmation service is not connected yet.</small>
</section>
<!-- /wp:html -->
