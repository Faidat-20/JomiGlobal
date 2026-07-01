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

        <p class="auth-eyebrow">Account Recovery</p>
        <h2 class="auth-title">Forgot Password?</h2>
        <p class="auth-subtitle">Enter your email and we'll send you a reset link.</p>

        <?php if (isset($success)): ?>
          <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> <?= $success ?>
          </div>
          <a href="<?= APP_URL ?>/login" class="btn-luxury-submit" style="margin-top:24px;text-decoration:none;">
            Back to Login <i class="ti ti-arrow-right"></i>
          </a>

        <?php else: ?>

          <?php if (isset($error)): ?>
            <div class="alert alert-error">
              <i class="ti ti-alert-circle"></i> <?= $error ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= APP_URL ?>/login?action=forgot-password">

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
                  autofocus
                >
              </div>
            </div>

            <button type="submit" class="btn-luxury-submit">
              Send Reset Link <i class="ti ti-arrow-right"></i>
            </button>

          </form>

          <p class="auth-switch">
            Remember your password?
            <a href="<?= APP_URL ?>/login">Sign in here</a>
          </p>

        <?php endif; ?>

      </div>
    </div>

  </div>
</main>