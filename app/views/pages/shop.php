<main class="shop-page">

  <!-- Shop Header -->
  <div class="shop-header">
    <div class="container">
      <div class="shop-header-content">
        <div>
          <p class="section-label"><?= $currentCategory ? 'Category' : 'All Products' ?></p>
          <h1 class="shop-title"><?= htmlspecialchars($pageTitle) ?></h1>
        </div>
        <!-- Breadcrumb -->
        <div class="breadcrumb">
          <a href="<?= APP_URL ?>">Home</a>
          <span>/</span>
          <a href="<?= APP_URL ?>/shop">Shop</a>
          <?php if ($currentCategory): ?>
            <span>/</span>
            <span><?= htmlspecialchars($currentCategory['name']) ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="shop-layout">

      <!-- Sidebar -->
      <aside class="shop-sidebar">

        <!-- Categories -->
        <div class="sidebar-section">
          <h3 class="sidebar-title">Categories</h3>
          <ul class="sidebar-list">
            <li>
              <a href="<?= APP_URL ?>/shop" class="<?= !$currentCategory ? 'active' : '' ?>">
                All Products
              </a>
            </li>
            <?php foreach ($allCategories as $cat): ?>
              <li>
                <a href="<?= APP_URL ?>/shop?category=<?= $cat['slug'] ?>" class="<?= ($currentCategory && $currentCategory['id'] == $cat['id']) ? 'active' : '' ?>">
                  <?= htmlspecialchars($cat['name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Subcategories -->
        <?php if (!empty($subcategoriesForSidebar)): ?>
          <div class="sidebar-section">
            <h3 class="sidebar-title">Filter by Type</h3>
            <ul class="sidebar-list">
              <?php foreach ($subcategoriesForSidebar as $sub): ?>
                <li><a href="<?= APP_URL ?>/shop?category=<?= $currentCategory['slug'] ?>&subcategory=<?= $sub['slug'] ?>" class="<?= ($currentSubcategory && $currentSubcategory['id'] == $sub['id']) ? 'active' : '' ?>"><?= htmlspecialchars($sub['name']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

       
      </aside>

      <!-- Products -->
      <div class="shop-main">

        <!-- Sort Bar -->
        <div class="shop-toolbar">
          <form method="GET" action="<?= APP_URL ?>/shop" class="toolbar-price-filter">
            <?php if ($currentCategory): ?>
              <input type="hidden" name="category" value="<?= $currentCategory['slug'] ?>">
            <?php endif; ?>
            <input type="number" name="min_price" placeholder="Min ₦" value="<?= $minPrice ?? '' ?>" style="width:80px;padding:8px 10px;border:1px solid #e0e0e0;border-radius:8px;font-size:13px;outline:none;">
            <span>—</span>
            <input type="number" name="max_price" placeholder="Max ₦" value="<?= $maxPrice ?? '' ?>" style="width:80px;padding:8px 10px;border:1px solid #e0e0e0;border-radius:8px;font-size:13px;outline:none;">
            <button type="submit" class="btn btn-primary" style="padding:8px 16px;font-size:12px;">Apply</button>
          </form>
          <div class="sort-wrapper">
            <label>Sort by:</label>
            <select onchange="window.location=this.value" class="sort-select">
              <option value="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['sort' => 'newest'])) ?>" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
              <option value="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['sort' => 'price_asc'])) ?>" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
              <option value="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['sort' => 'price_desc'])) ?>" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
              <option value="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['sort' => 'name_asc'])) ?>" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name: A–Z</option>
            </select>
          </div>
        </div>

        <!-- Product Grid -->
        <?php if (empty($products)): ?>
          <div class="shop-empty">
            <i class="ti ti-package"></i>
            <h3>No products found</h3>
            <p>Try adjusting your filters or browse all products</p>
            <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Browse All</a>
          </div>
        <?php else: ?>
          <div class="products-grid">
            <?php foreach ($products as $p): ?>
              <a href="<?= APP_URL ?>/product/<?= $p['slug'] ?>" class="product-card reveal">

                <!-- Image -->
                <div class="product-card-image">
                  <?php if (!empty($p['image'])): ?>
                    <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                  <?php else: ?>
                    <div class="product-no-image">
                      <i class="ti ti-photo"></i>
                    </div>
                  <?php endif; ?>

                  <?php if ($p['sale_price']): ?>
                    <span class="product-badge sale">Sale</span>
                  <?php endif; ?>

                  <?php if ($p['is_featured']): ?>
                    <span class="product-badge featured">Featured</span>
                  <?php endif; ?>

                  <div class="product-card-actions">
                    <button class="product-action-btn" title="Quick View">
                      <i class="ti ti-eye"></i>
                    </button>
                    <button class="product-action-btn" title="Add to Wishlist">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="product-action-btn add-to-cart-btn" title="Add to Cart" data-id="<?= $p['id'] ?>">
                      <i class="ti ti-shopping-bag"></i>
                    </button>
                  </div>
                </div>

                <!-- Info -->
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
                  <?php if ($p['stock'] <= 0): ?>
                    <p class="out-of-stock">Out of Stock</p>
                  <?php endif; ?>
                </div>

              </a>
            <?php endforeach; ?>
          </div>

          <!-- Pagination -->
          <?php if ($totalPages > 1): ?>
            <div class="pagination">
              <?php if ($page > 1): ?>
                <a href="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" class="page-btn">
                  <i class="ti ti-chevron-left"></i>
                </a>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                
                  href="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                  class="page-btn <?= $i === $page ? 'active' : '' ?>"
                >
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($page < $totalPages): ?>
                <a href="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" class="page-btn">
                  <i class="ti ti-chevron-right"></i>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        <?php endif; ?>
      </div>
    </div>
  </div>

</main>