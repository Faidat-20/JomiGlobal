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
      <span><?= htmlspecialchars($currentProduct['name']) ?></span>
    </div>

    <!-- Product Detail -->
    <div class="product-detail">

      <!-- Image Section -->
      <div class="product-images">
        <div class="product-main-image">
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
            <span class="product-badge sale">Sale</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Info Section -->
      <div class="product-info">

        <!-- Category & Brand -->
        <div class="product-meta">
          <span class="product-category"><?= htmlspecialchars($currentProduct['category_name'] ?? '') ?></span>
          <?php if ($currentProduct['brand']): ?>
            <span class="product-brand"><?= htmlspecialchars($currentProduct['brand']) ?></span>
          <?php endif; ?>
        </div>

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
            <span class="stock-in"><i class="ti ti-check"></i> In Stock</span>
          <?php endif; ?>
        </div>

        <!-- Description -->
        <?php if ($currentProduct['description']): ?>
          <div class="product-description">
            <p><?= nl2br(htmlspecialchars($currentProduct['description'])) ?></p>
          </div>
        <?php endif; ?>

        <!-- Add to Cart -->
        <?php if ($currentProduct['stock'] > 0): ?>
          <div class="product-actions">
            <div class="quantity-picker">
              <button type="button" class="qty-btn" id="qtyMinus">−</button>
              <input type="number" id="productQty" value="1" min="1" max="<?= $currentProduct['stock'] ?>">
              <button type="button" class="qty-btn" id="qtyPlus">+</button>
            </div>
            <button
              class="btn btn-primary add-to-cart-btn"
              data-id="<?= $currentProduct['id'] ?>"
              id="addToCartBtn"
            >
              <i class="ti ti-shopping-bag"></i> Add to Cart
            </button>
            <button class="btn btn-secondary wishlist-btn">
              <i class="ti ti-heart"></i>
            </button>
          </div>
        <?php else: ?>
          <button class="btn btn-secondary" disabled style="opacity:0.5;cursor:not-allowed;width:100%;">
            Out of Stock
          </button>
        <?php endif; ?>

        <!-- Product Details -->
        <div class="product-details-table">
          <?php if ($currentProduct['sku']): ?>
            <div class="detail-row">
              <span>SKU</span>
              <span><?= htmlspecialchars($currentProduct['sku']) ?></span>
            </div>
          <?php endif; ?>
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
            <span><?= $currentProduct['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?></span>
          </div>
        </div>

      </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
      <div class="related-products">
        <h2 class="section-title reveal">You May Also Like</h2>
        <div class="products-grid">
          <?php foreach ($relatedProducts as $p): ?>
            <a href="<?= APP_URL ?>/product/<?= $p['slug'] ?>" class="product-card reveal">
              <div class="product-card-image">
                <?php if (!empty($p['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                <?php else: ?>
                  <div class="product-no-image"><i class="ti ti-photo"></i></div>
                <?php endif; ?>
                <div class="product-card-actions">
                  <button class="product-action-btn"><i class="ti ti-eye"></i></button>
                  <button class="product-action-btn"><i class="ti ti-heart"></i></button>
                  <button class="product-action-btn add-to-cart-btn" data-id="<?= $p['id'] ?>"><i class="ti ti-shopping-bag"></i></button>
                </div>
              </div>
              <div class="product-card-info">
                <p class="product-category"><?= htmlspecialchars($p['category_name']) ?></p>
                <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
                <div class="product-price">
                  <?php if ($p['sale_price']): ?>
                    <span class="price-original"><?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?></span>
                    <span class="price-sale"><?= CURRENCY_SYMBOL . number_format($p['sale_price'], 2) ?></span>
                  <?php else: ?>
                    <span class="price-regular"><?= CURRENCY_SYMBOL . number_format($p['price'], 2) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>