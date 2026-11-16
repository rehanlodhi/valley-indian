<?php
/**
 * Title: Advertise With Us Page
 * Slug: valley-indian/advertise-page
 * Categories: valley-indian
 * Description: Sponsorship placements overview paired with a business advertising inquiry form.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Grow with the community</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Local connections.<br>Lasting impact.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Support community journalism while introducing your business to Clark County’s Indian community.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"cards three","layout":{"type":"default"}} -->
<div class="wp-block-group cards three"><!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Homepage banner</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Business spotlight</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Article placement</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">News section banner</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Directory banner</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Events banner</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"card","layout":{"type":"default"}} -->
<div class="wp-block-group card"><!-- wp:paragraph {"className":"tag"} -->
<p class="tag">Placement available</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Newsletter sponsorship</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rates and audience metrics will be established before commercial launch. All paid placements are clearly labeled.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="form wp-block-group" id="advertise-inquiry-form" style="margin-top:30px">
  <h2>Tell us about your business</h2>
  <label>Business name
    <input name="title" required maxlength="160">
  </label>
  <label>Contact email
    <input name="email" type="email" required maxlength="200">
  </label>
  <label>Interested placement
    <select name="category">
      <option value="Homepage banner">Homepage banner</option>
      <option value="Business spotlight">Business spotlight</option>
      <option value="Article placement">Article placement</option>
      <option value="News section banner">News section banner</option>
      <option value="Directory banner">Directory banner</option>
      <option value="Events banner">Events banner</option>
      <option value="Newsletter sponsorship">Newsletter sponsorship</option>
    </select>
  </label>
  <label>Message
    <textarea name="body" required maxlength="3000"></textarea>
  </label>
  <label class="honeypot" aria-hidden="true">Leave blank
    <input name="website" tabindex="-1" autocomplete="off">
  </label>
  <button type="submit" class="primary">Submit inquiry</button>
  <p class="muted">Your inquiry is stored for the editor; no automated email is sent.</p>
</form>
<!-- /wp:html -->
