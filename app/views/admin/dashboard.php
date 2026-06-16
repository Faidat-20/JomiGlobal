<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Dashboard</h1>
    <p>Welcome back, <?= $_SESSION['first_name'] ?>. Here's what's happening.</p>
  </div>
  <a href="<?= APP_URL ?>/admin/products?action=add" class="btn-admin btn-admin-primary">
    <i class="ti ti-plus"></i> Add Product
  </a>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon gold">
      <i class="ti ti-shopping-bag"></i>
    </div>
    <div class="stat-info">
      <h3><?= $totalOrders ?></h3>
      <p>Total Orders</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <i class="ti ti-currency-naira"></i>
    </div>
    <div class="stat-info">
      <h3><?= CURRENCY_SYMBOL . number_format($totalRevenue, 2) ?></h3>
      <p>Total Revenue</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">
      <i class="ti ti-users"></i>
    </div>
    <div class="stat-info">
      <h3><?= $totalCustomers ?></h3>
      <p>Total Customers</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">
      <i class="ti ti-package"></i>
    </div>
    <div class="stat-info">
      <h3><?= $totalProducts ?></h3>
      <p>Total Products</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">
      <i class="ti ti-mail"></i>
    </div>
    <div class="stat-info">
      <h3><?= $totalSubscribers ?></h3>
      <p>Newsletter Subscribers</p>
    </div>
  </div>
</div>

<!-- Recent Orders -->
<div class="admin-table-wrapper">
  <div class="table-header">
    <h3>Recent Orders</h3>
    <a href="<?= APP_URL ?>/admin/orders" class="btn-admin btn-admin-secondary btn-sm">
      View All
    </a>
  </div>
  <table class="admin-table">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($recentOrders)): ?>
        <tr>
          <td colspan="6" style="text-align:center;padding:40px;color:#a0a0a0;">
            <i class="ti ti-shopping-cart" style="font-size:32px;display:block;margin-bottom:8px;"></i>
            No orders yet
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($recentOrders as $o): ?>
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
          <tr>
            <td><strong><?= htmlspecialchars($o['order_number']) ?></strong></td>
            <td><?= htmlspecialchars($o['shipping_first_name'] . ' ' . $o['shipping_last_name']) ?></td>
            <td><?= CURRENCY_SYMBOL . number_format($o['total'], 2) ?></td>
            <td><span class="badge <?= $badge ?>"><?= ucfirst($o['status']) ?></span></td>
            <td><?= date('M j, Y', strtotime($o['created_at'])) ?></td>
            <td>
              <a href="<?= APP_URL ?>/admin/orders?action=view&id=<?= $o['id'] ?>" class="btn-admin btn-admin-secondary btn-sm">
                <i class="ti ti-eye"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>