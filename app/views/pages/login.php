<main class="auth-page">
  <div class="auth-container">

    <!-- Left Side -->
    <div class="auth-left">
      <div class="auth-corner tl"></div>
      <div class="auth-corner br"></div>
      <div class="auth-brand">
        <p class="brand-logo">Jomi<span>Global</span></p>
        <div class="brand-divider"></div>
        <p class="brand-tagline">Luxury Jewelry · Perfume · Eyewear</p>
      </div>
    </div>

    <!-- Right Side -->
    <div class="auth-right">
      <div class="auth-form-wrapper">

        <p class="auth-eyebrow">Member Access</p>
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Sign in to your JomiGlobal account</p>

        <?php if (isset($error)): ?>
          <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="<?= APP_URL ?>/login">
          <!-- Email -->
          <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <div class="input-wrapper">
              <i class="ti ti-mail"></i>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="your@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
              >
            </div>
          </div>

          <!-- Password -->
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrapper">
              <i class="ti ti-lock"></i>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
              >
              <button type="button" class="password-toggle" id="togglePassword">
                <i class="ti ti-eye"></i>
              </button>
            </div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="remember_me" value="1">
              <span>Remember me</span>
            </label>
            <a href="<?= APP_URL ?>/login?action=forgot-password" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn-luxury-submit">
            Sign In <i class="ti ti-arrow-right"></i>
          </button>
        </form>

        <p class="auth-switch">
          Don't have an account?
          <a href="<?= APP_URL ?>/login?action=register">Create one here</a>
        </p>

      </div>
    </div>

  </div>
</main>