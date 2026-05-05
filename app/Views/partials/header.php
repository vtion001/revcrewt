<?php
$isLoggedIn = session()->get('logged_in') ?? false;
$role = session()->get('role') ?? '';
$userName = session()->get('name') ?? '';
$pageTitle = $page_title ?? 'revcrewt';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%231e3a5f'/><text x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-family='Inter,sans-serif' font-weight='800' font-size='16'>r</text></svg>">
<style>
.notif-btn { position: relative; background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: background 0.2s; color: var(--gray-500); }
.notif-btn:hover { background: var(--gray-50); color: var(--navy); }
.notif-badge { position: absolute; top: 4px; right: 4px; min-width: 18px; height: 18px; border-radius: 100px; background: #ef4444; color: #fff; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid var(--white); }
.notif-dropdown { position: absolute; top: calc(100% + 8px); right: 0; width: 320px; background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-100); box-shadow: 0 20px 60px rgba(30,58,95,0.12); z-index: 200; overflow: hidden; }
.notif-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center; }
.notif-header-title { font-size: 0.88rem; font-weight: 700; color: var(--navy); }
.notif-header-mark { font-size: 0.75rem; font-weight: 600; color: var(--cobalt); cursor: pointer; background: none; border: none; font-family: inherit; padding: 0; }
.notif-header-mark:hover { text-decoration: underline; }
.notif-empty { padding: 2rem 1.25rem; text-align: center; }
.notif-empty-text { font-size: 0.85rem; color: var(--gray-400); }
.notif-item { display: flex; gap: 0.85rem; padding: 0.9rem 1.25rem; border-bottom: 1px solid var(--gray-100); cursor: pointer; transition: background 0.15s; }
.notif-item:last-child { border-bottom: none; }
.notif-item:hover { background: var(--gray-50); }
.notif-item.unread { background: rgba(0,74,173,0.03); }
.notif-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--cobalt-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--cobalt); }
.notif-content { flex: 1; min-width: 0; }
.notif-title { font-size: 0.82rem; font-weight: 600; color: var(--navy); line-height: 1.3; }
.notif-msg { font-size: 0.75rem; color: var(--gray-500); margin-top: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.notif-time { font-size: 0.7rem; color: var(--gray-400); margin-top: 0.25rem; }
.notif-wrap { position: relative; }
</style>
</head>
<body>

<nav class="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">rev<span>crewt</span></a>
    <div class="nav-links">
      <a href="/how-it-works" class="<?= ($page ?? '') === 'how-it-works' ? 'active' : '' ?>">How It Works</a>
      <a href="/for-employers" class="<?= ($page ?? '') === 'for-employers' ? 'active' : '' ?>">For Employers</a>
      <a href="/for-talent" class="<?= ($page ?? '') === 'for-talent' ? 'active' : '' ?>">For Talent</a>
      <a href="/pricing" class="<?= ($page ?? '') === 'pricing' ? 'active' : '' ?>">Pricing</a>
      <a href="/employer/discover" class="<?= ($page ?? '') === 'employer-discover' ? 'active' : '' ?>">Discover</a>
      <?php if ($isLoggedIn && $role === 'talent'): ?>
      <a href="/talent/profile" class="<?= ($page ?? '') === 'talent-profile' ? 'active' : '' ?>">My Profile</a>
      <?php endif ?>
    </div>

    <!-- Auth / User Section -->
    <div class="nav-cta">
      <?php if ($isLoggedIn): ?>
        <?php if ($role === 'employer'): ?>
          <?php
            $nameParts = explode(' ', trim($userName));
            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
          ?>
          <!-- Notification Bell -->
          <div class="notif-wrap">
            <button class="notif-btn" id="notif-btn" aria-label="Notifications">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
              <span class="notif-badge" id="notif-badge" style="display:none;">0</span>
            </button>
            <div class="notif-dropdown" id="notif-dropdown" style="display:none;">
              <div class="notif-header">
                <span class="notif-header-title">Notifications</span>
              </div>
              <div id="notif-list">
                <div class="notif-empty"><span class="notif-empty-text">No notifications yet</span></div>
              </div>
            </div>
          </div>
          <span style="font-size:0.85rem;font-weight:600;color:var(--gray-500);"><?= esc($userName) ?></span>
          <a href="/employer/discover" class="btn btn-outline-navy btn-sm">Dashboard</a>
          <a href="/auth/logout" class="btn btn-primary btn-sm">Logout</a>
        <?php elseif ($role === 'talent'): ?>
          <?php
            $nameParts = explode(' ', trim($userName));
            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
          ?>
          <!-- Notification Bell -->
          <div class="notif-wrap">
            <button class="notif-btn" id="notif-btn" aria-label="Notifications">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
              <span class="notif-badge" id="notif-badge" style="display:none;">0</span>
            </button>
            <div class="notif-dropdown" id="notif-dropdown" style="display:none;">
              <div class="notif-header">
                <span class="notif-header-title">Notifications</span>
              </div>
              <div id="notif-list">
                <div class="notif-empty"><span class="notif-empty-text">No notifications yet</span></div>
              </div>
            </div>
          </div>
          <span style="font-size:0.85rem;font-weight:600;color:var(--gray-500);"><?= esc($userName) ?></span>
          <a href="/talent/profile" class="btn btn-outline-navy btn-sm">My Profile</a>
          <a href="/auth/logout" class="btn btn-primary btn-sm">Logout</a>
        <?php endif ?>
      <?php else: ?>
        <a href="/auth/login" class="btn btn-outline-navy btn-sm" style="padding:0.55rem 1.25rem;">Login</a>
        <a href="/#waitlist" class="btn btn-primary btn-sm">Join Waitlist</a>
      <?php endif ?>
    </div>
  </div>
</nav>

<script>
(function() {
  var badge = document.getElementById('notif-badge');
  var dropdown = document.getElementById('notif-dropdown');
  var notifBtn = document.getElementById('notif-btn');
  var notifList = document.getElementById('notif-list');

  if (!notifBtn) return;

  function loadNotifCount() {
    fetch('/api/notifications/unread-count')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        if (data.count > 0) {
          badge.textContent = data.count > 9 ? '9+' : data.count;
          badge.style.display = 'flex';
        } else {
          badge.style.display = 'none';
        }
      })
      .catch(function() {});
  }

  function loadNotifications() {
    fetch('/api/notifications/recent')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        var notifs = data.notifications || [];
        if (notifs.length === 0) {
          notifList.innerHTML = '<div class="notif-empty"><span class="notif-empty-text">No notifications yet</span></div>';
          return;
        }
        notifList.innerHTML = notifs.map(function(n) {
          var timeAgo = timeAgo(n.created_at);
          var iconHtml = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>';
          var typeIcon = {
            'offer_received': '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>',
            'offer_accepted': '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
            'offer_declined': '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
          };
          var icon = typeIcon[n.type] || iconHtml;
          var cls = n.is_read ? '' : 'unread';
          return '<div class="notif-item ' + cls + '" onclick="markRead(' + n.id + ', this)">' +
            '<div class="notif-icon">' + icon + '</div>' +
            '<div class="notif-content">' +
              '<div class="notif-title">' + n.title + '</div>' +
              '<div class="notif-msg">' + (n.message || '') + '</div>' +
              '<div class="notif-time">' + timeAgo(n.created_at) + '</div>' +
            '</div></div>';
        }).join('');
      })
      .catch(function() {});
  }

  function timeAgo(dateStr) {
    if (!dateStr) return '';
    var date = new Date(dateStr);
    var now = new Date();
    var diff = Math.floor((now - date) / 1000);
    if (diff < 60) return 'just now';
    if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
    if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
    return Math.floor(diff / 86400) + 'd ago';
  }

  window.markRead = function(id, el) {
    fetch('/api/notifications/' + id + '/read', { method: 'POST' })
      .then(function() {
        if (el) el.classList.remove('unread');
        loadNotifCount();
      })
      .catch(function() {});
    if (dropdown) dropdown.style.display = 'none';
  };

  notifBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    if (dropdown.style.display === 'none') {
      dropdown.style.display = 'block';
      loadNotifications();
    } else {
      dropdown.style.display = 'none';
    }
  });

  document.addEventListener('click', function(e) {
    if (!dropdown.contains(e.target) && e.target !== notifBtn) {
      dropdown.style.display = 'none';
    }
  });

  loadNotifCount();
  setInterval(loadNotifCount, 30000);
})();
</script>
