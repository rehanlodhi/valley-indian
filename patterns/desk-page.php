<?php
/**
 * Title: The Editor's Desk Page
 * Slug: valley-indian/desk-page
 * Categories: valley-indian
 * Description: Editorial workflow and newsroom dashboard demonstration.
 */
?>
<!-- wp:group {"className":"page-title","layout":{"type":"default"}} -->
<div class="wp-block-group page-title"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Newsroom / single-editor workflow</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">The editor’s desk</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"muted"} -->
<p class="muted">Review the source. Add context. Make the call.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"notice"} -->
<p class="notice">Workflow demonstration. This switch is not an admin login. Decisions persist only in this browser; production requires authenticated server-side permissions and storage.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<div class="desk-container">
  <div class="stats wp-block-columns">
    <div class="card wp-block-column">
      <strong id="stat-stories-count">2</strong>
      Stories to review
    </div>
    <div class="card wp-block-column">
      <strong id="stat-comments-count">1</strong>
      Comments to moderate
    </div>
    <div class="card wp-block-column">
      <strong id="stat-published-count">4</strong>
      Published demo stories
    </div>
  </div>

  <div class="tabs" id="desk-tabs">
    <button class="active" onclick="switchDeskTab('stories')">Article queue</button>
    <button onclick="switchDeskTab('comments')">Comments</button>
    <button onclick="switchDeskTab('sources')">Source connections</button>
    <button onclick="switchDeskTab('audit')">Decision log</button>
  </div>

  <div id="desk-content"></div>

  <div style="margin-top: 30px; padding: 20px; background: var(--notice-bg); border-left: 4px solid var(--notice-border);">
    <h3 style="margin-top: 0;">WordPress Newsroom Administration</h3>
    <p>Staff editors with publisher credentials can manage all posts, review submissions, and moderate comments directly in the WordPress dashboard.</p>
    <a href="/wp-admin" class="btn primary" style="display:inline-block;margin-top:8px;">Open WordPress Admin ↗</a>
  </div>
</div>
<!-- /wp:html -->
