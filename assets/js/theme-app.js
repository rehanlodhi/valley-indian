/**
 * Vegas Indian Pulse (valley-indian) Front-End Application Helper
 * Progressive enhancement for WordPress Full Site Editing (FSE)
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  initNavigationHighlight();
  initArchiveFiltering();
  initSubmissionForm();
  initNewsletterForm();
  initAdvertiseForm();
  initDeskWorkflow();
});

const escHtml = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
}[c]));

/**
 * Toast Notifications
 */
function showToast(message, isError = false) {
  let toast = document.getElementById('toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.style.backgroundColor = isError ? 'var(--saffron, #ce580b)' : 'var(--dark, #060b14)';
  toast.style.color = '#ffffff';
  toast.classList.add('show');

  if (window._toastTimer) clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => {
    toast.classList.remove('show');
  }, 4500);
}
window.showToast = showToast;

/**
 * Shared REST Helper
 */
async function vipRequest(url, body) {
  const settings = window.valleyIndianSettings || {};
  const headers = { 'Content-Type': 'application/json' };
  if (settings.nonce) {
    headers['X-WP-Nonce'] = settings.nonce;
  }
  const res = await fetch(url, {
    method: body !== undefined ? 'POST' : 'GET',
    credentials: 'same-origin',
    headers,
    body: body !== undefined ? JSON.stringify(body) : undefined,
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.message || data.error || 'Request failed');
  }
  return data;
}

/**
 * Navigation Current State Highlight
 */
function initNavigationHighlight() {
  const navLinks = document.querySelectorAll('.main-nav a');
  const currentPath = window.location.pathname.replace(/\/$/, '') || '/';

  navLinks.forEach((link) => {
    link.classList.remove('active');
    link.removeAttribute('aria-current');
    if (!link.href) return;
    try {
      const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
      if (linkPath === currentPath) {
        link.classList.add('active');
        link.setAttribute('aria-current', 'page');
      }
    } catch {
      // Ignore malformed hrefs
    }
  });
}

/**
 * Client-Side Archive Search, Category & Location Filter
 */
function initArchiveFiltering() {
  const searchInput = document.getElementById('archive-search');
  const categorySelect = document.getElementById('archive-category');
  const areaSelect = document.getElementById('archive-area');
  const resultsWrap = document.getElementById('results');
  const resultsContainer = resultsWrap
    ? (resultsWrap.querySelector('ul.wp-block-post-template') || resultsWrap)
    : document.querySelector('.cards.wp-block-post-template');

  if (!resultsContainer || (!searchInput && !categorySelect && !areaSelect)) return;

  const params = new URLSearchParams(window.location.search);
  const initialQuery = params.get('s') || '';
  const initialCategory = params.get('category') || '';
  const initialArea = params.get('area') || '';

  const selectValueCI = (sel, val) => {
    if (!sel || !val) return;
    const target = val.toLowerCase();
    for (let i = 0; i < sel.options.length; i++) {
      if (sel.options[i].value.toLowerCase() === target) {
        sel.selectedIndex = i;
        break;
      }
    }
  };

  if (searchInput && initialQuery) searchInput.value = initialQuery;
  selectValueCI(categorySelect, initialCategory);
  selectValueCI(areaSelect, initialArea);

  let debounceTimer = null;

  function updateUrlParams(q, cat, areaVal) {
    const url = new URL(window.location.href);
    if (q) url.searchParams.set('s', q);
    else url.searchParams.delete('s');

    if (cat && cat !== 'all') url.searchParams.set('category', cat);
    else url.searchParams.delete('category');

    if (areaVal && areaVal !== 'all') url.searchParams.set('area', areaVal);
    else url.searchParams.delete('area');

    window.history.replaceState({}, '', url.toString());
  }

  function filterCards() {
    const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
    const cat = categorySelect ? categorySelect.value.toLowerCase() : 'all';
    const areaVal = areaSelect ? areaSelect.value.toLowerCase() : 'all';

    const items = resultsContainer.querySelectorAll(':scope > li, :scope > .card');
    let visibleCount = 0;

    items.forEach((item) => {
      const text = item.textContent.toLowerCase();
      const matchesQuery = !query || text.includes(query);
      const matchesCat = (cat === 'all') || text.includes(cat);
      const matchesArea = (areaVal === 'all') || text.includes(areaVal);

      if (matchesQuery && matchesCat && matchesArea) {
        item.style.display = '';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    let emptyBox = document.getElementById('no-archive-results');
    if (visibleCount === 0) {
      if (!emptyBox) {
        emptyBox = document.createElement('div');
        emptyBox.id = 'no-archive-results';
        emptyBox.className = 'empty';
        emptyBox.style.marginTop = '20px';
        emptyBox.textContent = 'No matches. Try another category, location, or search.';
        resultsContainer.parentNode.insertBefore(emptyBox, resultsContainer.nextSibling);
      } else {
        emptyBox.style.display = 'block';
      }
    } else if (emptyBox) {
      emptyBox.style.display = 'none';
    }

    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => updateUrlParams(query, cat, areaVal), 200);
  }

  if (searchInput) searchInput.addEventListener('input', filterCards);
  if (categorySelect) categorySelect.addEventListener('change', filterCards);
  if (areaSelect) areaSelect.addEventListener('change', filterCards);

  if (initialQuery || (initialCategory && initialCategory.toLowerCase() !== 'all') || (initialArea && initialArea.toLowerCase() !== 'all')) {
    filterCards();
  }
}

/**
 * Multi-Type Community Submission Form (/submit)
 */
function renderDynamicSubmissionFields(type) {
  const container = document.getElementById('dynamic-submission-fields');
  if (!container) return;

  const areas = ['Clark County', 'Las Vegas', 'Henderson', 'North Las Vegas', 'Summerlin', 'United States'];
  const categories = type === 'businesses'
    ? ['Physicians', 'Attorneys', 'Accountants', 'Other businesses']
    : type === 'correction'
      ? ['Correction']
      : ['Community', 'People', 'Culture', 'Business', 'National', 'Public records'];

  let html = `
    <label>Location
      <select name="area">
        ${areas.map((a) => `<option value="${escHtml(a)}">${escHtml(a)}</option>`).join('')}
      </select>
    </label>
    <label>Category
      <select name="category">
        ${categories.map((c) => `<option value="${escHtml(c)}">${escHtml(c)}</option>`).join('')}
      </select>
    </label>
  `;

  if (type === 'businesses') {
    html += `
      <label>Specialty or service
        <input name="specialty" required maxlength="120">
      </label>
    `;
  } else if (type === 'events') {
    html += `
      <label>Event date
        <input name="date" type="date" required>
      </label>
      <label>Venue
        <input name="venue" maxlength="200">
      </label>
    `;
  }

  container.innerHTML = html;
}

function initSubmissionForm() {
  const form = document.getElementById('story-submission-form');
  if (!form) return;

  const typeSelect = document.getElementById('submission-type');
  const params = new URLSearchParams(window.location.search);
  const initialType = params.get('type');

  if (typeSelect) {
    if (initialType && ['stories', 'businesses', 'events', 'correction'].includes(initialType)) {
      typeSelect.value = initialType;
    }
    renderDynamicSubmissionFields(typeSelect.value);
    typeSelect.addEventListener('change', () => renderDynamicSubmissionFields(typeSelect.value));
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn ? btn.textContent : '';
    const settings = window.valleyIndianSettings || {};
    const restUrl = settings.restUrl || '/wp-json/valley-indian/v1/submit';

    const fd = new FormData(form);
    const payload = {
      type: (fd.get('type') || 'stories').toString(),
      title: (fd.get('title') || '').toString().trim(),
      area: (fd.get('area') || 'Clark County').toString().trim(),
      category: (fd.get('category') || 'Community').toString().trim(),
      body: (fd.get('body') || '').toString().trim(),
      url: (fd.get('url') || '').toString().trim(),
      email: (fd.get('email') || '').toString().trim(),
      specialty: (fd.get('specialty') || '').toString().trim(),
      date: (fd.get('date') || '').toString().trim(),
      venue: (fd.get('venue') || '').toString().trim(),
      website: (fd.get('website') || '').toString().trim(),
      consent: form.querySelector('input[name="consent"]')?.checked || false,
    };

    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Submitting…';
    }

    try {
      const result = await vipRequest(restUrl, payload);
      form.reset();
      if (typeSelect) renderDynamicSubmissionFields(typeSelect.value);
      showToast(result.message || 'Submitted for editorial review. Nothing has been published.');
    } catch (err) {
      showToast(err.message || 'Unable to submit. Please check your entries.', true);
    } finally {
      if (btn) {
        btn.disabled = false;
        btn.textContent = originalText;
      }
    }
  });
}

/**
 * Newsletter Request Form
 */
function initNewsletterForm() {
  const form = document.getElementById('newsletter-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn ? btn.textContent : '';
    const settings = window.valleyIndianSettings || {};
    const restUrl = settings.restUrl || '/wp-json/valley-indian/v1/submit';
    const fd = new FormData(form);

    if (btn) btn.disabled = true;
    try {
      const res = await vipRequest(restUrl, {
        type: 'subscribers',
        email: (fd.get('email') || '').toString().trim(),
        website: (fd.get('website') || '').toString().trim(),
        consent: form.querySelector('input[name="consent"]')?.checked || false,
      });
      form.reset();
      showToast(res.message || 'Subscription request recorded.');
    } catch (err) {
      showToast(err.message || 'Unable to record subscription request.', true);
    } finally {
      if (btn) {
        btn.disabled = false;
        btn.textContent = originalText;
      }
    }
  });
}

/**
 * Advertising Inquiry Form (/advertise)
 */
function initAdvertiseForm() {
  const form = document.getElementById('advertise-inquiry-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn ? btn.textContent : '';
    const settings = window.valleyIndianSettings || {};
    const restUrl = settings.restUrl || '/wp-json/valley-indian/v1/submit';
    const fd = new FormData(form);

    if (btn) btn.disabled = true;
    try {
      const res = await vipRequest(restUrl, {
        type: 'inquiries',
        title: (fd.get('title') || '').toString().trim(),
        email: (fd.get('email') || '').toString().trim(),
        category: (fd.get('category') || 'Homepage banner').toString().trim(),
        body: (fd.get('body') || '').toString().trim(),
        website: (fd.get('website') || '').toString().trim(),
      });
      form.reset();
      showToast(res.message || 'Inquiry recorded for review. No email sent.');
    } catch (err) {
      showToast(err.message || 'Unable to submit inquiry.', true);
    } finally {
      if (btn) {
        btn.disabled = false;
        btn.textContent = originalText;
      }
    }
  });
}

/**
 * Authenticated Editor's Desk (/desk)
 */
const DESK_DEFAULT_STATE = {
  authenticated: false,
  stories: [
    {
      id: 1,
      title: 'Community arts gathering proposed for the fall calendar',
      category: 'Culture',
      area: 'Clark County',
      status: 'pending',
      body: 'Demo submission. Verify all details before using Approve & publish.',
      court: false,
    },
    {
      id: 2,
      title: 'Court-record lead: identity and public-interest review required',
      category: 'Public records',
      area: 'Clark County',
      status: 'pending',
      body: 'Fictional workflow example. Check the original docket, identity, case status and public-interest basis.',
      court: true,
    },
  ],
  comments: [
    {
      id: 101,
      name: 'Sample reader',
      text: 'I would love to see more local volunteer opportunities featured.',
      status: 'pending',
    },
  ],
  businesses: [],
  events: [],
  subscribers: [],
  inquiries: [],
  log: [],
};

let deskTab = 'stories';
let deskState = DESK_DEFAULT_STATE;

async function refreshDeskState() {
  const settings = window.valleyIndianSettings || {};
  const notice = document.getElementById('desk-status-notice');
  if (!settings.canModerate) {
    deskState = JSON.parse(JSON.stringify(DESK_DEFAULT_STATE));
    if (notice) {
      const loginHref = escHtml(settings.loginUrl || '/wp-login.php');
      notice.innerHTML = `Review preview mode. <a class="read" href="${loginHref}">Sign in as WordPress Editor ↗</a> to manage live pending submissions and persist moderation decisions.`;
    }
    return;
  }

  try {
    deskState = await vipRequest(settings.deskUrl || '/wp-json/valley-indian/v1/desk');
    if (notice) {
      notice.textContent = 'Authenticated WordPress editorial workspace. Decisions and audit log entries are saved on the server.';
    }
  } catch (err) {
    if (notice) {
      notice.textContent = 'Unable to load editorial queue from REST API; showing preview.';
    }
  }
}

function updateDeskStats() {
  const pendingStories = (deskState.stories || []).filter((x) => x.status === 'pending').length;
  const pendingComments = (deskState.comments || []).filter((x) => x.status === 'pending').length;
  const publishedStories = (deskState.stories || []).filter((x) => x.status === 'publish' || x.status === 'published').length;

  const s1 = document.getElementById('stat-stories-count');
  const s2 = document.getElementById('stat-comments-count');
  const s3 = document.getElementById('stat-published-count');
  if (s1) s1.textContent = String(pendingStories);
  if (s2) s2.textContent = String(pendingComments);
  if (s3) s3.textContent = String(publishedStories);
}

function renderReviewCard(kind, x) {
  const simple = ['comments', 'subscribers', 'inquiries'].includes(kind);
  const checks = [
    'Facts, identity and relevance verified',
    'Attribution and usage rights checked',
    ...(x.court ? [
      'Current case status verified',
      'Allegations distinguished from findings',
      'Response outreach and privacy reviewed',
    ] : []),
  ];

  const approveLabel = ['subscribers', 'inquiries'].includes(kind)
    ? 'Mark reviewed'
    : `Approve${kind === 'comments' ? '' : ' & publish'}`;

  return `
    <article class="card">
      <span class="tag">${x.court ? 'Court record · Enhanced review' : 'Pending review'}</span>
      <h3>${escHtml(x.title || x.name || 'Newsletter request')}</h3>
      ${x.email ? `<p>Private contact: ${escHtml(x.email)}</p>` : ''}
      ${x.text ? `<p>${escHtml(x.text)}</p>` : ''}
      ${!simple ? `
        <label>Headline
          <input id="desk-title-${x.id}" value="${escHtml(x.title)}" maxlength="160">
        </label>
        <label>Copy
          <textarea id="desk-body-${x.id}">${escHtml(x.body || '')}</textarea>
        </label>
        <div class="review" id="desk-checks-${x.id}">
          ${checks.map((label) => `<label><input type="checkbox">${escHtml(label)}</label>`).join('')}
        </div>
      ` : (x.body ? `<p>${escHtml(x.body)}</p>` : '')}
      <label>Editorial notes
        <textarea id="desk-notes-${x.id}" placeholder="Verification, follow-up, or rejection reason"></textarea>
      </label>
      <div class="actions">
        <button type="button" class="primary" onclick="window.vipDeskDecide('${kind}', ${x.id}, 'approve')">${approveLabel}</button>
        <button type="button" onclick="window.vipDeskDecide('${kind}', ${x.id}, 'reject')">Reject</button>
      </div>
    </article>
  `;
}

function renderDeskTabContent() {
  const container = document.getElementById('desk-content');
  if (!container) return;

  updateDeskStats();

  const queues = ['stories', 'comments', 'businesses', 'events', 'subscribers', 'inquiries'];
  if (queues.includes(deskTab)) {
    const pending = (deskState[deskTab] || []).filter((x) => x.status === 'pending');
    container.innerHTML = pending.length
      ? pending.map((item) => renderReviewCard(deskTab, item)).join('')
      : '<div class="empty">All caught up. No pending items in this queue.</div>';
    return;
  }

  if (deskTab === 'published') {
    const sections = [
      ['stories', 'Articles'],
      ['businesses', 'Businesses'],
      ['events', 'Events'],
    ];
    container.innerHTML = sections.map(([k, label]) => {
      const pubItems = (deskState[k] || []).filter((x) => x.status === 'publish' || x.status === 'published');
      return `
        <h2>${label}</h2>
        ${pubItems.length ? pubItems.map((x) => `
          <div class="card">
            <h3>${escHtml(x.title)}</h3>
            <div class="actions">
              <button type="button" onclick="window.vipDeskDecide('${k}', ${x.id}, 'unpublish')">Return to review</button>
            </div>
          </div>
        `).join('') : '<div class="empty">No published items yet.</div>'}
      `;
    }).join('');
    return;
  }

  if (deskTab === 'sources') {
    const rows = [
      ['Local / national news', 'RSS / licensed API'],
      ['Court records', 'Permitted alerts / manual verified import'],
      ['Facebook · Instagram · X', 'Outbound publisher / inbound moderation adapters'],
      ['Newsletter', 'Email provider + double opt-in'],
    ];
    container.innerHTML = `
      <h2>Connected-source roadmap</h2>
      <div class="tablewrap">
        <table>
          <tr><th>Source</th><th>Collection route</th><th>Status</th></tr>
          ${rows.map(([src, route]) => `<tr><td>${src}</td><td>${route}</td><td>Not connected</td></tr>`).join('')}
        </table>
      </div>
      <div class="notice">Authenticated editors can test deduplicated lead intake below. Imported leads always enter pending review.</div>
      <div>
        <button type="button" class="primary" onclick="window.vipDeskImport()">Test feed intake</button>
      </div>
    `;
    return;
  }

  const log = (deskState.log || []).slice().reverse();
  container.innerHTML = log.length
    ? log.map((entry) => `
      <article class="audit-log-item">
        <strong>${escHtml(entry.action)}</strong>
        <p>${escHtml(entry.title)}</p>
        <small class="muted">${escHtml(entry.time)}</small>
        ${entry.notes ? `<p>${escHtml(entry.notes)}</p>` : ''}
      </article>
    `).join('')
    : '<div class="empty">No decisions recorded yet.</div>';
}

window.vipDeskDecide = async function (kind, id, action) {
  const settings = window.valleyIndianSettings || {};
  const item = (deskState[kind] || []).find((x) => x.id === id);
  if (!item) return;

  const titleEl = document.getElementById(`desk-title-${id}`);
  const bodyEl = document.getElementById(`desk-body-${id}`);
  const notesEl = document.getElementById(`desk-notes-${id}`);
  const checks = [...document.querySelectorAll(`#desk-checks-${id} input`)].map((c) => c.checked);

  const payload = {
    kind,
    id,
    action,
    title: titleEl ? titleEl.value.trim() : undefined,
    body: bodyEl ? bodyEl.value.trim() : undefined,
    notes: notesEl ? notesEl.value.trim() : '',
    checks,
  };

  if (action === 'approve' && !['comments', 'subscribers', 'inquiries'].includes(kind)) {
    if ((titleEl && !payload.title) || (bodyEl && !payload.body) || checks.some((v) => !v)) {
      showToast('Complete every verification check and the article text.', true);
      return;
    }
    if (item.court && !payload.notes) {
      showToast('Document case verification and outreach before publication.', true);
      return;
    }
  }

  if (!settings.canModerate) {
    if (action === 'reject') {
      item.status = 'rejected';
    } else if (action === 'unpublish') {
      item.status = 'pending';
    } else {
      item.status = 'publish';
    }
    deskState.log.push({
      action: `${kind} ${action}`,
      title: item.title || item.text || 'Preview item',
      notes: payload.notes,
      time: new Date().toISOString(),
    });
    renderDeskTabContent();
    showToast('Preview decision recorded (sign in as editor to save to WordPress).');
    return;
  }

  try {
    await vipRequest(`${settings.deskUrl}/decide`, payload);
    await refreshDeskState();
    renderDeskTabContent();
    showToast('Decision saved.');
  } catch (err) {
    showToast(err.message || 'Unable to save decision.', true);
  }
};

window.vipDeskImport = async function () {
  const settings = window.valleyIndianSettings || {};
  if (!settings.canModerate) {
    showToast('Sign in as WordPress Editor to test live feed intake.', true);
    return;
  }
  try {
    const res = await vipRequest(`${settings.deskUrl}/import`, {});
    await refreshDeskState();
    deskTab = 'stories';
    document.querySelectorAll('#desk-tabs button').forEach((b) => {
      b.classList.toggle('active', b.dataset.tab === 'stories');
    });
    renderDeskTabContent();
    showToast(res.message || 'Intake processed.');
  } catch (err) {
    showToast(err.message || 'Feed intake test failed.', true);
  }
};

async function initDeskWorkflow() {
  const deskWrap = document.querySelector('.desk-container');
  if (!deskWrap) return;

  const tabs = document.querySelectorAll('#desk-tabs button');
  tabs.forEach((btn) => {
    btn.addEventListener('click', () => {
      deskTab = btn.dataset.tab || 'stories';
      tabs.forEach((b) => b.classList.toggle('active', b === btn));
      renderDeskTabContent();
    });
  });

  await refreshDeskState();
  renderDeskTabContent();
}
