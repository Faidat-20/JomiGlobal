<main class="checkout-page">
  <div class="container">

    <!-- Step Indicator (matching cart page style) -->
    <h1 class="cart-title">Check Out</h1>
    <div class="cart-steps">
      <div class="cart-step done">
        <div class="step-num"><i class="ti ti-check"></i></div>
        <span class="step-label">Shopping cart</span>
      </div>
      <div class="step-line done"></div>
      <div class="cart-step active">
        <div class="step-num">2</div>
        <span class="step-label">Checkout details</span>
      </div>
      <div class="step-line"></div>
      <div class="cart-step">
        <div class="step-num">3</div>
        <span class="step-label">Order complete</span>
      </div>
    </div>

    <div class="checkout-layout">

      <!-- Left -->
      <div class="checkout-left">

        <!-- Delivery Details -->
        <div class="checkout-block">
          <div class="checkout-block-header">
            <div class="checkout-block-title">
              <span class="checkout-block-num">1</span>
              <h3>Delivery Details</h3>
            </div>
            <?php if (isset($deliveryFilled)): ?>
              <button class="checkout-change-btn" id="openDeliveryBtn">Change</button>
            <?php endif; ?>
          </div>

          <?php if (!isset($deliveryFilled)): ?>
            <button class="checkout-add-btn" id="openDeliveryBtn">
              <i class="ti ti-map-pin"></i> Add Delivery Details
            </button>
          <?php else: ?>
            <div class="checkout-filled-info">
              <p><?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?></p>
              <p><?= htmlspecialchars($currentUser['address'] ?? '') ?></p>
              <p><?= htmlspecialchars($currentUser['phone'] ?? '') ?></p>
            </div>
          <?php endif; ?>
        </div>

        <!-- Shipping Method -->
        <div class="checkout-block">
          <div class="checkout-block-header">
            <div class="checkout-block-title">
              <span class="checkout-block-num">2</span>
              <h3>Shipping Method</h3>
            </div>
            <button class="checkout-change-btn" id="changeShippingBtn" style="display:none;">Change</button>
          </div>

          <div id="shippingDisplay">
            <button class="checkout-add-btn" id="openShippingBtn">
              <i class="ti ti-truck"></i> Select Shipping Rate
            </button>
          </div>
        </div>

        <!-- Payment Method -->
        <div class="checkout-block">
          <div class="checkout-block-header">
            <div class="checkout-block-title">
              <span class="checkout-block-num">3</span>
              <h3>Payment Method</h3>
            </div>
          </div>

          <div class="payment-methods">

            <!-- Card Option -->
            <label class="payment-option" id="payCardOption">
              <input type="radio" name="payment_method" value="card" checked>
              <div class="payment-option-info">
                <div class="payment-option-top">
                  <strong>Pay by Card Credit</strong>
                  <i class="ti ti-credit-card payment-option-icon"></i>
                </div>
              </div>
            </label>

            <!-- Card Fields -->
            <div class="payment-card-fields" id="cardFields">
              <div class="checkout-field">
                <label>Card Number</label>
                <input type="text" id="cardNumber" placeholder="1234 1234 1234 1234" maxlength="19">
              </div>
              <div class="form-grid-2">
                <div class="checkout-field">
                  <label>Expiration Date</label>
                  <input type="text" id="cardExpiry" placeholder="MM/YY" maxlength="5">
                </div>
                <div class="checkout-field">
                  <label>CVV</label>
                  <input type="text" id="cardCvv" placeholder="CVC code" maxlength="4">
                </div>
              </div>
            </div>

            <!-- PayPal Option -->
            <label class="payment-option" id="payPaypalOption">
              <input type="radio" name="payment_method" value="paypal">
              <div class="payment-option-info">
                <div class="payment-option-top">
                  <strong>PayPal</strong>
                  <i class="ti ti-brand-paypal payment-option-icon"></i>
                </div>
              </div>
            </label>

          </div>
        </div>

        <!-- Place Order -->
        <button class="btn btn-primary checkout-place-btn" id="placeOrderBtn">
          Place Order <i class="ti ti-arrow-right"></i>
        </button>

        <div class="checkout-secure">
          <i class="ti ti-lock"></i>
          <span>Secure SSL encrypted checkout</span>
        </div>

      </div>

      <!-- Right: Order Summary -->
      <div class="checkout-summary">
        <h3>Order Summary</h3>

        <div class="checkout-items">
          <?php foreach ($cartItems as $item): ?>
            <div class="checkout-item">
              <div class="checkout-item-img">
                <?php if (!empty($item['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <?php else: ?>
                  <div class="checkout-no-img"><i class="ti ti-photo"></i></div>
                <?php endif; ?>
                <span class="checkout-item-qty"><?= $item['quantity'] ?></span>
              </div>
              <div class="checkout-item-info">
                <p class="checkout-item-name"><?= htmlspecialchars($item['name']) ?></p>
              </div>
              <p class="checkout-item-price">
                <?= CURRENCY_SYMBOL . number_format($item['price'] * $item['quantity'], 2) ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="checkout-totals">
          <div class="checkout-total-row">
            <span>Subtotal</span>
            <span><?= CURRENCY_SYMBOL . number_format($subtotal, 2) ?></span>
          </div>
          <div class="checkout-total-row">
            <span>Shipping</span>
            <span id="shippingCost" style="color:var(--text-grey);">Select shipping</span>
          </div>
          <div class="checkout-total-row total">
            <span>Total</span>
            <span id="checkoutTotal"><?= CURRENCY_SYMBOL . number_format($subtotal, 2) ?></span>
          </div>
        </div>

        <div class="checkout-security">
          <i class="ti ti-shield-check"></i>
          <span>Your payment info is safe with us</span>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Delivery Modal -->
<div class="checkout-modal" id="deliveryModal">
  <div class="checkout-modal-overlay" id="closeDeliveryOverlay"></div>
  <div class="checkout-modal-content">
    <div class="checkout-modal-header">
      <h3>Delivery Details</h3>
      <button class="checkout-modal-close" id="closeDeliveryModal">
        <i class="ti ti-x"></i>
      </button>
    </div>
    <div class="checkout-modal-body">
      <form id="deliveryForm">
        <div class="form-grid-2">
          <div class="checkout-field">
            <label>First Name *</label>
            <input type="text" name="first_name" id="del_first_name" placeholder="First name" value="<?= htmlspecialchars($currentUser['first_name'] ?? '') ?>" required>
          </div>
          <div class="checkout-field">
            <label>Last Name *</label>
            <input type="text" name="last_name" id="del_last_name" placeholder="Last name" value="<?= htmlspecialchars($currentUser['last_name'] ?? '') ?>" required>
          </div>
        </div>
        <div class="checkout-field">
          <label>Email Address *</label>
          <input type="email" name="email" id="del_email" placeholder="your@email.com" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" required>
        </div>
        <div class="checkout-field">
          <label>Phone Number *</label>
          <input type="tel" name="phone" id="del_phone" placeholder="+234 800 000 0000" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>" required>
        </div>
        <div class="checkout-field">
          <label>Street Address *</label>
          <input type="text" name="address" id="del_address" placeholder="House number and street name" value="<?= htmlspecialchars($currentUser['address'] ?? '') ?>" required>
        </div>
        <div class="form-grid-2">
          <div class="checkout-field">
            <label>City *</label>
            <input type="text" name="city" id="del_city" placeholder="City" value="<?= htmlspecialchars($currentUser['city'] ?? '') ?>" required>
          </div>
          <div class="checkout-field">
            <label>State/Province *</label>
            <input type="text" name="state" id="del_state" placeholder="State" value="<?= htmlspecialchars($currentUser['state'] ?? '') ?>" required>
          </div>
        </div>
        <div class="form-grid-2">
          <div class="checkout-field">
            <label>Country *</label>
            <select name="country" id="del_country">
              <option value="">Loading countries...</option>
            </select>
          </div>
          <div class="checkout-field">
            <label>ZIP / Postal Code</label>
            <input type="text" name="zip" id="del_zip" placeholder="ZIP code">
          </div>
        </div>
        <div class="checkout-field">
          <label>Order Notes (optional)</label>
          <textarea name="notes" id="del_notes" placeholder="Any special instructions..." rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:16px;margin-top:8px;">
          Save & Continue <i class="ti ti-arrow-right"></i>
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Shipping Modal -->
<div class="checkout-modal" id="shippingModal">
  <div class="checkout-modal-overlay" id="closeShippingOverlay"></div>
  <div class="checkout-modal-content">
    <div class="checkout-modal-header">
      <h3>Select Shipping Method</h3>
      <button class="checkout-modal-close" id="closeShippingModal">
        <i class="ti ti-x"></i>
      </button>
    </div>
    <div class="checkout-modal-body">
      <?php
        $stmt = $pdo->prepare('SELECT * FROM shipping_rates WHERE is_active = 1 ORDER BY price ASC');
        $stmt->execute();
        $shippingRates = $stmt->fetchAll();
      ?>
      <?php if (empty($shippingRates)): ?>
        <p style="text-align:center;color:var(--text-grey);padding:40px 0;">No shipping rates available yet.</p>
      <?php else: ?>
        <div class="shipping-options">
          <?php foreach ($shippingRates as $rate): ?>
            <label class="shipping-option" data-price="<?= $rate['price'] ?>" data-name="<?= htmlspecialchars($rate['name']) ?>">
              <input type="radio" name="shipping_rate" value="<?= $rate['id'] ?>" data-price="<?= $rate['price'] ?>" data-name="<?= htmlspecialchars($rate['name']) ?>">
              <div class="shipping-option-info">
                <div class="shipping-option-top">
                  <strong><?= htmlspecialchars($rate['name']) ?></strong>
                  <span class="shipping-option-price"><?= CURRENCY_SYMBOL . number_format($rate['price'], 2) ?></span>
                </div>
                <?php if ($rate['description']): ?>
                  <p><?= htmlspecialchars($rate['description']) ?></p>
                <?php endif; ?>
                <?php if ($rate['estimated_days']): ?>
                  <span class="shipping-option-days"><i class="ti ti-clock"></i> <?= htmlspecialchars($rate['estimated_days']) ?></span>
                <?php endif; ?>
              </div>
            </label>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-primary" id="confirmShippingBtn" style="width:100%;justify-content:center;padding:16px;margin-top:20px;">
          Confirm Shipping <i class="ti ti-check"></i>
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
const subtotal = <?= $subtotal ?>;
const CURRENCY = '<?= CURRENCY_SYMBOL ?>';
let selectedShipping = null;
let deliveryDetails = null;
let selectedPayment = 'card';

// ── Delivery Modal ──
document.getElementById('openDeliveryBtn').addEventListener('click', () => {
  document.getElementById('deliveryModal').classList.add('open');
  document.body.style.overflow = 'hidden';
});
document.getElementById('closeDeliveryModal').addEventListener('click', closeDeliveryModal);
document.getElementById('closeDeliveryOverlay').addEventListener('click', closeDeliveryModal);
function closeDeliveryModal() {
  document.getElementById('deliveryModal').classList.remove('open');
  document.body.style.overflow = '';
}

// ── Shipping Modal ──
document.getElementById('openShippingBtn').addEventListener('click', () => {
  document.getElementById('shippingModal').classList.add('open');
  document.body.style.overflow = 'hidden';
});
document.getElementById('closeShippingModal').addEventListener('click', closeShippingModal);
document.getElementById('closeShippingOverlay').addEventListener('click', closeShippingModal);
document.getElementById('changeShippingBtn').addEventListener('click', () => {
  document.getElementById('shippingModal').classList.add('open');
  document.body.style.overflow = 'hidden';
});
function closeShippingModal() {
  document.getElementById('shippingModal').classList.remove('open');
  document.body.style.overflow = '';
}

// ── Delivery Form ──
document.getElementById('deliveryForm').addEventListener('submit', function(e) {
  e.preventDefault();
  deliveryDetails = {
    first_name: document.getElementById('del_first_name').value,
    last_name:  document.getElementById('del_last_name').value,
    email:      document.getElementById('del_email').value,
    phone:      document.getElementById('del_phone').value,
    address:    document.getElementById('del_address').value,
    city:       document.getElementById('del_city').value,
    state:      document.getElementById('del_state').value,
    country:    document.getElementById('del_country').value,
    zip:        document.getElementById('del_zip').value,
    notes:      document.getElementById('del_notes').value,
  };

  const block = document.querySelector('.checkout-block:first-child');
  const existing = block.querySelector('.checkout-filled-info');
  if (existing) existing.remove();
  const btn = block.querySelector('#openDeliveryBtn');
  if (btn) btn.style.display = 'none';

  const info = document.createElement('div');
  info.className = 'checkout-filled-info';
  info.innerHTML = `
    <p><strong>${deliveryDetails.first_name} ${deliveryDetails.last_name}</strong></p>
    <p>${deliveryDetails.address}, ${deliveryDetails.city}, ${deliveryDetails.state}</p>
    <p>${deliveryDetails.phone}</p>
    <button class="checkout-change-btn" id="changeDeliveryBtn">Change</button>
  `;
  block.appendChild(info);

  document.getElementById('changeDeliveryBtn').addEventListener('click', () => {
    document.getElementById('deliveryModal').classList.add('open');
    document.body.style.overflow = 'hidden';
  });

  closeDeliveryModal();
  showToast('Delivery details saved!');
});

// ── Shipping Options ──
document.querySelectorAll('.shipping-option').forEach(option => {
  option.addEventListener('click', function() {
    document.querySelectorAll('.shipping-option').forEach(o => o.classList.remove('selected'));
    this.classList.add('selected');
    this.querySelector('input[type="radio"]').checked = true;
  });
});

document.getElementById('confirmShippingBtn') && document.getElementById('confirmShippingBtn').addEventListener('click', () => {
  const selected = document.querySelector('input[name="shipping_rate"]:checked');
  if (!selected) {
    showToast('Please select a shipping method', 'error');
    return;
  }
  selectedShipping = {
    id:    selected.value,
    name:  selected.getAttribute('data-name'),
    price: parseFloat(selected.getAttribute('data-price'))
  };

  document.getElementById('shippingDisplay').innerHTML = `
    <div class="checkout-filled-info">
      <p><strong>${selectedShipping.name}</strong></p>
      <p>${CURRENCY}${selectedShipping.price.toLocaleString()}</p>
    </div>
  `;
  document.getElementById('changeShippingBtn').style.display = 'block';

  const total = subtotal + selectedShipping.price;
  document.getElementById('shippingCost').textContent = CURRENCY + selectedShipping.price.toLocaleString();
  document.getElementById('shippingCost').style.color = 'var(--text-dark)';
  document.getElementById('checkoutTotal').textContent = CURRENCY + total.toLocaleString();

  closeShippingModal();
  showToast('Shipping method selected!');
});

// ── Payment Method Toggle ──
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
  radio.addEventListener('change', function() {
    selectedPayment = this.value;
    const cardFields = document.getElementById('cardFields');
    // Mark selected option
    document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
    this.closest('.payment-option').classList.add('selected');
    if (this.value === 'card') {
      cardFields.style.display = 'block';
    } else {
      cardFields.style.display = 'none';
    }
  });
});

// Mark card as selected by default
document.querySelector('.payment-option').classList.add('selected');

// Card number formatting
document.getElementById('cardNumber') && document.getElementById('cardNumber').addEventListener('input', function() {
  let val = this.value.replace(/\D/g, '').substring(0, 16);
  this.value = val.replace(/(.{4})/g, '$1 ').trim();
});

document.getElementById('cardExpiry') && document.getElementById('cardExpiry').addEventListener('input', function() {
  let val = this.value.replace(/\D/g, '').substring(0, 4);
  if (val.length >= 2) val = val.substring(0,2) + '/' + val.substring(2);
  this.value = val;
});

// ── Place Order ──
document.getElementById('placeOrderBtn').addEventListener('click', () => {
  if (!deliveryDetails) {
    showToast('Please add your delivery details', 'error');
    return;
  }
  if (!selectedShipping) {
    showToast('Please select a shipping method', 'error');
    return;
  }
  if (selectedPayment === 'card') {
    const cardNum = document.getElementById('cardNumber').value.replace(/\s/g, '');
    const expiry  = document.getElementById('cardExpiry').value;
    const cvv     = document.getElementById('cardCvv').value;
    if (cardNum.length < 16 || !expiry || cvv.length < 3) {
      showToast('Please fill in your card details', 'error');
      return;
    }
  }
  showToast('Placing your order...');
  setTimeout(() => {
    window.location.href = APP_URL + '/payment';
  }, 1000);
});

// ── Load Countries ──
async function loadCountries() {
  try {
    const res = await fetch('https://countriesnow.space/api/v0.1/countries');
    const data = await res.json();
    const select = document.getElementById('del_country');
    select.innerHTML = '<option value="">Select Country</option>';
    data.data.forEach(country => {
      const option = document.createElement('option');
      option.value = country.country;
      option.textContent = country.country;
      if (country.country === 'Nigeria') option.selected = true;
      select.appendChild(option);
    });
  } catch (err) {
    const select = document.getElementById('del_country');
    select.innerHTML = `
      <option value="Nigeria">Nigeria</option>
      <option value="Ghana">Ghana</option>
      <option value="Kenya">Kenya</option>
      <option value="United Kingdom">United Kingdom</option>
      <option value="United States">United States</option>
      <option value="Canada">Canada</option>
      <option value="France">France</option>
      <option value="Germany">Germany</option>
      <option value="UAE">UAE</option>
    `;
  }
}
loadCountries();
</script>