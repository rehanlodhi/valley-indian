<?php
/**
 * Title: Submit a Story Page
 * Slug: valley-indian/submit-page
 * Categories: valley-indian
 * Description: Community submission form for stories, events, and tips.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">From the community</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Every neighborhood has a story.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Share a story idea, event or listing for editorial review. Submissions never appear automatically.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="form wp-block-group" id="story-submission-form">
  <label>Headline or idea
    <input name="title" required maxlength="160" placeholder="e.g. New Indian Grocery Opening in Henderson">
  </label>

  <label>Location
    <select name="area">
      <option value="Clark County">Clark County</option>
      <option value="Las Vegas">Las Vegas</option>
      <option value="Henderson">Henderson</option>
      <option value="North Las Vegas">North Las Vegas</option>
      <option value="United States">United States</option>
    </select>
  </label>

  <label>Category
    <select name="category">
      <option value="Community">Community</option>
      <option value="Culture">Culture</option>
      <option value="Business">Business</option>
      <option value="People">People</option>
      <option value="National">National</option>
      <option value="Public records">Public records</option>
    </select>
  </label>

  <label>Details
    <textarea name="body" required maxlength="6000" rows="6" placeholder="Provide background, quotes, dates or details..."></textarea>
  </label>

  <label>Source link (optional)
    <input name="url" type="url" placeholder="https://">
  </label>

  <p class="notice">Submissions are sent directly to our WordPress editorial pending queue for review prior to publication.</p>

  <button type="submit" class="btn primary" id="story-submit-btn">Send to editorial queue ↗</button>
</form>
<!-- /wp:html -->
