<main class="category-page">

  <!-- Header -->
  <div class="category-hero">
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/collections">Collections</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>"><?= htmlspecialchars($collection['name']) ?></a>
      </div>
      <h1 class="category-hero-title"><?= htmlspecialchars($collection['name']) ?></h1>
      <?php if ($collection['description']): ?>
        <p style="color:#a0a0a0;margin-top:12px;font-size:15px;position:relative;z-index:1;">
          <?= htmlspecialchars($collection['description']) ?>
        </p>
      <?php endif; ?>
    </div>
  </div>

  <div class="container" style="padding-bottom:80px;">

    <!-- Toolbar -->
    <div class="shop-toolbar">
      <p style="font-size:13px;color:var(--text-grey);">
        <?= count($products) ?> product<?= count($products) !== 1 ? 's' : '' ?>
      </p>
      <div class="sort-wrapper">
        <label>Sort by:</label>
        <select onchange="window.location=this.value" class="sort-select">
          <option value="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>?sort=newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
          <option value="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>?sort=price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
          <option value="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>?sort=price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
          <option value="<?= APP_URL ?>/collections/<?= $collection['slug'] ?>?sort=name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name: A–Z</option>
        </select>
      </div>
    </div>

    <!-- Products -->
    <?php if (empty($products)): ?>
      <div class="shop-empty">
        <i class="ti ti-package"></i>
        <h3>No products in this collection yet</h3>
        <p>Check back soon or browse all products</p>
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

  </div>
</main>