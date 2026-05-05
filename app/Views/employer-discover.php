<?php
$isLoggedIn = session()->get('logged_in') ?? false;
$isEmployer = $isLoggedIn && session()->get('role') === 'employer';
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
    img { max-width: 100%; display: block; }
    ::selection { background: var(--cobalt); color: var(--white); }

    .eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--cobalt); margin-bottom: 0.75rem; }
    .body-md { font-size: 0.92rem; color: var(--gray-500); line-height: 1.7; }

    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }
    .btn-primary { background: var(--cobalt); color: var(--white); }
    .btn-primary:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-navy { background: var(--navy); color: var(--white); }
    .btn-navy:hover { background: var(--navy-900); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(30,58,95,0.25); }
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
    .dash-inner { max-width: 1280px; margin: 0 auto; padding: 2.5rem 2rem 6rem; display: flex; gap: 2rem; align-items: flex-start; }

    /* Sidebar */
    .dash-sidebar { width: 268px; flex-shrink: 0; position: sticky; top: 90px; }
    .dash-sidebar-card { background: var(--white); border: 1.5px solid var(--gray-100); border-radius: 16px; padding: 1.75rem; }
    .sidebar-section { margin-bottom: 1.75rem; }
    .sidebar-section:last-child { margin-bottom: 0; }
    .filter-title { font-size: 0.8rem; font-weight: 700; color: var(--gray-900); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.9rem; }
    .filter-group { display: flex; flex-direction: column; gap: 0.55rem; }
    .filter-check { display: flex; align-items: center; gap: 0.65rem; cursor: pointer; }
    .filter-check input[type="checkbox"] { width: 16px; height: 16px; border-radius: 4px; accent-color: var(--cobalt); cursor: pointer; }
    .filter-check label { font-size: 0.88rem; color: var(--gray-700); cursor: pointer; line-height: 1; }
    .sidebar-divider { height: 1px; background: var(--gray-100); margin: 1.5rem 0; }
    .range-display { font-size: 0.85rem; color: var(--gray-700); font-weight: 600; margin-top: 0.75rem; }
    input[type="range"] { width: 100%; accent-color: var(--cobalt); cursor: pointer; }

    /* Main content */
    .dash-main { flex: 1; min-width: 0; }

    /* Tabs */
    .dash-tabs { display: flex; gap: 0.25rem; margin-bottom: 1.75rem; border-bottom: 2px solid var(--gray-100); }
    .dash-tab { padding: 0.65rem 1.25rem; font-size: 0.88rem; font-weight: 600; color: var(--gray-500); background: none; border: none; cursor: pointer; font-family: inherit; transition: all 0.2s; border-bottom: 2px solid transparent; margin-bottom: -2px; border-radius: 8px 8px 0 0; }
    .dash-tab:hover { color: var(--navy); }
    .dash-tab.active { color: var(--cobalt); border-bottom-color: var(--cobalt); }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Stats bar */
    .stats-bar { background: var(--white); border: 1.5px solid var(--gray-100); border-radius: 16px; padding: 1.5rem 2rem; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center; }
    .stats-left { display: flex; gap: 3rem; }
    .stat-item { display: flex; flex-direction: column; }
    .stat-val { font-size: 1.4rem; font-weight: 900; color: var(--navy); letter-spacing: -0.03em; line-height: 1; }
    .stat-val span { color: var(--cobalt); }
    .stat-lbl { font-size: 0.75rem; color: var(--gray-500); margin-top: 0.25rem; }
    .stats-right { display: flex; align-items: center; gap: 1rem; }
    .sort-wrap { display: flex; align-items: center; gap: 0.6rem; }
    .sort-label { font-size: 0.82rem; color: var(--gray-500); font-weight: 500; }
    select.sort-select { padding: 0.5rem 2.2rem 0.5rem 0.9rem; border-radius: 8px; border: 1.5px solid var(--gray-200); font-size: 0.85rem; font-weight: 600; color: var(--navy); background: var(--white); font-family: inherit; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.7rem center; }
    select.sort-select:focus { outline: none; border-color: var(--cobalt); }

    /* Search */
    .search-bar { background: var(--white); border: 1.5px solid var(--gray-200); border-radius: 12px; padding: 0.85rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; transition: border-color 0.2s; }
    .search-bar:focus-within { border-color: var(--cobalt); }
    .search-bar svg { flex-shrink: 0; color: var(--gray-400); }
    .search-bar input { flex: 1; border: none; outline: none; font-size: 0.92rem; color: var(--gray-900); background: transparent; font-family: inherit; }
    .search-bar input::placeholder { color: var(--gray-400); }

    /* Talent grid */
    .talent-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; margin-bottom: 2rem; }
    .talent-card { background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-100); padding: 1.5rem; transition: all 0.3s; display: flex; flex-direction: column; gap: 1rem; }
    .talent-card:hover { box-shadow: 0 16px 50px rgba(30,58,95,0.1); transform: translateY(-4px); border-color: var(--gray-300); }
    .talent-card-top { display: flex; align-items: flex-start; gap: 1rem; }
    .talent-avatar { width: 54px; height: 54px; border-radius: 14px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.05rem; color: var(--white); }
    .talent-info { flex: 1; min-width: 0; }
    .talent-name { font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.2rem; }
    .talent-headline { font-size: 0.82rem; color: var(--gray-500); line-height: 1.4; margin-bottom: 0.65rem; }
    .talent-tags { display: flex; flex-wrap: wrap; gap: 0.35rem; }
    .talent-meta { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .talent-exp { font-size: 0.78rem; color: var(--gray-500); font-weight: 500; display: flex; align-items: center; gap: 0.3rem; }
    .talent-exp svg { color: var(--gray-400); }
    .talent-divider { height: 1px; background: var(--gray-100); }
    .talent-actions { display: flex; gap: 0.6rem; }
    .btn-card-primary { flex: 1; padding: 0.6rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; background: var(--cobalt); color: var(--white); border: none; cursor: pointer; transition: all 0.2s; font-family: inherit; text-align: center; display: flex; align-items: center; justify-content: center; }
    .btn-card-primary:hover { background: var(--cobalt-400); }
    .btn-card-primary.sent { background: #16a34a; cursor: default; }
    .btn-card-outline { flex: 1; padding: 0.6rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; background: transparent; color: var(--navy); border: 1.5px solid var(--gray-200); cursor: pointer; transition: all 0.2s; font-family: inherit; text-align: center; }
    .btn-card-outline:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }

    /* Pagination */
    .pagination { display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 2rem 0; }
    .page-btn { width: 38px; height: 38px; border-radius: 8px; border: 1.5px solid var(--gray-200); background: var(--white); color: var(--gray-700); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; justify-content: center; }
    .page-btn:hover { border-color: var(--cobalt); color: var(--cobalt); }
    .page-btn.active { background: var(--cobalt); color: var(--white); border-color: var(--cobalt); }
    .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* Empty state */
    .empty-state { text-align: center; padding: 4rem 2rem; background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-100); }
    .empty-icon { width: 56px; height: 56px; margin: 0 auto 1.25rem; background: var(--gray-100); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
    .empty-title { font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; }
    .empty-body { font-size: 0.88rem; color: var(--gray-500); }

    /* My Offers */
    .offers-stat-row { display: flex; gap: 1.5rem; margin-bottom: 1.75rem; flex-wrap: wrap; }
    .offers-stat { background: var(--white); border: 1.5px solid var(--gray-100); border-radius: 16px; padding: 1.25rem 1.75rem; display: flex; align-items: center; gap: 1.25rem; }
    .offers-stat-num { font-size: 1.8rem; font-weight: 900; color: var(--navy); letter-spacing: -0.04em; line-height: 1; }
    .offers-stat-label { font-size: 0.82rem; color: var(--gray-500); font-weight: 500; }
    .offers-table { background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-100); overflow: hidden; }
    .offers-table table { width: 100%; border-collapse: collapse; }
    .offers-table th { padding: 1rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-500); border-bottom: 1px solid var(--gray-100); background: var(--gray-50); }
    .offers-table td { padding: 1rem 1.25rem; font-size: 0.88rem; color: var(--gray-700); border-bottom: 1px solid var(--gray-100); }
    .offers-table tr:last-child td { border-bottom: none; }
    .offers-table tr:hover td { background: var(--gray-50); }
    .status-badge { display: inline-flex; padding: 0.25rem 0.75rem; border-radius: 100px; font-size: 0.75rem; font-weight: 700; }
    .status-pending { background: rgba(234,179,8,0.1); color: #92400e; }
    .status-accepted { background: rgba(22,163,74,0.1); color: #166534; }
    .status-declined { background: rgba(239,68,68,0.1); color: #991b1b; }

    /* Sticky bottom bar */
    .sticky-bar { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--white); border-top: 1.5px solid var(--gray-100); padding: 0.9rem 2rem; z-index: 90; box-shadow: 0 -8px 30px rgba(30,58,95,0.08); }
    .sticky-bar.visible { display: block; }
    .sticky-bar-inner { max-width: 1280px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .sticky-bar-text { font-size: 0.92rem; font-weight: 600; color: var(--navy); }
    .sticky-bar-text span { color: var(--cobalt); }

    /* Toast */
    .toast { position: fixed; bottom: 80px; right: 2rem; background: var(--navy); color: var(--white); padding: 0.85rem 1.5rem; border-radius: 12px; font-size: 0.88rem; font-weight: 600; box-shadow: 0 10px 30px rgba(30,58,95,0.2); z-index: 300; display: none; }
    .toast.show { display: block; animation: toastIn 0.3s ease; }
    .toast.error { background: #dc2626; }
    @keyframes toastIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .footer { background: var(--navy-900); padding: 3rem 0; }
    .footer-inner { max-width: 1280px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

    @media (max-width: 900px) {
      .dash-inner { flex-direction: column; }
      .dash-sidebar { width: 100%; position: static; }
      .talent-grid { grid-template-columns: 1fr; }
      .stats-bar { flex-direction: column; gap: 1rem; align-items: flex-start; }
      .stats-left { flex-wrap: wrap; gap: 1.5rem; }
    }
    @media (max-width: 600px) {
      .dash-inner { padding: 1.5rem 1rem 6rem; }
      .nav-links { display: none; }
      .offers-table { overflow-x: auto; }
    }
  </style>
</head>
<body>
<?= view('partials/header') ?>

<div class="dash-body">
  <div class="dash-inner">

    <!-- Sidebar -->
    <aside class="dash-sidebar">
      <div class="dash-sidebar-card">
        <div class="sidebar-section">
          <div class="filter-title">Skills</div>
          <div class="filter-group">
            <?php $skillFilters = ['PHP / Laravel' => 'php', 'JavaScript / React' => 'js', 'Python' => 'python', 'Node.js' => 'node', 'UI/UX Design' => 'design', 'Data Analysis' => 'data', 'DevOps / Cloud' => 'devops']; ?>
            <?php foreach ($skillFilters as $label => $id): ?>
            <div class="filter-check">
              <input type="checkbox" id="sk-<?= $id ?>" data-filter="skills" value="<?= $id ?>">
              <label for="sk-<?= $id ?>"><?= $label ?></label>
            </div>
            <?php endforeach ?>
          </div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Experience Level</div>
          <div class="filter-group">
            <?php $expFilters = ['Junior (0-2 yrs)' => 'junior', 'Mid-Level (3-5 yrs)' => 'mid', 'Senior (6-9 yrs)' => 'senior', 'Lead (10+ yrs)' => 'lead']; ?>
            <?php foreach ($expFilters as $label => $id): ?>
            <div class="filter-check">
              <input type="checkbox" id="lv-<?= $id ?>" data-filter="experience" value="<?= $id ?>">
              <label for="lv-<?= $id ?>"><?= $label ?></label>
            </div>
            <?php endforeach ?>
          </div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Availability</div>
          <div class="filter-group">
            <div class="filter-check">
              <input type="checkbox" id="av-open" data-filter="availability" value="open">
              <label for="av-open">Open to Work</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="av-exploring" data-filter="availability" value="exploring">
              <label for="av-exploring">Exploring</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="av-receptive" data-filter="availability" value="receptive">
              <label for="av-receptive">Receptive (employed)</label>
            </div>
          </div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Salary Expectation</div>
          <input type="range" id="salary-range" min="20000" max="300000" step="5000" value="150000">
          <div class="range-display" id="salary-display">Up to PHP 150,000/mo</div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Location</div>
          <div class="filter-group">
            <div class="filter-check"><input type="checkbox" id="loc-mnl"><label for="loc-mnl">Metro Manila</label></div>
            <div class="filter-check"><input type="checkbox" id="loc-ces"><label for="loc-ces">Cebu / Visayas</label></div>
            <div class="filter-check"><input type="checkbox" id="loc-dav"><label for="loc-dav">Davao / Mindanao</label></div>
            <div class="filter-check"><input type="checkbox" id="loc-wfh"><label for="loc-wfh">Remote / Work from Home</label></div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="dash-main">

      <?php if ($isEmployer): ?>
      <!-- Dashboard Tabs -->
      <div class="dash-tabs">
        <button class="dash-tab active" onclick="switchDashTab('discover', this)">Discover Talent</button>
        <button class="dash-tab" onclick="switchDashTab('offers', this)">My Offers</button>
      </div>
      <?php endif ?>

      <!-- Discover Tab -->
      <div id="tab-discover" class="tab-panel <?= !$isEmployer ? 'active' : '' ?>">

        <!-- Stats bar -->
        <div class="stats-bar reveal">
          <div class="stats-left">
            <div class="stat-item">
              <div class="stat-val" id="stat-total">0<span>+</span></div>
              <div class="stat-lbl">Talents Available</div>
            </div>
            <div class="stat-item">
              <div class="stat-val" id="stat-open">0</div>
              <div class="stat-lbl">Open to Work</div>
            </div>
            <div class="stat-item">
              <div class="stat-val" id="stat-premium">0</div>
              <div class="stat-lbl">Premium</div>
            </div>
          </div>
          <div class="stats-right">
            <div class="sort-wrap">
              <span class="sort-label">Sort:</span>
              <select class="sort-select" id="sort-select">
                <option value="newest">Newest</option>
                <option value="experience">Most Experienced</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Search -->
        <div class="search-bar reveal">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          <input type="text" placeholder="Search by skill, role, or name" id="search-input">
        </div>

        <!-- Talent grid -->
        <div class="talent-grid" id="talent-grid"></div>

        <!-- Empty state -->
        <div class="empty-state" id="empty-state" style="display:none;">
          <div class="empty-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          </div>
          <div class="empty-title">No talents match your filters.</div>
          <div class="empty-body">Try adjusting your search criteria.</div>
        </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination"></div>
      </div>

      <!-- My Offers Tab -->
      <?php if ($isEmployer): ?>
      <div id="tab-offers" class="tab-panel">
        <div class="offers-stat-row">
          <div class="offers-stat">
            <div class="offers-stat-num" id="month-offers-count">0</div>
            <div class="offers-stat-label">Offers sent<br>this month</div>
          </div>
          <div class="offers-stat">
            <div class="offers-stat-num" id="pending-offers-count">0</div>
            <div class="offers-stat-label">Pending<br>responses</div>
          </div>
          <div class="offers-stat">
            <div class="offers-stat-num" id="accepted-offers-count">0</div>
            <div class="offers-stat-label">Offers<br>accepted</div>
          </div>
        </div>

        <div class="offers-table">
          <table>
            <thead>
              <tr>
                <th>Talent</th>
                <th>Role / Subject</th>
                <th>Type</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Sent</th>
              </tr>
            </thead>
            <tbody id="offers-tbody"></tbody>
          </table>
        </div>
        <div id="offers-empty" class="empty-state" style="display:none;margin-top:1.5rem;">
          <div class="empty-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          </div>
          <div class="empty-title">No offers sent yet.</div>
          <div class="empty-body">When you send offers to talents, they'll appear here.</div>
        </div>
      </div>
      <?php endif ?>

    </main>
  </div>
</div>

<!-- Sticky Bottom Bar -->
<?php if ($isEmployer): ?>
<div class="sticky-bar" id="sticky-bar">
  <div class="sticky-bar-inner">
    <div class="sticky-bar-text">Ready to send an offer? <span>Find a talent and click "Send Offer"</span></div>
    <a href="#tab-discover" class="btn btn-primary btn-sm" style="padding:0.6rem 1.5rem;" onclick="document.getElementById('search-input').focus(); return false;">Find Talent</a>
  </div>
</div>
<?php endif ?>

<!-- Toast -->
<div class="toast" id="toast"></div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>

<script>
var AVATAR_COLORS = ['#1e3a5f','#004aad','#334155','#0f172a','#1e40af','#1d4ed8','#065f46','#064e3b','#7c3aed','#6d28d9'];
function getAvatarColor(name) {
  var hash = 0;
  for (var i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
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
  return '<span class="tag">' + (status || 'Unknown') + '</span>';
}
function getOfferTypeLabel(type) {
  if (type === 'free_interview') return 'Free Interview';
  if (type === 'paid_interview') return 'Paid Interview';
  if (type === 'paid_assessment') return 'Paid Assessment';
  return type;
}
function getStatusBadge(status) {
  if (status === 'pending') return '<span class="status-badge status-pending">Pending</span>';
  if (status === 'accepted') return '<span class="status-badge status-accepted">Accepted</span>';
  if (status === 'declined') return '<span class="status-badge status-declined">Declined</span>';
  return '<span class="status-badge">' + (status || '') + '</span>';
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

var currentPage = 1;
var isEmployer = <?= $isEmployer ? 'true' : 'false' ?>;
var sentOffers = {};

function buildTalentCard(t) {
  var color = getAvatarColor(t.name || t.headline || '??');
  var initials = getInitials(t.name || '??');
  var skillTags = (t.skills_array || []).slice(0, 4).map(function(s) {
    return '<span class="tag">' + s + '</span>';
  }).join('');
  var availTag = getAvailTag(t.availability_status);
  var expYears = t.experience_years || 0;
  var sentKey = t.user_id || t.id;
  var alreadySent = sentOffers[sentKey];

  var viewBtn = '<a href="/employer/talent/' + (t.id || t.user_id) + '" class="btn-card-primary">View Profile</a>';
  var secondBtn;

  if (!isEmployer) {
    secondBtn = '<a href="/auth/login" class="btn-card-outline">Login to Send Offer</a>';
  } else if (alreadySent) {
    secondBtn = '<button class="btn-card-primary sent" disabled>Offer Sent</button>';
  } else {
    secondBtn = '<button class="btn-card-primary" onclick="openOfferModal(' + (t.user_id || t.id) + ', \'' + (t.name || '').replace(/'/g, "\\'") + '\')">Send Offer</button>';
  }

  return '<div class="talent-card reveal">' +
    '<div class="talent-card-top">' +
      '<div class="talent-avatar" style="background:' + color + ';">' + initials + '</div>' +
      '<div class="talent-info">' +
        '<div class="talent-name">' + (t.name || 'Unknown') + '</div>' +
        '<div class="talent-headline">' + (t.headline || '') + '</div>' +
        '<div class="talent-tags">' + skillTags + '</div>' +
      '</div>' +
    '</div>' +
    '<div class="talent-meta">' +
      '<div class="talent-exp"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>' + expYears + ' yrs exp</div>' +
      availTag +
    '</div>' +
    '<div class="talent-divider"></div>' +
    '<div class="talent-actions">' + viewBtn + secondBtn + '</div>' +
  '</div>';
}

function loadTalents(page) {
  currentPage = page || 1;
  var params = new URLSearchParams();
  params.set('page', currentPage);
  var q = document.getElementById('search-input').value;
  if (q) params.set('q', q);
  var sort = document.getElementById('sort-select').value;
  if (sort) params.set('sort', sort);

  document.querySelectorAll('input[data-filter]:checked').forEach(function(cb) {
    var f = cb.dataset.filter;
    var existing = params.get(f);
    if (existing) params.set(f, existing + ',' + cb.value);
    else params.set(f, cb.value);
  });

  document.getElementById('talent-grid').innerHTML = '<div style="padding:3rem;text-align:center;color:var(--gray-400);font-size:0.9rem;">Loading...</div>';
  document.getElementById('empty-state').style.display = 'none';

  fetch('/api/talents?' + params.toString())
    .then(function(r) { return r.json(); })
    .then(function(data) {
      var talents = data.talents || [];
      var stats = data.stats || {};
      document.getElementById('stat-total').innerHTML = (stats.total || 0) + '<span>+</span>';
      document.getElementById('stat-open').textContent = stats.openToWork || 0;
      document.getElementById('stat-premium').textContent = stats.premium || 0;

      if (talents.length === 0) {
        document.getElementById('talent-grid').innerHTML = '';
        document.getElementById('empty-state').style.display = 'block';
        return;
      }

      document.getElementById('talent-grid').innerHTML = talents.map(buildTalentCard).join('');
      renderPagination(data.pagination);

      // Reveal animation
      var reveals = document.querySelectorAll('.reveal');
      reveals.forEach(function(el) { el.classList.add('visible'); });
    })
    .catch(function() {
      document.getElementById('talent-grid').innerHTML = '<div style="padding:3rem;text-align:center;color:#ef4444;font-size:0.9rem;">Failed to load talents.</div>';
    });
}

function renderPagination(p) {
  var container = document.getElementById('pagination');
  if (!p || p.totalPages <= 1) { container.innerHTML = ''; return; }
  var html = '';
  html += '<button class="page-btn" ' + (p.page <= 1 ? 'disabled' : '') + ' onclick="loadTalents(' + (p.page - 1) + ')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>';
  for (var i = 1; i <= p.totalPages; i++) {
    html += '<button class="page-btn ' + (i === p.page ? 'active' : '') + '" onclick="loadTalents(' + i + ')">' + i + '</button>';
  }
  html += '<button class="page-btn" ' + (p.page >= p.totalPages ? 'disabled' : '') + ' onclick="loadTalents(' + (p.page + 1) + ')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>';
  container.innerHTML = html;
}

function loadSentOffers() {
  if (!isEmployer) return;
  fetch('/api/offers/sent')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      var offers = data.offers || [];
      var monthCount = data.monthCount || 0;
      document.getElementById('month-offers-count').textContent = monthCount;

      var pending = offers.filter(function(o) { return o.status === 'pending'; }).length;
      var accepted = offers.filter(function(o) { return o.status === 'accepted'; }).length;
      document.getElementById('pending-offers-count').textContent = pending;
      document.getElementById('accepted-offers-count').textContent = accepted;

      // Store sent offers for talent cards
      offers.forEach(function(o) { sentOffers[o.talent_id] = true; });

      var tbody = document.getElementById('offers-tbody');
      var emptyState = document.getElementById('offers-empty');

      if (offers.length === 0) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
        return;
      }
      emptyState.style.display = 'none';
      tbody.innerHTML = offers.map(function(o) {
        return '<tr>' +
          '<td style="font-weight:600;color:var(--navy);">' + (o.talent_name || 'Talent #' + o.talent_id) + '</td>' +
          '<td>' + (o.subject || '-') + '</td>' +
          '<td>' + getOfferTypeLabel(o.type) + '</td>' +
          '<td>' + (o.proposed_salary || '-') + '</td>' +
          '<td>' + getStatusBadge(o.status) + '</td>' +
          '<td style="color:var(--gray-400);font-size:0.8rem;">' + timeAgo(o.created_at) + '</td>' +
        '</tr>';
      }).join('');

      // Reload discover grid with sent offers info
      loadTalents(currentPage);
    })
    .catch(function() {});
}

function switchDashTab(tab, btn) {
  document.querySelectorAll('.dash-tab').forEach(function(t) { t.classList.remove('active'); });
  document.querySelectorAll('.tab-panel').forEach(function(p) { p.classList.remove('active'); });
  if (btn) btn.classList.add('active');
  document.getElementById('tab-' + tab).classList.add('active');
  if (tab === 'offers') loadSentOffers();
  if (tab === 'discover') loadTalents(currentPage);
}

// Search debounce
var searchTimer = null;
document.getElementById('search-input').addEventListener('input', function() {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(function() { loadTalents(1); }, 400);
});
document.getElementById('sort-select').addEventListener('change', function() { loadTalents(1); });
document.querySelectorAll('input[data-filter]').forEach(function(cb) {
  cb.addEventListener('change', function() { loadTalents(1); });
});

// Salary range
var salaryRange = document.getElementById('salary-range');
var salaryDisplay = document.getElementById('salary-display');
if (salaryRange && salaryDisplay) {
  salaryRange.addEventListener('input', function() {
    salaryDisplay.textContent = 'Up to PHP ' + Number(salaryRange.value).toLocaleString() + '/mo';
  });
}

// Sticky bar
var stickyBar = document.getElementById('sticky-bar');
if (stickyBar && isEmployer) {
  stickyBar.classList.add('visible');
}

// Toast
function showToast(msg, isError) {
  var toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.className = 'toast show' + (isError ? ' error' : '');
  setTimeout(function() { toast.className = 'toast'; }, 3000);
}
window.showToast = showToast;

// Offer modal
function openOfferModal(talentId, talentName) {
  var overlay = document.createElement('div');
  overlay.id = 'offer-modal-overlay';
  overlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:500;display:flex;align-items:center;justify-content:center;padding:1rem;';
  overlay.innerHTML = '<div style="background:var(--white);border-radius:20px;padding:2.5rem;width:100%;max-width:480px;box-shadow:0 24px 64px rgba(0,0,0,0.15);position:relative;">' +
    '<button onclick="this.closest(\'#offer-modal-overlay\').remove()" style="position:absolute;top:1.25rem;right:1.25rem;background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:1.2rem;line-height:1;">&times;</button>' +
    '<h2 style="font-size:1.2rem;font-weight:800;color:var(--navy);margin-bottom:0.25rem;">Send Offer to ' + talentName + '</h2>' +
    '<p style="font-size:0.82rem;color:var(--gray-500);margin-bottom:1.5rem;">Fill in the details below to send an offer.</p>' +
    '<div id="modal-error" style="display:none;background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:10px;margin-bottom:1rem;font-size:0.88rem;"></div>' +
    '<form id="offer-form" onsubmit="submitOffer(event, ' + talentId + ')">' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Role / Position</label>' +
        '<input type="text" name="subject" required style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;" placeholder="e.g. Senior Full-Stack Developer">' +
      '</div>' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Proposed Salary (PHP/month)</label>' +
        '<input type="text" name="proposed_salary" style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;" placeholder="e.g. PHP 120,000">' +
      '</div>' +
      '<div style="margin-bottom:1rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Offer Type</label>' +
        '<select name="offer_type" required style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;background:var(--white);">' +
          '<option value="free_interview">Free Interview</option>' +
          '<option value="paid_interview">Paid Interview</option>' +
          '<option value="paid_assessment">Paid Assessment</option>' +
        '</select>' +
      '</div>' +
      '<div style="margin-bottom:1.5rem;">' +
        '<label style="font-size:0.82rem;font-weight:600;color:var(--gray-700);display:block;margin-bottom:0.4rem;">Message (optional)</label>' +
        '<textarea name="message" rows="3" style="width:100%;padding:0.7rem 1rem;border-radius:10px;border:1.5px solid var(--gray-200);font-size:0.9rem;font-family:inherit;resize:vertical;" placeholder="Introduce your company and the opportunity..."></textarea>' +
      '</div>' +
      '<input type="hidden" name="talent_id" value="' + talentId + '">' +
      '<button type="submit" id="offer-submit-btn" style="width:100%;padding:0.85rem;border-radius:12px;background:var(--cobalt);color:var(--white);border:none;font-size:0.95rem;font-weight:700;cursor:pointer;font-family:inherit;transition:all 0.2s;">Send Offer</button>' +
    '</form>' +
  '</div>';
  document.body.appendChild(overlay);
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) overlay.remove();
  });
}
window.openOfferModal = openOfferModal;

function submitOffer(e, talentId) {
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
      sentOffers[talentId] = true;
      loadTalents(currentPage);
    })
    .catch(function() {
      errorDiv.textContent = 'Network error. Please try again.';
      errorDiv.style.display = 'block';
      btn.textContent = orig;
      btn.disabled = false;
    });
}

// Init
loadTalents(1);
</script>
