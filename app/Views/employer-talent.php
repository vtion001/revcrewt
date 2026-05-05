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
    .dash-inner { max-width: 900px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    .back-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; font-weight: 600; color: var(--gray-500); margin-bottom: 2rem; transition: color 0.2s; }
    .back-link:hover { color: var(--cobalt); }

    .profile-card { background: var(--white); border-radius: 20px; border: 1.5px solid var(--gray-100); overflow: hidden; }

    /* Profile header */
    .profile-header { padding: 2.5rem 2.5rem 2rem; display: flex; gap: 1.75rem; align-items: flex-start; border-bottom: 1px solid var(--gray-100); }
    .profile-avatar { width: 88px; height: 88px; border-radius: 20px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.7rem; color: var(--white); }
    .profile-meta { flex: 1; }
    .profile-name { font-size: 1.35rem; font-weight: 800; color: var(--navy); letter-spacing: -0.03em; margin-bottom: 0.3rem; }
    .profile-headline { font-size: 0.92rem; color: var(--gray-500); line-height: 1.5; margin-bottom: 0.9rem; }
    .profile-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
    .profile-badges { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.75rem; border-radius: 8px; font-size: 0.78rem; font-weight: 600; background: var(--gray-100); color: var(--gray-700); }
    .badge svg { flex-shrink: 0; }

    /* Profile body */
    .profile-body { padding: 2.5rem; }
    .profile-section { margin-bottom: 2.5rem; }
    .profile-section:last-child { margin-bottom: 0; }
    .section-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--cobalt); margin-bottom: 1rem; }
    .section-text { font-size: 0.9rem; color: var(--gray-700); line-height: 1.8; }
    .skills-wrap { display: flex; flex-wrap: wrap; gap: 0.5rem; }

    /* Experience timeline */
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

    /* Salary & availability row */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem; }
    .detail-card { background: var(--gray-50); border-radius: 12px; padding: 1.25rem; border: 1.5px solid var(--gray-100); }
    .detail-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-500); margin-bottom: 0.5rem; }
    .detail-value { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .detail-sub { font-size: 0.78rem; color: var(--gray-500); margin-top: 0.2rem; }

    /* Actions */
    .profile-actions { padding: 1.75rem 2.5rem 2rem; border-top: 1px solid var(--gray-100); display: flex; gap: 1rem; }
    .btn-interview { flex: 1; padding: 0.9rem 1.5rem; border-radius: 12px; font-size: 0.92rem; font-weight: 700; background: var(--cobalt); color: var(--white); border: none; cursor: pointer; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.6rem; }
    .btn-interview:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-save { padding: 0.9rem 1.5rem; border-radius: 12px; font-size: 0.92rem; font-weight: 700; background: transparent; color: var(--navy); border: 2px solid var(--gray-200); cursor: pointer; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 0.6rem; }
    .btn-save:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }

    .footer { background: var(--navy-900); padding: 3rem 0; margin-top: 0; }
    .footer-inner { max-width: 900px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

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

    <a href="/employer/discover" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
      Back to Discover
    </a>

    <div class="profile-card">

      <!-- Header -->
      <div class="profile-header">
        <div class="profile-avatar" style="background:#1e3a5f;">MR</div>
        <div class="profile-meta">
          <div class="profile-name">Maria Reyes</div>
          <div class="profile-headline">Senior Full-Stack Developer at TechVentures PH</div>
          <div class="profile-tags">
            <span class="tag">Laravel</span>
            <span class="tag">React</span>
            <span class="tag">PostgreSQL</span>
            <span class="tag">Docker</span>
            <span class="tag">AWS</span>
          </div>
          <div class="profile-badges">
            <div class="badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              7 Years Experience
            </div>
            <div class="badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Metro Manila, PH
            </div>
            <span class="tag tag-avail">Open to Work</span>
          </div>
        </div>
      </div>

      <!-- Body -->
      <div class="profile-body">

        <!-- Summary -->
        <div class="profile-section">
          <div class="section-label">About</div>
          <p class="section-text">
            Full-stack developer with 7 years of experience building scalable web applications in the Philippine tech ecosystem. Strong background in Laravel and React, with a focus on clean architecture and developer experience. Led a team of 4 at TechVentures PH building an internal SaaS platform used by 50+ enterprise clients. Passionate about mentoring junior devs and contributing to open source.
          </p>
        </div>

        <!-- Salary & Availability -->
        <div class="detail-grid">
          <div class="detail-card">
            <div class="detail-label">Salary Expectation</div>
            <div class="detail-value">PHP 120,000 - 180,000</div>
            <div class="detail-sub">per month</div>
          </div>
          <div class="detail-card">
            <div class="detail-label">Availability</div>
            <div class="detail-value">Open to Work</div>
            <div class="detail-sub">Immediate start available</div>
          </div>
        </div>

        <!-- Experience -->
        <div class="profile-section">
          <div class="section-label">Experience</div>
          <div class="exp-list">
            <div class="exp-item">
              <div class="exp-dot-col"><div class="exp-dot"></div><div class="exp-line"></div></div>
              <div class="exp-content">
                <div class="exp-role">Senior Full-Stack Developer</div>
                <div class="exp-company">TechVentures PH</div>
                <div class="exp-dates">Jan 2021 - Present</div>
                <div class="exp-desc">Led development of an internal SaaS platform for enterprise clients. Managed a team of 4 developers. Migrated legacy PHP codebase to Laravel, reducing page load by 60%.</div>
              </div>
            </div>
            <div class="exp-item">
              <div class="exp-dot-col"><div class="exp-dot"></div><div class="exp-line"></div></div>
              <div class="exp-content">
                <div class="exp-role">Full-Stack Developer</div>
                <div class="exp-company">StartupHub Manila</div>
                <div class="exp-dates">Mar 2018 - Dec 2020</div>
                <div class="exp-desc">Built MVP for a fintech startup from scratch. Implemented React frontend and Node.js API. Platform reached 10,000 active users within 6 months of launch.</div>
              </div>
            </div>
            <div class="exp-item">
              <div class="exp-dot-col"><div class="exp-dot"></div><div class="exp-line" style="background:transparent;"></div></div>
              <div class="exp-content">
                <div class="exp-role">Junior Web Developer</div>
                <div class="exp-company">Freelance</div>
                <div class="exp-dates">Jun 2017 - Feb 2018</div>
                <div class="exp-desc">Delivered 15+ client projects for small businesses across e-commerce, portfolios, and landing pages.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Skills -->
        <div class="profile-section">
          <div class="section-label">Skills</div>
          <div class="skills-wrap">
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">Laravel</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">React</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">PostgreSQL</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">Docker</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">AWS</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">REST APIs</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">Git</span>
            <span class="tag" style="font-size:0.85rem;padding:0.4rem 1rem;">Agile</span>
          </div>
        </div>

      </div>

      <!-- Actions -->
      <div class="profile-actions">
        <button class="btn-interview">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          Send Interview Request
        </button>
        <button class="btn-save">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
          Save to Tracked
        </button>
      </div>

    </div>
  </div>
</div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>
</body>
</html>
