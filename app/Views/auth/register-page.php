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

    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }

    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(30,58,95,0.06); box-shadow: 0 4px 30px rgba(30,58,95,0.05); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 1.35rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .nav-logo span { color: var(--cobalt); }

    .auth-page { padding-top: 72px; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 6rem 1.5rem 4rem; }
    .auth-card { background: var(--white); border-radius: 24px; border: 1.5px solid var(--gray-100); padding: 2.5rem; width: 100%; max-width: 460px; box-shadow: 0 24px 64px rgba(30,58,95,0.08); }

    .auth-logo { text-align: center; margin-bottom: 2rem; }
    .auth-logo a { font-size: 1.5rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .auth-logo a span { color: var(--cobalt); }

    .role-tabs { display: flex; background: var(--gray-100); border-radius: 12px; padding: 4px; margin-bottom: 1.75rem; }
    .role-tab { flex: 1; padding: 0.65rem 1rem; border-radius: 9px; border: none; background: transparent; font-size: 0.88rem; font-weight: 600; color: var(--gray-500); cursor: pointer; transition: all 0.25s; font-family: inherit; }
    .role-tab.active { background: var(--white); color: var(--navy); box-shadow: 0 2px 8px rgba(30,58,95,0.08); }

    .form-title { font-size: 1.3rem; font-weight: 800; color: var(--navy); letter-spacing: -0.03em; margin-bottom: 0.3rem; }
    .form-sub { font-size: 0.85rem; color: var(--gray-500); margin-bottom: 1.75rem; }

    .form-field { margin-bottom: 1rem; }
    .form-label { font-size: 0.82rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.4rem; display: block; }
    .form-input { width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1.5px solid var(--gray-200); font-size: 0.92rem; font-family: inherit; color: var(--gray-900); background: var(--white); transition: border-color 0.2s; }
    .form-input:focus { outline: none; border-color: var(--cobalt); }
    .form-input::placeholder { color: var(--gray-400); }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.9rem; }

    .role-section { display: none; }
    .role-section.active { display: block; }

    .terms-row { display: flex; align-items: flex-start; gap: 0.7rem; margin-bottom: 1.5rem; }
    .terms-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--cobalt); cursor: pointer; flex-shrink: 0; margin-top: 2px; }
    .terms-row label { font-size: 0.82rem; color: var(--gray-500); line-height: 1.5; cursor: pointer; }
    .terms-row label a { color: var(--cobalt); font-weight: 600; }

    .btn-submit { width: 100%; padding: 0.85rem; border-radius: 12px; font-size: 0.95rem; font-weight: 700; background: var(--cobalt); color: var(--white); border: none; cursor: pointer; transition: all 0.25s; font-family: inherit; }
    .btn-submit:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-submit:active { transform: translateY(0); }

    .auth-divider { height: 1px; background: var(--gray-100); margin: 1.5rem 0; }

    .auth-footer { text-align: center; font-size: 0.85rem; color: var(--gray-500); }
    .auth-footer a { color: var(--cobalt); font-weight: 600; }
    .auth-footer a:hover { text-decoration: underline; }

    .footer { background: var(--navy-900); padding: 3rem 0; margin-top: auto; }
    .footer-inner { max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
    .footer-logo { font-size: 1.15rem; font-weight: 900; color: var(--white); letter-spacing: -0.04em; }
    .footer-logo span { color: var(--cobalt-400); }
    .footer-copy { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

    @media (max-width: 480px) {
      .auth-card { padding: 2rem 1.5rem; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
<nav class="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">rev<span>crewt</span></a>
  </div>
</nav>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo">
      <a href="/">rev<span>crewt</span></a>
    </div>

    <!-- Role Tabs -->
    <div class="role-tabs">
      <button type="button" class="role-tab active" id="tab-employer" onclick="switchTab('employer')">Employer</button>
      <button type="button" class="role-tab" id="tab-talent" onclick="switchTab('talent')">Talent</button>
    </div>

    <h1 class="form-title">Create your account</h1>
    <p class="form-sub">Join revcrewt and start hiring or getting hired</p>

    <?= view('partials/flash') ?>

    <form method="POST" action="/auth/register" id="register-form">
      <input type="hidden" name="role" id="form-role" value="<?= old('role') ?: 'employer' ?>">

      <!-- Employer Fields -->
      <div id="section-employer" class="role-section active">
        <div class="form-field">
          <label class="form-label" for="emp-name">Full Name</label>
          <input type="text" id="emp-name" name="name" class="form-input" placeholder="Juan dela Cruz" value="<?= old('name') ?>">
        </div>
        <div class="form-field">
          <label class="form-label" for="emp-company">Company Name</label>
          <input type="text" id="emp-company" name="company_name" class="form-input" placeholder="Acme Corp Philippines" value="<?= old('company_name') ?>">
        </div>
        <div class="form-field">
          <label class="form-label" for="emp-email">Work Email</label>
          <input type="email" id="emp-email" name="email" class="form-input" placeholder="juan@acmecorp.ph" value="<?= old('email') ?>">
        </div>
        <div class="form-row">
          <div class="form-field">
            <label class="form-label" for="emp-password">Password</label>
            <input type="password" id="emp-password" name="password" class="form-input" placeholder="Min 8 characters">
          </div>
          <div class="form-field">
            <label class="form-label" for="emp-confirm">Confirm Password</label>
            <input type="password" id="emp-confirm" name="password_confirmation" class="form-input" placeholder="Repeat password">
          </div>
        </div>
      </div>

      <!-- Talent Fields -->
      <div id="section-talent" class="role-section">
        <div class="form-field">
          <label class="form-label" for="tal-name">Full Name</label>
          <input type="text" id="tal-name" name="name" class="form-input" placeholder="Juan dela Cruz" value="<?= old('name') ?>">
        </div>
        <div class="form-field">
          <label class="form-label" for="tal-headline">Professional Headline</label>
          <input type="text" id="tal-headline" name="headline" class="form-input" placeholder="e.g. Senior Full-Stack Developer" value="<?= old('headline') ?>">
        </div>
        <div class="form-field">
          <label class="form-label" for="tal-email">Email Address</label>
          <input type="email" id="tal-email" name="email" class="form-input" placeholder="juan@email.com" value="<?= old('email') ?>">
        </div>
        <div class="form-row">
          <div class="form-field">
            <label class="form-label" for="tal-password">Password</label>
            <input type="password" id="tal-password" name="password" class="form-input" placeholder="Min 8 characters">
          </div>
          <div class="form-field">
            <label class="form-label" for="tal-confirm">Confirm Password</label>
            <input type="password" id="tal-confirm" name="password_confirmation" class="form-input" placeholder="Repeat password">
          </div>
        </div>
      </div>

      <div class="terms-row">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
      </div>

      <button type="submit" class="btn-submit">Create Account</button>
    </form>

    <div class="auth-divider"></div>

    <p class="auth-footer">
      Already have an account? <a href="/auth/login">Sign in</a>
    </p>
  </div>
</div>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
  </div>
</footer>

<script>
  function switchTab(role) {
    document.getElementById('tab-employer').classList.toggle('active', role === 'employer');
    document.getElementById('tab-talent').classList.toggle('active', role === 'talent');
    document.getElementById('form-role').value = role;
    document.getElementById('section-employer').classList.toggle('active', role === 'employer');
    document.getElementById('section-talent').classList.toggle('active', role === 'talent');
  }

  // Initialize from old role
  var savedRole = '<?= old('role') ?: 'employer' ?>';
  switchTab(savedRole);
</script>
</body>
</html>
