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