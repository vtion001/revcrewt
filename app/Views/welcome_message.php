<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>revcrewt — Discover Better. Match Smarter.</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #1e3a5f;
      --navy-900: #152a45;
      --navy-700: #1e3a5f;
      --navy-500: #2a4f7a;
      --cobalt: #004aad;
      --cobalt-400: #0066cc;
      --cobalt-100: rgba(0,74,173,0.07);
      --cobalt-200: rgba(0,74,173,0.12);
      --gray-900: #0f172a;
      --gray-700: #334155;
      --gray-500: #64748b;
      --gray-300: #cbd5e1;
      --gray-100: #f1f5f9;
      --gray-50: #f8fafc;
      --white: #ffffff;
    }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      color: var(--gray-900);
      background: var(--white);
      overflow-x: hidden;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }
    a { text-decoration: none; }
    img { max-width: 100%; display: block; }
    ::selection { background: var(--cobalt); color: var(--white); }

    /* ── LAYOUT ── */
    .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .section { padding: 7rem 2rem; }
    .section-sm { padding: 4rem 2rem; }

    /* ── COLORS ── */
    .text-navy { color: var(--navy); }
    .text-cobalt { color: var(--cobalt); }
    .text-muted { color: var(--gray-500); }
    .bg-navy { background: var(--navy); }
    .bg-navy-900 { background: var(--navy-900); }
    .bg-gray { background: var(--gray-50); }
    .bg-white { background: var(--white); }

    /* ── TYPOGRAPHY ── */
    .eyebrow {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--cobalt);
      margin-bottom: 0.75rem;
    }
    .headline-xl {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 900;
      color: var(--navy);
      line-height: 1.05;
      letter-spacing: -0.04em;
    }
    .headline-lg {
      font-size: clamp(1.8rem, 3.5vw, 2.75rem);
      font-weight: 800;
      color: var(--navy);
      line-height: 1.1;
      letter-spacing: -0.035em;
    }
    .headline-md {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.015em;
    }
    .body-lg { font-size: 1.1rem; color: var(--gray-500); line-height: 1.75; }
    .body-md { font-size: 0.95rem; color: var(--gray-500); line-height: 1.7; }

    /* ── BUTTONS ── */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.8rem 2rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      border: none;
      cursor: pointer;
      transition: all 0.25s ease;
      text-decoration: none;
      white-space: nowrap;
    }
    .btn-primary {
      background: var(--cobalt);
      color: var(--white);
    }
    .btn-primary:hover {
      background: var(--cobalt-400);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0,74,173,0.3);
    }
    .btn-navy {
      background: var(--navy);
      color: var(--white);
    }
    .btn-navy:hover {
      background: var(--navy-900);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(30,58,95,0.25);
    }
    .btn-outline-navy {
      background: transparent;
      color: var(--navy);
      border: 2px solid var(--gray-300);
    }
    .btn-outline-navy:hover {
      border-color: var(--navy);
      background: var(--navy);
      color: var(--white);
    }
    .btn-ghost {
      background: transparent;
      color: var(--cobalt);
      border: 2.5px solid var(--cobalt);
    }
    .btn-ghost:hover { background: var(--cobalt); color: var(--white); }
    .btn-lg { padding: 1rem 2.5rem; font-size: 1.05rem; border-radius: 12px; }
    .btn-sm { padding: 0.55rem 1.4rem; font-size: 0.85rem; }

    /* ── NAVBAR ── */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      padding: 1rem 2rem;
      background: rgba(255,255,255,0.96);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(30,58,95,0.06);
      transition: box-shadow 0.3s;
    }
    .navbar.scrolled { box-shadow: 0 4px 30px rgba(30,58,95,0.08); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo {
      font-size: 1.35rem;
      font-weight: 900;
      letter-spacing: -0.04em;
      color: var(--navy);
    }
    .nav-logo span { color: var(--cobalt); }
    .nav-links { display: flex; gap: 0.15rem; align-items: center; }
    .nav-links a {
      padding: 0.5rem 0.9rem;
      color: var(--gray-500);
      font-weight: 500;
      font-size: 0.88rem;
      border-radius: 8px;
      transition: all 0.2s;
    }
    .nav-links a:hover { color: var(--navy); background: var(--gray-50); }

    /* ── HERO ── */
    .hero {
      padding-top: 100px;
      padding-bottom: 0;
      overflow: hidden;
    }
    .hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem 5rem;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }
    .hero-copy { }
    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.35rem 1rem 0.35rem 0.5rem;
      background: var(--cobalt-100);
      border: 1px solid var(--cobalt-200);
      border-radius: 100px;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--cobalt);
      margin-bottom: 1.5rem;
      letter-spacing: 0.03em;
    }
    .hero-tag-dot {
      width: 20px; height: 20px;
      border-radius: 50%;
      background: var(--cobalt);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .hero-tag-dot::after {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--white);
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(0.85); }
    }
    .hero-headline { margin-bottom: 1.5rem; }
    .hero-headline .accent { color: var(--cobalt); }
    .hero-body { margin-bottom: 2.5rem; max-width: 480px; }
    .hero-ctas { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem; }
    .hero-stats {
      display: flex;
      gap: 2.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid var(--gray-300);
    }
    .hero-stat { }
    .hero-stat-num {
      font-size: 1.6rem;
      font-weight: 900;
      color: var(--navy);
      letter-spacing: -0.03em;
      line-height: 1;
    }
    .hero-stat-label {
      font-size: 0.78rem;
      color: var(--gray-500);
      font-weight: 500;
      margin-top: 0.3rem;
    }
    .hero-image-wrap {
      position: relative;
    }
    .hero-image {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 40px 80px rgba(30,58,95,0.15), 0 0 0 1px rgba(30,58,95,0.05);
    }
    .hero-image img {
      width: 100%;
      height: 420px;
      object-fit: cover;
    }
    .hero-image-caption {
      position: absolute;
      bottom: 1.5rem;
      left: 1.5rem;
      right: 1.5rem;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(12px);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    .hero-caption-icon {
      width: 40px; height: 40px;
      border-radius: 10px;
      background: var(--cobalt);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .hero-caption-text { font-size: 0.82rem; font-weight: 600; color: var(--navy); line-height: 1.3; }
    .hero-caption-sub { font-size: 0.75rem; color: var(--gray-500); font-weight: 400; }

    /* ── LOGOS ── */
    .logos-bar {
      border-top: 1px solid var(--gray-100);
      border-bottom: 1px solid var(--gray-100);
      padding: 2rem 0;
      background: var(--white);
    }
    .logos-inner { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .logos-label {
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--gray-300);
      text-transform: uppercase;
      letter-spacing: 0.12em;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .logos-grid {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 3rem;
      align-items: center;
    }
    .logos-grid span {
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--gray-300);
      letter-spacing: -0.03em;
      transition: color 0.2s;
    }
    .logos-grid span:hover { color: var(--gray-500); }

    /* ── HOW IT WORKS ── */
    .hiw { background: var(--white); }
    .section-header { text-align: center; margin-bottom: 4rem; }
    .section-header-left { margin-bottom: 3rem; }
    .section-eyebrow {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--cobalt);
      margin-bottom: 0.75rem;
    }
    .steps-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2rem;
      position: relative;
    }
    .steps-grid::before {
      content: '';
      position: absolute;
      top: 40px;
      left: 12.5%;
      right: 12.5%;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--gray-300) 20%, var(--gray-300) 80%, transparent);
      z-index: 0;
    }
    .step { position: relative; z-index: 1; }
    .step-icon-wrap {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      background: var(--white);
      border: 1.5px solid var(--gray-300);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      position: relative;
      box-shadow: 0 4px 20px rgba(30,58,95,0.06);
    }
    .step-icon-svg { }
    .step-num {
      position: absolute;
      top: -10px;
      right: -10px;
      width: 28px;
      height: 28px;
      border-radius: 8px;
      background: var(--cobalt);
      color: var(--white);
      font-size: 0.72rem;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .step-title { font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 0.6rem; text-align: center; letter-spacing: -0.01em; }
    .step-body { font-size: 0.88rem; color: var(--gray-500); line-height: 1.7; text-align: center; }

    /* ── TWO COLUMN ── */
    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5rem;
      align-items: center;
    }
    .two-col.reverse { direction: rtl; }
    .two-col.reverse > * { direction: ltr; }
    .section-image {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 30px 70px rgba(30,58,95,0.12);
    }
    .section-image img { width: 100%; height: 400px; object-fit: cover; }
    .section-copy { }
    .section-copy .headline-lg { margin-bottom: 1.25rem; }
    .section-copy .body-lg { margin-bottom: 2rem; }
    .check-list { display: flex; flex-direction: column; gap: 1rem; }
    .check-item { display: flex; align-items: flex-start; gap: 0.9rem; }
    .check-circle {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: var(--cobalt);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }
    .check-text { font-size: 0.92rem; color: var(--gray-700); font-weight: 500; line-height: 1.5; }

    /* ── STATS BAR ── */
    .stats-bar { background: var(--navy); }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
      text-align: center;
    }
    .stat-item { padding: 2rem; }
    .stat-value {
      font-size: 3rem;
      font-weight: 900;
      color: var(--white);
      letter-spacing: -0.04em;
      line-height: 1;
      margin-bottom: 0.5rem;
    }
    .stat-value span { color: var(--cobalt-400); }
    .stat-label { font-size: 0.88rem; color: rgba(255,255,255,0.5); font-weight: 500; }
    .stat-sub { font-size: 0.75rem; color: rgba(255,255,255,0.35); margin-top: 0.25rem; }

    /* ── TALENT FEATURES ── */
    .talent-features { display: flex; flex-direction: column; gap: 1rem; }
    .talent-feat {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 16px;
      padding: 1.25rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.25rem;
      transition: all 0.25s;
    }
    .talent-feat:hover { background: rgba(255,255,255,0.08); transform: translateX(4px); }
    .talent-feat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: var(--cobalt);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .talent-feat-title { font-size: 0.95rem; font-weight: 700; color: var(--white); margin-bottom: 0.15rem; }
    .talent-feat-desc { font-size: 0.82rem; color: rgba(255,255,255,0.45); }

    /* ── PRICING ── */
    .pricing { background: var(--gray-50); }
    .pricing-toggle {
      display: inline-flex;
      background: var(--white);
      border-radius: 100px;
      padding: 0.35rem;
      gap: 0.25rem;
      border: 1px solid var(--gray-300);
    }
    .toggle-btn {
      padding: 0.55rem 1.4rem;
      border-radius: 100px;
      font-weight: 600;
      font-size: 0.85rem;
      border: none;
      cursor: pointer;
      transition: all 0.2s;
      background: transparent;
      color: var(--gray-500);
    }
    .toggle-btn.active { background: var(--navy); color: var(--white); }
    .toggle-save {
      display: inline-flex;
      align-items: center;
      background: var(--cobalt);
      color: var(--white);
      border-radius: 100px;
      padding: 0.15rem 0.55rem;
      font-size: 0.68rem;
      font-weight: 800;
      margin-left: 0.35rem;
    }
    .plans-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      align-items: start;
    }
    .plan-card {
      background: var(--white);
      border-radius: 20px;
      padding: 2rem;
      border: 1.5px solid var(--gray-300);
      position: relative;
      transition: all 0.3s;
    }
    .plan-card:hover { box-shadow: 0 20px 60px rgba(30,58,95,0.1); transform: translateY(-4px); }
    .plan-card.featured {
      border-color: var(--cobalt);
      border-width: 2px;
      transform: scale(1.03);
      box-shadow: 0 20px 60px rgba(0,74,173,0.15);
    }
    .plan-card.featured:hover { transform: scale(1.03) translateY(-4px); }
    .plan-badge {
      position: absolute;
      top: -13px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--cobalt);
      color: var(--white);
      padding: 0.3rem 1.1rem;
      border-radius: 100px;
      font-size: 0.72rem;
      font-weight: 800;
      white-space: nowrap;
      letter-spacing: 0.02em;
    }
    .plan-name {
      font-size: 1.1rem;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 0.35rem;
      letter-spacing: -0.02em;
    }
    .plan-desc { font-size: 0.85rem; color: var(--gray-500); margin-bottom: 1.5rem; line-height: 1.5; }
    .plan-price {
      font-size: 2.4rem;
      font-weight: 900;
      color: var(--navy);
      line-height: 1;
      letter-spacing: -0.04em;
      margin-bottom: 0.25rem;
    }
    .plan-price small { font-size: 1rem; font-weight: 500; color: var(--gray-500); }
    .plan-price-sub { font-size: 0.78rem; color: var(--gray-500); margin-bottom: 1.5rem; }
    .plan-divider {
      height: 2px;
      border-radius: 1px;
      background: var(--gray-100);
      margin-bottom: 1.5rem;
    }
    .plan-divider.colored { background: linear-gradient(90deg, var(--navy), var(--cobalt)); }
    .plan-features { display: flex; flex-direction: column; gap: 0.8rem; margin-bottom: 2rem; }
    .plan-feat { display: flex; align-items: center; gap: 0.65rem; font-size: 0.88rem; color: var(--gray-700); }
    .plan-feat-icon { width: 18px; height: 18px; border-radius: 50%; background: var(--cobalt-100); border: 1px solid var(--cobalt-200); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* ── WAITLIST ── */
    .waitlist { background: var(--navy); text-align: center; }
    .waitlist .headline-xl { color: var(--white); }
    .waitlist .body-lg { color: rgba(255,255,255,0.55); }
    .wl-inner { max-width: 560px; margin: 0 auto; }
    .wl-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
      margin-top: 2.5rem;
    }
    .wl-input {
      padding: 0.9rem 1.2rem;
      border: 1.5px solid rgba(255,255,255,0.15);
      border-radius: 10px;
      background: rgba(255,255,255,0.07);
      color: var(--white);
      font-size: 0.95rem;
      font-family: inherit;
      outline: none;
      transition: border 0.2s, background 0.2s;
    }
    .wl-input::placeholder { color: rgba(255,255,255,0.3); }
    .wl-input:focus { border-color: rgba(255,255,255,0.4); background: rgba(255,255,255,0.1); }
    .wl-input.full { grid-column: 1 / -1; }
    .wl-input.select { grid-column: 1 / -1; }
    .wl-input.select option { color: var(--gray-900); background: var(--white); }
    .wl-submit { grid-column: 1 / -1; }
    .wl-note { font-size: 0.78rem; color: rgba(255,255,255,0.3); margin-top: 1rem; }
    .wl-success {
      display: none;
      margin-top: 1.5rem;
      background: rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 1.5rem;
      color: var(--white);
      font-weight: 700;
      font-size: 1rem;
    }

    /* ── FOOTER ── */
    .footer { background: var(--navy-900); padding: 3rem 0; }
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1.5rem;
    }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }
    .footer-links { display: flex; gap: 2rem; }
    .footer-links a { font-size: 0.85rem; color: rgba(255,255,255,0.4); transition: color 0.2s; }
    .footer-links a:hover { color: rgba(255,255,255,0.8); }

    /* ── SCROLL REVEAL ── */
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
      .steps-grid { grid-template-columns: repeat(2, 1fr); }
      .steps-grid::before { display: none; }
      .stats-grid { grid-template-columns: repeat(3, 1fr); }
      .plans-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
      .plan-card.featured { transform: none; }
      .plan-card.featured:hover { transform: translateY(-4px); }
    }
    @media (max-width: 768px) {
      .hero-inner { grid-template-columns: 1fr; gap: 2.5rem; }
      .two-col { grid-template-columns: 1fr; gap: 2.5rem; direction: ltr; }
      .two-col.reverse { direction: ltr; }
      .hero-stats { gap: 1.5rem; flex-wrap: wrap; }
      .nav-links { display: none; }
      .wl-form { grid-template-columns: 1fr; }
      .wl-input, .wl-submit { grid-column: 1; }
      .stats-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .section { padding: 4rem 1.25rem; }
      .container { padding: 0 1.25rem; }
      .hero-inner { padding: 0 1.25rem 3rem; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <div class="nav-logo">rev<span>crewt</span></div>
    <div class="nav-links">
      <a href="#how-it-works">How It Works</a>
      <a href="#for-employers">For Employers</a>
      <a href="#for-talent">For Talent</a>
      <a href="#pricing">Pricing</a>
    </div>
    <a href="#waitlist" class="btn btn-primary btn-sm">Join Waitlist</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <!-- Left copy -->
    <div>
      <div class="hero-tag reveal">
        <div class="hero-tag-dot"></div>
        Early Access Now Open
      </div>
      <h1 class="headline-xl hero-headline reveal" style="transition-delay:0.05s">
        Stop Applying.<br>
        <span class="accent">Start Matching.</span>
      </h1>
      <p class="body-lg hero-body reveal" style="transition-delay:0.1s">
        revcrewt flips the recruiting game. Companies compete for you — not the other way around. Build your profile, set your terms, and let top employers bid for your attention.
      </p>
      <div class="hero-ctas reveal" style="transition-delay:0.15s">
        <a href="#waitlist" class="btn btn-primary btn-lg">
          Get Early Access
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="#how-it-works" class="btn btn-outline-navy btn-lg">See How It Works</a>
      </div>
      <div class="hero-stats reveal" style="transition-delay:0.2s">
        <div class="hero-stat">
          <div class="hero-stat-num">2,400+</div>
          <div class="hero-stat-label">Active Professionals</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">180+</div>
          <div class="hero-stat-label">Partner Companies</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">4.9</div>
          <div class="hero-stat-label">Average Rating</div>
        </div>
      </div>
    </div>

    <!-- Right image -->
    <div class="hero-image-wrap reveal" style="transition-delay:0.1s">
      <div class="hero-image">
        <img src="/assets/hero-recruiting.jpg" alt="Professional recruiting session" loading="eager">
      </div>
      <div class="hero-image-caption">
        <div class="hero-caption-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
          <div class="hero-caption-text">Application submitted</div>
          <div class="hero-caption-sub">Matched with 3 companies in 24 hours</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LOGOS -->
<div class="logos-bar">
  <div class="logos-inner">
    <div class="logos-label">Trusted by hiring teams at</div>
    <div class="logos-grid">
      <span>TechVentures PH</span>
      <span>DataStream Asia</span>
      <span>CloudFirst Inc.</span>
      <span>Innovate Labs</span>
      <span>NextWave Corp</span>
      <span>BuildStack</span>
    </div>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="section hiw" id="how-it-works">
  <div class="container">
    <div class="section-header reveal">
      <div class="section-eyebrow">How It Works</div>
      <h2 class="headline-lg">Four Steps to<br><span class="text-cobalt">Take Back Control</span></h2>
      <p class="body-lg" style="max-width:520px;margin:0.75rem auto 0">Reverse recruiting puts the power in your hands. Here is how the process works — from sign-up to your first offer.</p>
    </div>

    <div class="steps-grid">
      <!-- Step 1 -->
      <div class="step reveal">
        <div class="step-icon-wrap">
          <svg class="step-icon-svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
            <rect x="4" y="4" width="28" height="28" rx="6" stroke="#004aad" stroke-width="2"/>
            <path d="M11 18h14M11 13h8M11 23h10" stroke="#004aad" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <div class="step-num">01</div>
        </div>
        <h3 class="step-title">Create Your Profile</h3>
        <p class="step-body">Tell us your skills, experience, salary expectations, and the work environment you thrive in.</p>
      </div>

      <!-- Step 2 -->
      <div class="step reveal" style="transition-delay:0.1s">
        <div class="step-icon-wrap">
          <svg class="step-icon-svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
            <circle cx="18" cy="14" r="6" stroke="#004aad" stroke-width="2"/>
            <path d="M6 30c0-6.627 5.373-12 12-12s12 5.373 12 12" stroke="#004aad" stroke-width="2" stroke-linecap="round"/>
            <circle cx="26" cy="24" r="3" stroke="#004aad" stroke-width="2"/>
            <path d="M28 28l3 3" stroke="#004aad" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <div class="step-num">02</div>
        </div>
        <h3 class="step-title">Companies Discover You</h3>
        <p class="step-body">Hiring managers find and shortlist candidates based on talent fit — not just keywords on a resume.</p>
      </div>

      <!-- Step 3 -->
      <div class="step reveal" style      <div class="step-icon-wrap">
        <svg class="step-icon-svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
          <rect x="4" y="8" width="28" height="20" rx="4" stroke="#004aad" stroke-width="2"/>
          <path d="M12 18h12M12 22h8" stroke="#004aad" stroke-width="2" stroke-linecap="round"/>
          <path d="M22 4l6 6" stroke="#004aad" stroke-width="2" stroke-linecap="round"/>
          <path d="M28 4H22v6" stroke="#004aad" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="step-num">03</div>
      </div>
      <h3 class="step-title">Receive Competing Offers</h3>
      <p class="step-body">Companies send you offers with salary, benefits, and growth opportunities. You compare and choose.</p>
    </div>

    <!-- Step 4 -->
    <div class="step reveal" style="transition-delay:0.3s">
      <div class="step-icon-wrap">
        <svg class="step-icon-svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
          <path d="M18 4l3.5 7.5L30 13l-6 5.5L25 26l-7-4-7 4 1.5-7.5L6 13l8.5-1.5L18 4z" stroke="#004aad" stroke-width="2" stroke-linejoin="round"/>
        </svg>
        <div class="step-num">04</div>
      </div>
      <h3 class="step-title">You Control the Process</h3>
      <p class="step-body">No more ghosting. You are in the driver seat — negotiate, ask questions, accept on your terms.</p>
    </div>
  </div>
</section>

<!-- FOR EMPLOYERS -->
<section class="section bg-gray" id="for-employers">
  <div class="container">
    <div class="two-col">
      <div class="section-image reveal">
        <img src="/assets/hero-recruiter.jpg" alt="HR team reviewing candidates" loading="lazy">
      </div>
      <div class="section-copy reveal" style="transition-delay:0.15s">
        <div class="section-eyebrow">For Employers</div>
        <h2 class="headline-lg">Hire Faster with<br><span class="text-cobalt">Pre-Vetted Talent</span></h2>
        <p class="body-lg">Stop chasing candidates who ghost you. revcrewt gives you direct access to active, qualified talent who have already expressed interest in your opportunities.</p>
        <div class="check-list">
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">AI-powered matching by skills and culture fit</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Verified work history and skill assessments</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Direct messaging with salary pre-disclosure</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Reduce time-to-hire by up to 60 percent</span>
          </div>
        </div>
        <div style="margin-top:2.5rem">
          <a href="#waitlist" class="btn btn-navy btn-lg">Post a Job Free</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<section class="section-sm stats-bar">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item reveal">
        <div class="stat-value">&lt;<span> 24</span></div>
        <div class="stat-label">Hours to Shortlist</div>
        <div class="stat-sub">vs. 2-3 weeks traditional</div>
      </div>
      <div class="stat-item reveal" style="transition-delay:0.1s">
        <div class="stat-value"><span>87</span>%</div>
        <div class="stat-label">Offer Acceptance Rate</div>
        <div class="stat-sub">Candidates are pre-interested</div>
      </div>
      <div class="stat-item reveal" style="transition-delay:0.2s">
        <div class="stat-value"><span>45</span>%</div>
        <div class="stat-label">Reduction in Cost per Hire</div>
        <div class="stat-sub">vs. traditional job boards</div>
      </div>
    </div>
  </div>
</section>

<!-- FOR TALENT -->
<section class="section bg-white" id="for-talent">
  <div class="container">
    <div class="two-col reverse">
      <div class="section-image reveal">
        <img src="/assets/hero-talent.jpg" alt="Professional receiving job offer" loading="lazy">
      </div>
      <div class="section-copy reveal" style="transition-delay:0.15s">
        <div class="section-eyebrow" style="color:var(--gray-500)">For Job Seekers</div>
        <h2 class="headline-lg">Your Dream Role Should<br><span class="text-cobalt">Come to You</span></h2>
        <p class="body-lg">Stop blasting resumes into the void. On revcrewt, companies reach out with real opportunities. All offers are transparent — salary, benefits, and culture up front.</p>
        <div class="check-list" style="margin-bottom:2.5rem">
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Zero applications — companies find you</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Transparent salary ranges on every offer</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Negotiate from a position of power</span>
          </div>
          <div class="check-item">
            <div class="check-circle">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="check-text">Built-in career roadmap and skill tracking</span>
          </div>
        </div>
        <a href="#waitlist" class="btn btn-primary btn-lg">Join the Waitlist</a>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="section pricing" id="pricing">
  <div class="container">
    <div class="section-header reveal">
      <div class="section-eyebrow">Pricing</div>
      <h2 class="headline-lg">Simple, Transparent <span class="text-cobalt">Pricing</span></h2>
      <p class="body-lg" style="max-width:480px;margin:0.75rem auto 0">No hidden fees. No commission on your salary. Ever.</p>
      <div class="pricing-toggle" style="margin-top:1.75rem">
        <button class="toggle-btn active" id="btn-m">Monthly</button>
        <button class="toggle-btn" id="btn-a">Annual <span class="toggle-save">Save 20%</span></button>
      </div>
    </div>

    <div class="plans-grid">
      <!-- Starter -->
      <div class="plan-card reveal">
        <div class="plan-name">Starter</div>
        <div class="plan-desc">For individual job seekers starting out</div>
        <div class="plan-price">Free <small>/mo</small></div>
        <div class="plan-divider"></div>
        <div class="plan-features">
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Basic profile creation
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Limited offer visibility (3 per month)
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Standard matching
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Email support
          </div>
        </div>
        <a href="#waitlist" class="btn btn-ghost" style="width:100%;justify-content:center">Get Started Free</a>
      </div>

      <!-- Pro -->
      <div class="plan-card featured reveal" style="transition-delay:0.1s">
        <div class="plan-badge">Most Popular</div>
        <div class="plan-name">Pro</div>
        <div class="plan-desc">For serious professionals who want the edge</div>
        <div class="plan-price" id="pro-price">&#8369;1,499<small>/mo</small></div>
        <div class="plan-price-sub" id="pro-sub">or &#8369;1,199/mo billed annually</div>
        <div class="plan-divider colored"></div>
        <div class="plan-features">
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Unlimited offer visibility
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Priority matching algorithm
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Salary negotiation toolkit
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Career roadmap builder
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            1-on-1 coaching session
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Discord community access
          </div>
        </div>
        <a href="#waitlist" class="btn btn-primary" style="width:100%;justify-content:center">Go Pro</a>
      </div>

      <!-- Enterprise -->
      <div class="plan-card reveal" style="transition-delay:0.2s">
        <div class="plan-name">Enterprise</div>
        <div class="plan-desc">For companies building high-performance teams</div>
        <div class="plan-price">Custom <small>/mo</small></div>
        <div class="plan-divider"></div>
        <div class="plan-features">
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Unlimited team hiring
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            AI sourcing dashboard
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Dedicated account manager
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Custom assessment integration
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            SLA-backed support
          </div>
          <div class="plan-feat">
            <div class="plan-feat-icon">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#004aad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            API access
          </div>
        </div>
        <a href="#waitlist" class="btn btn-navy" style="width:100%;justify-content:center">Contact Sales</a>
      </div>
    </div>
  </div>
</section>

<!-- WAITLIST -->
<section class="section waitlist" id="waitlist">
  <div class="container wl-inner">
    <div class="section-eyebrow" style="color:rgba(255,255,255,0.5)">Early Access</div>
    <h2 class="headline-xl" style="margin:0.75rem 0">Be First in Line<br>When We Launch</h2>
    <p class="body-lg">Join 1,200+ professionals already on the waitlist. Early access members get 3 months of Pro free.</p>
    <form class="wl-form" onsubmit="handleWL(event)">
      <input type="text" class="wl-input" placeholder="Full name" required id="wl-name" autocomplete="name">
      <input type="email" class="wl-input" placeholder="Email address" required id="wl-email" autocomplete="email">
      <select class="wl-input select" id="wl-role" required>
        <option value="" disabled selected>I am a...</option>
        <option value="jobseeker">Job Seeker</option>
        <option value="employer">Employer / Recruiter</option>
        <option value="both">Both</option>
      </select>
      <button type="submit" class="btn btn-primary btn-lg wl-submit">Join the Waitlist</button>
    </form>
    <p class="wl-note">No spam. No credit card. Unsubscribe anytime.</p>
    <div class="wl-success" id="wl-success">
      You are on the list. We will be in touch soon.
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
    <div class="footer-links">
      <a href="#">Privacy</a>
      <a href="#">Terms</a>
      <a href="#">Contact</a>
    </div>
  </div>
</footer>

<script>
  // Navbar scroll
  window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
  });

  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => obs.observe(el));

  // Pricing toggle
  const btnM = document.getElementById('btn-m');
  const btnA = document.getElementById('btn-a');
  const proPrice = document.getElementById('pro-price');
  const proSub = document.getElementById('pro-sub');
  btnM.addEventListener('click', () => {
    btnM.classList.add('active'); btnA.classList.remove('active');
    proPrice.innerHTML = '\u20b11,499<small>/mo</small>';
    proSub.style.display = 'block';
  });
  btnA.addEventListener('click', () => {
    btnA.classList.add('active'); btnM.classList.remove('active');
    proPrice.innerHTML = '\u20b11,199<small>/mo</small>';
    proSub.style.display = 'none';
  });

  // Waitlist
  function handleWL(e) {
    e.preventDefault();
    document.querySelector('.wl-form').style.display = 'none';
    document.getElementById('wl-success').style.display = 'block';
  }
</script>

</body>
</html>
