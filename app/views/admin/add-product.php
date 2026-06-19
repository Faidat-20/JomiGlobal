<?php require_once ROOT . '/app/views/layouts/admin-layout.php'; ?>

<div class="page-header">
  <div>
    <h1><?= isset($editProduct) ? 'Edit Product' : 'Add Product' ?></h1>
    <p><?= isset($editProduct) ? 'Update product details' : 'Add a new product to JomiGlobal' ?></p>
  </div>
  <a href="<?= APP_URL ?>/admin/products" class="btn-admin btn-admin-secondary">
    <i class="ti ti-arrow-left"></i> Back to Products
  </a>
</div>

<?php if (isset($error)): ?>
  <div class="alert alert-error" style="margin-bottom:24px;">
    <i class="ti ti-alert-circle"></i> <?= $error ?>
  </div>
<?php endif; ?>

<form
  class="admin-form"
  method="POST"
  action="<?= APP_URL ?>/admin/products?action=<?= isset($editProduct) ? 'edit&id=' . $editProduct['id'] : 'add' ?>"
  enctype="multipart/form-data"
>
  <div class="form-grid-2">

    <!-- Left Column -->
    <div>
      <div class="admin-form-group">
        <label>Product Name *</label>
        <input
          type="text"
          name="name"
          placeholder="e.g. 24K Gold Ring"
          value="<?= htmlspecialchars($editProduct['name'] ?? $_POST['name'] ?? '') ?>"
          required
        >
      </div>

      <div class="admin-form-group">
        <label>Category *</label>
        <select name="category_id" required>
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
            <option
              value="<?= $cat['id'] ?>"
              <?= (($editProduct['category_id'] ?? $_POST['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>
            >
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="admin-form-group">
        <label>Subcategory</label>
        <select name="subcategory_id" id="subcategorySelect">
          <option value="">Select Subcategory</option>
        </select>
      </div>
      
      <div class="admin-form-group">
        <label>Brand</label>
        <input
          type="text"
          name="brand"
          placeholder="e.g. Chanel, Gucci"
          value="<?= htmlspecialchars($editProduct['brand'] ?? $_POST['brand'] ?? '') ?>"
        >
      </div>

      <div class="admin-form-group">
        <label>SKU</label>
        <input
          type="text"
          name="sku"
          placeholder="e.g. JWL-RING-001"
          value="<?= htmlspecialchars($editProduct['sku'] ?? $_POST['sku'] ?? '') ?>"
        >
      </div>

      <div class="form-grid-2">
        <div class="admin-form-group">
          <label>Price (₦) *</label>
          <input
            type="number"
            name="price"
            step="0.01"
            placeholder="0.00"
            value="<?= $editProduct['price'] ?? $_POST['price'] ?? '' ?>"
            required
          >
        </div>
        <div class="admin-form-group">
          <label>Sale Price (₦)</label>
          <input
            type="number"
            name="sale_price"
            step="0.01"
            placeholder="0.00"
            value="<?= $editProduct['sale_price'] ?? $_POST['sale_price'] ?? '' ?>"
          >
        </div>
      </div>

      <div class="admin-form-group">
        <label>Stock Quantity *</label>
        <input
          type="number"
          name="stock"
          placeholder="0"
          value="<?= $editProduct['stock'] ?? $_POST['stock'] ?? '' ?>"
          required
        >
      </div>

      <?php if (isset($editProduct)): ?>
        <div class="admin-form-group">
          <label>Slug</label>
          <input
            type="text"
            name="slug"
            value="<?= htmlspecialchars($editProduct['slug']) ?>"
          >
        </div>
      <?php endif; ?>

      <div class="admin-form-group">
        <label>Collections</label>
        <?php
          $pdo = connectDB();
          $stmt = $pdo->prepare('SELECT * FROM collections WHERE is_active = 1');
          $stmt->execute();
          $collections = $stmt->fetchAll();
        ?>
        <div style="display:flex;flex-wrap:wrap;gap:10px;">
          <?php foreach ($collections as $col): ?>
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;text-transform:none;letter-spacing:0;font-weight:400;cursor:pointer;">
              <input
                type="checkbox"
                name="collections[]"
                value="<?= $col['id'] ?>"
                <?= in_array($col['id'], $productCollections ?? []) ? 'checked' : '' ?>
              >
              <?= htmlspecialchars($col['name']) ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px;">
        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px;">
          <input
            type="checkbox"
            name="is_featured"
            value="1"
            <?= ($editProduct['is_featured'] ?? 0) ? 'checked' : '' ?>
          >
          <span>Mark as Featured (shows on homepage)</span>
        </label>
        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px;">
          <input
            type="checkbox"
            name="is_active"
            value="1"
            <?= ($editProduct['is_active'] ?? 1) ? 'checked' : '' ?>
          >
          <span>Active (visible in shop)</span>
        </label>
      </div>
    </div>

    <!-- Right Column -->
    <div>
      <div class="admin-form-group">
        <label>Description</label>
        <textarea
          name="description"
          placeholder="Describe the product..."
          rows="6"
        ><?= htmlspecialchars($editProduct['description'] ?? $_POST['description'] ?? '') ?></textarea>
      </div>

      <div class="admin-form-group">
        <label>Product Images</label>
        <?php if (isset($editProduct['image']) && $editProduct['image']): ?>
          <div style="margin-bottom:12px;">
            <img
              src="<?= APP_URL ?>/uploads/<?= $editProduct['image'] ?>"
              style="width:120px;height:120px;object-fit:cover;border-radius:8px;"
            >
          </div>
        <?php endif; ?>
        <div id="imagePreviewGrid" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:10px;"></div>
        <input
          type="file"
          name="images[]"
          id="imageInput"
          accept=".jpg,.jpeg,.png,.webp"
          multiple
          style="display:none;"
        >
        <button
          type="button"
          onclick="document.getElementById('imageInput').click()"
          style="padding:10px 20px;border:1px dashed #ccc;border-radius:8px;background:white;cursor:pointer;font-size:13px;font-family:inherit;"
        >
          + Add Image
        </button>
        <p style="font-size:12px;color:#a0a0a0;margin-top:8px;">
          You can select multiple images. First image will be the main image.
        </p>
      </div>
    </div>

  </div>

  <div style="margin-top:32px;padding-top:24px;border-top:1px solid #eee;display:flex;gap:12px;">
    <button type="submit" class="btn-admin btn-admin-primary">
      <i class="ti ti-check"></i>
      <?= isset($editProduct) ? 'Update Product' : 'Add Product' ?>
    </button>
    <a href="<?= APP_URL ?>/admin/products" class="btn-admin btn-admin-secondary">
      Cancel
    </a>
  </div>

</form>

<script>
const subcategoriesData = <?= json_encode($subcategories ?? []) ?>;
const categorySelect = document.querySelector('select[name="category_id"]');
const subcategorySelect = document.getElementById('subcategorySelect');

if (categorySelect && subcategorySelect) {
  function loadSubcategories(catId, selectedId = null) {
    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

    // Get top level groups for this category
    const groups = subcategoriesData.filter(s => s.category_id == catId && s.parent_id === null);
    
    groups.forEach(group => {
      // Add group as optgroup
      const optgroup = document.createElement('optgroup');
      optgroup.label = group.name;
      
      // Add children of this group
      const children = subcategoriesData.filter(s => s.parent_id == group.id);
      
      if (children.length > 0) {
        children.forEach(child => {
          const option = document.createElement('option');
          option.value = child.id;
          option.textContent = child.name;
          if (selectedId && child.id == selectedId) option.selected = true;
          optgroup.appendChild(option);
        });
        subcategorySelect.appendChild(optgroup);
      } else {
        // No children — add group itself as option
        const option = document.createElement('option');
        option.value = group.id;
        option.textContent = group.name;
        if (selectedId && group.id == selectedId) option.selected = true;
        subcategorySelect.appendChild(option);
      }
    });
  }

  categorySelect.addEventListener('change', function() {
    loadSubcategories(this.value);
  });

  // On page load for edit
  if (categorySelect.value) {
    loadSubcategories(categorySelect.value, <?= json_encode($editProduct['subcategory_id'] ?? null) ?>);
  }
}
</script>

<?php require_once ROOT . '/app/views/layouts/admin-layout-end.php'; ?>