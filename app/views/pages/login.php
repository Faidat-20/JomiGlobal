<main class="auth-page">
  <div class="auth-container">

    <!-- Left Side -->
    <div class="auth-left">
      <div class="auth-brand">
        <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal">
        <p>Luxury Jewelry, Perfume & Glasses</p>
      </div>
    </div>

    <!-- Right Side -->
    <div class="auth-right">
      <div class="auth-form-wrapper">

        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Sign in to your JomiGlobal account</p>

        <?php if (isset($error)): ?>
          <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="<?= APP_URL ?>/login">
          <div class="form-group">
            <label for="email">Email Address</label>
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

          <div class="form-group">
            <label for="password">Password</label>
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

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="remember">
              <span>Remember me</span>
            </label>
            <a href="<?= APP_URL ?>/forgot-password" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn btn-primary btn-full">
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