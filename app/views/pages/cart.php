<main class="cart-page">
  <div class="container">

    <!-- Page Title -->
    <h1 class="cart-title">Cart</h1>

    <!-- Step Indicator -->
    <div class="cart-steps">
      <div class="cart-step active">
        <div class="step-num">1</div>
        <span class="step-label">Shopping cart</span>
      </div>
      <div class="step-line"></div>
      <div class="cart-step">
        <div class="step-num">2</div>
        <span class="step-label">Checkout details</span>
      </div>
      <div class="step-line"></div>
      <div class="cart-step">
        <div class="step-num">3</div>
        <span class="step-label">Order complete</span>
      </div>
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

          <!-- Table Header -->
          <div class="cart-table-header">
            <span class="col-product">Product</span>
            <span class="col-qty">Quantity</span>
            <span class="col-price">Price</span>
            <span class="col-subtotal">Subtotal</span>
          </div>

          <div class="cart-table-body">
            <?php foreach ($cartItems as $cartKey => $item): ?>
              <div class="cart-item" id="cart-item-<?= $cartKey ?>">

                <!-- Product col -->
                <div class="cart-item-product">
                  <a href="<?= APP_URL ?>/product/<?= $item['slug'] ?>" class="cart-item-img">
                    <?php if (!empty($item['image'])): ?>
                      <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <?php else: ?>
                      <div class="cart-no-img"><i class="ti ti-photo"></i></div>
                    <?php endif; ?>
                  </a>
                  <div class="cart-item-info">
                    <a href="<?= APP_URL ?>/product/<?= $item['slug'] ?>" class="cart-item-name">
                      <?= htmlspecialchars($item['name']) ?>
                    </a>

                    <?php if (!empty($item['variant_label'])): ?>
                      <p style="font-size:12px;color:var(--gold);margin-top:3px;">
                        <?= htmlspecialchars($item['variant_label']) ?>
                      </p>
                    <?php endif; ?>

                    <?php if ($item['stock'] <= 5 && $item['stock'] > 0): ?>
                      <p class="cart-item-stock low"><i class="ti ti-alert-triangle"></i> <?= $item['stock'] ?> left</p>
                    <?php else: ?>
                      <p class="cart-item-stock in"><i class="ti ti-circle-check"></i> In Stock</p>
                    <?php endif; ?>

                    <a href="#" class="cart-remove-link cart-remove" data-id="<?= $item['id'] ?>" data-variant-id="<?= $item['variant_id'] ?? '' ?>" data-cart-key="<?= $cartKey ?>">
                      <i class="ti ti-x"></i> Remove
                    </a>
                  </div>
                </div>

                <!-- Quantity col -->
                <div class="cart-item-qty">
                  <form method="POST" action="<?= APP_URL ?>/cart?action=update" class="qty-form">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="variant_id" value="<?= $item['variant_id'] ?? '' ?>">
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
                        data-variant-id="<?= $item['variant_id'] ?? '' ?>"
                        data-cart-key="<?= $cartKey ?>"
                      >
                      <button type="button" class="qty-btn cart-qty-plus">+</button>
                    </div>
                  </form>
                </div>

                <!-- Price col -->
                <div class="cart-item-price">
                  <?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?>
                </div>

                <!-- Subtotal col -->
                <div class="cart-item-subtotal" id="item-total-<?= $cartKey ?>">
                  <?= CURRENCY_SYMBOL . number_format($item['price'] * $item['quantity'], 2) ?>
                </div>

              </div>
            <?php endforeach; ?>
          </div>

          <!-- Table Footer -->
          <div class="cart-table-footer">
            <a href="<?= APP_URL ?>/shop?category=" class="continue-shopping">
              <i class="ti ti-arrow-left"></i> Continue Shopping
            </a>
            <a href="#" class="clear-cart-link" id="clearCartBtn">
              <i class="ti ti-trash"></i> Clear All
            </a>
          </div>

        </div>

        <!-- Order Summary (unchanged style) -->
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

          <div class="summary-security">
            <span><i class="ti ti-lock"></i> Secure encrypted checkout</span>
            <span><i class="ti ti-shield-check"></i> SSL Protected</span>
          </div>
        </div>

      </div>
    <?php endif; ?>

  </div>
</main>