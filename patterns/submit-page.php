<?php
/**
 * Title: Submit / Contribute Page
 * Slug: valley-indian/submit-page
 * Categories: valley-indian
 * Description: Community submission form supporting stories, businesses, events, and corrections.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">A community shaped by you</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Share something that matters.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every submission goes to the editor. Nothing appears automatically.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<form class="form wp-block-group" id="story-submission-form">
  <label>Submission type
    <select name="type" id="submission-type">
      <option value="stories">Story or news tip</option>
      <option value="businesses">Business listing</option>
      <option value="events">Event</option>
      <option value="correction">Correction</option>
    </select>
  </label>

  <label>Title or business name
    <input name="title" required maxlength="160">
  </label>

  <div id="dynamic-submission-fields">
    <label>Location
      <select name="area">
        <option value="Clark County">Clark County</option>
        <option value="Las Vegas">Las Vegas</option>
        <option value="Henderson">Henderson</option>
        <option value="North Las Vegas">North Las Vegas</option>
        <option value="Summerlin">Summerlin</option>
        <option value="United States">United States</option>
      </select>
    </label>
    <label>Category
      <select name="category">
        <option value="Community">Community</option>
        <option value="People">People</option>
        <option value="Culture">Culture</option>
        <option value="Business">Business</option>
        <option value="National">National</option>
        <option value="Public records">Public records</option>
      </select>
    </label>
  </div>

  <label>Details
    <textarea name="body" required maxlength="12000"></textarea>
  </label>

  <label>Source or website link (optional)
    <input name="url" type="url" placeholder="https://" maxlength="1000">
  </label>

  <label>Contact email (editor only)
    <input name="email" type="email" required maxlength="200">
  </label>

  <label class="honeypot" aria-hidden="true">Leave blank
    <input name="website" tabindex="-1" autocomplete="off">
  </label>

  <label>
    <input name="consent" type="checkbox" required>I have permission to submit this information for review.
  </label>

  <div class="notice">Submissions are stored privately until editorial approval. Contact email is never published.</div>

  <button type="submit" class="primary" id="story-submit-btn">Submit for review ↗</button>
</form>
<!-- /wp:html -->
