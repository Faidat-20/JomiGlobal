const filterToggle = document.getElementById('filterToggle');
const sidebar = document.querySelector('.shop-sidebar');

// Toggle sidebar
if (filterToggle && sidebar) {
  filterToggle.addEventListener('click', function() {
    sidebar.classList.toggle('open');
    if (sidebar.classList.contains('open')) {
      filterToggle.innerHTML = '<i class="ti ti-x"></i> Close Filters';
    } else {
      filterToggle.innerHTML = '<i class="ti ti-adjustments-horizontal"></i> Filter & Categories';
    }
  });
}

// Category links
document.querySelectorAll('.sidebar-list a').forEach(link => {
  link.addEventListener('click', function() {
    const isAllProducts = this.textContent.trim() === 'All Products';
    if (isAllProducts) {
      sessionStorage.removeItem('shopSidebarOpen');
    } else {
      sessionStorage.setItem('shopSidebarOpen', 'true');
    }
    const shopMain = document.querySelector('.shop-main');
    if (shopMain) {
      shopMain.style.opacity = '0.3';
      shopMain.style.transition = 'opacity 0.2s ease';
    }
  });
});

// Restore sidebar state after reload
if (sessionStorage.getItem('shopSidebarOpen') === 'true' && sidebar) {
  sidebar.classList.add('open');
  filterToggle.innerHTML = '<i class="ti ti-x"></i> Close Filters';
  sessionStorage.removeItem('shopSidebarOpen');
}

// Sort select
const sortSelect = document.querySelector('.sort-select');
if (sortSelect) {
  sortSelect.addEventListener('change', function() {
    const shopMain = document.querySelector('.shop-main');
    if (shopMain) {
      shopMain.style.opacity = '0.3';
      shopMain.style.transition = 'opacity 0.2s ease';
    }
    window.location = this.value;
  });
}

// Price filter
const priceForm = document.querySelector('.toolbar-price-filter');
if (priceForm) {
  priceForm.addEventListener('submit', function() {
    if (sidebar && sidebar.classList.contains('open')) {
      sessionStorage.setItem('shopSidebarOpen', 'true');
    }
    const shopMain = document.querySelector('.shop-main');
    if (shopMain) {
      shopMain.style.opacity = '0.3';
      shopMain.style.transition = 'opacity 0.2s ease';
    }
  });
}

// Subcategory accordion
const subcatToggle = document.getElementById('subcatToggle');
const subcatList = document.getElementById('subcatList');

if (subcatToggle && subcatList) {
  if (subcatList.querySelector('a.active')) {
    subcatToggle.classList.add('open');
    subcatList.classList.add('open');
  }

  subcatToggle.addEventListener('click', function() {
    this.classList.toggle('open');
    subcatList.classList.toggle('open');
  });
}

// For Her / For Him dropdowns - only one open at a time
if (subcatList) {
  const allDetails = subcatList.querySelectorAll('.sidebar-subgroup > details');

  allDetails.forEach(function (details) {
    details.addEventListener('toggle', function () {
      if (details.open) {
        allDetails.forEach(function (other) {
          if (other !== details) {
            other.open = false;
          }
        });
      }
    });
  });
}