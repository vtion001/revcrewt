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
    .headline-md { font-size: 1.15rem; font-weight: 700; color: var(--navy); letter-spacing: -0.015em; }
    .body-md { font-size: 0.92rem; color: var(--gray-500); line-height: 1.7; }

    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }
    .btn-primary { background: var(--cobalt); color: var(--white); }
    .btn-primary:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-navy { background: var(--navy); color: var(--white); }
    .btn-navy:hover { background: var(--navy-900); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(30,58,95,0.25); }
    .btn-outline-navy { background: transparent; color: var(--navy); border: 2px solid var(--gray-300); }
    .btn-outline-navy:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }
    .btn-sm { padding: 0.55rem 1.4rem; font-size: 0.85rem; }
    .btn-ghost { background: transparent; color: var(--cobalt); border: 1.5px solid var(--cobalt-200); padding: 0.5rem 1.2rem; font-size: 0.85rem; border-radius: 8px; }
    .btn-ghost:hover { background: var(--cobalt-100); }

    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(30,58,95,0.06); box-shadow: 0 4px 30px rgba(30,58,95,0.05); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 1.35rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .nav-logo span { color: var(--cobalt); }
    .nav-links { display: flex; gap: 0.15rem; align-items: center; }
    .nav-links a { padding: 0.5rem 0.9rem; color: var(--gray-500); font-weight: 500; font-size: 0.88rem; border-radius: 8px; transition: all 0.2s; }
    .nav-links a:hover { color: var(--navy); background: var(--gray-50); }
    .nav-links a.active { color: var(--cobalt); background: var(--cobalt-100); }
    .nav-cta { display: flex; gap: 0.75rem; align-items: center; }

    .tag { display: inline-flex; align-items: center; padding: 0.3rem 0.85rem; border-radius: 100px; font-size: 0.78rem; font-weight: 700; background: var(--gray-100); color: var(--gray-500); }
    .tag-avail { background: rgba(0,74,173,0.08); color: var(--cobalt); }
    .tag-avail-exploring { background: rgba(234,179,8,0.1); color: #92400e; }
    .tag-avail-receptive { background: rgba(30,58,95,0.08); color: var(--navy); }

    /* Dashboard layout */
    .dash-body { padding-top: 72px; min-height: 100vh; }
    .dash-inner { max-width: 1280px; margin: 0 auto; padding: 2.5rem 2rem; display: flex; gap: 2rem; align-items: flex-start; }

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
    .filter-radio { display: flex; align-items: center; gap: 0.65rem; cursor: pointer; }
    .filter-radio input[type="radio"] { accent-color: var(--cobalt); cursor: pointer; }
    .filter-radio label { font-size: 0.88rem; color: var(--gray-700); cursor: pointer; }
    .sidebar-divider { height: 1px; background: var(--gray-100); margin: 1.5rem 0; }

    /* Salary range */
    .range-display { font-size: 0.85rem; color: var(--gray-700); font-weight: 600; margin-top: 0.75rem; }
    input[type="range"] { width: 100%; accent-color: var(--cobalt); cursor: pointer; }

    /* Main content */
    .dash-main { flex: 1; min-width: 0; }

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
    .btn-card-primary { flex: 1; padding: 0.6rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; background: var(--cobalt); color: var(--white); border: none; cursor: pointer; transition: all 0.2s; font-family: inherit; text-align: center; }
    .btn-card-primary:hover { background: var(--cobalt-400); }
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

    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.65s ease, transform 0.65s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    .footer { background: var(--navy-900); padding: 3rem 0; margin-top: 0; }
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
      .dash-inner { padding: 1.5rem 1rem; }
      .nav-links { display: none; }
    }
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
    </div>
    <div class="nav-cta">
      <a href="/talent/profile" class="btn btn-outline-navy btn-sm">My Profile</a>
      <a href="/#waitlist" class="btn btn-primary btn-sm">Join Waitlist</a>
    </div>
  </div>
</nav>

<div class="dash-body">
  <div class="dash-inner">

    <!-- Sidebar -->
    <aside class="dash-sidebar">
      <div class="dash-sidebar-card">
        <div class="sidebar-section">
          <div class="filter-title">Skills</div>
          <div class="filter-group">
            <div class="filter-check">
              <input type="checkbox" id="sk-php">
              <label for="sk-php">PHP / Laravel</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-js">
              <label for="sk-js">JavaScript / React</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-python">
              <label for="sk-python">Python</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-node">
              <label for="sk-node">Node.js</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-design">
              <label for="sk-design">UI/UX Design</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-data">
              <label for="sk-data">Data Analysis</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="sk-devops">
              <label for="sk-devops">DevOps / Cloud</label>
            </div>
          </div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Experience Level</div>
          <div class="filter-group">
            <div class="filter-check">
              <input type="checkbox" id="lv-junior">
              <label for="lv-junior">Junior (0-2 yrs)</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="lv-mid">
              <label for="lv-mid">Mid-Level (3-5 yrs)</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="lv-senior">
              <label for="lv-senior">Senior (6-9 yrs)</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="lv-lead">
              <label for="lv-lead">Lead (10+ yrs)</label>
            </div>
          </div>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-section">
          <div class="filter-title">Availability</div>
          <div class="filter-group">
            <div class="filter-check">
              <input type="checkbox" id="av-open">
              <label for="av-open">Open to Work</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="av-exploring">
              <label for="av-exploring">Exploring</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="av-receptive">
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
            <div class="filter-check">
              <input type="checkbox" id="loc-mnl">
              <label for="loc-mnl">Metro Manila</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="loc-ces">
              <label for="loc-ces">Cebu / Visayas</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="loc-dav">
              <label for="loc-dav">Davao / Mindanao</label>
            </div>
            <div class="filter-check">
              <input type="checkbox" id="loc-wfh">
              <label for="loc-wfh">Remote / Work from Home</label>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="dash-main">

      <!-- Stats bar -->
      <div class="stats-bar reveal">
        <div class="stats-left">
          <div class="stat-item">
            <div class="stat-val">2,400<span>+</span></div>
            <div class="stat-lbl">Talents Available</div>
          </div>
          <div class="stat-item">
            <div class="stat-val">847</div>
            <div class="stat-lbl">Open to Work</div>
          </div>
          <div class="stat-item">
            <div class="stat-val">180</div>
            <div class="stat-lbl">Companies Active</div>
          </div>
        </div>
        <div class="stats-right">
          <div class="sort-wrap">
            <span class="sort-label">Sort:</span>
            <select class="sort-select">
              <option>Newest</option>
              <option>Most Experienced</option>
              <option>Highest Demand</option>
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
      <div class="talent-grid" id="talent-grid">

        <!-- Card 1 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#1e3a5f;">MR</div>
            <div class="talent-info">
              <div class="talent-name">Maria Reyes</div>
              <div class="talent-headline">Senior Full-Stack Developer at TechVentures PH</div>
              <div class="talent-tags">
                <span class="tag">Laravel</span>
                <span class="tag">React</span>
                <span class="tag">PostgreSQL</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              7 yrs exp
            </div>
            <span class="tag tag-avail">Open to Work</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/1" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#004aad;">JC</div>
            <div class="talent-info">
              <div class="talent-name">James Cruz</div>
              <div class="talent-headline">Lead DevOps Engineer at Globe Fintech</div>
              <div class="talent-tags">
                <span class="tag">AWS</span>
                <span class="tag">Kubernetes</span>
                <span class="tag">Terraform</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              9 yrs exp
            </div>
            <span class="tag tag-avail">Open to Work</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/2" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#0f172a;">AS</div>
            <div class="talent-info">
              <div class="talent-name">Anna Santos</div>
              <div class="talent-headline">Mid-Level UI/UX Designer at StartupHub Cebu</div>
              <div class="talent-tags">
                <span class="tag">Figma</span>
                <span class="tag">User Research</span>
                <span class="tag">Prototyping</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              4 yrs exp
            </div>
            <span class="tag tag-avail-exploring">Exploring</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/3" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#334155;">BT</div>
            <div class="talent-info">
              <div class="talent-name">Bryan Torres</div>
              <div class="talent-headline">Junior Python Developer at DataFirst Inc.</div>
              <div class="talent-tags">
                <span class="tag">Python</span>
                <span class="tag">Django</span>
                <span class="tag">Pandas</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              2 yrs exp
            </div>
            <span class="tag tag-avail">Open to Work</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/4" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#1e3a5f;">LP</div>
            <div class="talent-info">
              <div class="talent-name">Liza Punzalan</div>
              <div class="talent-headline">Senior Data Analyst at ConsultCorp Manila</div>
              <div class="talent-tags">
                <span class="tag">SQL</span>
                <span class="tag">Power BI</span>
                <span class="tag">Python</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              6 yrs exp
            </div>
            <span class="tag tag-avail-receptive">Receptive</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/5" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="talent-card reveal">
          <div class="talent-card-top">
            <div class="talent-avatar" style="background:#004aad;">DG</div>
            <div class="talent-info">
              <div class="talent-name">Daniel Garcia</div>
              <div class="talent-headline">Lead Mobile Developer at AppFactory PH</div>
              <div class="talent-tags">
                <span class="tag">Flutter</span>
                <span class="tag">Dart</span>
                <span class="tag">Firebase</span>
              </div>
            </div>
          </div>
          <div class="talent-meta">
            <div class="talent-exp">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              8 yrs exp
            </div>
            <span class="tag tag-avail">Open to Work</span>
          </div>
          <div class="talent-divider"></div>
          <div class="talent-actions">
            <a href="/employer/talent/6" class="btn-card-primary">View Profile</a>
            <button class="btn-card-outline">Shortlist</button>
          </div>
        </div>

      </div>

      <!-- Empty state (hidden by default) -->
      <div class="empty-state" id="empty-state" style="display:none;">
        <div class="empty-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        </div>
        <div class="empty-title">No talents match your filters.</div>
        <div class="empty-body">Try adjusting your search criteria.</div>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <button class="page-btn" disabled>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button        <button class="page-btn">3</button>
        <button class="page-btn">4</button>
        <button class="page-btn">5</button>
        <button class="page-btn" disabled>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
        </button>
      </div>

    </main>
  </div>
</div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>

<script>
  const salaryRange = document.getElementById('salary-range');
  const salaryDisplay = document.getElementById('salary-display');
  if (salaryRange && salaryDisplay) {
    salaryRange.addEventListener('input', () => {
      salaryDisplay.textContent = 'Up to PHP ' + Number(salaryRange.value).toLocaleString() + '/mo';
    });
  }
  const reveals = document.querySelectorAll('.reveal');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.08 });
  reveals.forEach(el => obs.observe(el));
</script>
</body>
</html>
