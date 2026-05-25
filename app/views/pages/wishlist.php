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

      <div class="wishlist-card">
        <div class="wishlist-table-wrap">
          <table class="wishlist-main-table">
            <thead>
              <tr>
                <th></th>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($wishlistItems as $item): ?>
                <tr id="wishlist-item-<?= $item['id'] ?>">

                  <!-- Remove -->
                  <td class="wl-remove-cell">
                    <button class="wl-remove-btn wishlist-btn" data-id="<?= $item['id'] ?>" title="Remove">
                      <i class="ti ti-x"></i>
                    </button>
                  </td>

                  <!-- Product -->
                  <td class="wl-product-cell">
                    <div class="wl-product">
                      <?php if (!empty($item['image'])): ?>
                        <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="wl-img">
                      <?php else: ?>
                        <div class="wl-no-img"><i class="ti ti-photo"></i></div>
                      <?php endif; ?>
                      <a href="<?= APP_URL ?>/product/<?= htmlspecialchars($item['slug']) ?>">
                        <?= htmlspecialchars($item['name']) ?>
                      </a>
                    </div>
                  </td>

                  <!-- Price -->
                  <td class="wl-price">
                    <?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?>
                  </td>

                  <!-- Action -->
                  <td class="wl-action-cell">
                    <button class="wl-cart-btn add-to-cart-btn" data-id="<?= $item['id'] ?>">
                      <i class="ti ti-shopping-bag"></i> Add to Cart
                    </button>
                  </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    <?php endif; ?>

  </div>
</main>