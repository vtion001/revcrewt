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
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: var(--gray-900); background: var(--white); overflow-x: hidden; line-height: 1.6; -webkit-font-smoothing: antialiased; }
    a { text-decoration: none; }
    img { max-width: 100%; display: block; }
    ::selection { background: var(--cobalt); color: var(--white); }

    .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .section { padding: 6rem 2rem; }

    .eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--cobalt); margin-bottom: 0.75rem; }
    .headline-xl { font-size: clamp(2.2rem, 4.5vw, 3.5rem); font-weight: 900; color: var(--navy); line-height: 1.06; letter-spacing: -0.04em; }
    .headline-lg { font-size: clamp(1.6rem, 3vw, 2.4rem); font-weight: 800; color: var(--navy); line-height: 1.1; letter-spacing: -0.035em; }
    .headline-md { font-size: 1.15rem; font-weight: 700; color: var(--navy); letter-spacing: -0.015em; }
    .body-lg { font-size: 1.05rem; color: var(--gray-500); line-height: 1.75; }
    .body-md { font-size: 0.92rem; color: var(--gray-500); line-height: 1.7; }

    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }
    .btn-primary { background: var(--cobalt); color: var(--white); }
    .btn-primary:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-navy { background: var(--navy); color: var(--white); }
    .btn-navy:hover { background: var(--navy-900); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(30,58,95,0.25); }
    .btn-outline-navy { background: transparent; color: var(--navy); border: 2px solid var(--gray-300); }
    .btn-outline-navy:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }
    .btn-lg { padding: 1rem 2.5rem; font-size: 1.05rem; border-radius: 12px; }
    .btn-sm { padding: 0.55rem 1.4rem; font-size: 0.85rem; }

    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(30,58,95,0.06); transition: box-shadow 0.3s; }
    .navbar.scrolled { box-shadow: 0 4px 30px rgba(30,58,95,0.08); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 1.35rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .nav-logo span { color: var(--cobalt); }
    .nav-links { display: flex; gap: 0.15rem; align-items: center; }
    .nav-links a { padding: 0.5rem 0.9rem; color: var(--gray-500); font-weight: 500; font-size: 0.88rem; border-radius: 8px; transition: all 0.2s; }
    .nav-links a:hover { color: var(--navy); background: var(--gray-50); }
    .nav-links a.active { color: var(--cobalt); background: var(--cobalt-100); }

    .footer { background: var(--navy-900); padding: 3rem 0; }
    .footer-inner { max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }
    .footer-links { display: flex; gap: 2rem; }
    .footer-links a { font-size: 0.85rem; color: rgba(255,255,255,0.4); transition: color 0.2s; }
    .footer-links a:hover { color: rgba(255,255,255,0.8); }

    .section-header { text-align: center; margin-bottom: 3.5rem; }
    .section-header .body-lg { max-width: 560px; margin: 0.75rem auto 0; }

    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
    .two-col.reverse { direction: rtl; }
    .two-col.reverse > * { direction: ltr; }

    .check-list { display: flex; flex-direction: column; gap: 0.9rem; }
    .check-item { display: flex; align-items: flex-start; gap: 0.85rem; }
    .check-circle { width: 24px; height: 24px; border-radius: 50%; background: var(--cobalt); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
    .check-text { font-size: 0.92rem; color: var(--gray-700); font-weight: 500; line-height: 1.5; }

    .section-image { border-radius: 20px; overflow: hidden; box-shadow: 0 30px 70px rgba(30,58,95,0.12); }
    .section-image img { width: 100%; height: 380px; object-fit: cover; }

    .stat-bar { background: var(--navy); }
    .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; }
    .stat-item { text-align: center; padding: 2.5rem 1.5rem; border-right: 1px solid rgba(255,255,255,0.08); }
    .stat-item:last-child { border-right: none; }
    .stat-value { font-size: 2.8rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.5rem; }
    .stat-value span { color: var(--cobalt-400); }
    .stat-label { font-size: 0.85rem; color: rgba(255,255,255,0.5); font-weight: 500; }
    .stat-sub { font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-top: 0.2rem; }

    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.65s ease, transform 0.65s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    .page-hero { padding: 8rem 2rem 5rem; background: var(--gray-50); border-bottom: 1px solid var(--gray-100); }
    .page-hero .container { max-width: 800px; text-align: center; margin: 0 auto; }
    .page-hero h1 { margin: 0.75rem 0 1rem; }
    .page-hero .body-lg { max-width: 560px; margin: 0 auto; }

    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }

    .card { background: var(--white); border-radius: 20px; padding: 2rem; border: 1.5px solid var(--gray-100); transition: all 0.3s; }
    .card:hover { box-shadow: 0 16px 50px rgba(30,58,95,0.1); transform: translateY(-4px); border-color: var(--gray-300); }
    .card-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--cobalt-100); border: 1px solid var(--cobalt-200); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; }
    .card-title { font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 0.6rem; }
    .card-body { font-size: 0.9rem; color: var(--gray-500); line-height: 1.7; }

    .tag { display: inline-flex; align-items: center; padding: 0.3rem 0.85rem; border-radius: 100px; font-size: 0.78rem; font-weight: 700; background: var(--cobalt-100); color: var(--cobalt); border: 1px solid var(--cobalt-200); }

    .accordion-item { border: 1.5px solid var(--gray-100); border-radius: 14px; overflow: hidden; margin-bottom: 0.75rem; }
    .accordion-header { width: 100%; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; background: var(--white); border: none; cursor: pointer; font-size: 0.95rem; font-weight: 600; color: var(--navy); font-family: inherit; text-align: left; transition: background 0.2s; }
    .accordion-header:hover { background: var(--gray-50); }
    .accordion-header.open { background: var(--gray-50); }
    .accordion-body { padding: 0 1.5rem 1.25rem; font-size: 0.92rem; color: var(--gray-500); line-height: 1.7; border-top: 1px solid var(--gray-100); display: none; }
    .accordion-body.open { display: block; }
    .accordion-arrow { transition: transform 0.25s; flex-shrink: 0; color: var(--gray-400); }
    .accordion-header.open .accordion-arrow { transform: rotate(180deg); }

    .divider { height: 2px; background: linear-gradient(90deg, var(--navy), var(--cobalt)); border-radius: 1px; margin: 0 auto 3.5rem; max-width: 60px; }

    @media (max-width: 768px) {
      .two-col { grid-template-columns: 1fr; gap: 2.5rem; direction: ltr !important; }
      .grid-3, .grid-2 { grid-template-columns: 1fr; }
      .stat-grid { grid-template-columns: 1fr; }
      .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
      .stat-item:last-child { border-bottom: none; }
      .nav-links { display: none; }
    }
    @media (max-width: 480px) {
      .section { padding: 4rem 1.25rem; }
      .container { padding: 0 1.25rem; }
    }
  </style>
</head>
<body>
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">rev<span>crewt</span></a>
    <div class="nav-links">
      <a href="/how-it-works" class="<?= ($page ?? '') === 'how-it-works' ? 'active' : '' ?>">How It Works</a>
      <a href="/for-employers" class="<?= ($page ?? '') === 'for-employers' ? 'active' : '' ?>">For Employers</a>
      <a href="/for-talent" class="<?= ($page ?? '') === 'for-talent' ? 'active' : '' ?>">For Talent</a>
      <a href="/pricing" class="<?= ($page ?? '') === 'pricing' ? 'active' : '' ?>">Pricing</a>
    </div>
    <a href="/#waitlist" class="btn btn-primary btn-sm">Join Waitlist</a>
  </div>
</nav>
