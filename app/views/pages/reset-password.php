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

        <p class="auth-eyebrow">Account Security</p>
        <h2 class="auth-title">Reset Password</h2>
        <p class="auth-subtitle">Enter your new password below.</p>

        <?php if (isset($success)): ?>
          <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> <?= $success ?>
          </div>
          <a href="<?= APP_URL ?>/login" class="btn-luxury-submit" style="margin-top:24px;text-decoration:none;">
            Login Now <i class="ti ti-arrow-right"></i>
          </a>

        <?php elseif (isset($error) && $_SERVER['REQUEST_METHOD'] === 'GET'): ?>
          <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i> <?= $error ?>
          </div>
          <a href="<?= APP_URL ?>/login?action=forgot-password" class="btn-luxury-submit" style="margin-top:24px;text-decoration:none;">
            Request New Link <i class="ti ti-arrow-right"></i>
          </a>

        <?php else: ?>

          <?php if (isset($error)): ?>
            <div class="alert alert-error">
              <i class="ti ti-alert-circle"></i> <?= $error ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= APP_URL ?>/login?action=reset-password">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? $_POST['token'] ?? '') ?>">

            <div class="form-group">
              <label class="form-label" for="new_password">New Password</label>
              <div class="input-wrapper">
                <i class="ti ti-lock"></i>
                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    placeholder="Minimum 8 characters"
                    required
                >
                <button type="button" class="password-toggle" id="toggleNewPassword">
                    <i class="ti ti-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="confirm_password">Confirm New Password</label>
              <div class="input-wrapper">
                <i class="ti ti-lock"></i>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Repeat new password"
                    required
                >
                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                    <i class="ti ti-eye"></i>
                </button>
              </div>
            </div>

            <button type="submit" class="btn-luxury-submit">
              Reset Password <i class="ti ti-arrow-right"></i>
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

  <script>
    document.getElementById('toggleNewPassword')?.addEventListener('click', function() {
        const input = document.getElementById('new_password');
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('ti-eye');
        icon.classList.toggle('ti-eye-off');
    });

    document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
        const input = document.getElementById('confirm_password');
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('ti-eye');
        icon.classList.toggle('ti-eye-off');
    });
  </script>
</main>