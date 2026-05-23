<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Shipping Rates</h1>
    <p>Manage shipping options customers see at checkout</p>
  </div>
  <button onclick="document.getElementById('addShippingModal').classList.add('open')" class="btn-admin btn-admin-primary">
    <i class="ti ti-plus"></i> Add Rate
  </button>
</div>

<?php if (isset($success)): ?>
  <div class="alert alert-success"><i class="ti ti-check"></i> <?= $success ?></div>
<?php endif; ?>

<!-- Shipping Rates Table -->
<div class="admin-table-wrapper">
  <div class="table-header">
    <h3>All Shipping Rates (<?= count($shippingRates) ?>)</h3>
  </div>
  <table class="admin-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Estimated Days</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($shippingRates)): ?>
        <tr>
          <td colspan="6" style="text-align:center;padding:40px;color:#a0a0a0;">
            No shipping rates yet
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($shippingRates as $rate): ?>
          <tr>
            <td><strong><?= htmlspecialchars($rate['name']) ?></strong></td>
            <td><?= htmlspecialchars($rate['description']) ?></td>
            <td><?= CURRENCY_SYMBOL . number_format($rate['price'], 2) ?></td>
            <td><?= htmlspecialchars($rate['estimated_days']) ?></td>
            <td>
              <a href="<?= APP_URL ?>/admin/shipping?action=toggle&id=<?= $rate['id'] ?>">
                <?php if ($rate['is_active']): ?>
                  <span class="badge badge-success">Active</span>
                <?php else: ?>
                  <span class="badge badge-error">Inactive</span>
                <?php endif; ?>
              </a>
            </td>
            <td>
              <div style="display:flex;gap:8px;">
                <button
                  onclick="openEditModal(<?= htmlspecialchars(json_encode($rate)) ?>)"
                  class="btn-admin btn-admin-secondary btn-sm"
                >
                  <i class="ti ti-edit"></i>
                </button>
                
                  href="<?= APP_URL ?>/admin/shipping?action=delete&id=<?= $rate['id'] ?>"
                  class="btn-admin btn-admin-danger btn-sm"
                  onclick="return confirmDelete('Delete this shipping rate?')"
                >
                  <i class="ti ti-trash"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Add Modal -->
<div class="shipping-modal" id="addShippingModal">
  <div class="shipping-modal-content">
    <div class="shipping-modal-header">
      <h3>Add Shipping Rate</h3>
      <button onclick="document.getElementById('addShippingModal').classList.remove('open')" class="modal-close">
        <i class="ti ti-x"></i>
      </button>
    </div>
    <form method="POST" action="<?= APP_URL ?>/admin/shipping?action=add">
      <div class="admin-form-group">
        <label>Name *</label>
        <input type="text" name="name" placeholder="e.g. Lagos Standard" required>
      </div>
      <div class="admin-form-group">
        <label>Description</label>
        <input type="text" name="description" placeholder="e.g. Delivery within Lagos State">
      </div>
      <div class="form-grid-2">
        <div class="admin-form-group">
          <label>Price (₦) *</label>
          <input type="number" name="price" step="0.01" placeholder="0.00" required>
        </div>
        <div class="admin-form-group">
          <label>Estimated Days</label>
          <input type="text" name="estimated_days" placeholder="e.g. 1-2 days">
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <input type="checkbox" name="is_active" value="1" checked id="addActive">
        <label for="addActive" style="font-size:13px;text-transform:none;letter-spacing:0;">Active (visible at checkout)</label>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-admin btn-admin-primary">Add Rate</button>
        <button type="button" onclick="document.getElementById('addShippingModal').classList.remove('open')" class="btn-admin btn-admin-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="shipping-modal" id="editShippingModal">
  <div class="shipping-modal-content">
    <div class="shipping-modal-header">
      <h3>Edit Shipping Rate</h3>
      <button onclick="document.getElementById('editShippingModal').classList.remove('open')" class="modal-close">
        <i class="ti ti-x"></i>
      </button>
    </div>
    <form method="POST" id="editShippingForm" action="">
      <div class="admin-form-group">
        <label>Name *</label>
        <input type="text" name="name" id="editName" required>
      </div>
      <div class="admin-form-group">
        <label>Description</label>
        <input type="text" name="description" id="editDescription">
      </div>
      <div class="form-grid-2">
        <div class="admin-form-group">
          <label>Price (₦) *</label>
          <input type="number" name="price" id="editPrice" step="0.01" required>
        </div>
        <div class="admin-form-group">
          <label>Estimated Days</label>
          <input type="text" name="estimated_days" id="editDays">
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <input type="checkbox" name="is_active" value="1" id="editActive">
        <label for="editActive" style="font-size:13px;text-transform:none;letter-spacing:0;">Active (visible at checkout)</label>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-admin btn-admin-primary">Update Rate</button>
        <button type="button" onclick="document.getElementById('editShippingModal').classList.remove('open')" class="btn-admin btn-admin-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(rate) {
  document.getElementById('editName').value = rate.name;
  document.getElementById('editDescription').value = rate.description;
  document.getElementById('editPrice').value = rate.price;
  document.getElementById('editDays').value = rate.estimated_days;
  document.getElementById('editActive').checked = rate.is_active == 1;
  document.getElementById('editShippingForm').action = '<?= APP_URL ?>/admin/shipping?action=edit&id=' + rate.id;
  document.getElementById('editShippingModal').classList.add('open');
}
</script>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>