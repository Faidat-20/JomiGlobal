<main class="search-page">
  <div class="container">

    <!-- Search Header -->
    <div class="search-page-header">
      <h1>Search</h1>
      <form method="GET" action="<?= APP_URL ?>/search" class="search-page-form">
        <div class="search-page-input-wrapper">
          <i class="ti ti-search"></i>
          <input
            type="text"
            name="q"
            placeholder="Search for jewelry, perfume, glasses..."
            value="<?= htmlspecialchars($query) ?>"
            autofocus
          >
          <?php if ($query): ?>
            <a href="<?= APP_URL ?>/search" class="search-clear">
              <i class="ti ti-x"></i>
            </a>
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
    </div>

    <?php if (!empty($query)): ?>

      <!-- Results Header -->
      <div class="search-results-header">
        <p class="search-results-count">
          <?php if ($totalResults > 0): ?>
            <strong><?= $totalResults ?></strong> result<?= $totalResults !== 1 ? 's' : '' ?> for "<strong><?= htmlspecialchars($query) ?></strong>"
          <?php else: ?>
            No results for "<strong><?= htmlspecialchars($query) ?></strong>"
          <?php endif; ?>
        </p>

        <!-- Filters -->
        <div class="search-filters">
          <div class="search-filter-categories">
            <a href="<?= APP_URL ?>/search?q=<?= urlencode($query) ?>" class="filter-tag <?= !$category ? 'active' : '' ?>">All</a>
            <?php foreach ($allCategories as $cat): ?>
              <a href="<?= APP_URL ?>/search?q=<?= urlencode($query) ?>&category=<?= $cat['slug'] ?>" class="filter-tag <?= $category === $cat['slug'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['name']) ?>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="sort-wrapper">
            <label>Sort by:</label>
            <select onchange="window.location=this.value" class="sort-select">
              <option value="<?= APP_URL ?>/search?q=<?= urlencode($query) ?>&sort=newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
              <option value="<?= APP_URL ?>/search?q=<?= urlencode($query) ?>&sort=price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
              <option value="<?= APP_URL ?>/search?q=<?= urlencode($query) ?>&sort=price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
            </select>
          </div>
        </div>
      </div>

      <?php if (empty($products)): ?>
        <div class="search-empty">
          <i class="ti ti-search-off"></i>
          <h3>No products found</h3>
          <p>Try different keywords or browse our categories</p>
          <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:24px;">
            <a href="<?= APP_URL ?>/category/jewelry" class="btn btn-secondary">Jewelry</a>
            <a href="<?= APP_URL ?>/category/perfume" class="btn btn-secondary">Perfume</a>
            <a href="<?= APP_URL ?>/category/glasses" class="btn btn-secondary">Glasses</a>
          </div>
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

        <!-- Pagination -->
        <?php
          $baseUrl = APP_URL . '/search?q=' . urlencode($query);
          if ($category) $baseUrl .= '&category=' . urlencode($category);
          if ($sort)     $baseUrl .= '&sort='     . urlencode($sort);
        ?>
        <?php if ($totalPages > 1): ?>
          <div class="pagination">

            <?php if ($page > 1): ?>
              <a href="<?= $baseUrl ?>&page=<?= $page - 1 ?>" class="page-btn">
                <i class="ti ti-chevron-left"></i>
              </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a href="<?= $baseUrl ?>&page=<?= $i ?>"
                class="page-btn <?= $i === $page ? 'active' : '' ?>"
              ><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <a href="<?= $baseUrl ?>&page=<?= $page + 1 ?>" class="page-btn">
                <i class="ti ti-chevron-right"></i>
              </a>
            <?php endif; ?>

          </div>
        <?php endif; ?>

      <?php endif; ?>

    <?php else: ?>
      <!-- Empty Search State -->
      <div class="search-suggestions">
        <h3>Popular Categories</h3>
        <div class="suggestion-categories">
          <a href="<?= APP_URL ?>/category/jewelry" class="suggestion-card">
            <i class="ti ti-diamond"></i>
            <span>Jewelry</span>
          </a>
          <a href="<?= APP_URL ?>/category/perfume" class="suggestion-card">
            <i class="ti ti-bottle"></i>
            <span>Perfume</span>
          </a>
          <a href="<?= APP_URL ?>/category/glasses" class="suggestion-card">
            <i class="ti ti-eyeglass"></i>
            <span>Glasses</span>
          </a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>