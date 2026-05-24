<main class="wishlist-page">
  <div class="container">

    <div class="wishlist-header">
      <div>
        <h1>My Wishlist</h1>
        <p><?= count($wishlistItems) ?> item<?= count($wishlistItems) !== 1 ? 's' : '' ?> saved</p>
      </div>
      <?php if (!empty($wishlistItems)): ?>
        <a href="<?= APP_URL ?>/wishlist?action=clear" class="wishlist-clear-btn" onclick="return confirm('Clear your wishlist?')">
          <i class="ti ti-trash"></i> Clear All
        </a>
      <?php endif; ?>
    </div>

    <?php if (empty($wishlistItems)): ?>
      <div class="wishlist-empty">
        <div class="wishlist-empty-icon">
          <i class="ti ti-heart"></i>
        </div>
        <h2>Your wishlist is empty</h2>
        <p>Save items you love and come back to them anytime.</p>
        <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Explore Products</a>
      </div>

    <?php else: ?>
      <div class="products-grid wishlist-grid">
        <?php foreach ($wishlistItems as $item): ?>
          <div class="product-card" id="wishlist-item-<?= $item['id'] ?>">
            <a href="<?= APP_URL ?>/product/<?= htmlspecialchars($item['slug']) ?>">

              <!-- Image -->
              <div class="product-card-image">
                <?php if (!empty($item['image'])): ?>
                  <img
                    src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>"
                    alt="<?= htmlspecialchars($item['name']) ?>"
                  >
                <?php else: ?>
                  <div class="product-no-image">
                    <i class="ti ti-photo"></i>
                  </div>
                <?php endif; ?>

                <div class="product-card-actions">
                  <a href="<?= APP_URL ?>/product/<?= $item['slug'] ?>" 
                      class="product-action-btn" 
                      title="View Product"
                      onclick="event.stopPropagation()">
                      <i class="ti ti-eye"></i>
                  </a>
                  <button
                    class="product-action-btn wishlist-btn"
                    data-id="<?= $item['id'] ?>"
                    title="Remove from Wishlist"
                    style="background:var(--mustard);color:var(--ash);"
                    onclick="event.preventDefault();event.stopPropagation();"
                  >
                    <i class="ti ti-heart"></i>
                  </button>
                  <button
                    class="product-action-btn add-to-cart-btn"
                    data-id="<?= $item['id'] ?>"
                    title="Add to Cart"
                    onclick="event.preventDefault();event.stopPropagation();"
                  >
                    <i class="ti ti-shopping-bag"></i>
                  </button>
                </div>
              </div>

            </a>

            <!-- Info -->
            <div class="product-card-info">
              <?php if (!empty($item['category_name'])): ?>
                <p class="product-category"><?= htmlspecialchars($item['category_name']) ?></p>
              <?php endif; ?>
              <a href="<?= APP_URL ?>/product/<?= htmlspecialchars($item['slug']) ?>">
                <h3 class="product-name"><?= htmlspecialchars($item['name']) ?></h3>
              </a>
              <div class="product-price">
                <span class="price-regular"><?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</main>