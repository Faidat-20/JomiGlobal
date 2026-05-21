<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Orders</h1>
    <p>Manage all JomiGlobal orders</p>
  </div>
</div>

<div class="admin-table-wrapper">
  <div class="table-header">
    <h3>All Orders (<?= count($orders) ?>)</h3>
    <input
      type="text"
      placeholder="Search orders..."
      class="admin-search-input"
      id="orderSearch"
    >
  </div>
  <table class="admin-table" id="ordersTable">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($orders)): ?>
        <tr>
          <td colspan="6" style="text-align:center;padding:40px;color:#a0a0a0;">
            <i class="ti ti-clipboard-list" style="font-size:32px;display:block;margin-bottom:8px;"></i>
            No orders yet
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><strong><?= htmlspecialchars($o['order_number']) ?></strong></td>
            <td>
              <?= htmlspecialchars($o['shipping_first_name'] . ' ' . $o['shipping_last_name']) ?>
              <br><small style="color:#a0a0a0;"><?= htmlspecialchars($o['shipping_email']) ?></small>
            </td>
            <td><?= CURRENCY_SYMBOL . number_format($o['total'], 2) ?></td>
            <td>
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
                $badge = $badges[$o['status']] ?? 'badge-info';
              ?>
              <span class="badge <?= $badge ?>"><?= ucfirst($o['status']) ?></span>
            </td>
            <td><?= date('M j, Y', strtotime($o['created_at'])) ?></td>
            <td>
              
                href="<?= APP_URL ?>/admin/orders?action=view&id=<?= $o['id'] ?>"
                class="btn-admin btn-admin-secondary btn-sm"
              >
                <i class="ti ti-eye"></i> View
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>