<main class="cart-page">
  <div class="container">

    <div class="cart-page-header">
      <h1>Your Cart</h1>
      <?php if (!empty($cartItems)): ?>
        <a href="#" class="clear-cart-link" id="clearCartBtn">
          <i class="ti ti-trash"></i> Clear All
        </a>
      <?php endif; ?>
    </div>

    <?php if (empty($cartItems)): ?>
      <div class="cart-empty">
        <div class="cart-empty-icon">
          <i class="ti ti-shopping-bag"></i>
        </div>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything yet.</p>
        <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Start Shopping</a>
      </div>

    <?php else: ?>
      <div class="cart-layout">

        <!-- Cart Items -->
        <div class="cart-items">
          <?php foreach ($cartItems as $item): ?>
            <div class="cart-item" id="cart-item-<?= $item['id'] ?>">
              <!-- Image -->
              <a href="<?= APP_URL ?>/product/<?= $item['slug'] ?>" class="cart-item-img">
                <?php if (!empty($item['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <?php else: ?>
                  <div class="cart-no-img"><i class="ti ti-photo"></i></div>
                <?php endif; ?>
              </a>

              <!-- Details -->
              <div class="cart-item-details">
                <a href="<?= APP_URL ?>/product/<?= $item['slug'] ?>" class="cart-item-name">
                  <?= htmlspecialchars($item['name']) ?>
                </a>
                <?php if ($item['stock'] <= 5 && $item['stock'] > 0): ?>
                  <p class="cart-item-stock low"><i class="ti ti-alert-triangle"></i> Only <?= $item['stock'] ?> left</p>
                <?php else: ?>
                  <p class="cart-item-stock in"><i class="ti ti-circle-check"></i> In Stock</p>
                <?php endif; ?>
              </div>

              <!-- Quantity -->
              <div class="cart-item-qty">
                <form method="POST" action="<?= APP_URL ?>/cart?action=update" class="qty-form">
                  <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                  <div class="qty-control">
                    <button type="button" class="qty-btn cart-qty-minus">−</button>
                    <input
                      type="number"
                      name="quantity"
                      value="<?= $item['quantity'] ?>"
                      min="1"
                      max="<?= $item['stock'] ?>"
                      class="cart-qty-input"
                      data-product-id="<?= $item['id'] ?>"
                    >
                    <button type="button" class="qty-btn cart-qty-plus">+</button>
                  </div>
                </form>
              </div>

              <!-- Price -->
              <div class="cart-item-price">
                <span class="cart-item-unit"><?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?></span>
                <span class="cart-item-total" id="item-total-<?= $item['id'] ?>"><?= CURRENCY_SYMBOL . number_format($item['price'] * $item['quantity'], 2) ?></span>
              </div>

            <!-- Remove -->
            <a href="#" class="cart-remove" data-action="remove" data-id="<?= $item['id'] ?>">
                <i class="ti ti-x"></i>
            </a>
            </div>
          <?php endforeach; ?>

          <a href="<?= APP_URL ?>/shop" class="continue-shopping">
            <i class="ti ti-arrow-left"></i> Continue Shopping
          </a>
        </div>

        <!-- Order Summary -->
        <div class="cart-summary">
          <h3>Order Summary</h3>

          <div class="summary-lines">
            <div class="summary-line">
                <span>Subtotal</span>
                <span id="cart-subtotal"><?= CURRENCY_SYMBOL . number_format($subtotal, 2) ?></span>
            </div>
            <div class="summary-line">
                <span>Shipping</span>
                <span style="color:var(--success);">Calculated at checkout</span>
                </div>
          </div>

          <div class="summary-total-row">
            <span>Total</span>
            <span class="summary-total-amount" id="cart-total"><?= CURRENCY_SYMBOL . number_format($total, 2) ?></span>
          </div>

          <a href="<?= APP_URL ?>/checkout" class="btn btn-primary checkout-btn">
            Proceed to Checkout <i class="ti ti-arrow-right"></i>
          </a>

          <a href="<?= APP_URL ?>/shop" class="btn btn-secondary continue-btn">
            Continue Shopping
          </a>

          <div class="summary-security">
            <span><i class="ti ti-lock"></i> Secure encrypted checkout</span>
            <span><i class="ti ti-shield-check"></i> SSL Protected</span>
          </div>
        </div>

      </div>
    <?php endif; ?>

  </div>
</main>