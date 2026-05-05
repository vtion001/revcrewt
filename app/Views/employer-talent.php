<?php
$isLoggedIn = session()->get('logged_in') ?? false;
$isEmployer = $isLoggedIn && session()->get('role') === 'employer';
$talentId = $talent_id ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'revcrewt' ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #1e3a5f; --navy-900: #152a45;
      --cobalt: #004aad; --cobalt-400: #0066cc; --cobalt-100: rgba(0,74,173,0.07); --cobalt-200: rgba(0,74,173,0.12);
      --gray-900: #0f172a; --gray-700: #334155; --gray-500: #64748b; --gray-400: #94a3b8; --gray-300: #cbd5e1; --gray-100: #f1f5f9; --gray-50: #f8fafc; --white: #ffffff;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: var(--gray-900); background: var(--gray-50); overflow-x: hidden; line-height: 1.6; -webkit-font-smoothing: antialiased; }
    a { text-decoration: none; color: inherit; }
    ::selection { background: var(--cobalt); color: var(--white); }

    .eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--cobalt); margin-bottom: 0.75rem; }
    .body-md { font-size: 0.92rem; color: var(--gray-500); line-height: 1.7; }

    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }
    .btn-primary { background: var(--cobalt); color: var(--white); }
    .btn-primary:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-outline-navy { background: transparent; color: var(--navy); border: 2px solid var(--gray-300); }
    .btn-outline-navy:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }
    .btn-sm { padding: 0.55rem 1.4rem; font-size: 0.85rem; }

    .tag { display: inline-flex; align-items: center; padding: 0.3rem 0.85rem; border-radius: 100px; font-size: 0.78rem; font-weight: 700; background: var(--gray-100); color: var(--gray-500); }
    .tag-avail { background: rgba(0,74,173,0.08); color: var(--cobalt); }
    .tag-avail-exploring { background: rgba(234,179,8,0.1); color: #92400e; }
    .tag-avail-receptive { background: rgba(30,58,95,0.08); color: var(--navy); }

    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(30,58,95,0.06); box-shadow: 0 4px 30px rgba(30,58,95,0.05); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 1.35rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .nav-logo span { color: var(--cobalt); }
    .nav-links { display: flex; gap: 0.15rem; align-items: center; }
    .nav-links a { padding: 0.5rem 0.9rem; color: var(--gray-500); font-weight: 500; font-size: 0.88rem; border-radius: 8px; transition: all 0.2s; }
    .nav-links a:hover { color: var(--navy); background: var(--gray-50); }
    .nav-links a.active { color: var(--cobalt); background: var(--cobalt-100); }
    .nav-cta { display: flex; gap: 0.75rem; align-items: center; }

    .dash-body { padding-top: 72px; min-height: 100vh; }
    .dash-inner { max-width: 900px; margin: 0 auto; padding: 2.5rem 2rem 5rem; }

    .back-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; font-weight: 600; color: var(--gray-500); margin-bottom: 2rem; transition: color 0.2s; }
    .back-link:hover { color: var(--cobalt); }

    .profile-card { background: var(--white); border-radius: 20px; border: 1.5px solid var(--gray-100); overflow: hidden; }

    .profile-header { padding: 2.5rem 2.5rem 2rem; display: flex; gap: 1.75rem; align-items: flex-start; border-bottom: 1px solid var(--gray-100); }
    .profile-avatar { width: 88px; height: 88px; border-radius: 20px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.7rem; color: var(--white); }
    .profile-meta { flex: 1; }
    .profile-name { font-size: 1.35rem; font-weight: 800; color: var(--navy); letter-spacing: -0.03em; margin-bottom: 0.3rem; }
    .profile-headline { font-size: 0.92rem; color: var(--gray-500); line-height: 1.5; margin-bottom: 0.9rem; }
    .profile-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
    .profile-badges { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.75rem; border-radius: 8px; font-size: 0.78rem; font-weight: 600; background: var(--gray-100); color: var(--gray-700); }
    .badge svg { flex-shrink: 0; }

    .profile-body { padding: 2.5rem; }
    .profile-section { margin-bottom: 2.5rem; }
    .profile-section:last-child { margin-bottom: 0; }
    .section-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--cobalt); margin-bottom: 1rem; }
    .section-text { font-size: 0.9rem; color: var(--gray-700); line-height: 1.8; }
    .skills-wrap { display: flex; flex-wrap: wrap; gap: 0.5rem; }

    .exp-list { display: flex; flex-direction: column; gap: 1.25rem; }
    .exp-item { display: flex; gap: 1rem; }
    .exp-dot-col { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
    .exp-dot { width: 12px; height: 12px; border-radius: 50%; background: var(--cobalt); flex-shrink: 0; margin-top: 4px; }
    .exp-line { width: 1.5px; flex: 1; background: var(--gray-200); min-height: 24px; }
    .exp-content { flex: 1; padding-bottom: 0.25rem; }
    .exp-role { font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.2rem; }
    .exp-company { font-size: 0.82rem; color: var(--gray-500); margin-bottom: 0.35rem; }
    .exp-dates { font-size: 0.78rem; color: var(--gray-400); margin-bottom: 0.5rem; font-weight: 500; }
    .exp-desc { font-size: 0.85rem; color: var(--gray-600); line-height: 1.65; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem; }
    .detail-card { background: var(--gray-50); border-radius: 12px; padding: 1.25rem; border: 1.5px solid var(--gray-100); }
    .detail-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-500); margin-bottom: 0.5rem; }
    .detail-value { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .detail-sub { font-size: 0.78rem; color: var(--gray-500); margin-top: 0.2rem; }

    .profile-actions { padding: 1.75rem 2.5rem 2rem; border-top: 1px solid var(--gray-100); display: flex; gap: 1rem; }
    .btn-interview { flex: 1; padding: 0.9rem 1.5rem; border-radius: 12px; font-size: 0.92rem; font-weight: 700; background: var(--cobalt); color: var(--white); border: none; cursor: pointer; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.6rem; }
    .btn-interview:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-interview.sent { background: #16a34a; cursor: default; transform: none; box-shadow: none; }
    .btn-save { padding: 0.9rem 1.5rem; border-radius: 12px; font-size: 0.92rem; font-weight: 700; background: transparent; color: var(--navy); border: 2px solid var(--gray-200); cursor: pointer; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.6rem; }
    .btn-save:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }

    .login-overlay { position: relative; }
    .login-overlay::after { content: ''; position: absolute; inset: 0; background: rgba(248,250,252,0.85); border-radius: 0 0 20px 20px; z-index: 5; }
    .login-cta { position: absolute; bottom: -2rem; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }

    .footer { background: var(--navy-900); padding: 3rem 0; margin-top: 3rem; }
    .footer-inner { max-width: 900px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

    /* Toast */
    .toast { position: fixed; bottom: 2rem; right: 2rem; background: var(--navy); color: var(--white); padding: 0.85rem 1.5rem; border-radius: 12px; font-size: 0.88rem; font-weight: 600; box-shadow: 0 10px 30px rgba(30,58,95,0.2); z-index: 600; display: none; }
    .toast.show { display: block; animation: toastIn 0.3s ease; }
    .toast.error { background: #dc2626; }
    @keyframes toastIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 640px) {
      .profile-header { flex-direction: column; align-items: center; text-align: center; padding: 2rem 1.5rem; }
      .profile-tags, .profile-badges { justify-content: center; }
      .profile-body { padding: 1.5rem; }
      .detail-grid { grid-template-columns: 1fr; }
      .profile-actions { flex-direction: column; padding: 1.5rem; }
      .dash-inner { padding: 1.5rem 1rem 3rem; }
      .nav-links { display: none; }
    }
  </style>
</head>
<body>
<?= view('partials/header') ?>

<div class="dash-body">
  <div class="dash-inner">

    <a href="/employer/discover" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
      Back to Discover
    </a>

    <div class="profile-card" id="profile-card-wrap">

      <!-- Header -->
      <div class="profile-header">
        <div class="profile-avatar" id="profile-avatar" style="background:#1e3a5f;">--</div>
        <div class="profile-meta">
          <div class="profile-name" id="profile-name">Loading...</div>
          <div class="profile-headline" id="profile-headline">-</div>
          <div class="profile-tags" id="profile-tags"></div>
          <div class="profile-badges">
            <div class="badge" id="profile-exp-badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <span id="profile-exp">-</span>
            </div>
            <div class="badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span id="profile-location">-</span>
            </div>
            <span id="profile-avail-tag" class="tag tag-avail">-</span>
          </div>
        </div>
      </div>

      <!-- Body -->
      <div class="profile-body">

        <!-- Summary -->
        <div class="profile-section">
          <div class="section-label">About</div>
          <p class="section-text" id="profile-summary">Loading talent profile...</p>
        </div>

        <!-- Salary & Availability -->
        <div class="detail-grid">
          <div class="detail-card">
            <div class="detail-label">Salary Expectation</div>
            <div class="detail-value" id="profile-salary">-</div>
            <div class="detail-sub">per month</div>
          </div>
          <div class="detail-card">
            <div class="detail-label">Availability</div>
            <div class="detail-value" id="profile-avail-text">-</div>
            <div class="detail-sub" id="profile-avail-sub">-</div>
          </div>
        </div>

        <!-- Experience -->
        <div class="profile-section">
          <div class="section-label">Experience</div>
          <div class="exp-list" id="exp-list">
            <div style="font-size:0.88rem;color:var(--gray-400);padding:1rem 0;">Loading experience...</div>
          </div>
        </div>

        <!-- Skills -->
        <div class="profile-section">
          <div class="section-label">Skills</div>
          <div class="skills-wrap" id="skills-wrap"></div>
        </div>

      </div>

      <!-- Actions -->
      <div class="profile-actions" id="profile-actions">
        <?php if ($isEmployer): ?>
        <button class="btn-interview" id="send-offer-btn" onclick="openOfferModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          <span id="send-offer-label">Send Offer</span>
        </button>
        <button class="btn-save">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
          Save to Tracked
        </button>
        <?php else: ?>
        <a href="/auth/login" class="btn-interview" style="flex:1;justify-content:center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          Login to Send Offer
        </a>
        <button class="btn-save">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
          Save to Tracked
        </button>
        <?php endif ?>
      </div>

    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>

<script>
var talentId = <?= $talentId ?>;
var talentData = null;
var alreadySent = false;
var AVATAR_COLORS = ['#1e3a5f','#004aad','#334155','#0f172a','#1e40af','#1d4ed8','#065f46','#064e3b','#7c3aed','#6d28d9'];

function getAvatarColor(name) {
  var hash = 0;
  for (var i = 0; i < (name||'').length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
  return AVATAR_COLORS[Math.abs(hash) % AVATAR_COLORS.length];
}
function getInitials(name) {
  if (!name) return '??';
  var parts = name.trim().split(' ');
  if (parts.length >= 2) return (parts[0][0] + parts[1][0]).toUpperCase();
  return name.substring(0, 2).toUpperCase();
}
function getAvailTag(status) {
  if (status === 'open') return '<span class="tag tag-avail">Open to Work</span>';
  if (status === 'exploring') return '<span class="tag tag-avail-exploring">Exploring</span>';
  if (status === 'receptive') return '<span class="tag tag-avail-receptive">Receptive</span>';
  return '<span class="tag">' + (status || '-') + '</span>';
}
function getAvailText(status) {
  if (status === 'open') return 'Open to Work';
  if (status === 'exploring') return 'Exploring';
  if (status === 'receptive') return 'Receptive';
  return status || '-';
}
function getAvailSub(status) {
  if (status === 'open') return 'Ready to start';
  if (status === 'exploring') return 'Actively considering';
  if (status === 'receptive') return 'Currently employed';
  return '-';
}

function renderTalent(data) {
  talentData = data;
  var name = data.name || data.headline || 'Talent';
  var headline = data.headline || '';
  var skills = data.skills_array || (data.skills ? JSON.parse(data.skills) : []) || [];
  var expYears = data.experience_years || 0;
  var color = getAvatarColor(name);
  var initials = getInitials(name);

  document.getElementById('profile-avatar').style.background = color;
  document.getElementById('profile-avatar').textContent = initials;
  document.getElementById('profile-name').textContent = name;
  document.getElementById('profile-headline').textContent = headline;
  document.getElementById('profile-exp').textContent = expYears + ' Years Experience';
  document.getElementById('profile-location').textContent = data.location || 'Philippines';
  document.getElementById('profile-summary').textContent = data.summary || 'No summary provided.';
  document.getElementById('profile-avail-tag').outerHTML = getAvailTag(data.availability_status);
  document.getElementById('profile-avail-text').textContent = getAvailText(data.availability_status);
  document.getElementById('profile-avail-sub').textContent = getAvailSub(data.availability_status);

  var salMin = data.salary_min ? 'PHP ' + Number(data.salary_min).toLocaleString() : '';
  var salMax = data.salary_max ? 'PHP ' + Number(data.salary_max).toLocaleString() : '';
  document.getElementById('profile-salary').textContent = salMin && salMax ? salMin + ' - ' + salMax : (salMin || salMax || '-');

  // Tags
  document.getElementById('profile-tags').innerHTML = skills.slice(0, 5).map(function(s) {
    return '<span class="tag">' + s + '</span>';
  }).join('');

  // Skills
  document.getElementById('skills-wrap').innerHTML = skills.map(function(s) {
    return '<span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">' + s + '</span>';
  }).join('');

  // Experience placeholder (no experience field in model, so show placeholder)
  var expList = document.getElementById('exp-list');
  if (headline) {
    expList.innerHTML = '<div class="exp-item">' +
      '<div class="exp-dot-col"><div class="exp-dot"></div><div class="exp-line" style="background:transparent;"></div></div>' +
      '<div class="exp-content">' +
        '<div class="exp-role">' + headline + '</div>' +
        '<div class="exp-company">-</div>' +
        '<div class="exp-dates">' + expYears + ' years of experience</div>' +
        '<div class="exp-desc">' + (data.summary || 'Detailed experience information will be available once the talent completes their profile.') + '</div>' +
      '</div></div>';
  }
}

function loadTalent() {
  fetch('/api/talents/' + talentId)
    .then(function(r) { return r.json(); })
    .then(function(data) {
      renderTalent(data);
      // Check if offer already sent
      return fetch('/api/offers/sent');
    })
    .then(function(r) { return r.json(); })
    .then(function(offersData) {
      var sentOffers = offersData.offers || [];
      var alreadySentOffer = sentOffers.find(function(o) { return o.talent_id == talentId || o.talent_id == talentId; });
      if (alreadySentOffer) {
        alreadySent = true;
        var btn = document.getElementById('send-offer-btn');
        if (btn) {
          btn.classList.add('sent');
          btn.disabled = true;
          var label = document.getElementById('send-offer-label');
          if (label) label.textContent = 'Offer Already Sent';
        }
      }
    })
    .catch(function() {
      document.getElementById('profile-name').textContent = 'Talent not found';
      document.getElementById('profile-summary').textContent = 'This talent profile could not be loaded.';
    });
}

function showToast(msg, isError) {
  var toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.className = 'toast show' + (isError ? ' error' : '');
  setTimeout(function() { toast.className = 'toast'; }, 3000);
}
window.showToast = showToast;

function openOfferModal() {
  if (!talentData) return;
  var name = talentData.name || 'this talent';
  var overlay = document.createElement('div');
  overlay.id = 'offer-modal-overlay';
  overlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:500;display:flex;align-items:center;justify-content:center;padding:1rem;';
  overlay.innerHTML = '<div style="background:var(--white);border-radius:20px;padding:2.5rem;width:100%;max-width:480px;box-shadow:0 24px 64px rgba(0,0,0,0.15);position:relative;">' +
    '<button onclick="this.closest(\'#offer-modal-overlay\').remove()" style="position:absolute;top:1.25rem;right:1.25rem;background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:1.4rem;line-height:1;">&times;</button>' +
    '<h2 style="font-size:1.2rem;font-weight:800;color:var(--navy);margin-bottom:0.25rem;">Send Offer to ' + name + '</h2>' +
    '<p style="font-size:0.82rem;color:var(--gray-500);margin-bottom:1.5rem;">Fill in the details below to send an offer.</p>' +
    '<div id="modal-error" style="display:none;background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:10px;margin-bottom:1rem;font-size:0.88rem;"></div>' +
    '<form id="offer-form" onsubmit="submitOffer(event)">' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Role / Position</label>' +
        '<input type="text" name="subject" required style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;box-sizing:border-box;" placeholder="e.g. Senior Full-Stack Developer">' +
      '</div>' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Proposed Salary (PHP/month)</label>' +
        '<input type="text" name="proposed_salary" style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;box-sizing:border-box;" placeholder="e.g. PHP 120,000">' +
      '</div>' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Offer Type</label>' +
        '<select name="offer_type" required style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;background:var(--white);box-sizing:border-box;">' +
          '<option value="free_interview">Free Interview</option>' +
          '<option value="paid_interview">Paid Interview</option>' +
          '<option value="paid_assessment">Paid Assessment</option>' +
        '</select>' +
      '</div>' +
      '<div style="margin-bottom:1.5rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Message (optional)</label>' +
        '<textarea name="message" rows="3" style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;resize:vertical;box-sizing:border-box;" placeholder="Introduce your company and the opportunity..."></textarea>' +
      '</div>' +
      '<input type="hidden" name="talent_id" value="' + talentId + '">' +
      '<button type="submit" id="offer-submit-btn" style="width:100%;padding:0.85rem;border-radius:12px;background:var(--cobalt);color:var(--white);border:none;font-size:0.95rem;font-weight:700;cursor:pointer;font-family:inherit;transition:all 0.2s;">Send Offer</button>' +
    '</form>' +
  '</div>';
  document.body.appendChild(overlay);
  overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
}
window.openOfferModal = openOfferModal;

function submitOffer(e) {
  e.preventDefault();
  var form = e.target;
  var btn = document.getElementById('offer-submit-btn');
  var orig = btn.textContent;
  btn.textContent = 'Sending...';
  btn.disabled = true;
  var errorDiv = document.getElementById('modal-error');
  errorDiv.style.display = 'none';

  var formData = new FormData(form);
  fetch('/api/offers', { method: 'POST', body: formData })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.status && data.status >= 400) {
        errorDiv.textContent = data.message || 'Failed to send offer.';
        errorDiv.style.display = 'block';
        btn.textContent = orig;
        btn.disabled = false;
        return;
      }
      var overlay = document.getElementById('offer-modal-overlay');
      if (overlay) overlay.remove();
      showToast('Offer sent!');
      alreadySent = true;
      var btnEl = document.getElementById('send-offer-btn');
      if (btnEl) { btnEl.classList.add('sent'); btnEl.disabled = true; }
      var labelEl = document.getElementById('send-offer-label');
      if (labelEl) labelEl.textContent = 'Offer Sent';
    })
    .catch(function() {
      var errorDiv = document.getElementById('modal-error');
      errorDiv.textContent = 'Network error. Please try again.';
      errorDiv.style.display = 'block';
      btn.textContent = orig;
      btn.disabled = false;
    });
}

loadTalent();
</script>
</body>
</html>