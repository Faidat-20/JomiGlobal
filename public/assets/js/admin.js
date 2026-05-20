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
const imageUploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const uploadPlaceholder = document.getElementById('uploadPlaceholder');

if (imageUploadArea) {
  imageUploadArea.addEventListener('click', () => imageInput.click());

  imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
        uploadPlaceholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });

  // Drag and drop
  imageUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    imageUploadArea.style.borderColor = 'var(--gold)';
  });

  imageUploadArea.addEventListener('dragleave', () => {
    imageUploadArea.style.borderColor = '#e0e0e0';
  });

  imageUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    imageUploadArea.style.borderColor = '#e0e0e0';
    const file = e.dataTransfer.files[0];
    if (file) {
      imageInput.files = e.dataTransfer.files;
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
        uploadPlaceholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });
}

// Product search
const productSearch = document.getElementById('productSearch');
if (productSearch) {
  productSearch.addEventListener('input', (e) => {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#productsTable tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(search) ? '' : 'none';
    });
  });
}