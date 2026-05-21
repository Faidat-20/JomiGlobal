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

// Image upload preview
const imageInput = document.getElementById('imageInput');
const imagePreviewGrid = document.getElementById('imagePreviewGrid');

if (imageInput) {
  imageInput.addEventListener('change', function() {
    const files = this.files;
    if (files.length > 0) {
      imagePreviewGrid.innerHTML = '';
      Array.from(files).forEach(function(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const div = document.createElement('div');
          div.style.cssText = 'position:relative;width:100px;height:100px;';
          div.innerHTML = `
            <img src="${e.target.result}" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
            ${index === 0 ? '<span style="position:absolute;bottom:4px;left:4px;background:var(--mustard);color:var(--ash);font-size:10px;padding:2px 6px;border-radius:4px;font-weight:600;">Main</span>' : ''}
            <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:-6px;right:-6px;background:#e74c3c;color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;">×</button>
          `;
          imagePreviewGrid.appendChild(div);
        };
        reader.readAsDataURL(file);
      });
    }
  });
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
