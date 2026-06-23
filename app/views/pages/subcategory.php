<main class="category-page">

  <!-- Header -->
  <div class="category-hero">
    <div class="header-banner-bg">
      <img src="<?= APP_URL ?>/uploads/product_6a3514a3c7c6a.png" alt="" class="header-banner-img" id="headerBannerImg">
    </div>
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>"><?= htmlspecialchars($category['name']) ?></a>
        <?php if (isset($group)): ?>
          <span>/</span>
          <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>"><?= htmlspecialchars($group['name']) ?></a>
        <?php endif; ?>
        <?php if (isset($subcategory) && empty($isLeafGroup)): ?>
          <span>/</span>
          <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $subcategory['slug'] ?>"><?= htmlspecialchars($subcategory['name']) ?></a>
        <?php endif; ?>
      </div>
      <h1 class="category-hero-title">
        <?= isset($subcategory) ? htmlspecialchars($subcategory['name']) : htmlspecialchars($group['name']) ?>
      </h1>
    </div>
  </div>

  <div class="container" style="padding:24px 24px 80px;">

    <?php if (isset($subcategories)): ?>
      <!-- Show subcategory grid -->
      <div class="subcategory-grid">
        <?php foreach ($subcategories as $sub): ?>
          
          <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $sub['slug'] ?>"
            class="subcategory-card reveal"
          >
            <div class="subcategory-card-icon">
              <i class="ti ti-diamond"></i>
            </div>
            <h3><?= htmlspecialchars($sub['name']) ?></h3>
            <span>Shop Now <i class="ti ti-arrow-right"></i></span>
          </a>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <!-- Show products -->
      <div class="shop-toolbar">
      <form method="GET" action="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>" class="toolbar-price-filter">
        <input type="number" name="min_price" placeholder="Min ₦" value="<?= $minPrice ?? '' ?>" style="width:80px;padding:8px 10px;border:1px solid #e0e0e0;border-radius:8px;font-size:13px;outline:none;">
        <span>—</span>
        <input type="number" name="max_price" placeholder="Max ₦" value="<?= $maxPrice ?? '' ?>" style="width:80px;padding:8px 10px;border:1px solid #e0e0e0;border-radius:8px;font-size:13px;outline:none;">
        <button type="submit" class="btn btn-primary" style="padding:8px 16px;font-size:12px;">Apply</button>
      </form>
        <div class="sort-wrapper">
          <label>Sort by:</label>
          <select onchange="window.location=this.value" class="sort-select">
            <option value="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $subcategory['slug'] ?>?sort=newest" <?= ($sort ?? 'newest') === 'newest' ? 'selected' : '' ?>>Newest</option>
            <option value="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $subcategory['slug'] ?>?sort=price_asc" <?= ($sort ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
            <option value="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $subcategory['slug'] ?>?sort=price_desc" <?= ($sort ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
          </select>
        </div>
      </div>

      <?php if (empty($products)): ?>
        <div class="shop-empty">
          <i class="ti ti-package"></i>
          <h3>No products yet</h3>
          <p>Check back soon!</p>
          <a href="<?= APP_URL ?>/shop?category=" class="btn-browse-all">
            <div class="btn-browse-all-line"></div>
            <span class="btn-browse-all-text">Browse All</span>
            <div class="btn-browse-all-line"></div>
          </a>
        </div>
      <?php else: ?>
        <div class="products-grid">
          <?php foreach ($products as $p): ?>
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
      <?php endif; ?>
    <?php endif; ?>

  </div>
</main>