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
      --navy-dark: #152a45;
      --cobalt: #004aad;
      --cobalt-light: #0066cc;
      --slate: #64748b;
      --silver: #f1f5f9;
      --shadow-sm: 0 2px 8px rgba(30,58,95,0.08);
      --shadow-md: 0 8px 30px rgba(30,58,95,0.12);
      --shadow-lg: 0 20px 60px rgba(30,58,95,0.16);
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: var(--navy); background: #fff; overflow-x: hidden; line-height: 1.6; }
    a { text-decoration: none; }

    /* NAVBAR */
    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.95); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(30,58,95,0.07); transition: box-shadow 0.3s; }
    .navbar.scrolled { box-shadow: var(--shadow-md); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .logo { font-size: 1.4rem; font-weight: 900; letter-spacing: -0.03em; color: var(--navy); }
    .logo span { color: var(--cobalt); }
    .nav-links { display: flex; gap: 0.25rem; align-items: center; }
    .nav-links a { padding: 0.5rem 1rem; color: var(--slate); font-weight: 500; font-size: 0.9rem; border-radius: 8px; transition: all 0.2s; }
    .nav-links a:hover { color: var(--navy); background: var(--silver); }
    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.6rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.3s ease; text-decoration: none; }
    .btn-primary { background: var(--cobalt); color: #fff; }
    .btn-primary:hover { background: var(--cobalt-light); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,74,173,0.35); }
    .btn-navy { background: var(--navy); color: #fff; }
    .btn-navy:hover { background: var(--navy-dark); transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .btn-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.35); }
    .btn-outline:hover { border-color: #fff; background: rgba(255,255,255,0.1); }
    .btn-ghost { background: transparent; color: var(--cobalt); border: 2px solid var(--cobalt); }
    .btn-ghost:hover { background: var(--cobalt); color: #fff; }
    .badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 1rem; border-radius: 100px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.02em; }
    .badge-blue { background: rgba(0,74,173,0.08); color: var(--cobalt); border: 1px solid rgba(0,74,173,0.15); }
    .badge-white { background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
    .section { padding: 6rem 2rem; }
    .container { max-width: 1200px; margin: 0 auto; }
    .gradient-line { height: 3px; border-radius: 2px; background: linear-gradient(90deg, var(--navy), var(--cobalt), var(--cobalt-light)); }

    /* HERO */
    .hero { min-height: 100vh; background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 50%, #003d7a 100%); display: flex; align-items: center; position: relative; overflow: hidden; padding-top: 80px; }
    .hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px; pointer-events: none; }
    .hero-glow { position: absolute; width: 700px; height: 700px; border-radius: 50%; background: radial-gradient(circle, rgba(0,74,173,0.35) 0%, transparent 70%); top: -150px; right: -150px; pointer-events: none; }
    .hero-glow-2 { position: absolute; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(0,102,204,0.15) 0%, transparent 70%); bottom: -100px; left: -100px; pointer-events: none; }
    .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; position: relative; z-index: 1; }
    .hero h1 { font-size: clamp(2.5rem, 5vw, 4.2rem); font-weight: 900; color: #fff; line-height: 1.08; letter-spacing: -0.035em; margin-bottom: 1.5rem; }
    .hero h1 .accent { color: #7dd3fc; }
    .hero p { font-size: 1.1rem; color: rgba(255,255,255,0.68); line-height: 1.75; margin-bottom: 2.5rem; max-width: 500px; }
    .hero-stats { display: flex; gap: 2.5rem; margin-top: 3rem; padding-top: 2.5rem; border-top: 1px solid rgba(255,255,255,0.1); }
    .hero-stat-num { font-size: 1.7rem; font-weight: 900; color: #fff; }
    .hero-stat-label { font-size: 0.78rem; color: rgba(255,255,255,0.5); font-weight: 600; margin-top: 0.15rem; }
    .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
    .hero-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 2rem; color: #fff; animation: float 5s ease-in-out infinite; }
    .hero-card-top { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .hero-card-avatar { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, var(--cobalt), var(--cobalt-light)); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    .hero-card-name { font-weight: 700; font-size: 1.05rem; }
    .hero-card-role { font-size: 0.82rem; color: rgba(255,255,255,0.5); margin-top: 0.15rem; }
    .hero-card-badge { margin-left: auto; background: var(--cobalt); border-radius: 100px; padding: 0.25rem 0.8rem; font-size: 0.72rem; font-weight: 800; }
    .hero-card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1.5rem; }
    .hero-card-tag { background: rgba(0,74,173,0.3); border: 1px solid rgba(0,74,173,0.4); border-radius: 100px; padding: 0.25rem 0.7rem; font-size: 0.72rem; font-weight: 600; color: #93c5fd; }
    .hero-offers-box { background: rgba(0,74,173,0.15); border: 1px solid rgba(0,74,173,0.2); border-radius: 14px; padding: 1rem; }
    .hero-offers-title { font-size: 0.72rem; color: rgba(255,255,255,0.45); font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem; }
    .offer-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .offer-item:last-child { border-bottom: none; }
    .offer-logo { width: 34px; height: 34px; border-radius: 9px; background: linear-gradient(135deg, var(--navy), var(--cobalt)); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 900; flex-shrink: 0; }
    .offer-company { font-size: 0.85rem; font-weight: 600; }
    .offer-role { font-size: 0.72rem; color: rgba(255,255,255,0.45); }
    .offer-salary { margin-left: auto; text-align: right; font-size: 0.85rem; font-weight: 700; color: #86efac; }
    .offer-hot { display: block; font-size: 0.62rem; font-weight: 800; color: #fbbf24; }
    .float-badge { position: absolute; top: -18px; right: -18px; background: #fff; border-radius: 16px; padding: 0.75rem 1.1rem; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 0.6rem; animation: float 4s ease-in-out 1s infinite; }
    .float-badge-icon { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--cobalt), var(--cobalt-light)); display: flex; align-items: center; justify-content: center; font-size: 1rem; }
    .float-badge-text { font-weight: 800; font-size: 0.85rem; color: var(--navy); }
    .float-badge-sub { font-size: 0.7rem; color: var(--slate); }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }

    /* LOGOS */
    .logos { background: var(--silver); padding: 2.5rem 2rem; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    .logos-inner { max-width: 1200px; margin: 0 auto; text-align: center; }
    .logos-label { font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; }
    .logos-grid { display: flex; justify-content: center; flex-wrap: wrap; gap: 2.5rem; align-items: center; opacity: 0.45; }
    .logos-grid span { font-size: 1.1rem; font-weight: 800; color: var(--navy); letter-spacing: -0.02em; }

    /* SECTIONS */
    .section-header { text-align: center; margin-bottom: 4rem; }
    .section-title { font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: var(--navy); letter-spacing: -0.035em; line-height: 1.1; margin: 0.75rem 0; }
    .section-title .accent { color: var(--cobalt); }
    .section-sub { font-size: 1.05rem; color: var(--slate); max-width: 520px; margin: 0 auto; line-height: 1.7; }
    .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
    .step-card { background: #fff; border-radius: 20px; padding: 2rem; border: 1px solid rgba(30,58,95,0.07); transition: all 0.4s ease; position: relative; overflow: hidden; }
    .step-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: rgba(0,74,173,0.15); }
    .step-icon { font-size: 3rem; margin-bottom: 1.25rem; }
    .step-num-bg { position: absolute; top: 1.5rem; right: 1.5rem; font-size: 4rem; font-weight: 900; color: #f1f5f9; line-height: 1; }
    .step-title { font-size: 1.15rem; font-weight: 800; color: var(--navy); margin-bottom: 0.75rem; letter-spacing: -0.01em; }
    .step-desc { font-size: 0.9rem; color: var(--slate); line-height: 1.7; }

    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
    .check-list { display: flex; flex-direction: column; gap: 0.9rem; margin-top: 1.5rem; }
    .check-item { display: flex; align-items: flex-start; gap: 0.75rem; }
    .check-icon { width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, var(--cobalt), var(--cobalt-light)); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .check-icon svg { color: #fff; }
    .check-item span { font-size: 0.95rem; color: #475569; font-weight: 500; }
    .stat-cards { display: flex; flex-direction: column; gap: 1rem; }
    .stat-card { background: #fff; border-radius: 16px; padding: 1.25rem 1.5rem; border: 1px solid rgba(30,58,95,0.07); display: flex; align-items: center; gap: 1.5rem; transition: all 0.3s; }
    .stat-card:hover { transform: translateX(4px); box-shadow: var(--shadow-sm); }
    .stat-val { font-size: 2rem; font-weight: 900; background: linear-gradient(135deg, var(--navy), var(--cobalt)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .stat-label { font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-sub { font-size: 0.78rem; color: #94a3b8; margin-top: 0.15rem; }

    /* TALENT */
    .talent { background: linear-gradient(135deg, var(--navy), var(--navy-dark)); }
    .talent .section-title { color: #fff; }
    .talent .section-sub { color: rgba(255,255,255,0.6); }
    .talent-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 18px; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1.25rem; backdrop-filter: blur(12px); transition: all 0.3s; }
    .talent-card:hover { background: rgba(255,255,255,0.08); transform: translateX(4px); }
    .talent-emoji { font-size: 2.2rem; flex-shrink: 0; }
    .talent-title { font-weight: 700; color: #fff; font-size: 1rem; margin-bottom: 0.2rem; }
    .talent-desc { font-size: 0.82rem; color: rgba(255,255,255,0.5); }
    .talent .check-item span { color: rgba(255,255,255,0.8); }
    .talent .check-icon { background: rgba(0,74,173,0.5); border: 1px solid rgba(96,165,250,0.3); }

    /* PRICING */
    .pricing { background: #fff; }
    .pricing-toggle { display: inline-flex; background: var(--silver); border-radius: 100px; padding: 0.3rem; gap: 0.25rem; }
    .toggle-btn { padding: 0.5rem 1.2rem; border-radius: 100px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.2s; background: transparent; color: var(--slate); }
    .toggle-btn.active { background: var(--navy); color: #fff; }
    .toggle-badge { background: var(--cobalt); color: #fff; border-radius: 100px; padding: 0.15rem 0.5rem; font-size: 0.68rem; font-weight: 800; margin-left: 0.4rem; }
    .plans-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; align-items: start; }
    .plan-card { background: #fff; border-radius: 24px; padding: 2rem; border: 2px solid #e2e8f0; transition: all 0.3s; position: relative; }
    .plan-card.featured { border-color: var(--cobalt); transform: scale(1.03); box-shadow: var(--shadow-lg); z-index: 1; }
    .plan-popular { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, var(--cobalt), var(--cobalt-light)); color: #fff; padding: 0.3rem 1.2rem; border-radius: 100px; font-size: 0.75rem; font-weight: 800; white-space: nowrap; }
    .plan-name { font-size: 1.3rem; font-weight: 800; color: var(--navy); margin-bottom: 0.35rem; }
    .plan-desc { font-size: 0.85rem; color: #94a3b8; margin-bottom: 1.25rem; line-height: 1.5; }
    .plan-price { font-size: 2.5rem; font-weight: 900; color: var(--navy); line-height: 1; margin-bottom: 0.25rem; }
    .plan-price small { font-size: 1rem; font-weight: 500; color: #94a3b8; }
    .plan-price-sub { font-size: 0.8rem; color: #94a3b8; margin-bottom: 1.5rem; }
    .plan-divider { height: 3px; border-radius: 2px; background: linear-gradient(90deg, var(--navy), var(--cobalt)); margin-bottom: 1.5rem; opacity: 0.15; }
    .plan-features { display: flex; flex-direction: column; gap: 0.7rem; margin-bottom: 2rem; }
    .plan-feature { display: flex; align-items: center; gap: 0.6rem; font-size: 0.88rem; color: #475569; }

    /* WAITLIST */
    .waitlist { background: linear-gradient(135deg, var(--navy), #003d7a); text-align: center; }
    .waitlist .section-title { color: #fff; }
    .waitlist .section-sub { color: rgba(255,255,255,0.65); margin: 0 auto 2.5rem; }
    .waitlist-form { max-width: 540px; margin: 0 auto; display: flex; gap: 0.75rem; flex-wrap: wrap; justify-content: center; }
    .waitlist-input { flex: 1; min-width: 220px; padding: 0.85rem 1.2rem; border: 2px solid rgba(255,255,255,0.2); border-radius: 12px; background: rgba(255,255,255,0.08); color: #fff; font-size: 1rem; font-family: inherit; outline: none; transition: border 0.2s; }
    .waitlist-input::placeholder { color: rgba(255,255,255,0.4); }
    .waitlist-input:focus { border-color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.12); }
    .waitlist-note { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-top: 1rem; }

    /* FOOTER */
    .footer { background: var(--navy-dark); padding: 3rem 2rem; }
    .footer-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.2rem; font-weight: 900; color: #fff; }
    .footer-logo span { color: var(--cobalt-light); }
    .footer-copy { font-size: 0.82rem; color: rgba(255,255,255,0.35); }
    .footer-links { display: flex; gap: 1.5rem; }
    .footer-links a { font-size: 0.85rem; color: rgba(255,255,255,0.5); transition: color 0.2s; }
    .footer-links a:hover { color: #fff; }

    /* FADE UP */
    .fade-up { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
    .fade-up.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 900px) {
      .hero-grid, .two-col { grid-template-columns: 1fr; gap: 3rem; }
      .hero-stats { gap: 1.5rem; }
      .nav-links { display: none; }
    }
    @media (max-width: 600px) {
      .hero h1 { font-size: 2.2rem; }
      .section { padding: 4rem 1.25rem; }
      .plans-grid { grid-template-columns: 1fr; }
      .plan-card.featured { transform: none; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <div class="logo">rev<span>crewt</span></div>
    <div class="nav-links">
      <a href="#how-it-works">How It Works</a>
      <a href="#for-employers">For Employers</a>
      <a href="#for-talent">For Talent</a>
      <a href="#pricing">Pricing</a>
    </div>
    <a href="#waitlist" class="btn btn-primary" style="padding:0.55rem 1.4rem;font-size:0.9rem">Join Waitlist</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-glow-2"></div>
  <div class="container" style="width:100%">
    <div class="hero-grid">
      <div>
        <div class="badge badge-white fade-up" style="margin-bottom:1.5rem">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          The Future of Hiring
        </div>
        <h1 class="fade-up" style="transition-delay:0.1s">
          Stop Applying.<br>
          <span class="accent">Start Matching.</span>
        </h1>
        <p class="fade-up" style="transition-delay:0.2s">
          revcrewt flips the recruiting game. Companies compete for you — not the other way around. Build your profile, set your terms, and let top employers bid for your attention.
        </p>
        <div class="hero-btns fade-up" style="transition-delay:0.3s">
          <a href="#waitlist" class="btn btn-primary" style="font-size:1.05rem;padding:0.9rem 2rem">
            Get Early Access
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="#how-it-works" class="btn btn-outline">See How It Works</a>
        </div>
        <div class="hero-stats fade-up" style="transition-delay:0.4s">
          <div><div class="hero-stat-num">2,400+</div><div class="hero-stat-label">Active Talent</div></div>
          <div><div class="hero-stat-num">180+</div><div class="hero-stat-label">Partner Companies</div></div>
          <div><div class="hero-stat-num">4.9&#9733;</div><div class="hero-stat-label">Avg. Rating</div></div>
        </div>
      </div>

      <!-- Profile Card -->
      <div style="position:relative" class="fade-up" class="fade-up" style="transition-delay:0.3s">
        <div class="hero-card">
          <div class="hero-card-top">
            <div class="hero-card-avatar">&#128187;</div>
            <div>
              <div class="hero-card-name">Marcus Dela Cruz</div>
              <div class="hero-card-role">Senior Full-Stack Developer &middot; 8 yrs</div>
            </div>
            <div class="hero-card-badge">TOP 5%</div>
          </div>
          <div class="hero-card-tags">
            <span class="hero-card-tag">React</span>
            <span class="hero-card-tag">Node.js</span>
            <span class="hero-card-tag">AWS</span>
            <span class="hero-card-tag">PostgreSQL</span>
            <span class="hero-card-tag">TypeScript</span>
          </div>
          <div class="hero-offers-box">
            <div class="hero-offers-title">Active Offers Received</div>
            <div class="offer-item">
              <div class="offer-logo">T</div>
              <div><div class="offer-company">TechVentures PH</div><div class="offer-role">Lead Engineer</div></div>
              <div><div class="offer-salary">&#8369;420K/mo</div><span class="offer-hot">&#128293; Hot</span></div>
            </div>
            <div class="offer-item">
              <div class="offer-logo">D</div>
              <div><div class="offer-company">DataStream Asia</div><div class="offer-role">Senior Dev</div></div>
              <div><div class="offer-salary">&#8369;380K/mo</div><span class="offer-hot">&#11088; New</span></div>
            </div>
            <div class="offer-item">
              <div class="offer-logo">C</div>
              <div><div class="offer-company">CloudFirst Inc.</div><div class="offer-role">Full-Stack Lead</div></div>
              <div><div class="offer-salary">&#8369;350K/mo</div></div>
            </div>
          </div>
        </div>
        <div class="float-badge">
          <div class="float-badge-icon">&#127919;</div>
          <div>
            <div class="float-badge-text">3 Offers</div>
            <div class="float-badge-sub">in 48 hours</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LOGOS -->
<div class="logos">
  <div class="logos-inner">
    <div class="logos-label">Trusted by hiring teams at</div>
    <div class="logos-grid">
      <span>TechVentures PH</span>
      <span>DataStream</span>
      <span>CloudFirst</span>
      <span>Innovate Labs</span>
      <span>NextWave</span>
      <span>BuildStack</span>
    </div>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="section" id="how-it-works" style="background:#fff">
  <div class="container">
    <div class="section-header fade-up">
      <div class="badge badge-blue">How It Works</div>
      <h2 class="section-title">Four Steps to<br><span class="accent">Take Back Control</span></h2>
      <p class="section-sub">Reverse recruiting puts the power in your hands. From sign-up to your first offer, here's the process.</p>
    </div>
    <div class="steps-grid">
      <div class="step-card fade-up">
        <div class="step-icon">&#128221;</div>
        <div class="step-num-bg">01</div>
        <h3 class="step-title">Create Your Profile</h3>
        <p class="step-desc">Tell us who you are &mdash; your skills, experience, salary expectations, and the work environment you thrive in.</p>
      </div>
      <div class="step-card fade-up" style="transition-delay:0.1s">
        <div class="step-icon">&#128269;</div>
        <div class="step-num-bg">02</div>
        <h3 class="step-title">Companies Discover You</h3>
        <p class="step-desc">Hiring managers find and shortlist candidates based on talent fit &mdash; not just keywords on a r&eacute;sum&eacute;.</p>
      </div>
      <div class="step-card fade-up" style="transition-delay:0.2s">
        <div class="step-icon">&#128188;</div>
        <div class="step-num-bg">03</div>
        <h3 class="step-title">Receive Competing Offers</h3>
        <p class="step-desc">Companies send you offers with salary, benefits, and growth opportunities. You compare and choose.</p>
      </div>
      <div class="step-card fade-up" style="transition-delay:0.3s">
        <div class="step-icon">&#128640;</div>
        <div class="step-num-bg">04</div>
        <h3 class="step-title">You Control the Process</h3>
        <p class="step-desc">No more ghosting. You&rsquo;re in the driver&rsquo;s seat &mdash; negotiate, ask questions, accept on your terms.</p>
      </div>
    </div>
  </div>
</section>

<!-- FOR EMPLOYERS -->
<section class="section" id="for-employers" style="background:#f1f5f9">
  <div class="container">
    <div class="two-col">
      <div class="fade-up">
        <div class="badge badge-blue" style="margin-bottom:1.5rem">For Employers</div>
        <h2 class="section-title" style="text-align:left">Hire Faster with<br><span class="accent">Pre-Vetted Talent</span></h2>
        <p style="font-size:1.05rem;color:var(--slate);line-height:1.75;margin:1rem 0 1.5rem">
          Stop chasing candidates who ghost you. revcrewt gives you direct access to active, qualified talent who have already expressed interest in your opportunities.
        </p>
        <div class="check-list">
          <div class="check-item">
            <div class="check-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>AI-powered matching by skills &amp; culture fit</span>
          </div>
          <div class="check-item">
            <div class="check-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div            <span>Verified work history and skill assessments</span>
          </div>
          <div class="check-item">
            <div class="check-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Direct messaging with salary pre-disclosure</span>
          </div>
          <div class="check-item">
            <div class="check-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Reduce time-to-hire by up to 60%</span>
          </div>
        </div>
        <div style="margin-top:2rem">
          <a href="#waitlist" class="btn btn-navy">Post a Job Free &rarr;</a>
        </div>
      </div>
      <div class="stat-cards fade-up" style="transition-delay:0.15s">
        <div class="stat-card">
          <div style="flex:1">
            <div class="stat-label">Time to Shortlist</div>
            <div class="stat-val">&lt; 24 hrs</div>
            <div class="stat-sub">vs. 2&ndash;3 weeks traditional</div>
          </div>
        </div>
        <div class="stat-card">
          <div style="flex:1">
            <div class="stat-label">Offer Acceptance</div>
            <div class="stat-val">87%</div>
            <div class="stat-sub">Candidates are pre-interested</div>
          </div>
        </div>
        <div class="stat-card">
          <div style="flex:1">
            <div class="stat-label">Cost per Hire</div>
            <div class="stat-val">&darr; 45%</div>
            <div class="stat-sub">vs. traditional job boards</div>
          </div>
        </div>
        <div class="stat-card">
          <div style="flex:1">
            <div class="stat-label">Retention at 6 Mo.</div>
            <div class="stat-val">94%</div>
            <div class="stat-sub">Better culture matches</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOR TALENT -->
<section class="section talent" id="for-talent">
  <div class="container">
    <div class="two-col">
      <div class="fade-up" style="order:2">
        <div class="badge badge-white" style="margin-bottom:1.5rem">For Job Seekers</div>
        <h2 class="section-title" style="text-align:left">Your Dream Role Should<br><span style="color:#7dd3fc">Come to You</span></h2>
        <p style="font-size:1.05rem;color:rgba(255,255,255,0.6);line-height:1.75;margin:1rem 0 1.5rem">
          Stop blasting r&eacute;sum&eacute;s into the void. On revcrewt, companies reach out with real opportunities. All offers are transparent &mdash; salary, benefits, and culture up front.
        </p>
        <div class="check-list">
          <div class="check-item">
            <div class="check-icon" style="background:rgba(0,74,173,0.5);border:1px solid rgba(96,165,250,0.3)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Zero applications &mdash; companies find you</span>
          </div>
          <div class="check-item">
            <div class="check-icon" style="background:rgba(0,74,173,0.5);border:1px solid rgba(96,165,250,0.3)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Transparent salary ranges on every offer</span>
          </div>
          <div class="check-item">
            <div class="check-icon" style="background:rgba(0,74,173,0.5);border:1px solid rgba(96,165,250,0.3)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Negotiate from a position of power</span>
          </div>
          <div class="check-item">
            <div class="check-icon" style="background:rgba(0,74,173,0.5);border:1px solid rgba(96,165,250,0.3)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Built-in career roadmap &amp; skill tracking</span>
          </div>
        </div>
        <div style="margin-top:2rem">
          <a href="#waitlist" class="btn btn-primary" style="font-size:1.05rem">Join the Waitlist <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem" class="fade-up" style="transition-delay:0.15s">
        <div class="talent-card">
          <div class="talent-emoji">&#128176;</div>
          <div><div class="talent-title">Earn 15&ndash;30% More</div><div class="talent-desc">Transparent competition drives salary up</div></div>
        </div>
        <div class="talent-card">
          <div class="talent-emoji">&#9201;</div>
          <div><div class="talent-title">Save 20+ Hours</div><div class="talent-desc">No more mass-applying and tracking</div></div>
        </div>
        <div class="talent-card">
          <div class="talent-emoji">&#127919;</div>
          <div><div class="talent-title">Better Culture Fits</div><div class="talent-desc">Matched by values, not just titles</div></div>
        </div>
        <div class="talent-card">
          <div class="talent-emoji">&#128274;</div>
          <div><div class="talent-title">Full Privacy</div><div class="talent-desc">Control who sees your profile and when</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="section pricing" id="pricing">
  <div class="container">
    <div class="section-header fade-up">
      <div class="badge badge-blue">Pricing</div>
      <h2 class="section-title">Simple, Transparent <span class="accent">Pricing</span></h2>
      <p class="section-sub">No hidden fees. No commission on your salary. Ever.</p>
      <div class="pricing-toggle" style="margin-top:1.5rem">
        <button class="toggle-btn active" id="btn-m">Monthly</button>
        <button class="toggle-btn" id="btn-a">Annual <span class="toggle-badge">Save 20%</span></button>
      </div>
    </div>
    <div class="plans-grid">
      <!-- Starter -->
      <div class="plan-card fade-up">
        <div class="plan-name">Starter</div>
        <div class="plan-desc">For individual job seekers starting out</div>
        <div class="plan-price">Free <small>/mo</small></div>
        <div class="plan-divider"></div>
        <div class="plan-features">
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Basic profile creation</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Limited offer visibility (3/mo)</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Standard matching</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Email support</div>
        </div>
        <a href="#waitlist" class="btn btn-ghost" style="width:100%;justify-content:center">Get Started Free</a>
      </div>
      <!-- Pro -->
      <div class="plan-card featured fade-up" style="transition-delay:0.1s">
        <div class="plan-popular">Most Popular</div>
        <div class="plan-name">Pro</div>
        <div class="plan-desc">For serious professionals who want the edge</div>
        <div class="plan-price" id="pro-price">&#8369;1,499<small>/mo</small></div>
        <div class="plan-price-sub" id="pro-sub">or &#8369;1,199/mo billed annually</div>
        <div class="plan-divider"></div>
        <div class="plan-features">
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Unlimited offer visibility</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Priority matching algorithm</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Salary negotiation toolkit</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Career roadmap builder</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> 1-on-1 coaching session</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cobalt)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Discord community access</div>
        </div>
        <a href="#waitlist" class="btn btn-primary" style="width:100%;justify-content:center">Go Pro</a>
      </div>
      <!-- Enterprise -->
      <div class="plan-card fade-up" style="transition-delay:0.2s">
        <div class="plan-name">Enterprise</div>
        <div class="plan-desc">For companies building high-performance teams</div>
        <div class="plan-price">Custom <small>/mo</small></div>
        <div class="plan-divider"></div>
        <div class="plan-features">
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Unlimited team hiring</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> AI sourcing dashboard</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Dedicated account manager</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Custom assessment integration</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> SLA-backed support</div>
          <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--slate)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> API access</div>
        </div>
        <a href="#waitlist" class="btn btn-navy" style="width:100%;justify-content:center">Contact Sales</a>
      </div>
    </div>
  </div>
</section>

<!-- WAITLIST -->
<section class="section waitlist" id="waitlist">
  <div class="container" style="max-width:700px">
    <div class="badge badge-white" style="margin-bottom:1.5rem">Early Access</div>
    <h2 class="section-title">Be First in Line<br>When We Launch</h2>
    <p class="section-sub">Join 1,200+ professionals already on the waitlist. Early access members get 3 months of Pro free.</p>
    <form class="waitlist-form" onsubmit="handleWaitlist(event)">
      <input type="text" class="waitlist-input" placeholder="Full name" required id="wl-name">
      <input type="email" class="waitlist-input" placeholder="Email address" required id="wl-email">
      <select class="waitlist-input" id="wl-role">
        <option value="" disabled selected style="color:rgba(255,255,255,0.4)">I am a...</option>
        <option value="jobseeker">Job Seeker</option>
        <option value="employer">Employer / Recruiter</option>
        <option value="both">Both</option>
      </select>
      <button type="submit" class="btn btn-primary" style="padding:0.85rem 2rem;font-size:1rem;width:100%;justify-content:center">
        Join the Waitlist &rarr;
      </button>
    </form>
    <p class="waitlist-note">&#128274; No spam. No credit card. Unsubscribe anytime.</p>
    <div id="wl-success" style="display:none;margin-top:1.5rem;background:rgba(255,255,255,0.1);border-radius:12px;padding:1.25rem;text-align:center;color:#fff;font-weight:700">
      &#127881; You&rsquo;re on the list! We&rsquo;ll be in touch soon.
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">&copy; 2026 revcrewt. All rights reserved.</div>
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
  const reveals = document.querySelectorAll('.fade-up');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.12 });
  reveals.forEach(el => obs.observe(el));

  // Pricing toggle
  const btnM = document.getElementById('btn-m');
  const btnA = document.getElementById('btn-a');
  const proPrice = document.getElementById('pro-price');
  const proSub = document.getElementById('pro-sub');
  btnM.addEventListener('click', () => {
    btnM.classList.add('active'); btnA.classList.remove('active');
    proPrice.innerHTML = '&#8369;1,499<small>/mo</small>'; proSub.style.display = 'block';
  });
  btnA.addEventListener('click', () => {
    btnA.classList.add('active'); btnM.classList.remove('active');
    proPrice.innerHTML = '&#8369;1,199<small>/mo</small>'; proSub.style.display = 'none';
  });

  // Waitlist
  function handleWaitlist(e) {
    e.preventDefault();
    document.querySelector('.waitlist-form').style.display = 'none';
    document.getElementById('wl-success').style.display = 'block';
  }
</script>

</body>
</html>
