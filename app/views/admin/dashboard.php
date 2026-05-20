<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Dashboard</h1>
    <p>Welcome back, <?= $_SESSION['first_name'] ?>. Here's what's happening.</p>
  </div>
  <a href="<?= APP_URL ?>/admin/products/add" class="btn-admin btn-admin-primary">
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
      <h3>0</h3>
      <p>Total Orders</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <i class="ti ti-currency-naira"></i>
    </div>
    <div class="stat-info">
      <h3>₦0</h3>
      <p>Total Revenue</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">
      <i class="ti ti-users"></i>
    </div>
    <div class="stat-info">
      <h3>0</h3>
      <p>Total Customers</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">
      <i class="ti ti-package"></i>
    </div>
    <div class="stat-info">
      <h3>0</h3>
      <p>Total Products</p>
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
        <th>Products</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="7" style="text-align:center;padding:40px;color:#a0a0a0;">
          <i class="ti ti-shopping-cart" style="font-size:32px;display:block;margin-bottom:8px;"></i>
          No orders yet
        </td>
      </tr>
    </tbody>
  </table>
</div>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>