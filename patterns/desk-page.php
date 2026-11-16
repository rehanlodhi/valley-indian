<?php
/**
 * Title: The Editor's Desk Page
 * Slug: valley-indian/desk-page
 * Categories: valley-indian
 * Description: Editorial review queues, connected sources roadmap, and decision audit trail.
 */
?>
<!-- wp:html -->
<div class="desk-container">
  <div class="sectionhead">
    <div>
      <span class="eyebrow">Newsroom · One editor</span>
      <h1>The editor’s desk</h1>
    </div>
    <a href="<?php echo esc_url( admin_url() ); ?>" class="button">Open WordPress Admin ↗</a>
  </div>

  <div class="notice" id="desk-status-notice">
    Loading editorial workspace… Authenticated WordPress editors can review, approve, reject, and unpublish items directly here.
  </div>

  <div class="stats">
    <div class="card">
      <strong id="stat-stories-count">0</strong>
      Articles to review
    </div>
    <div class="card">
      <strong id="stat-comments-count">0</strong>
      Comments waiting
    </div>
    <div class="card">
      <strong id="stat-published-count">0</strong>
      Published articles
    </div>
  </div>

  <div class="tabs" id="desk-tabs">
    <button type="button" class="active" data-tab="stories">Articles</button>
    <button type="button" data-tab="comments">Comments</button>
    <button type="button" data-tab="businesses">Businesses</button>
    <button type="button" data-tab="events">Events</button>
    <button type="button" data-tab="subscribers">Newsletter requests</button>
    <button type="button" data-tab="inquiries">Ad inquiries</button>
    <button type="button" data-tab="published">Published content</button>
    <button type="button" data-tab="sources">Integrations</button>
    <button type="button" data-tab="audit">Decision log</button>
  </div>

  <div class="queue" id="desk-content"></div>
</div>
<!-- /wp:html -->
