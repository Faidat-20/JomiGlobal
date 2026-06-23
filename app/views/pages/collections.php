<main class="category-page">

  <div class="category-hero">
    <div class="header-banner-bg">
      <img src="<?= APP_URL ?>/uploads/product_6a3514a3c7c6a.png" alt="" class="header-banner-img" id="headerBannerImg">
    </div>
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/collections">Collections</a>
      </div>
      <h1 class="category-hero-title">Our Collections</h1>
      <p style="color:#a0a0a0;margin-top:12px;font-size:15px;position:relative;z-index:1;">
        Curated collections for every style and occasion
      </p>
    </div>
  </div>

  <div class="container" style="padding-bottom:80px;">
    <div class="collections-grid">
      <?php
        $icons = [
          'for-her'    => 'ti-heart',
          'for-him'    => 'ti-crown',
          'gift-ideas' => 'ti-gift',
          'customised' => 'ti-sparkles',
        ];
        $i = 1;
      ?>
      <?php foreach ($collections as $col): ?>
        <a href="<?= APP_URL ?>/collections/<?= $col['slug'] ?>" class="col-card reveal">

          <!-- Image or placeholder -->
          <?php if (!empty($col['image'])): ?>
            <div class="col-placeholder" style="background:none;">
              <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($col['image']) ?>"
                   alt="<?= htmlspecialchars($col['name']) ?>"
                   style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
            </div>
          <?php else: ?>
            <div class="col-placeholder col-bg-<?= $i ?>">
              <?php $icon = $icons[$col['slug']] ?? 'ti-diamond'; ?>
              <i class="ti <?= $icon ?>"></i>
            </div>
          <?php endif; ?>

          <!-- Corner frames -->
          <div class="col-corner c-tl"></div>
          <div class="col-corner c-tr"></div>
          <div class="col-corner c-bl"></div>
          <div class="col-corner c-br"></div>

          <!-- Number -->
          <div class="col-num"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></div>

          <!-- Overlay -->
          <div class="col-overlay">
            <p class="col-tag">Collection</p>
            <h2 class="col-title"><?= htmlspecialchars($col['name']) ?></h2>
            <?php if (!empty($col['description'])): ?>
              <p class="col-desc"><?= htmlspecialchars($col['description']) ?></p>
            <?php endif; ?>
            <div class="col-line"></div>
            <div class="col-cta"><div class="cta-bar"></div>Explore</div>
          </div>

        </a>
      <?php $i++; endforeach; ?>
    </div>
  </div>

</main>