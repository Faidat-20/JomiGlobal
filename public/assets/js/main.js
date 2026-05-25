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
const mobileMenuBtn = document.getElementById('mobileMenuToggle');
const navLinks = document.querySelector('.nav-links');

if (mobileMenuBtn && navLinks) {
  mobileMenuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    navLinks.classList.toggle('open');
    const icon = mobileMenuBtn.querySelector('i');
    if (icon) {
      icon.classList.toggle('ti-menu-2');
      icon.classList.toggle('ti-x');
    }
  });

  // Close when clicking outside
  document.addEventListener('click', (e) => {
    if (!navLinks.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
      navLinks.classList.remove('open');
      const icon = mobileMenuBtn.querySelector('i');
      if (icon) {
        icon.classList.add('ti-menu-2');
        icon.classList.remove('ti-x');
      }
    }
  });
}

// ============ WISHLIST ============
function updateWishlistCount(count) {
  const badge = document.querySelector('.wishlist-count');
  if (!badge) return;
  badge.textContent = count;
  badge.style.display = count > 0 ? 'inline-flex' : 'none';
}

function setWishlistState(btn, inWishlist) {
  if (inWishlist) {
    btn.style.background = 'var(--mustard)';
    btn.style.color = 'var(--ash)';
  } else {
    btn.style.background = '';
    btn.style.color = '';
  }
}

// Mark buttons on page load
document.querySelectorAll('.wishlist-btn').forEach(btn => {
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