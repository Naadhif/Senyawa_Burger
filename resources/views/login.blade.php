<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login – Senyawa Burger</title>
  <meta name="description" content="Halaman login sistem kasir dan owner Senyawa Burger." />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --orange:       #e8500a;
      --orange-mid:   #f26318;
      --orange-light: #ff6b2b;
      --cream:        #faefe2;
      --dark:         #1a1008;
      --dark-card:    #1f1409;
      --text-muted:   #b09070;
      --red:          #e85555;
      --green:        #4caf50;
      --radius:       20px;
      --pill:         100px;
      --shadow-glow:  0 8px 40px rgba(232,80,10,0.35);
    }

    html, body {
      height: 100%;
      font-family: "Nunito", sans-serif;
      overflow: hidden;
    }

    /* ══ LAYOUT ══ */
    .page {
      display: flex;
      height: 100vh;
    }

    /* ══ LEFT PANEL – Foto Branding ══ */
    .panel-left {
      flex: 1;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0d0703;
    }

    .panel-left::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 80% 60% at 50% 40%, rgba(232,80,10,0.22) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 80% 80%, rgba(255,107,43,0.12) 0%, transparent 70%);
      z-index: 1;
    }

    .brand-photo {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.65;
      filter: saturate(1.3) contrast(1.1);
      animation: zoomIn 18s ease-in-out infinite alternate;
    }

    @keyframes zoomIn {
      from { transform: scale(1); }
      to   { transform: scale(1.08); }
    }

    /* Brand overlay */
    .brand-overlay {
      position: absolute;
      inset: 0;
      z-index: 2;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 48px;
      background: linear-gradient(
        to top,
        rgba(10, 5, 0, 0.88) 0%,
        rgba(10, 5, 0, 0.25) 55%,
        transparent 100%
      );
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(232,80,10,0.15);
      border: 1px solid rgba(232,80,10,0.4);
      border-radius: var(--pill);
      padding: 6px 16px;
      width: fit-content;
      margin-bottom: 16px;
      backdrop-filter: blur(6px);
    }
    .brand-badge span {
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--orange-light);
    }
    .brand-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--orange-light);
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; transform: scale(1); }
      50%      { opacity: 0.5; transform: scale(0.8); }
    }

    .brand-title {
      font-family: "Bebas Neue", cursive;
      font-size: 64px;
      line-height: 1;
      color: #fff;
      letter-spacing: 3px;
    }
    .brand-title span { color: var(--orange-light); }

    .brand-sub {
      font-size: 15px;
      color: rgba(255,255,255,0.55);
      margin-top: 10px;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    /* ══ RIGHT PANEL – Login Form ══ */
    .panel-right {
      width: 460px;
      flex-shrink: 0;
      background: #130d05;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 44px;
      position: relative;
      overflow: hidden;
    }

    /* decorative glow */
    .panel-right::before {
      content: '';
      position: absolute;
      top: -120px; right: -120px;
      width: 340px; height: 340px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(232,80,10,0.18) 0%, transparent 70%);
      pointer-events: none;
    }
    .panel-right::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -80px;
      width: 260px; height: 260px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,107,43,0.10) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Logo area */
    .logo-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 36px;
    }

    .logo-ring {
      width: 80px; height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--orange), var(--orange-light));
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 16px;
      box-shadow: var(--shadow-glow), inset 0 2px 0 rgba(255,255,255,0.15);
      animation: logoFloat 4s ease-in-out infinite;
    }
    @keyframes logoFloat {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(-6px); }
    }
    .logo-ring svg { width: 40px; height: 40px; fill: #fff; }

    .login-heading {
      font-family: "Bebas Neue", cursive;
      font-size: 32px;
      letter-spacing: 2px;
      color: #fff;
      text-align: center;
    }
    .login-sub {
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 600;
      text-align: center;
      margin-top: 4px;
    }

    /* ══ ALERT MESSAGES ══ */
    .alert {
      width: 100%;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 13.5px;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: slideDown 0.3s ease;
    }
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .alert-error {
      background: rgba(232,85,85,0.15);
      border: 1px solid rgba(232,85,85,0.35);
      color: #ff8080;
    }
    .alert-success {
      background: rgba(76,175,80,0.15);
      border: 1px solid rgba(76,175,80,0.35);
      color: #80d883;
    }
    .alert-icon { font-size: 16px; flex-shrink: 0; }

    /* ══ FORM ══ */
    .login-form {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-label {
      font-size: 12.5px;
      font-weight: 800;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    .input-wrap {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 16px; top: 50%;
      transform: translateY(-50%);
      width: 18px; height: 18px;
      stroke: var(--text-muted);
      stroke-width: 2; fill: none;
      transition: stroke 0.2s;
      pointer-events: none;
    }
    .form-input {
      width: 100%;
      background: rgba(255,255,255,0.04);
      border: 1.5px solid rgba(255,255,255,0.08);
      border-radius: 12px;
      padding: 14px 16px 14px 46px;
      font-family: "Nunito", sans-serif;
      font-size: 14.5px;
      font-weight: 600;
      color: #fff;
      outline: none;
      transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
      -webkit-appearance: none;
    }
    .form-input::placeholder { color: rgba(255,255,255,0.2); }
    .form-input:focus {
      border-color: var(--orange);
      background: rgba(232,80,10,0.07);
      box-shadow: 0 0 0 3px rgba(232,80,10,0.15);
    }
    .form-input:focus + .input-icon,
    .input-wrap:focus-within .input-icon {
      stroke: var(--orange-light);
    }

    /* Password toggle */
    .eye-btn {
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none;
      cursor: pointer; padding: 4px;
      display: flex; align-items: center; justify-content: center;
      color: var(--text-muted);
      transition: color 0.2s;
    }
    .eye-btn:hover { color: var(--orange-light); }
    .eye-btn svg { width: 18px; height: 18px; stroke: currentColor; stroke-width: 2; fill: none; }



    /* Submit button */
    .btn-login {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
      color: #fff;
      font-family: "Nunito", sans-serif;
      font-size: 15px;
      font-weight: 900;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 6px 24px rgba(232,80,10,0.4);
      margin-top: 4px;
    }
    .btn-login::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
      pointer-events: none;
    }
    .btn-login:hover  { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(232,80,10,0.5); }
    .btn-login:active { transform: scale(0.98); }

    /* Loading state */
    .btn-login .btn-spinner {
      display: none;
      width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,0.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-login.loading .btn-text { display: none; }
    .btn-login.loading .btn-spinner { display: block; }

    /* Footer */
    .form-footer {
      text-align: center;
      font-size: 12px;
      color: rgba(255,255,255,0.2);
      margin-top: 8px;
      font-weight: 600;
    }
    .form-footer span { color: var(--orange-light); }

    /* ══ RESPONSIVE ══ */
    @media (max-width: 768px) {
      .panel-left { display: none; }
      .panel-right {
        width: 100%;
        padding: 40px 28px;
      }
    }
  </style>
</head>
<body>

<div class="page">

  <!-- ═══ LEFT PANEL ═══ -->
  <div class="panel-left">
    <img src="{{ asset('senyawa1.png') }}" alt="Senyawa Burger" class="brand-photo" />
    <div class="brand-overlay">
      <div class="brand-badge">
        <div class="brand-dot"></div>
        <span>Open for Business</span>
      </div>
      <h1 class="brand-title">Senyawa<br><span>Burger</span></h1>
      <p class="brand-sub">Sistem Manajemen Restoran – v1.0</p>
    </div>
  </div>  

  <!-- ═══ RIGHT PANEL ═══ -->
  <div class="panel-right">

    <!-- Logo -->
    <div class="logo-wrap">
      <div class="logo-ring">
        <!-- Burger icon -->
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 8h16c.55 0 1-.45 1-1 0-3.86-4.03-7-9-7S3 3.14 3 7c0 .55.45 1 1 1zm0 3c-.55 0-1 .45-1 1s.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4zm15 4H5c-.55 0-1 .45-1 1v1c0 2.21 3.58 4 8 4s8-1.79 8-4v-1c0-.55-.45-1-1-1z"/>
        </svg>
      </div>
      <h2 class="login-heading">Masuk ke Sistem</h2>
      <p class="login-sub">Senyawa Burger – Panel Manajemen</p>
    </div>

    <!-- Alert messages -->
    @if(session('error'))
    <div class="alert alert-error" role="alert">
      <span class="alert-icon"></span>
      <span>{{ session('error') }}</span>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" role="alert">
      <span class="alert-icon"></span>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error" role="alert">
      <span class="alert-icon"></span>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- Form -->
    <form class="login-form" id="loginForm" action="{{ route('login.post') }}" method="POST" novalidate>
      @csrf


      <!-- Username -->
      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <div class="input-wrap">
          <input
            type="text"
            id="username"
            name="username"
            class="form-input"
            placeholder="Masukkan username…"
            value="{{ old('username') }}"
            autocomplete="username"
            autofocus
            required
          />
          <svg class="input-icon" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <input
            type="password"
            id="password"
            name="password"
            class="form-input"
            placeholder="Masukkan password…"
            autocomplete="current-password"
            required
          />
          <svg class="input-icon" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <button type="button" class="eye-btn" id="eyeBtn" onclick="togglePassword()" title="Tampilkan/sembunyikan password">
            <svg id="eyeIcon" viewBox="0 0 24 24">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-login" id="loginBtn">
        <span class="btn-text">MASUK</span>
        <div class="btn-spinner"></div>
      </button>

      <p class="form-footer">
        Sistem manajemen <span>Senyawa Burger</span> &copy; {{ date('Y') }}
      </p>
    </form>

  </div>
</div>

<script>

  /* ── Toggle password visibility ── */
  function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
      ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`
      : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  }

  /* ── Loading state on submit ── */
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('loginBtn');
    btn.classList.add('loading');
  });
</script>

</body>
</html>
