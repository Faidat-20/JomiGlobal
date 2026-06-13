// Scroll reveal animation
const revealElements = document.querySelectorAll('.reveal');

// Scroll reveal — triggers every time element enters viewport
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    } else {
      entry.target.classList.remove('visible');
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Hero cursor glow effect
const hero = document.getElementById('hero');
const heroGlow = document.getElementById('heroGlow');

if (hero && heroGlow) {
  hero.addEventListener('mousemove', (e) => {
    const rect = hero.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    heroGlow.style.left = x + 'px';
    heroGlow.style.top = y + 'px';
  });
}

// Password toggle
const togglePassword = document.getElementById('togglePassword');
if (togglePassword) {
  togglePassword.addEventListener('click', () => {
    const input = document.getElementById('password');
    const icon = togglePassword.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('ti-eye', 'ti-eye-off');
    } else {
      input.type = 'password';
      icon.classList.replace('ti-eye-off', 'ti-eye');
    }
  });
}

// Mobile slide panel
const mobileMenuBtn = document.getElementById('mobileMenuToggle');
const mobilePanel = document.getElementById('mobilePanel');
const mobileOverlay = document.getElementById('mobileOverlay');
const mobilePanelClose = document.getElementById('mobilePanelClose');

function openMobilePanel() {
  mobilePanel.classList.add('open');
  mobileOverlay.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeMobilePanel() {
  mobilePanel.classList.remove('open');
  mobileOverlay.classList.remove('show');
  document.body.style.overflow = '';
}

if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobilePanel);
if (mobilePanelClose) mobilePanelClose.addEventListener('click', closeMobilePanel);
if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobilePanel);

// Mobile dropdowns
const shopDropToggle = document.getElementById('shopDropToggle');
const shopDropSub = document.getElementById('shopDropSub');
const colDropToggle = document.getElementById('colDropToggle');
const colDropSub = document.getElementById('colDropSub');

if (shopDropToggle && shopDropSub) {
  shopDropToggle.addEventListener('click', function() {
    this.classList.toggle('active');
    shopDropSub.classList.toggle('open');
    // Close other
    colDropToggle.classList.remove('active');
    colDropSub.classList.remove('open');
  });
}

if (colDropToggle && colDropSub) {
  colDropToggle.addEventListener('click', function() {
    this.classList.toggle('active');
    colDropSub.classList.toggle('open');
    // Close other
    shopDropToggle.classList.remove('active');
    shopDropSub.classList.remove('open');
  });
}

window.addEventListener('resize', function() {
  if (window.innerWidth > 768) {
    closeMobilePanel();
  }
});

// ============ WISHLIST ============
function updateWishlistCount(count) {
  const badge = document.querySelector('.wishlist-count');
  if (!badge) return;
  badge.textContent = count;
  badge.style.display = count > 0 ? 'inline-flex' : 'none';
}

function setWishlistState(btn, inWishlist) {
  if (btn.classList.contains('wl-remove-btn')) return;
}

// Mark buttons on page load
document.querySelectorAll('.wishlist-btn').forEach(btn => {
  if (btn.classList.contains('wl-remove-btn')) return;
  const id = parseInt(btn.getAttribute('data-id'));
  if (wishlistIds && wishlistIds.includes(id)) {
    setWishlistState(btn, true);
  }
});

// Toggle wishlist
document.querySelectorAll('.wishlist-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const productId = this.getAttribute('data-id');

    fetch(APP_URL + '/wishlist?action=toggle&id=' + productId, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.querySelectorAll('.wishlist-btn[data-id="' + productId + '"]').forEach(b => {
          setWishlistState(b, data.in_wishlist);
        });

        if (data.in_wishlist) {
          if (!window.wishlistIds) window.wishlistIds = [];
          if (!window.wishlistIds.includes(parseInt(productId))) {
            window.wishlistIds.push(parseInt(productId));
          }
        } else {
          if (window.wishlistIds) {
            window.wishlistIds = window.wishlistIds.filter(id => id !== parseInt(productId));
          }

          // Remove row from wishlist page table
          const row = document.getElementById('wishlist-item-' + productId);
          if (row) {
            row.style.opacity = '0';
            row.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
              row.remove();

              // Update "X items saved" text
              const savedText = document.querySelector('.wishlist-header p');
              if (savedText) {
                const remaining = data.wishlist_count;
                savedText.textContent = remaining + ' item' + (remaining !== 1 ? 's' : '') + ' saved';
              }

              // Hide Clear All when empty
              const clearBtn = document.querySelector('.wishlist-clear-btn');
              if (clearBtn && data.wishlist_count === 0) {
                clearBtn.style.display = 'none';
              }

              // Check if table is now empty
              const tbody = document.querySelector('.wishlist-main-table tbody');
              if (tbody && tbody.querySelectorAll('tr').length === 0) {
                document.querySelector('.wishlist-card').outerHTML = `
                  <div class="wishlist-empty">
                    <div class="wishlist-empty-icon"><i class="ti ti-heart"></i></div>
                    <h2>Your wishlist is empty</h2>
                    <p>Save items you love and come back to them anytime.</p>
                    <a href="${APP_URL}/shop" class="btn btn-primary">Explore Products</a>
                  </div>`;
              }
            }, 300);
          }
        }

        updateWishlistCount(data.wishlist_count);
        showToast(data.in_wishlist ? 'Added to wishlist!' : 'Removed from wishlist', data.in_wishlist ? 'success' : 'error');
      }
    });
  });
});

document.querySelectorAll('.hc-slider').forEach(function(slider, sliderIndex) {
  const slides = slider.querySelectorAll('.hc-slide');
  if (slides.length <= 1) return;
  let current = 0;

  setTimeout(function() {
    setInterval(function() {
      slides[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
    }, 3000);
  }, sliderIndex * 1200);
});