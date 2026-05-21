<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Order #<?= htmlspecialchars($order['order_number']) ?></h1>
    <p>Placed on <?= date('F j, Y \a\t g:i A', strtotime($order['created_at'])) ?></p>
  </div>
  <a href="<?= APP_URL ?>/admin/orders" class="btn-admin btn-admin-secondary">
    <i class="ti ti-arrow-left"></i> Back to Orders
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;">

  <!-- Left -->
  <div>
    <!-- Order Items -->
    <div class="admin-table-wrapper" style="margin-bottom:24px;">
      <div class="table-header">
        <h3>Order Items</h3>
      </div>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orderItems as $item): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:12px;">
                  <?php if (!empty($item['image'])): ?>
                    <img
                      src="<?= APP_URL ?>/uploads/<?= $item['image'] ?>"
                      style="width:40px;height:40px;object-fit:cover;border-radius:6px;"
                    >
                  <?php endif; ?>
                  <strong><?= htmlspecialchars($item['product_name']) ?></strong>
                </div>
              </td>
              <td><?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?></td>
              <td><?= $item['quantity'] ?></td>
              <td><?= CURRENCY_SYMBOL . number_format($item['total'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Shipping Details -->
    <div class="admin-form" style="margin-bottom:24px;">
      <h3 style="margin-bottom:16px;font-family:var(--font-body);font-size:1rem;">Shipping Details</h3>
      <div class="form-grid-2">
        <div>
          <p style="font-size:12px;color:#a0a0a0;margin-bottom:4px;">NAME</p>
          <p><?= htmlspecialchars($order['shipping_first_name'] . ' ' . $order['shipping_last_name']) ?></p>
        </div>
        <div>
          <p style="font-size:12px;color:#a0a0a0;margin-bottom:4px;">EMAIL</p>
          <p><?= htmlspecialchars($order['shipping_email']) ?></p>
        </div>
        <div>
          <p style="font-size:12px;color:#a0a0a0;margin-bottom:4px;">PHONE</p>
          <p><?= htmlspecialchars($order['shipping_phone']) ?></p>
        </div>
        <div>
          <p style="font-size:12px;color:#a0a0a0;margin-bottom:4px;">COUNTRY</p>
          <p><?= htmlspecialchars($order['shipping_country']) ?></p>
        </div>
        <div style="grid-column:1/-1;">
          <p style="font-size:12px;color:#a0a0a0;margin-bottom:4px;">ADDRESS</p>
          <p><?= htmlspecialchars($order['shipping_address'] . ', ' . $order['shipping_city'] . ', ' . $order['shipping_state']) ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Right -->
  <div>
    <!-- Order Summary -->
    <div class="admin-form" style="margin-bottom:24px;">
      <h3 style="margin-bottom:16px;font-family:var(--font-body);font-size:1rem;">Order Summary</h3>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:13px;">
        <div style="display:flex;justify-content:space-between;">
          <span style="color:#a0a0a0;">Subtotal</span>
          <span><?= CURRENCY_SYMBOL . number_format($order['subtotal'], 2) ?></span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span style="color:#a0a0a0;">Shipping</span>
          <span><?= CURRENCY_SYMBOL . number_format($order['shipping_fee'], 2) ?></span>
        </div>
        <?php if ($order['discount'] > 0): ?>
          <div style="display:flex;justify-content:space-between;">
            <span style="color:#a0a0a0;">Discount</span>
            <span style="color:var(--success);">-<?= CURRENCY_SYMBOL . number_format($order['discount'], 2) ?></span>
          </div>
        <?php endif; ?>
        <div style="display:flex;justify-content:space-between;font-weight:600;font-size:15px;padding-top:10px;border-top:1px solid #eee;">
          <span>Total</span>
          <span><?= CURRENCY_SYMBOL . number_format($order['total'], 2) ?></span>
        </div>
      </div>
    </div>

    <!-- Update Status -->
    <div class="admin-form">
      <h3 style="margin-bottom:16px;font-family:var(--font-body);font-size:1rem;">Update Order</h3>
      <form method="POST" action="<?= APP_URL ?>/admin/orders?action=update-status&id=<?= $order['id'] ?>">
        <div class="admin-form-group">
          <label>Status</label>
          <select name="status">
            <?php
              $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
              foreach ($statuses as $s):
            ?>
              <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                <?= ucfirst($s) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="admin-form-group">
          <label>Tracking Number</label>
          <input
            type="text"
            name="tracking_number"
            placeholder="Enter tracking number"
            value="<?= htmlspecialchars($order['tracking_number'] ?? '') ?>"
          >
        </div>
        <div class="admin-form-group">
          <label>Notes</label>
          <textarea name="notes" rows="3" placeholder="Add notes..."><?= htmlspecialchars($order['notes'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;justify-content:center;">
          <i class="ti ti-check"></i> Update Order
        </button>
      </form>
    </div>
  </div>

</div>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>