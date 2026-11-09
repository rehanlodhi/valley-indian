/**
 * The Valley Indian - Front-End Application Helper
 * Progressive enhancement for WordPress Full Site Editing (FSE)
 */

document.addEventListener('DOMContentLoaded', () => {
  initNavigationHighlight();
  initSubmissionForm();
  initNewsletterForm();
  initArchiveFiltering();
  initDeskWorkflow();
});

/**
 * Toast Notifications
 */
function showToast(message, isError = false) {
  let toast = document.getElementById('toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    toast.setAttribute('role', 'status');
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.style.backgroundColor = isError ? 'var(--orange, #ba4c2c)' : 'var(--ink, #183c39)';
  toast.style.color = '#fff';
  toast.classList.add('show');

  if (window._toastTimer) clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => {
    toast.classList.remove('show');
  }, 4500);
}
window.showToast = showToast;

/**
 * Navigation Current State Highlight
 */
function initNavigationHighlight() {
  const navLinks = document.querySelectorAll('.main-nav a');
  const currentPath = window.location.pathname.replace(/\/$/, '') || '/';

  navLinks.forEach(link => {
    link.classList.remove('active');
    const href = link.getAttribute('href');
    if (!href) return;
    const cleanHref = href.replace(/\/$/, '') || '/';
    if (cleanHref === currentPath) {
      link.classList.add('active');
    }
  });
}

/**
 * Real-Time Client-Side Archive Search & Filter
 * Progressively enhances Gutenberg wp:post-template queries on clark-county, across-america, and any card-grid pattern
 */
function initArchiveFiltering() {
  const searchInput = document.getElementById('archive-search');
  const categorySelect = document.getElementById('archive-category');
  const resultsContainer = document.getElementById('results') || document.querySelector('.cards.wp-block-post-template, ul.wp-block-post-template');

  if (!resultsContainer || (!searchInput && !categorySelect)) return;

  // Restore state from URL search params if present
  const params = new URLSearchParams(window.location.search);
  const initialQuery = params.get('s') || '';
  const initialCategory = params.get('category') || '';

  if (searchInput && initialQuery) {
    searchInput.value = initialQuery;
  }
  if (categorySelect && initialCategory) {
    for (let i = 0; i < categorySelect.options.length; i++) {
      if (categorySelect.options[i].value.toLowerCase() === initialCategory.toLowerCase()) {
        categorySelect.selectedIndex = i;
        break;
      }
    }
  }

  let debounceTimer = null;

  function updateUrlParams(query, filter) {
    const url = new URL(window.location.href);
    if (query) {
      url.searchParams.set('s', query);
    } else {
      url.searchParams.delete('s');
    }
    if (filter && filter !== 'all') {
      url.searchParams.set('category', filter);
    } else {
      url.searchParams.delete('category');
    }
    window.history.replaceState({}, '', url.toString());
  }

  function filterCards() {
    const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
    const filter = categorySelect ? categorySelect.value.toLowerCase() : 'all';

    // Target the direct list item or card children only
    const items = resultsContainer.querySelectorAll(':scope > li, :scope > .card, ul.cards > li');
    let visibleCount = 0;

    items.forEach(item => {
      const text = item.textContent.toLowerCase();
      const matchesQuery = !query || text.includes(query);
      const matchesCategory = (filter === 'all') || text.includes(filter);

      if (matchesQuery && matchesCategory) {
        item.style.display = '';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    let noResultsMsg = document.getElementById('no-archive-results');
    if (visibleCount === 0) {
      if (!noResultsMsg) {
        noResultsMsg = document.createElement('div');
        noResultsMsg.id = 'no-archive-results';
        noResultsMsg.className = 'notice';
        noResultsMsg.style.marginTop = '20px';
        noResultsMsg.textContent = 'No matching stories found. Try a different search term or category.';
        resultsContainer.parentNode.insertBefore(noResultsMsg, resultsContainer.nextSibling);
      } else {
        noResultsMsg.style.display = 'block';
      }
    } else if (noResultsMsg) {
      noResultsMsg.style.display = 'none';
    }

    // Debounced URL state update
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      updateUrlParams(query, filter);
    }, 250);
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCards);
  }
  if (categorySelect) {
    categorySelect.addEventListener('change', filterCards);
  }

  // Trigger initial filter if params were pre-populated
  if (initialQuery || (initialCategory && initialCategory.toLowerCase() !== 'all')) {
    filterCards();
  }
}

/**
 * Story Submission Form Handling via WordPress REST API
 */
function initSubmissionForm() {
  const form = document.getElementById('story-submission-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.textContent : '';

    const formData = new FormData(form);
    const payload = {
      title: (formData.get('title') || '').toString().trim(),
      area: (formData.get('area') || '').toString().trim(),
      category: (formData.get('category') || '').toString().trim(),
      body: (formData.get('body') || '').toString().trim(),
      url: (formData.get('url') || '').toString().trim()
    };

    if (!payload.title || !payload.body) {
      showToast('Please fill out both headline and details.', true);
      return;
    }

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting to newsroom...';
    }

    try {
      const restUrl = (window.valleyIndianSettings && window.valleyIndianSettings.restUrl)
        ? window.valleyIndianSettings.restUrl
        : '/wp-json/valley-indian/v1/submit';

      const nonce = (window.valleyIndianSettings && window.valleyIndianSettings.nonce)
        ? window.valleyIndianSettings.nonce
        : '';

      const response = await fetch(restUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': nonce
        },
        body: JSON.stringify(payload)
      });

      const result = await response.json();

      if (response.ok && result.success) {
        form.reset();
        showToast(result.message || 'Story submitted to editorial queue! Thank you.');
      } else {
        const errorMsg = result.message || 'Unable to submit story. Please try again.';
        showToast(errorMsg, true);
      }
    } catch (err) {
      console.error('Submission error:', err);
      showToast('Connection error. Story could not be submitted.', true);
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
    }
  });
}

/**
 * Newsletter Form Handling
 */
function initNewsletterForm() {
  const form = document.getElementById('newsletter-form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const emailInput = document.getElementById('newsletter-email');
    if (emailInput && emailInput.value) {
      showToast('Thank you for subscribing to The Valley Brief!');
      form.reset();
    }
  });
}
window.handleNewsletter = function(e) {
  if (e) e.preventDefault();
  showToast('Thank you for subscribing to The Valley Brief!');
  const form = document.getElementById('newsletter-form');
  if (form) form.reset();
};

/**
 * Editor's Desk Interactive Workflow
 */
let currentDeskTab = 'stories';
function initDeskWorkflow() {
  const deskContainer = document.querySelector('.desk-container');
  if (!deskContainer) return;
  renderDeskTab(currentDeskTab);
}

function switchDeskTab(tab) {
  currentDeskTab = tab;
  const tabBtns = document.querySelectorAll('#desk-tabs button');
  tabBtns.forEach(btn => {
    if (btn.getAttribute('onclick')?.includes(tab)) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });
  renderDeskTab(tab);
}
window.switchDeskTab = switchDeskTab;

function renderDeskTab(tab) {
  const contentEl = document.getElementById('desk-content');
  if (!contentEl) return;

  if (tab === 'stories') {
    contentEl.innerHTML = `
      <div class="cards" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px;">
        <div class="card">
          <span class="eyebrow">Pending submission · Clark County</span>
          <h3>Community Youth Robotics Team Advances to Nationals</h3>
          <p class="muted">A team of high school students from Henderson designed an autonomous robot...</p>
          <div style="margin-top:auto;display:flex;gap:10px;">
            <button class="btn primary" onclick="showToast('Story approved and published!')">Approve & Publish</button>
            <button class="btn" onclick="showToast('Edit mode opened')">Edit Copy</button>
          </div>
        </div>
        <div class="card">
          <span class="eyebrow">Pending submission · Las Vegas</span>
          <h3>Annual South Asian Music Festival Returning in Spring</h3>
          <p class="muted">Organizers announced dates and preliminary lineup for the annual cultural gathering...</p>
          <div style="margin-top:auto;display:flex;gap:10px;">
            <button class="btn primary" onclick="showToast('Story approved and published!')">Approve & Publish</button>
            <button class="btn" onclick="showToast('Edit mode opened')">Edit Copy</button>
          </div>
        </div>
      </div>
    `;
  } else if (tab === 'comments') {
    contentEl.innerHTML = `
      <div style="margin-top:20px;">
        <div class="card" style="margin-bottom:15px;">
          <span class="eyebrow">Comment on "Many roots. One valley."</span>
          <p><strong>Asha M.</strong>: <em>"So thrilled to see a dedicated publication for the Valley Indian community. Great first issue!"</em></p>
          <div style="margin-top:10px;display:flex;gap:10px;">
            <button class="btn primary" onclick="showToast('Comment approved!')">Approve</button>
            <button class="btn" onclick="showToast('Comment archived')">Dismiss</button>
          </div>
        </div>
      </div>
    `;
  } else if (tab === 'sources') {
    contentEl.innerHTML = `
      <div style="margin-top:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;background:var(--card-bg);border:1px solid var(--line);">
          <thead>
            <tr style="background:#efe7d3;text-align:left;">
              <th style="padding:10px;border-bottom:1px solid var(--line);">Source Feed</th>
              <th style="padding:10px;border-bottom:1px solid var(--line);">Type</th>
              <th style="padding:10px;border-bottom:1px solid var(--line);">Status</th>
              <th style="padding:10px;border-bottom:1px solid var(--line);">Last Poll</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding:10px;border-bottom:1px solid var(--line);">Clark County Public Records RSS</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);">Court / Legal</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);color:#285b54;font-weight:bold;">Active</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);">12 mins ago</td>
            </tr>
            <tr>
              <td style="padding:10px;border-bottom:1px solid var(--line);">Las Vegas Chamber of Commerce</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);">Business</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);color:#285b54;font-weight:bold;">Active</td>
              <td style="padding:10px;border-bottom:1px solid var(--line);">1 hour ago</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;
  } else if (tab === 'audit') {
    contentEl.innerHTML = `
      <div style="margin-top:20px;">
        <div class="audit-log-item" style="padding:15px;background:var(--card-bg);border:1px solid var(--line);margin-bottom:10px;">
          <strong>Published: "Small businesses, big neighborhood connections"</strong>
          <small class="muted">November 8, 2026 · Editor: Admin · Status: Live</small>
        </div>
        <div class="audit-log-item" style="padding:15px;background:var(--card-bg);border:1px solid var(--line);margin-bottom:10px;">
          <strong>Approved: "The next generation of community builders"</strong>
          <small class="muted">November 8, 2026 · Editor: Admin · Status: Live</small>
        </div>
      </div>
    `;
  }
}
