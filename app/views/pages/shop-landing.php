<main class="category-page">

  <div class="category-hero">
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/shop">Shop</a>
      </div>
      <h1 class="category-hero-title">Shop</h1>
      <p style="color:#a0a0a0;margin-top:12px;font-size:15px;position:relative;z-index:1;">
        Explore our luxury collections of jewelry, perfume and glasses
      </p>
    </div>
  </div>

  <div class="container" style="padding-bottom:80px;padding-top:48px;">

    <div class="categories-grid">
      <?php
        $catIcons = [
          'jewelry' => ['icon' => 'ti-diamond', 'bg' => 'cat-bg-1'],
          'perfume' => ['icon' => 'ti-bottle',  'bg' => 'cat-bg-2'],
          'glasses' => ['icon' => 'ti-eyeglass','bg' => 'cat-bg-3'],
        ];
      ?>
      <?php foreach ($categories as $cat):
        $meta = $catIcons[$cat['slug']] ?? ['icon' => 'ti-diamond', 'bg' => 'cat-bg-1'];
      ?>
        <a href="<?= APP_URL ?>/category/<?= $cat['slug'] ?>" class="cat-card reveal">

          <?php if (!empty($cat['image'])): ?>
            <div class="cat-card-bg" style="background:none;">
              <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($cat['image']) ?>"
                   class="cat-card-img" alt="<?= htmlspecialchars($cat['name']) ?>">
            </div>
          <?php else: ?>
            <div class="cat-card-bg <?= $meta['bg'] ?>"></div>
          <?php endif; ?>

          <div class="cat-corner tl"></div>
          <div class="cat-corner tr"></div>
          <div class="cat-corner bl"></div>
          <div class="cat-corner br"></div>

          <div class="cat-card-inner">
            <div class="cat-icon-wrap">
              <i class="ti <?= $meta['icon'] ?>" aria-hidden="true"></i>
            </div>
            <h3 class="cat-name"><?= htmlspecialchars($cat['name']) ?></h3>
            <p class="cat-sub">
              <?php
                $subs = [
                  'jewelry' => 'Rings · Necklaces · More',
                  'perfume' => 'Exclusive Fragrances',
                  'glasses' => 'Premium Eyewear',
                ];
                echo $subs[$cat['slug']] ?? 'Shop Now';
              ?>
            </p>
          </div>

          <div class="cat-card-overlay"></div>

        </a>
      <?php endforeach; ?>
    </div>

    <!-- Browse All -->
    <div style="text-align:center;margin-top:48px;">
      <a href="<?= APP_URL ?>/shop?category=" class="btn btn-secondary">
        Browse All Products <i class="ti ti-arrow-right"></i>
      </a>
    </div>

  </div>

</main>