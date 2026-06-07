<main class="category-page">

  <!-- Header -->
  <div class="category-hero">
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>"><?= htmlspecialchars($category['name']) ?></a>
        <?php if (isset($group)): ?>
          <span>/</span>
          <?php if (isset($subcategory)): ?>
            <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>"><?= htmlspecialchars($group['name']) ?></a>
          <?php else: ?>
             <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>"><?= htmlspecialchars($group['name']) ?></a>
          <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($subcategory)): ?>
          <span>/</span>
          <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>/<?= $subcategory['slug'] ?>"><?= htmlspecialchars($subcategory['name']) ?></a>
        <?php endif; ?>
      </div>
      <h1 class="category-hero-title">
        <?= isset($subcategory) ? htmlspecialchars($subcategory['name']) : htmlspecialchars($group['name']) ?>
      </h1>
    </div>
  </div>

  <div class="container" style="padding:48px 24px;">

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
        <p style="font-size:13px;color:var(--text-grey);"><?= count($products) ?> products</p>
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
          <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Browse All</a>
        </div>
      <?php else: ?>
        <div class="products-grid">
          <?php foreach ($products as $p): ?>
            <a href="<?= APP_URL ?>/product/<?= $p['slug'] ?>" class="product-card reveal">
              <div class="product-card-image">
                <?php if (!empty($p['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                <?php else: ?>
                  <div class="product-no-image"><i class="ti ti-photo"></i></div>
                <?php endif; ?>
                <?php if ($p['sale_price']): ?>
                  <span class="product-badge sale">Sale</span>
                <?php endif; ?>
                <div class="product-card-actions">
                  <a href="<?= APP_URL ?>/product/<?= $p['slug'] ?>" class="product-action-btn"><i class="ti ti-eye"></i></a>
                  <button class="product-action-btn wishlist-btn" data-id="<?= $p['id'] ?>"><i class="ti ti-heart"></i></button>
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
      <?php endif; ?>
    <?php endif; ?>

  </div>
</main>