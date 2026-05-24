const CURRENCY = '₦';

// ============ TOAST ============
function showToast(message, type = 'success') {
  const existing = document.querySelector('.cart-toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.className = 'cart-toast cart-toast-' + type;
  toast.innerHTML = `
    <i class="ti ti-${type === 'success' ? 'check' : 'trash'}"></i>
    <span>${message}</span>
  `;
  document.body.appendChild(toast);
  setTimeout(() => toast.classList.add('show'), 10);
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

// ============ CART COUNT ============
function updateCartCount(count) {
  const cartCount = document.querySelector('.cart-btn .cart-count');
  if (cartCount) cartCount.textContent = count;
}

// ============ SUMMARY ============
function updateSummary(data) {
  const subtotal = document.getElementById('cart-subtotal');
  const total = document.getElementById('cart-total');
  if (subtotal) subtotal.textContent = CURRENCY + data.subtotal;
  if (total) total.textContent = CURRENCY + data.total;
}

// ============ EMPTY CART ============
function showEmptyCart() {
  const cartLayout = document.querySelector('.cart-layout');
  if (cartLayout) {
    cartLayout.innerHTML = `
      <div class="cart-empty" style="grid-column:1/-1;text-align:center;padding:80px 24px;">
        <div class="cart-empty-icon"><i class="ti ti-shopping-bag"></i></div>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything yet.</p>
        <a href="${APP_URL}/shop" class="btn btn-primary">Start Shopping</a>
      </div>
    `;
  }
}

// ============ UPDATE ITEM ============
function updateCartItem(input) {
  const productId = input.getAttribute('data-product-id');
  const quantity = input.value;

  fetch(APP_URL + '/cart?action=update', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: 'product_id=' + productId + '&quantity=' + quantity
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const itemTotal = document.getElementById('item-total-' + productId);
      if (itemTotal) itemTotal.textContent = CURRENCY + data.item_total;
      updateSummary(data);
      updateCartCount(data.cart_count);
      showToast('Cart updated!');
    }
  });
}

// ============ QUANTITY BUTTONS ============
document.querySelectorAll('.cart-qty-minus').forEach(btn => {
  btn.addEventListener('click', function() {
    const input = this.closest('.qty-control').querySelector('.cart-qty-input');
    const val = parseInt(input.value);
    if (val > 1) {
      input.value = val - 1;
      updateCartItem(input);
    }
  });
});

document.querySelectorAll('.cart-qty-plus').forEach(btn => {
  btn.addEventListener('click', function() {
    const input = this.closest('.qty-control').querySelector('.cart-qty-input');
    const val = parseInt(input.value);
    const max = parseInt(input.getAttribute('max'));
    if (val < max) {
      input.value = val + 1;
      updateCartItem(input);
    }
  });
});

document.querySelectorAll('.cart-qty-input').forEach(input => {
  input.addEventListener('change', function() {
    updateCartItem(this);
  });
});

// ============ REMOVE ITEM ============
document.querySelectorAll('.cart-remove').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    const id = this.getAttribute('data-id');

    fetch(APP_URL + '/cart?action=remove&id=' + id, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const item = document.getElementById('cart-item-' + id);
        if (item) {
          item.style.opacity = '0';
          item.style.transform = 'translateX(20px)';
          item.style.transition = 'all 0.3s ease';
          setTimeout(() => {
            item.remove();
            updateSummary(data);
            if (data.empty) showEmptyCart();
          }, 300);
        }
        updateCartCount(data.cart_count);
        showToast('Item removed from cart', 'error');
      }
    });
  });
});

// ============ CLEAR CART ============
const clearBtn = document.getElementById('clearCartBtn');
if (clearBtn) {
  clearBtn.addEventListener('click', function(e) {
    e.preventDefault();
    if (!confirm('Clear your cart?')) return;

    fetch(APP_URL + '/cart?action=clear', {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        updateCartCount(0);
        showToast('Cart cleared!', 'error');
        showEmptyCart();
      }
    });
  });
}

// ============ ADD TO CART (shop & product pages) ============
function markAddedProducts() {
  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    const id = parseInt(btn.getAttribute('data-id'));
    if (window.cartItemIds && window.cartItemIds.includes(id)) {
      btn.classList.add('in-cart');
      btn.innerHTML = '<i class="ti ti-check"></i>';
      btn.style.background = 'var(--success)';
      btn.style.color = 'white';
    }
  });
}

document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const productId = this.getAttribute('data-id');
    const qty = document.getElementById('productQty') ? document.getElementById('productQty').value : 1;
    const self = this;
    const alreadyInCart = self.classList.contains('in-cart');

    fetch(APP_URL + '/cart?action=add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: 'product_id=' + productId + '&quantity=' + qty
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        updateCartCount(data.cart_count);
        self.classList.add('in-cart');
        self.innerHTML = '<i class="ti ti-check"></i>';
        self.style.background = 'var(--success)';
        self.style.color = 'white';
        if (window.cartItemIds && !window.cartItemIds.includes(parseInt(productId))) {
          window.cartItemIds.push(parseInt(productId));
        }
        showToast(alreadyInCart ? 'Cart updated!' : 'Added to cart!');
      }
    });
  });
});

// ============ PRODUCT PAGE QTY ============
const qtyMinus = document.getElementById('qtyMinus');
const qtyPlus = document.getElementById('qtyPlus');
const productQty = document.getElementById('productQty');
const addToCartBtn = document.getElementById('addToCartBtn');

if (qtyMinus && qtyPlus && productQty) {
  qtyMinus.addEventListener('click', () => {
    const val = parseInt(productQty.value);
    if (val > 1) {
      productQty.value = val - 1;
      // If already in cart auto update
      if (addToCartBtn && addToCartBtn.classList.contains('in-cart')) {
        updateProductPageCart();
      }
    }
  });

  qtyPlus.addEventListener('click', () => {
    const val = parseInt(productQty.value);
    const max = parseInt(productQty.getAttribute('max'));
    if (val < max) {
      productQty.value = val + 1;
      // If already in cart auto update
      if (addToCartBtn && addToCartBtn.classList.contains('in-cart')) {
        updateProductPageCart();
      }
    }
  });
}

function updateProductPageCart() {
  if (!addToCartBtn) return;
  const productId = addToCartBtn.getAttribute('data-id');
  const qty = productQty.value;

  fetch(APP_URL + '/cart?action=add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: 'product_id=' + productId + '&quantity=' + qty
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      updateCartCount(data.cart_count);
      showToast('Cart updated!');
    }
  });
}

// Init
markAddedProducts();