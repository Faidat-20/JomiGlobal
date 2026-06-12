<main class="product-page">
  <div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb product-breadcrumb">
      <a href="<?= APP_URL ?>">Home</a>
      <span>/</span>
      <a href="<?= APP_URL ?>/shop">Shop</a>
      <span>/</span>
      <a href="<?= APP_URL ?>/shop?category=<?= $currentProduct['category_name'] ? strtolower($currentProduct['category_name']) : '' ?>">
        <?= htmlspecialchars($currentProduct['category_name'] ?? '') ?>
      </a>
      <span>/</span>
      <span class="breadcrumb-current"><?= htmlspecialchars($currentProduct['name']) ?></span>
    </div>

    <!-- Product Detail -->
    <div class="product-detail">

      <!-- Image Section -->
      <div class="product-images">
        <div class="product-main-image">
          <div class="pd-img-corner pd-tl"></div>
          <div class="pd-img-corner pd-br"></div>
          <?php if (!empty($currentProduct['image'])): ?>
            <img
              src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($currentProduct['image']) ?>"
              alt="<?= htmlspecialchars($currentProduct['name']) ?>"
              id="mainProductImage"
            >
          <?php else: ?>
            <div class="product-no-image">
              <i class="ti ti-photo"></i>
            </div>
          <?php endif; ?>
          <?php if ($currentProduct['sale_price']): ?>
            <span class="pd-badge sale">Sale</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Info Section -->
      <div class="product-info">

        <!-- Category label with line -->
        <p class="pd-cat-label">
          <?= htmlspecialchars($currentProduct['category_name'] ?? '') ?>
          <?php if ($currentProduct['brand']): ?>
            &nbsp;·&nbsp; <?= htmlspecialchars($currentProduct['brand']) ?>
          <?php endif; ?>
        </p>

        <!-- Name -->
        <h1 class="product-detail-name"><?= htmlspecialchars($currentProduct['name']) ?></h1>

        <!-- Price -->
        <div class="product-detail-price">
          <?php if ($currentProduct['sale_price']): ?>
            <span class="price-original-lg"><?= CURRENCY_SYMBOL . number_format($currentProduct['price'], 2) ?></span>
            <span class="price-sale-lg"><?= CURRENCY_SYMBOL . number_format($currentProduct['sale_price'], 2) ?></span>
          <?php else: ?>
            <span class="price-regular-lg"><?= CURRENCY_SYMBOL . number_format($currentProduct['price'], 2) ?></span>
          <?php endif; ?>
        </div>

        <!-- Stock -->
        <div class="product-stock">
          <?php if ($currentProduct['stock'] <= 0): ?>
            <span class="stock-out"><i class="ti ti-x"></i> Out of Stock</span>
          <?php elseif ($currentProduct['stock'] <= 5): ?>
            <span class="stock-low"><i class="ti ti-alert-triangle"></i> Only <?= $currentProduct['stock'] ?> left</span>
          <?php else: ?>
            <span class="stock-in"><i class="ti ti-circle-check"></i> In Stock</span>
          <?php endif; ?>
        </div>

        <!-- Divider -->
        <div class="pd-divider"></div>

        <!-- Description -->
        <?php if ($currentProduct['description']): ?>
          <div class="product-description">
            <p><?= nl2br(htmlspecialchars($currentProduct['description'])) ?></p>
          </div>
        <?php endif; ?>

        <!-- Actions -->
        <?php if ($currentProduct['stock'] > 0): ?>
          <div class="product-actions">
            <div class="pd-qty-row">
              <span class="pd-qty-label">Quantity</span>
              <div class="pd-qty-controls">
                <button type="button" class="pd-qty-btn" id="qtyMinus">−</button>
                <input type="number" id="productQty" value="1" min="1" max="<?= $currentProduct['stock'] ?>" class="pd-qty-input">
                <button type="button" class="pd-qty-btn" id="qtyPlus">+</button>
              </div>
            </div>
            <div class="pd-btns-row">
              <button class="pd-btn-cart add-to-cart-btn" data-id="<?= $currentProduct['id'] ?>" id="addToCartBtn">
                <i class="ti ti-shopping-bag"></i> Add to Cart
              </button>
              <button class="pd-btn-wish wishlist-btn" data-id="<?= $currentProduct['id'] ?>">
                <i class="ti ti-heart"></i> Save to Wishlist
              </button>
            </div>
          </div>
        <?php else: ?>
          <button class="pd-btn-disabled" disabled>
            Out of Stock
          </button>
        <?php endif; ?>

        <!-- Meta Table -->
        <div class="product-details-table">
          <?php if ($currentProduct['brand']): ?>
            <div class="detail-row">
              <span>Brand</span>
              <span><?= htmlspecialchars($currentProduct['brand']) ?></span>
            </div>
          <?php endif; ?>
          <div class="detail-row">
            <span>Category</span>
            <span><?= htmlspecialchars($currentProduct['category_name'] ?? '') ?></span>
          </div>
          <div class="detail-row">
            <span>Availability</span>
            <span class="<?= $currentProduct['stock'] > 0 ? 'stock-in' : 'stock-out' ?>">
              <?= $currentProduct['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
            </span>
          </div>
        </div>

      </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
      <div class="related-products">
        <div class="pd-related-header">
          <span class="pd-related-label">You May Also Like</span>
          <div class="pd-related-divider"></div>
        </div>
        <div class="products-grid">
          <?php foreach ($relatedProducts as $p): ?>

            <a href="<?= APP_URL ?>/product/<?= $p['slug'] ?>" class="product-card reveal">

              <div class="card-corner c-tl"></div>
              <div class="card-corner c-tr"></div>

              <?php if ($p['sale_price']): ?>
                <span class="card-badge sale">Sale</span>
              <?php elseif ($p['is_featured']): ?>
                <span class="card-badge">Featured</span>
              <?php endif; ?>

              <div class="card-img-wrap">
                <?php if (!empty($p['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                       alt="<?= htmlspecialchars($p['name']) ?>">
                <?php else: ?>
                  <div class="card-img-placeholder">
                    <i class="ti ti-photo"></i>
                  </div>
                <?php endif; ?>
              </div>

              <div class="card-actions">
                <button class="action-btn" title="Quick View">
                  <i class="ti ti-eye"></i>
                </button>
                <button class="action-btn wishlist-btn" data-id="<?= $p['id'] ?>" title="Wishlist">
                  <i class="ti ti-heart"></i>
                </button>
              </div>

              <div class="card-divider"></div>

              <div class="card-info">
                <p class="card-cat"><?= htmlspecialchars($p['category_name']) ?></p>
                <h3 class="card-name"><?= htmlspecialchars($p['name']) ?></h3>
                <div class="card-price-row">
                  <div>
                    <?php if ($p['sale_price']): ?>
                      <span class="card-price-old"><?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?></span>
                      <span class="card-price" style="color:var(--gold);"><?= CURRENCY_SYMBOL . number_format($p['sale_price'], 2) ?></span>
                    <?php else: ?>
                      <span class="card-price"><?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?></span>
                    <?php endif; ?>
                  </div>
                  <button class="card-add add-to-cart-btn" data-id="<?= $p['id'] ?>" title="Add to Cart">
                    <i class="ti ti-shopping-bag"></i>
                  </button>
                </div>
              </div>

            </a>

          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>