<main class="shop-page">

  <!-- Shop Header -->
  <div class="shop-header">
    <div class="header-banner-bg">
      <img src="<?= APP_URL ?>/uploads/product_6a3514a3c7c6a.png" alt="" class="header-banner-img" id="headerBannerImg">
    </div>
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

      <!-- Mobile Filter Toggle -->
      <button class="shop-filter-toggle" id="filterToggle">
        <i class="ti ti-adjustments-horizontal"></i> Filter & Categories
      </button>

      <!-- Sidebar -->
      <aside class="shop-sidebar">

        <!-- Categories -->
        <div class="sidebar-section">
          <h3 class="sidebar-title">Categories</h3>
          <ul class="sidebar-list">
            <li>
              <a href="<?= APP_URL ?>/shop?category=" class="<?= !$currentCategory ? 'active' : '' ?>">
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
            <div class="sidebar-accordion-header" id="subcatToggle">
              <h3 class="sidebar-title" style="margin-bottom:0;">Filter by Type</h3>
              <i class="ti ti-chevron-down sidebar-accordion-icon"></i>
            </div>
            <?php
              // Group subcategories by parent
              $parents = [];
              $children = [];
              foreach ($subcategoriesForSidebar as $sub) {
                if (is_null($sub['parent_id'])) {
                  $parents[] = $sub;
                } else {
                  $children[$sub['parent_id']][] = $sub;
                }
              }
            ?>
            <ul class="sidebar-list sidebar-accordion-body" id="subcatList">
              <?php foreach ($parents as $parent): ?>
                <?php if (!empty($children[$parent['id']])): ?>
                  <!-- Has children -> collapsible dropdown -->
                  <li class="sidebar-subgroup">
                    <details>
                      <summary><?= htmlspecialchars($parent['name']) ?></summary>
                      <ul class="sidebar-subgroup-list">
                        <?php foreach ($children[$parent['id']] as $child): ?>
                          <li>
                            <a href="<?= APP_URL ?>/shop?category=<?= $currentCategory['slug'] ?>&subcategory=<?= $child['slug'] ?>"
                              class="<?= ($currentSubcategory && $currentSubcategory['id'] == $child['id']) ? 'active' : '' ?>">
                              <?= htmlspecialchars($child['name']) ?>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </details>
                  </li>
                <?php else: ?>
                  <!-- No children -> normal link -->
                  <li>
                    <a href="<?= APP_URL ?>/shop?category=<?= $currentCategory['slug'] ?>&subcategory=<?= $parent['slug'] ?>"
                      class="<?= ($currentSubcategory && $currentSubcategory['id'] == $parent['id']) ? 'active' : '' ?>">
                      <?= htmlspecialchars($parent['name']) ?>
                    </a>
                  </li>
                <?php endif; ?>
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
                  <?php if ($p['stock'] <= 0): ?>
                    <p class="pc-out-of-stock">Out of Stock</p>
                  <?php endif; ?>
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
          <?php if ($totalPages > 1): ?>
            <div class="pagination">
              <?php if ($page > 1): ?>
                <a href="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" class="page-btn">
                  <i class="ti ti-chevron-left"></i>
                </a>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                
                <a href="<?= APP_URL ?>/shop?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
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