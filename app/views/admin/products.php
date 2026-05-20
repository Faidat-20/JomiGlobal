<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1>Products</h1>
    <p>Manage all JomiGlobal products</p>
  </div>
  <a href="<?= APP_URL ?>/admin/products?action=add" class="btn-admin btn-admin-primary">
    <i class="ti ti-plus"></i> Add Product
  </a>
</div>

<?php if (isset($success)): ?>
  <div class="alert alert-success">
    <i class="ti ti-check"></i> <?= $success ?>
  </div>
<?php endif; ?>

<div class="admin-table-wrapper">
  <div class="table-header">
    <h3>All Products (<?= count($products) ?>)</h3>
    <div style="display:flex;gap:10px;">
      <input
        type="text"
        placeholder="Search products..."
        class="admin-search-input"
        id="productSearch"
      >
    </div>
  </div>
  <table class="admin-table" id="productsTable">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Featured</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($products)): ?>
        <tr>
          <td colspan="8" style="text-align:center;padding:40px;color:#a0a0a0;">
            <i class="ti ti-package" style="font-size:32px;display:block;margin-bottom:8px;"></i>
            No products yet. Add your first product!
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($products as $p): ?>
          <tr>
            <td>
              <?php if ($p['image']): ?>
                <img
                  src="<?= APP_URL ?>/uploads/<?= $p['image'] ?>"
                  alt="<?= htmlspecialchars($p['name']) ?>"
                  style="width:50px;height:50px;object-fit:cover;border-radius:8px;"
                >
              <?php else: ?>
                <div style="width:50px;height:50px;background:#f4f4f4;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                  <i class="ti ti-photo" style="color:#a0a0a0;"></i>
                </div>
              <?php endif; ?>
            </td>
            <td>
              <strong><?= htmlspecialchars($p['name']) ?></strong>
              <?php if ($p['sku']): ?>
                <br><small style="color:#a0a0a0;">SKU: <?= htmlspecialchars($p['sku']) ?></small>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($p['category_name']) ?></td>
            <td>
              <?php if ($p['sale_price']): ?>
                <span style="text-decoration:line-through;color:#a0a0a0;">
                  <?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?>
                </span><br>
                <strong style="color:var(--success);">
                  <?= CURRENCY_SYMBOL . number_format($p['sale_price'], 2) ?>
                </strong>
              <?php else: ?>
                <?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($p['stock'] <= 0): ?>
                <span class="badge badge-error">Out of Stock</span>
              <?php elseif ($p['stock'] <= 5): ?>
                <span class="badge badge-warning"><?= $p['stock'] ?> left</span>
              <?php else: ?>
                <span class="badge badge-success"><?= $p['stock'] ?> in stock</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($p['is_active']): ?>
                <span class="badge badge-success">Active</span>
              <?php else: ?>
                <span class="badge badge-error">Inactive</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($p['is_featured']): ?>
                <span class="badge badge-gold">Featured</span>
              <?php else: ?>
                <span style="color:#a0a0a0;font-size:12px;">No</span>
              <?php endif; ?>
            </td>
            <td>
              <div style="display:flex;gap:8px;">
                
                  href="<?= APP_URL ?>/admin/products?action=edit&id=<?= $p['id'] ?>"
                  class="btn-admin btn-admin-secondary btn-sm"
                >
                  <i class="ti ti-edit"></i>
                </a>
                
                  href="<?= APP_URL ?>/admin/products?action=delete&id=<?= $p['id'] ?>"
                  class="btn-admin btn-admin-danger btn-sm"
                  onclick="return confirmDelete('Are you sure you want to delete <?= htmlspecialchars($p['name']) ?>?')"
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

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>