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

        <p class="auth-eyebrow">Join Us</p>
        <h2 class="auth-title">Create Account</h2>
        <p class="auth-subtitle">Join JomiGlobal and shop luxury</p>

        <?php if (isset($error)): ?>
          <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="<?= APP_URL ?>/login?action=register">

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="first_name">First Name</label>
              <div class="input-wrapper">
                <i class="ti ti-user"></i>
                <input
                  type="text"
                  id="first_name"
                  name="first_name"
                  placeholder="First name"
                  value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                  required
                >
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="last_name">Last Name</label>
              <div class="input-wrapper">
                <i class="ti ti-user"></i>
                <input
                  type="text"
                  id="last_name"
                  name="last_name"
                  placeholder="Last name"
                  value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                  required
                >
              </div>
            </div>
          </div>

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

          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrapper">
              <i class="ti ti-lock"></i>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 characters"
                required
              >
              <button type="button" class="password-toggle" id="togglePassword">
                <i class="ti ti-eye"></i>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <div class="input-wrapper">
              <i class="ti ti-lock"></i>
              <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Repeat your password"
                required
              >
            </div>
          </div>

          <button type="submit" class="btn-luxury-submit">
            Create Account <i class="ti ti-arrow-right"></i>
          </button>

        </form>

        <p class="auth-switch">
          Already have an account?
          <a href="<?= APP_URL ?>/login">Sign in here</a>
        </p>

      </div>
    </div>

  </div>
</main>