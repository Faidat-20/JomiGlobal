<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Customers</h1>
    <p>Manage all JomiGlobal customers</p>
  </div>
</div>

<div class="admin-table-wrapper">
  <div class="table-header">
    <h3>All Customers (<?= count($customers) ?>)</h3>
    <input
      type="text"
      placeholder="Search customers..."
      class="admin-search-input"
      id="customerSearch"
    >
  </div>
  <table class="admin-table" id="customersTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Orders</th>
        <th>Total Spent</th>
        <th>Status</th>
        <th>Joined</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($customers)): ?>
        <tr>
          <td colspan="8" style="text-align:center;padding:40px;color:#a0a0a0;">
            <i class="ti ti-users" style="font-size:32px;display:block;margin-bottom:8px;"></i>
            No customers yet
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($customers as $c): ?>
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--ash);color:var(--mustard);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;">
                  <?= strtoupper(substr($c['first_name'], 0, 1)) ?>
                </div>
                <strong><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></strong>
              </div>
            </td>
            <td><?= htmlspecialchars($c['email']) ?></td>
            <td><?= htmlspecialchars($c['phone'] ?? '-') ?></td>
            <td><?= $c['total_orders'] ?></td>
            <td><?= CURRENCY_SYMBOL . number_format($c['total_spent'], 2) ?></td>
            <td>
              <?php if ($c['is_active']): ?>
                <span class="badge badge-success">Active</span>
              <?php else: ?>
                <span class="badge badge-error">Blocked</span>
              <?php endif; ?>
            </td>
            <td><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
            <td>
              
              <a  href="<?= APP_URL ?>/admin/customers?action=toggle&id=<?= $c['id'] ?>"
                class="btn-admin <?= $c['is_active'] ? 'btn-admin-danger' : 'btn-admin-secondary' ?> btn-sm"
                onclick="return confirm('Are you sure?')"
              >
                <?= $c['is_active'] ? 'Block' : 'Unblock' ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>