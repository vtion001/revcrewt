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
    .btn-primary { background: var(--cobalt); color: var(--white); }
    .btn-primary:hover { background: var(--cobalt-400); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,74,173,0.3); }
    .btn-outline-navy { background: transparent; color: var(--navy); border: 2px solid var(--gray-300); }
    .btn-outline-navy:hover { border-color: var(--navy); background: var(--navy); color: var(--white); }

    .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1rem 2rem; background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(30,58,95,0.06); box-shadow: 0 4px 30px rgba(30,58,95,0.05); }
    .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .nav-logo { font-size: 1.35rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .nav-logo span { color: var(--cobalt); }

    .auth-page { padding-top: 72px; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 6rem 1.5rem 4rem; }
    .auth-card { background: var(--white); border-radius: 24px; border: 1.5px solid var(--gray-100); padding: 2.5rem; width: 100%; max-width: 440px; box-shadow: 0 24px 64px rgba(30,58,95,0.08); }

    .auth-logo { text-align: center; margin-bottom: 2rem; }
    .auth-logo a { font-size: 1.5rem; font-weight: 900; letter-spacing: -0.04em; color: var(--navy); }
    .auth-logo a span { color: var(--cobalt); }

    .role-tabs { display: flex; background: var(--gray-100); border-radius: 12px; padding: 4px; margin-bottom: 1.75rem; }
    .role-tab { flex: 1; padding: 0.65rem 1rem; border-radius: 9px; border: none; background: transparent; font-size: 0.88rem; font-weight: 600; color: var(--gray-500); cursor: pointer; transition: all 0.25s; font-family: inherit; }
    .role-tab.active { background: var(--white); color: var(--navy); box-shadow: 0 2px 8px rgba(30,58,95,0.08); }

    .form-title { font-size: 1.3rem; font-weight: 800; color: var(--navy); letter-spacing: -0.03em; margin-bottom: 0.3rem; }
    .form-sub { font-size: 0.85rem; color: var(--gray-500); margin-bottom: 1.75rem; }

    .form-field { margin-bottom: 1.1rem; }
    .form-label { font-size: 0.82rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.45rem; display: block; }
    .form-input { width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1.5px solid var(--gray-200); font-size: 0.92rem; font-family: inherit; color: var(--gray-900); background: var(--white); transition: border-color 0.2s; }
    .form-input:focus { outline: none; border-color: var(--cobalt); }
    .form-input::placeholder { color: var(--gray-400); }
    .form-input.error { border-color: #ef4444; }

    .forgot-row { display: flex; justify-content: flex-end; margin-bottom: 1.5rem; }
    .forgot-link { font-size: 0.82rem; font-weight: 600; color: var(--cobalt); opacity: 0.8; transition: opacity 0.2s; }
    .forgot-link:hover { opacity: 1; }

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

    <h1 class="form-title">Welcome back</h1>
    <p class="form-sub">Sign in to your account</p>

    <?= view('partials/flash') ?>

    <form method="POST" action="/auth/login" id="login-form">
      <input type="hidden" name="role" id="form-role" value="<?= old('role') ?: 'employer' ?>">

      <div class="form-field">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="you@company.com" value="<?= old('email') ?>" required>
      </div>

      <div class="form-field">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input" placeholder="Your password" required>
      </div>

      <div class="forgot-row">
        <a href="#" class="forgot-link" onclick="return false;">Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit">Sign In</button>
    </form>

    <div class="auth-divider"></div>

    <p class="auth-footer">
      Don't have an account? <a href="/auth/register">Register here</a>
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
    var emailInput = document.getElementById('email');
    if (role === 'employer') {
      emailInput.placeholder = 'you@company.com';
    } else {
      emailInput.placeholder = 'you@email.com';
    }
  }

  // Initialize tab from old role
  var savedRole = '<?= old('role') ?: 'employer' ?>';
  switchTab(savedRole);
</script>
</body>
</html>
