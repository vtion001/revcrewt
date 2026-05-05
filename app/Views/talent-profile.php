<?php
$talentLoggedIn = session()->get('logged_in') && session()->get('role') === 'talent';
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
    .tag-remove { cursor: pointer; background: none; border: none; display: inline-flex; align-items: center; justify-content: center; width: 16px; height: 16px; border-radius: 50%; margin-left: 0.4rem; font-size: 12px; line-height: 1; color: var(--gray-500); transition: all 0.2s; }
    .tag-remove:hover { background: var(--gray-300); color: var(--gray-700); }

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
    .dash-inner { max-width: 760px; margin: 0 auto; padding: 2.5rem 2rem 5rem; }

    /* Page header */
    .page-head { margin-bottom: 2.5rem; }
    .page-head h1 { font-size: 1.75rem; font-weight: 900; color: var(--navy); letter-spacing: -0.04em; margin-bottom: 0.4rem; }
    .page-head p { font-size: 0.88rem; color: var(--gray-500); }

    /* Profile completion meter */
    .completion-card { background: var(--white); border: 1.5px solid var(--gray-100); border-radius: 16px; padding: 1.5rem 1.75rem; margin-bottom: 1.75rem; display: flex; align-items: center; gap: 1.5rem; }
    .completion-meter-wrap { flex: 1; }
    .completion-top { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.6rem; }
    .completion-label { font-size: 0.82rem; font-weight: 600; color: var(--gray-700); }
    .completion-pct { font-size: 1.1rem; font-weight: 800; color: var(--cobalt); }
    .meter-bar { height: 8px; background: var(--gray-100); border-radius: 100px; overflow: hidden; }
    .meter-fill { height: 100%; background: linear-gradient(90deg, var(--cobalt), var(--cobalt-400)); border-radius: 100px; transition: width 0.6s ease; }
    .completion-msg { font-size: 0.82rem; color: var(--gray-500); max-width: 200px; line-height: 1.5; }

    /* Form card */
    .form-card { background: var(--white); border-radius: 16px; border: 1.5px solid var(--gray-100); overflow: hidden; }
    .form-section { padding: 2rem 2.25rem; border-bottom: 1px solid var(--gray-100); }
    .form-section:last-child { border-bottom: none; }
    .form-section-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--cobalt); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .form-section-title svg { flex-shrink: 0; }

    /* Form fields */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
    .form-row:last-child { margin-bottom: 0; }
    .form-row.single { grid-template-columns: 1fr; }
    .form-field { display: flex; flex-direction: column; gap: 0.5rem; }
    .form-label { font-size: 0.8rem; font-weight: 600; color: var(--gray-700); }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 0.7rem 1rem; border-radius: 10px; border: 1.5px solid var(--gray-200); font-size: 0.9rem; font-family: inherit; color: var(--gray-900); background: var(--white); transition: border-color 0.2s; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--cobalt); }
    .form-input::placeholder, .form-textarea::placeholder { color: var(--gray-400); }
    .form-textarea { resize: vertical; min-height: 100px; line-height: 1.7; }

    /* Photo upload */
    .photo-upload { display: flex; align-items: center; gap: 1.5rem; }
    .photo-preview { width: 72px; height: 72px; border-radius: 16px; background: var(--cobalt-100); border: 2px dashed var(--cobalt-200); display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
    .photo-preview img { width: 100%; height: 100%; object-fit: cover; }
    .photo-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .photo-placeholder svg { color: var(--cobalt); opacity: 0.5; }
    .photo-upload-btn { padding: 0.55rem 1.2rem; border-radius: 8px; border: 1.5px solid var(--gray-200); font-size: 0.82rem; font-weight: 600; color: var(--navy); background: var(--white); cursor: pointer; font-family: inherit; transition: all 0.2s; }
    .photo-upload-btn:hover { border-color: var(--cobalt); color: var(--cobalt); }
    .photo-hint { font-size: 0.75rem; color: var(--gray-400); margin-top: 0.4rem; }

    /* Skills tag input */
    .skill-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem; border-radius: 10px; border: 1.5px solid var(--gray-200); min-height: 48px; align-items: center; transition: border-color 0.2s; }
    .skill-tags:focus-within { border-color: var(--cobalt); }
    .skill-tag { display: inline-flex; align-items: center; padding: 0.3rem 0.75rem 0.3rem 0.9rem; border-radius: 100px; font-size: 0.82rem; font-weight: 600; background: var(--cobalt-100); color: var(--cobalt); gap: 0.35rem; }
    .skill-add-input { border: none; outline: none; font-size: 0.88rem; color: var(--gray-900); background: transparent; font-family: inherit; min-width: 120px; flex: 1; }
    .skill-add-input::placeholder { color: var(--gray-400); }

    /* Availability toggle */
    .avail-options { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .avail-option { padding: 0.65rem 1.25rem; border-radius: 10px; border: 2px solid var(--gray-200); font-size: 0.85rem; font-weight: 600; color: var(--gray-500); background: var(--white); cursor: pointer; transition: all 0.2s; font-family: inherit; }
    .avail-option:hover { border-color: var(--gray-300); color: var(--gray-700); }
    .avail-option.selected-open { border-color: var(--cobalt); background: var(--cobalt-100); color: var(--cobalt); }
    .avail-option.selected-exploring { border-color: #ca8a04; background: rgba(234,179,8,0.08); color: #92400e; }
    .avail-option.selected-receptive { border-color: var(--navy); background: rgba(30,58,95,0.06); color: var(--navy); }

    /* Experience list */
    .exp-entry { background: var(--gray-50); border-radius: 12px; padding: 1.25rem; border: 1.5px solid var(--gray-100); margin-bottom: 0.9rem; }
    .exp-entry:last-child { margin-bottom: 0; }
    .exp-entry-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.9rem; margin-bottom: 0.9rem; }
    .exp-entry-row:last-child { margin-bottom: 0; }
    .exp-remove { display: flex; justify-content: flex-end; }
    .remove-btn { font-size: 0.78rem; font-weight: 600; color: var(--gray-400); background: none; border: none; cursor: pointer; font-family: inherit; transition: color 0.2s; padding: 0.25rem 0.5rem; border-radius: 6px; }
    .remove-btn:hover { color: #dc2626; background: rgba(220,38,38,0.06); }
    .add-exp-btn { width: 100%; padding: 0.75rem; border-radius: 10px; border: 2px dashed var(--gray-200); background: transparent; font-size: 0.85rem; font-weight: 600; color: var(--gray-500); cursor: pointer; font-family: inherit; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1rem; }
    .add-exp-btn:hover { border-color: var(--cobalt); color: var(--cobalt); background: var(--cobalt-100); }

    /* Salary range */
    .salary-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 1rem; align-items: center; }
    .salary-sep { font-size: 0.85rem; font-weight: 600; color: var(--gray-400); text-align: center; margin-top: 1.5rem; }

    /* Save section */
    .save-section { padding: 1.5rem 2.25rem; border-top: 1px solid var(--gray-100); display: flex; justify-content: flex-end; gap: 1rem; background: var(--gray-50); }

    .footer { background: var(--navy-900); padding: 3rem 0; margin-top: 0; }
    .footer-inner { max-width: 760px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

    @media (max-width: 640px) {
      .form-row { grid-template-columns: 1fr; }
      .form-row.exp-entry-row { grid-template-columns: 1fr; }
      .dash-inner { padding: 1.5rem 1rem 4rem; }
      .form-section { padding: 1.5rem; }
      .nav-links { display: none; }
      .completion-card { flex-direction: column; gap: 1rem; }
      .completion-msg { max-width: 100%; }
      .avail-options { flex-direction: column; }
      .avail-option { text-align: center; }
      .salary-row { grid-template-columns: 1fr; }
      .salary-sep { margin-top: 0; }
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
      <a href="/talent/profile" class="<?= ($page ?? '') === 'talent-profile' ? 'active' : '' ?>">My Profile</a>
    </div>
    <div class="nav-cta">
      <a href="/employer/discover" class="btn btn-outline-navy btn-sm">Find Talent</a>
      <a href="/#waitlist" class="btn btn-primary btn-sm">Join Waitlist</a>
    </div>
  </div>
</nav>

<div class="dash-body">
  <div class="dash-inner">

    <?php if (!$talentLoggedIn): ?>
    <!-- Login Gate -->
    <div style="background:var(--white);border-radius:20px;border:1.5px solid var(--gray-100);padding:3rem 2rem;text-align:center;max-width:480px;margin:0 auto;">
      <div style="width:64px;height:64px;border-radius:18px;background:var(--cobalt-100);margin:0 auto 1.5rem;display:flex;align-items:center;justify-content:center;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <h2 style="font-size:1.3rem;font-weight:800;color:var(--navy);margin-bottom:0.75rem;">Sign in to view your profile</h2>
      <p style="font-size:0.88rem;color:var(--gray-500);margin-bottom:1.75rem;line-height:1.7;">Please log in to view and manage your talent profile.</p>
      <a href="/auth/login" class="btn btn-primary" style="padding:0.85rem 2.5rem;border-radius:12px;font-size:0.95rem;font-weight:700;display:inline-flex;">Sign In</a>
    </div>
    <?php else: ?>

    <div class="page-head">
      <h1>My Profile</h1>
      <p>Complete your profile to attract the right employers.</p>
    </div>

    <!-- Profile completion -->
    <div class="completion-card">
      <div class="completion-meter-wrap">
        <div class="completion-top">
          <span class="completion-label">Profile Completion</span>
          <span class="completion-pct">60%</span>
        </div>
        <div class="meter-bar">
          <div class="meter-fill" style="width:60%;"></div>
        </div>
      </div>
      <div class="completion-msg">Complete it to get <strong>3x more</strong> interview requests.</div>
    </div>

    <form class="form-card" id="profile-form">

      <!-- Personal Info -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Personal Information
        </div>
        <div class="form-row">
          <div class="form-field">
            <label class="form-label" for="full-name">Full Name</label>
            <input type="text" id="full-name" class="form-input" placeholder="Juan dela Cruz" value="Juan dela Cruz">
          </div>
          <div class="form-field">
            <label class="form-label" for="headline">Professional Headline</label>
            <input type="text" id="headline" class="form-input" placeholder="e.g. Senior Full-Stack Developer" value="Full-Stack Developer">
          </div>
        </div>
        <div class="form-row">
          <div class="form-field">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" class="form-input" placeholder="juan@email.com" value="juan.delacruz@email.com">
          </div>
          <div class="form-field">
            <label class="form-label" for="phone">Phone Number</label>
            <input type="tel" id="phone" class="form-input" placeholder="+63 9XX XXX XXXX" value="+63 912 345 6789">
          </div>
        </div>
        <div class="form-row single">
          <div class="form-field">
            <label class="form-label" for="location">Location</label>
            <input type="text" id="location" class="form-input" placeholder="Metro Manila, Philippines" value="Metro Manila, Philippines">
          </div>
        </div>
        <div class="form-row single">
          <div class="form-field">
            <label class="form-label" for="summary">Professional Summary</label>
            <textarea id="summary" class="form-textarea" placeholder="Tell employers who you are and what you bring to the table...">Full-stack developer with 5 years of experience building web applications. Strong in Laravel and React. Looking for remote opportunities with growth-focused teams.</textarea>
          </div>
        </div>
      </div>

      <!-- Profile Photo -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          Profile Photo
        </div>
        <div class="photo-upload">
          <div class="photo-preview">
            <div class="photo-placeholder">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
          </div>
          <div>
            <button type="button" class="photo-upload-btn">Upload Photo</button>
            <div class="photo-hint">JPG or PNG, max 2MB. Recommended: 400x400px.</div>
          </div>
        </div>
      </div>

      <!-- Skills -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          Skills
        </div>
        <div class="skill-tags" id="skill-tags">
          <span class="skill-tag">Laravel <button type="button" class="tag-remove" aria-label="Remove">x</button></span>
          <span class="skill-tag">React <button type="button" class="tag-remove" aria-label="Remove">x</button></span>
          <span class="skill-tag">JavaScript <button type="button" class="tag-remove" aria-label="Remove">x</button></span>
          <span class="skill-tag">PostgreSQL <button type="button" class="tag-remove" aria-label="Remove">x</button></span>
          <input type="text" class="skill-add-input" id="skill-input" placeholder="Add a skill and press Enter...">
        </div>
      </div>

      <!-- Experience -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
          Work Experience
        </div>

        <div class="exp-entry" id="exp-1">
          <div class="exp-remove"><button type="button" class="remove-btn">Remove</button></div>
          <div class="exp-entry-row">
            <div class="form-field">
              <label class="form-label">Company</label>
              <input type="text" class="form-input" value="TechSolutions PH">
            </div>
            <div class="form-field">
              <label class="form-label">Role / Title</label>
              <input type="text" class="form-input" value="Full-Stack Developer">
            </div>
          </div>
          <div class="exp-entry-row">
            <div class="form-field">
              <label class="form-label">Start Date</label>
              <input type="month" class="form-input" value="2021-01">
            </div>
            <div class="form-field">
              <label class="form-label">End Date</label>
              <input type="month" class="form-input" value="2024-06">
            </div>
          </div>
          <div class="form-row single">
            <div class="form-field">
              <label class="form-label">Description</label>
              <textarea class="form-textarea" style="min-height:80px;">Built and maintained full-stack web applications for 20+ client projects using Laravel and React.</textarea>
            </div>
          </div>
        </div>

        <div class="exp-entry" id="exp-2">
          <div class="exp-remove"><button type="button" class="remove-btn">Remove</button></div>
          <div class="exp-entry-row">
            <div class="form-field">
              <label class="form-label">Company</label>
              <input type="text" class="form-input" value="StartupHub Manila">
            </div>
            <div class="form-field">
              <label class="form-label">Role / Title</label>
              <input type="text" class="form-input" value="Junior Web Developer">
            </div>
          </div>
          <div class="exp-entry-row">
            <div class="form-field">
              <label class="form-label">Start Date</label>
              <input type="month" class="form-input" value="2019-06">
            </div>
            <div class="form-field">
              <label class="form-label">End Date</label>
              <input type="month" class="form-input" value="2020-12">
            </div>
          </div>
          <div class="form-row single">
            <div class="form-field">
              <label class="form-label">Description</label>
              <textarea class="form-textarea" style="min-height:80px;">Developed MVP features for an e-commerce platform and managed client communications.</textarea>
            </div>
          </div>
        </div>

        <button type="button" class="add-exp-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
          Add Another Experience
        </button>
      </div>

      <!-- Availability -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          Availability Status
        </div>
        <div class="avail-options">
          <button type="button" class="avail-option selected-open" data-status="open">Open to Work</button>
          <button type="button" class="avail-option" data-status="exploring">Exploring</button>
          <button type="button" class="avail-option" data-status="receptive">Receptive (employed)</button>
        </div>
      </div>

      <!-- Salary Expectation -->
      <div class="form-section">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          Salary Expectation (Monthly)
        </div>
        <div class="salary-row">
          <div class="form-field">
            <label class="form-label" for="sal-min">Minimum (PHP)</label>
            <input type="number" id="sal-min" class="form-input" placeholder="60,000" value="60000">
          </div>
          <div class="salary-sep">to</div>
          <div class="form-field">
            <label class="form-label" for="sal-max">Maximum (PHP)</label>
            <input type="number" id="sal-max" class="form-input" placeholder="100,000" value="100000">
          </div>
        </div>
      </div>

      <!-- Incoming Offers (visible when logged in as talent) -->
      <div class="form-section" id="incoming-offers-section" style="display:<?= $talentLoggedIn ? 'block' : 'none' ?>;">
        <div class="form-section-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.07 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2.92 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          Incoming Offers
        </div>
        <div id="incoming-offers-empty" style="display:none;text-align:center;padding:2rem 1rem;background:var(--gray-50);border-radius:12px;border:1.5px dashed var(--gray-200);">
          <div style="font-size:0.88rem;color:var(--gray-400);">No offers yet. Employers will reach out when they find you.</div>
        </div>
        <div id="incoming-offers-list"></div>
      </div>

      <!-- Save -->
      <div class="save-section">
        <button type="button" class="btn btn-outline-navy" style="padding:0.75rem 1.75rem;">Cancel</button>
        <button type="submit" class="btn btn-primary" style="padding:0.75rem 2.5rem;">Save Profile</button>
      </div>

    </form>
  </div>
  <?php endif // talentLoggedIn ?>
</div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>

<script>
  // Availability toggle
  document.querySelectorAll('.avail-option').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.avail-option').forEach(b => {
        b.classList.remove('selected-open', 'selected-exploring', 'selected-receptive');
      });
      const status = btn.dataset.status;
      if (status === 'open') btn.classList.add('selected-open');
      else if (status === 'exploring') btn.classList.add('selected-exploring');
      else btn.classList.add('selected-receptive');
    });
  });

  // Skills add on Enter
  const skillInput = document.getElementById('skill-input');
  const skillTags = document.getElementById('skill-tags');
  if (skillInput) {
    skillInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const val = skillInput.value.trim();
        if (val) {
          const tag = document.createElement('span');
          tag.className = 'skill-tag';
          tag.innerHTML = val + ' <button type="button" class="tag-remove" aria-label="Remove">x</button>';
          skillTags.insertBefore(tag, skillInput);
          skillInput.value = '';
        }
      }
    });
    // Remove skill
    skillTags.addEventListener('click', (e) => {
      if (e.target.classList.contains('tag-remove')) {
        e.target.parentElement.remove();
      }
    });
  }

  // Form submit
  var profileForm = document.getElementById('profile-form');
  if (profileForm) {
    profileForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    const original = btn.textContent;
    btn.textContent = 'Saving...';
    btn.disabled = true;
    setTimeout(() => {
      btn.textContent = 'Saved!';
      btn.style.background = '#16a34a';
      setTimeout(() => {
        btn.textContent = original;
        btn.style.background = '';
        btn.disabled = false;
      }, 2000);
    }, 1000);
    });
  }

  // Load incoming offers
  function loadIncomingOffers() {
    fetch('/api/offers/incoming')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        var offers = data.offers || [];
        var container = document.getElementById('incoming-offers-list');
        var emptyState = document.getElementById('incoming-offers-empty');
        if (!container) return;

        if (offers.length === 0) {
          container.style.display = 'none';
          if (emptyState) emptyState.style.display = 'block';
          return;
        }
        if (emptyState) emptyState.style.display = 'none';
        container.innerHTML = offers.map(function(o) {
          var statusBadge = '';
          if (o.status === 'pending') {
            statusBadge = '<span style="display:inline-flex;padding:0.25rem 0.75rem;border-radius:100px;font-size:0.75rem;font-weight:700;background:rgba(234,179,8,0.1);color:#92400e;">Pending</span>';
          } else if (o.status === 'accepted') {
            statusBadge = '<span style="display:inline-flex;padding:0.25rem 0.75rem;border-radius:100px;font-size:0.75rem;font-weight:700;background:rgba(22,163,74,0.1);color:#166534;">Accepted</span>';
          } else if (o.status === 'declined') {
            statusBadge = '<span style="display:inline-flex;padding:0.25rem 0.75rem;border-radius:100px;font-size:0.75rem;font-weight:700;background:rgba(239,68,68,0.1);color:#991b1b;">Declined</span>';
          }
          var typeLabel = o.type === 'free_interview' ? 'Free Interview' : o.type === 'paid_interview' ? 'Paid Interview' : 'Paid Assessment';
          var btnHtml = '';
          if (o.status === 'pending') {
            btnHtml = '<div style="display:flex;gap:0.5rem;margin-top:0.75rem;">' +
              '<button onclick="respondOffer(' + o.id + ', \'accept\')" style="flex:1;padding:0.55rem;border-radius:8px;background:var(--cobalt);color:var(--white);border:none;font-size:0.82rem;font-weight:700;cursor:pointer;font-family:inherit;">Accept</button>' +
              '<button onclick="respondOffer(' + o.id + ', \'decline\')" style="flex:1;padding:0.55rem;border-radius:8px;background:transparent;color:#ef4444;border:1.5px solid #fca5a5;font-size:0.82rem;font-weight:700;cursor:pointer;font-family:inherit;">Decline</button>' +
            '</div>';
          }
          return '<div style="background:var(--gray-50);border-radius:12px;padding:1.25rem;border:1.5px solid var(--gray-100);margin-bottom:0.9rem;">' +
            '<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;">' +
              '<div>' +
                '<div style="font-size:0.95rem;font-weight:700;color:var(--navy);margin-bottom:0.2rem;">' + (o.employer_name || 'Employer') + '</div>' +
                '<div style="font-size:0.82rem;color:var(--gray-500);margin-bottom:0.5rem;">' + (o.subject || '-') + ' &middot; ' + typeLabel + '</div>' +
                (o.proposed_salary ? '<div style="font-size:0.82rem;font-weight:600;color:var(--cobalt);margin-bottom:0.35rem;">' + o.proposed_salary + '</div>' : '') +
                (o.message ? '<div style="font-size:0.82rem;color:var(--gray-500);margin-bottom:0.5rem;line-height:1.6;">' + o.message + '</div>' : '') +
                btnHtml +
              '</div>' +
              '<div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.5rem;flex-shrink:0;">' +
                statusBadge +
                '<span style="font-size:0.72rem;color:var(--gray-400);">' + timeAgo(o.created_at) + '</span>' +
              '</div>' +
            '</div>' +
          '</div>';
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

  function respondOffer(id, action) {
    fetch('/api/offers/' + id + '/' + action, { method: 'POST' })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        showToast(action === 'accept' ? 'Offer accepted!' : 'Offer declined.');
        loadIncomingOffers();
      })
      .catch(function() {
        showToast('Something went wrong.', true);
      });
  }

  function showToast(msg, isError) {
    var toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.className = 'toast show' + (isError ? ' error' : '');
    setTimeout(function() { toast.className = 'toast'; }, 3000);
  }
  window.showToast = showToast;

  // Init
  loadIncomingOffers();
</script>
</body>
</html>
