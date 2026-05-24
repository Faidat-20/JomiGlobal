<main class="account-page">
  <div class="container">

    <div class="account-header">
      <div class="account-avatar">
        <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
      </div>
      <div>
        <h1><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h1>
        <p><?= htmlspecialchars($user['email']) ?></p>
        <span class="account-member-since">Member since <?= date('F Y', strtotime($user['created_at'])) ?></span>
      </div>
    </div>

    <div class="account-layout">

      <!-- Sidebar -->
      <aside class="account-sidebar">
        <nav class="account-nav">
          <a href="#profile" class="account-nav-item active" data-tab="profile">
            <i class="ti ti-user"></i> Profile
          </a>
          <a href="#orders" class="account-nav-item" data-tab="orders">
            <i class="ti ti-shopping-bag"></i> My Orders
          </a>
          <a href="#password" class="account-nav-item" data-tab="password">
            <i class="ti ti-lock"></i> Change Password
          </a>
          <a href="<?= APP_URL ?>/wishlist" class="account-nav-item">
            <i class="ti ti-heart"></i> Wishlist
          </a>
          <a href="<?= APP_URL ?>/logout" class="account-nav-item account-logout">
            <i class="ti ti-logout"></i> Logout
          </a>
        </nav>
      </aside>

      <!-- Content -->
      <div class="account-content">

        <?php if (isset($success)): ?>
          <div class="alert alert-success" style="margin-bottom:24px;">
            <i class="ti ti-check"></i> <?= $success ?>
          </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
          <div class="alert alert-error" style="margin-bottom:24px;">
            <i class="ti ti-alert-circle"></i> <?= $error ?>
          </div>
        <?php endif; ?>

        <!-- Profile Tab -->
        <div class="account-tab active" id="tab-profile">
          <h2 class="account-tab-title">My Profile</h2>
          <form method="POST" action="<?= APP_URL ?>/account?action=update" class="account-form">
            <div class="form-grid-2">
              <div class="checkout-field">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
              </div>
              <div class="checkout-field">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
              </div>
            </div>
            <div class="checkout-field">
              <label>Email Address</label>
              <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled style="opacity:0.6;cursor:not-allowed;">
              <small style="color:var(--text-grey);font-size:11px;">Email cannot be changed</small>
            </div>
            <div class="checkout-field">
              <label>Phone Number</label>
              <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+234 800 000 0000">
            </div>
            <div class="checkout-field">
              <label>Street Address</label>
              <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="Your address">
            </div>
            <div class="form-grid-2">
              <div class="checkout-field">
                <label>City</label>
                <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" placeholder="City">
              </div>
              <div class="checkout-field">
                <label>State</label>
                <input type="text" name="state" value="<?= htmlspecialchars($user['state'] ?? '') ?>" placeholder="State">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-check"></i> Save Changes
            </button>
          </form>
        </div>

        <!-- Orders Tab -->
        <div class="account-tab" id="tab-orders">
          <h2 class="account-tab-title">My Orders</h2>
          <?php if (empty($orders)): ?>
            <div class="account-empty">
              <i class="ti ti-shopping-bag"></i>
              <p>You haven't placed any orders yet.</p>
              <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Start Shopping</a>
            </div>
          <?php else: ?>
            <div class="orders-list">
              <?php foreach ($orders as $order): ?>
                <?php
                  $badges = [
                    'pending'    => 'badge-warning',
                    'confirmed'  => 'badge-info',
                    'processing' => 'badge-info',
                    'shipped'    => 'badge-gold',
                    'delivered'  => 'badge-success',
                    'cancelled'  => 'badge-error',
                    'refunded'   => 'badge-error',
                  ];
                  $badge = $badges[$order['status']] ?? 'badge-info';
                ?>
                <div class="order-card">
                  <div class="order-card-header">
                    <div>
                      <strong><?= htmlspecialchars($order['order_number']) ?></strong>
                      <span class="badge <?= $badge ?>"><?= ucfirst($order['status']) ?></span>
                    </div>
                    <span class="order-date"><?= date('M j, Y', strtotime($order['created_at'])) ?></span>
                  </div>
                  <div class="order-card-body">
                    <div class="order-total">
                      <span>Total</span>
                      <strong><?= CURRENCY_SYMBOL . number_format($order['total'], 2) ?></strong>
                    </div>
                    <?php if ($order['tracking_number']): ?>
                      <div class="order-tracking">
                        <span>Tracking: <?= htmlspecialchars($order['tracking_number']) ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Password Tab -->
        <div class="account-tab" id="tab-password">
          <h2 class="account-tab-title">Change Password</h2>
          <form method="POST" action="<?= APP_URL ?>/account?action=password" class="account-form" style="max-width:480px;">
            <div class="checkout-field">
              <label>Current Password</label>
              <input type="password" name="current_password" required placeholder="Enter current password">
            </div>
            <div class="checkout-field">
              <label>New Password</label>
              <input type="password" name="new_password" required placeholder="Minimum 8 characters">
            </div>
            <div class="checkout-field">
              <label>Confirm New Password</label>
              <input type="password" name="confirm_password" required placeholder="Repeat new password">
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-lock"></i> Change Password
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</main>

<script>
// Account tabs
document.querySelectorAll('.account-nav-item[data-tab]').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    const tab = this.getAttribute('data-tab');

    document.querySelectorAll('.account-nav-item').forEach(i => i.classList.remove('active'));
    document.querySelectorAll('.account-tab').forEach(t => t.classList.remove('active'));

    this.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
  });
});
</script>