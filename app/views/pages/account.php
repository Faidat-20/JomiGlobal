<main class="account-page">
  <div class="container">

    <h1 class="account-page-title">My Account</h1>

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
          <a href="#address" class="account-nav-item" data-tab="address">
            <i class="ti ti-map-pin"></i> Address
          </a>
          <a href="#orders" class="account-nav-item" data-tab="orders">
            <i class="ti ti-shopping-bag"></i> My Orders
          </a>
          <a href="#password" class="account-nav-item" data-tab="password">
            <i class="ti ti-lock"></i> Change Password
          </a>
          <a href="#wishlist" class="account-nav-item" data-tab="wishlist">
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
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-check"></i> Save Changes
            </button>
          </form>
        </div>

        <!-- Address Tab -->
        <div class="account-tab" id="tab-address">
          <h2 class="account-tab-title">Address</h2>
          <div class="address-grid">

            <!-- Billing Address -->
            <div class="address-card">
              <div class="address-card-header">
                <strong>Billing Address</strong>
                <button type="button" class="address-edit-btn" onclick="toggleAddressForm('billing')">
                  <i class="ti ti-pencil"></i> Edit
                </button>
              </div>

              <!-- Display View -->
              <div class="address-card-body" id="billing-display">
                <p><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p><?= htmlspecialchars($user['phone'] ?? '—') ?></p>
                <p><?= htmlspecialchars(implode(', ', array_filter([
                      $user['address'] ?? '',
                      $user['city']    ?? '',
                      $user['state']   ?? '',
                    ]))) ?: '—' ?>
                </p>
              </div>

              <!-- Edit Form -->
              <div class="address-edit-form" id="billing-form" style="display:none;">
                <form method="POST" action="<?= APP_URL ?>/account?action=update_billing">
                  <div class="checkout-field">
                    <label>Street Address</label>
                    <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="Street address">
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
                  <div class="address-form-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn-cancel" onclick="toggleAddressForm('billing')">Cancel</button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Shipping Address -->
            <div class="address-card">
              <div class="address-card-header">
                <strong>Shipping Address</strong>
                <button type="button" class="address-edit-btn" onclick="toggleAddressForm('shipping')">
                  <i class="ti ti-pencil"></i> Edit
                </button>
              </div>

              <!-- Display View -->
              <div class="address-card-body" id="shipping-display">
                <p><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p><?= htmlspecialchars($user['phone'] ?? '—') ?></p>
                <p><?= htmlspecialchars(implode(', ', array_filter([
                      $user['shipping_address'] ?? $user['address'] ?? '',
                      $user['shipping_city']    ?? $user['city']    ?? '',
                      $user['shipping_state']   ?? $user['state']   ?? '',
                    ]))) ?: '—' ?>
                </p>
              </div>

              <!-- Edit Form -->
              <div class="address-edit-form" id="shipping-form" style="display:none;">
                <form method="POST" action="<?= APP_URL ?>/account?action=update_shipping">
                  <div class="checkout-field">
                    <label>Street Address</label>
                    <input type="text" name="shipping_address" value="<?= htmlspecialchars($user['shipping_address'] ?? $user['address'] ?? '') ?>" placeholder="Street address">
                  </div>
                  <div class="form-grid-2">
                    <div class="checkout-field">
                      <label>City</label>
                      <input type="text" name="shipping_city" value="<?= htmlspecialchars($user['shipping_city'] ?? $user['city'] ?? '') ?>" placeholder="City">
                    </div>
                    <div class="checkout-field">
                      <label>State</label>
                      <input type="text" name="shipping_state" value="<?= htmlspecialchars($user['shipping_state'] ?? $user['state'] ?? '') ?>" placeholder="State">
                    </div>
                  </div>
                  <div class="address-form-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn-cancel" onclick="toggleAddressForm('shipping')">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Orders Tab -->
        <div class="account-tab" id="tab-orders">
          <h2 class="account-tab-title">Orders History</h2>
          
          <?php if (empty($orders)): ?>
            <div class="acc-wishlist-empty">
              <i class="ti ti-shopping-bag"></i>
              <h3>No orders yet</h3>
              <p>You haven't placed any orders yet. Start shopping!</p>
              <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Continue Shopping</a>
            </div>

          <?php else: ?>
            <div class="orders-table-wrap">
              <table class="acc-orders-table">
                <thead>
                  <tr>
                    <th>Number ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>
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
                    <tr>
                      <td class="acc-order-num"><?= htmlspecialchars($order['order_number']) ?></td>
                      <td class="acc-order-date"><?= date('F j, Y', strtotime($order['created_at'])) ?></td>
                      <td><span class="badge <?= $badge ?>"><?= ucfirst($order['status']) ?></span></td>
                      <td class="acc-order-price"><?= CURRENCY_SYMBOL . number_format($order['total'], 2) ?></td>
                    </tr>
                    <?php if (!empty($order['tracking_number'])): ?>
                      <tr class="acc-order-tracking-row">
                        <td colspan="4" class="acc-order-tracking-cell">
                          <i class="ti ti-truck"></i> Tracking: <?= htmlspecialchars($order['tracking_number']) ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>

        <!-- Wishlist Tab -->
        <div class="account-tab" id="tab-wishlist">
          <h2 class="account-tab-title">Your Wishlist</h2>

          <?php if (empty($wishlistItems)): ?>
            <div class="acc-wishlist-empty">
              <i class="ti ti-heart"></i>
              <h3>Your wishlist is empty</h3>
              <p>You haven't saved any items yet. Continue shopping and save what you love.</p>
              <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Continue Shopping</a>
            </div>

          <?php else: ?>
            <div class="wishlist-table-wrap">
              <table class="acc-wishlist-table">
                <thead>
                  <tr>
                    <th></th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($wishlistItems as $item): ?>
                    <tr id="acc-wishlist-row-<?= $item['id'] ?>">

                      <!-- Remove -->
                      <td class="acc-wl-remove-cell">
                        <button
                          class="acc-wl-remove-btn"
                          onclick="accRemoveWishlist(<?= $item['id'] ?>)"
                          title="Remove">
                          <i class="ti ti-x"></i>
                        </button>
                      </td>

                      <!-- Product -->
                      <td class="acc-wl-product-cell">
                        <div class="acc-wl-product">
                          <?php if (!empty($item['image'])): ?>
                            <img
                              src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>"
                              alt="<?= htmlspecialchars($item['name']) ?>"
                              class="acc-wl-img">
                          <?php endif; ?>
                          <a href="<?= APP_URL ?>/product/<?= htmlspecialchars($item['slug']) ?>">
                            <?= htmlspecialchars($item['name']) ?>
                          </a>
                        </div>
                      </td>

                      <!-- Price -->
                      <td class="acc-wl-price">
                        <?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?>
                      </td>

                      <!-- Add to Cart -->
                      <td>
                        <button
                          class="acc-wl-cart-btn add-to-cart-btn"
                          data-id="<?= $item['id'] ?>">
                          Add to cart
                        </button>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
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

    // Save to URL hash
    window.location.hash = tab;
  });
});

// On page load, restore tab from hash
const hash = window.location.hash.replace('#', '');
if (hash) {
  const targetNav = document.querySelector(`.account-nav-item[data-tab="${hash}"]`);
  const targetTab = document.getElementById('tab-' + hash);
  if (targetNav && targetTab) {
    document.querySelectorAll('.account-nav-item').forEach(i => i.classList.remove('active'));
    document.querySelectorAll('.account-tab').forEach(t => t.classList.remove('active'));
    targetNav.classList.add('active');
    targetTab.classList.add('active');
  }
}
function toggleAddressForm(type) {
  const display = document.getElementById(type + '-display');
  const form    = document.getElementById(type + '-form');
  const isHidden = form.style.display === 'none';
  display.style.display = isHidden ? 'none' : 'block';
  form.style.display    = isHidden ? 'block' : 'none';
}

function accRemoveWishlist(productId) {
  fetch(APP_URL + '/wishlist?action=remove&id=' + productId, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const row = document.getElementById('acc-wishlist-row-' + productId);
      if (row) {
        row.style.opacity = '0';
        row.style.transition = 'opacity 0.3s ease';
        setTimeout(() => row.remove(), 300);
      }
      updateWishlistCount(data.wishlist_count);
      showToast('Removed from wishlist', 'error');
    }
  });
}
</script>