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
});// ============ NEWSLETTER POPUP ============
function initNewsletter() {
  const overlay = document.getElementById('newsletterOverlay');
  const closeBtn = document.getElementById('newsletterClose');
  const form = document.getElementById('newsletterForm');

  if (!overlay) return;


  const subscribedCookie = document.cookie.includes('jomi_subscribed=1');
  if (subscribedCookie) return;


  // Show popup after 3 seconds if not shown in last 24 hours
  const lastShown = localStorage.getItem('jomi_newsletter_shown');
  const now = Date.now();
  const twentyFourHours = 24 * 60 * 60 * 1000;

  if (!lastShown || now - parseInt(lastShown) > twentyFourHours) {
    setTimeout(() => {
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }, 3000);
  }

  // Close
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
      localStorage.setItem('jomi_newsletter_shown', Date.now());
    });
  }

  // Close on overlay click
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
      localStorage.setItem('jomi_newsletter_shown', Date.now());
    }
  });

  // Submit
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="ti ti-loader"></i> Subscribing...';
      btn.disabled = true;

      fetch(APP_URL + '/newsletter/subscribe', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(new FormData(form))
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          form.innerHTML = `
            <div style="text-align:center;padding:20px 0;">
              <div style="font-size:40px;margin-bottom:12px;">🎉</div>
              <p style="color:var(--success);font-weight:600;font-size:15px;">
                ${data.message}
              </p>
            </div>
          `;
          // Set cookie and localStorage so popup doesn't show again
          document.cookie = 'jomi_subscribed=1; max-age=31536000; path=/';
          localStorage.setItem('jomi_newsletter_shown', Date.now() + (365 * 24 * 60 * 60 * 1000));
          setTimeout(() => {
            overlay.classList.remove('open');
            document.body.style.overflow = '';
          }, 2000);
        } else {
          btn.innerHTML = originalText;
          btn.disabled = false;
          showToast(data.message, 'error');
        }
      })
      .catch(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showToast('Something went wrong. Please try again.', 'error');
      });
    });
  }
}

initNewsletter();