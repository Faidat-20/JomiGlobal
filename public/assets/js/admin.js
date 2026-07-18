// Sidebar toggle
const sidebarToggle = document.getElementById('sidebarToggle');
const adminSidebar = document.getElementById('adminSidebar');
const adminMain = document.getElementById('adminMain');

if (sidebarToggle) {
  sidebarToggle.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      adminSidebar.classList.toggle('mobile-open');
    } else {
      adminSidebar.classList.toggle('collapsed');
      adminMain.classList.toggle('expanded');
    }
  });
}

// Close sidebar on mobile when clicking outside
document.addEventListener('click', (e) => {
  if (window.innerWidth <= 768) {
    if (!adminSidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
      adminSidebar.classList.remove('mobile-open');
    }
  }
});

// Confirm delete
function confirmDelete(message) {
  return confirm(message || 'Are you sure you want to delete this?');
}

// Auto hide alerts
const alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
  setTimeout(() => {
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    setTimeout(() => alert.remove(), 300);
  }, 4000);
});

// Image upload — accumulate files
const imageInput = document.getElementById('imageInput');
const imagePreviewGrid = document.getElementById('imagePreviews');
let allFiles = []; // store all selected files

if (imageInput && imagePreviewGrid) {
  imageInput.addEventListener('change', function() {
    const newFiles = Array.from(this.files);
    
    // Add new files to our collection
    newFiles.forEach(file => {
      allFiles.push(file);
    });
    // Rebuild previews
    renderPreviews();
    // Keep the real file input in sync with our tracked files
    syncInputFiles();
  });
}
function syncInputFiles() {
  const dt = new DataTransfer();
  allFiles.forEach(file => dt.items.add(file));
  if (imageInput) imageInput.files = dt.files;
}

function renderPreviews() {
  if (!imagePreviewGrid) return;
  imagePreviewGrid.innerHTML = '';

  const hasExistingImages = document.querySelectorAll('#existingImagePreviews .existing-image-item').length > 0;

  allFiles.forEach(function(file, index) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const isMain = index === 0 && !hasExistingImages;
      const div = document.createElement('div');
      div.style.cssText = 'position:relative;width:100px;height:100px;';
      div.innerHTML = `
        <img src="${e.target.result}" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
        ${isMain ? '<span style="position:absolute;bottom:4px;left:4px;background:var(--mustard);color:var(--ash);font-size:10px;padding:2px 6px;border-radius:4px;font-weight:600;">Main</span>' : ''}
        <button type="button" onclick="removeImage(${index})" style="position:absolute;top:-6px;right:-6px;background:#e74c3c;color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;">×</button>
      `;
      imagePreviewGrid.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
}

function removeImage(index) {
  allFiles.splice(index, 1);
  renderPreviews();
  syncInputFiles();
}

function removeExistingImage(btn) {
  const item = btn.closest('.existing-image-item');
  if (item) item.remove();
  reassignMainBadge();
}

function reassignMainBadge() {
  document.querySelectorAll('#existingImagePreviews .main-badge').forEach(el => el.remove());
  const firstItem = document.querySelector('#existingImagePreviews .existing-image-item');
  if (firstItem) {
    const badge = document.createElement('span');
    badge.className = 'main-badge';
    badge.style.cssText = 'position:absolute;bottom:4px;left:4px;background:var(--mustard);color:var(--ash);font-size:10px;padding:2px 6px;border-radius:4px;font-weight:600;';
    badge.textContent = 'Main';
    firstItem.appendChild(badge);
  }
  renderPreviews();
}

// Order search
const orderSearch = document.getElementById('orderSearch');
if (orderSearch) {
  orderSearch.addEventListener('input', (e) => {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#ordersTable tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(search) ? '' : 'none';
    });
  });
}

// Customer search
const customerSearch = document.getElementById('customerSearch');
if (customerSearch) {
  customerSearch.addEventListener('input', (e) => {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#customersTable tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(search) ? '' : 'none';
    });
  });
}

// ===== Variant Groups =====
const variantGroupsContainer = document.getElementById('variantGroupsContainer');
const addVariantGroupBtn = document.getElementById('addVariantGroupBtn');

function createOptionRow(type) {
  const row = document.createElement('div');
  row.className = 'variant-option-row';
  row.innerHTML = `
    <input type="hidden" name="variant_type[]" value="${type}" class="variant-type-hidden">
    <input type="text" name="variant_value[]" placeholder="e.g. Gold, Large, 100ml">
    <input type="number" name="variant_price[]" placeholder="Price (₦)" step="0.01" value="0">
    <button type="button" class="remove-option-btn">
      <i class="ti ti-x"></i>
    </button>
  `;
  return row;
}

function createVariantGroup() {
  const group = document.createElement('div');
  group.className = 'variant-group-block';
  group.innerHTML = `
    <div class="variant-group-header">
      <select class="variant-group-type">
        <option value="size">Size</option>
        <option value="color">Color</option>
        <option value="quantity">Quantity</option>
        <option value="custom">Custom</option>
      </select>
      <input type="text" class="variant-group-custom-label" placeholder="e.g. Material" style="display:none;">
      <button type="button" class="remove-group-btn">
        <i class="ti ti-trash"></i>
      </button>
    </div>
    <div class="variant-options-list"></div>
    <button type="button" class="add-option-btn">
      <i class="ti ti-plus"></i> Add Option
    </button>
  `;
  group.querySelector('.variant-options-list').appendChild(createOptionRow('size'));
  return group;
}

if (addVariantGroupBtn && variantGroupsContainer) {
  addVariantGroupBtn.addEventListener('click', function() {
    variantGroupsContainer.appendChild(createVariantGroup());
  });
}

function getGroupType(group) {
  const select = group.querySelector('.variant-group-type');
  const customInput = group.querySelector('.variant-group-custom-label');
  if (select.value === 'custom') {
    const label = customInput.value.trim().toLowerCase().replace(/\s+/g, '_');
    return label || 'custom';
  }
  return select.value;
}

function syncGroupType(group) {
  const type = getGroupType(group);
  group.querySelectorAll('.variant-type-hidden').forEach(input => {
    input.value = type;
  });
}

if (variantGroupsContainer) {
  variantGroupsContainer.addEventListener('change', function(e) {
    if (e.target.classList.contains('variant-group-type')) {
      const group = e.target.closest('.variant-group-block');
      const customInput = group.querySelector('.variant-group-custom-label');
      customInput.style.display = e.target.value === 'custom' ? 'block' : 'none';
      syncGroupType(group);
    }
  });

  variantGroupsContainer.addEventListener('input', function(e) {
    if (e.target.classList.contains('variant-group-custom-label')) {
      syncGroupType(e.target.closest('.variant-group-block'));
    }
  });

  variantGroupsContainer.addEventListener('click', function(e) {
    if (e.target.closest('.add-option-btn')) {
      const group = e.target.closest('.variant-group-block');
      const type = getGroupType(group);
      group.querySelector('.variant-options-list').appendChild(createOptionRow(type));
    }
    if (e.target.closest('.remove-option-btn')) {
      e.target.closest('.variant-option-row').remove();
    }
    if (e.target.closest('.remove-group-btn')) {
      e.target.closest('.variant-group-block').remove();
    }
  });
}