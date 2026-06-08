<main class="home-page">

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="hero-glow" id="heroGlow"></div>
    <div class="hero-content">
      <p class="hero-subtitle">EXCLUSIVELY YOURS</p>
      <h1 class="hero-title">
        Luxury Redefined <br>
        <span>For You</span>
      </h1>
      <p class="hero-text">Discover our exclusive collection of jewelry, perfume and glasses crafted for the discerning individual.</p>
      <div class="hero-btns">
        <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Shop Now</a>
        <a href="<?= APP_URL ?>/collections" class="btn btn-white">Our Collections</a>
      </div>
    </div>
    <div class="scroll-indicator">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- Categories Section -->
  <section class="section categories-section">
    <div class="container">
      <h2 class="section-title reveal">Shop By Category</h2>
      <div class="categories-grid">
        <a href="<?= APP_URL ?>/category/jewelry" class="category-card reveal">
          <div class="category-img" style="background: var(--ash);">
            <i class="ti ti-diamond"></i>
          </div>
          <h3>Jewelry</h3>
          <p>Rings, Necklaces & More</p>
        </a>
        <a href="<?= APP_URL ?>/category/perfume" class="category-card reveal">
          <div class="category-img" style="background: var(--ash);">
            <i class="ti ti-bottle"></i>
          </div>
          <h3>Perfume</h3>
          <p>Exclusive Fragrances</p>
        </a>
        <a href="<?= APP_URL ?>/category/glasses" class="category-card reveal">
          <div class="category-img" style="background: var(--ash);">
            <i class="ti ti-eyeglass"></i>
          </div>
          <h3>Glasses</h3>
          <p>Premium Eyewear</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Collections Section -->
  <section class="home-collections-section">
    <div class="home-collections-header">
      <span class="hc-section-label">Curated For You</span>
      <h2 class="hc-section-title">Our Collections</h2>
      <div class="hc-section-divider"></div>
    </div>

    <div class="home-collections-grid">

      <!-- For Her -->
      <a href="<?= APP_URL ?>/collections/for-her" class="hc-card reveal">
        <?php
          $herImages = [
            // APP_URL . '/uploads/her-1.jpg',
            // APP_URL . '/uploads/her-2.jpg',
            // APP_URL . '/uploads/her-3.jpg',
            // APP_URL . '/uploads/her-4.jpg',
            // APP_URL . '/uploads/her-5.jpg',
          ];
        ?>
        <?php if (!empty($herImages)): ?>
          <div class="hc-slider">
            <?php foreach ($herImages as $index => $img): ?>
              <img src="<?= $img ?>" class="hc-slide <?= $index === 0 ? 'active' : '' ?>" alt="">
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="hc-placeholder bg1">
            <i class="ti ti-heart hc-icon" aria-hidden="true"></i>
          </div>
        <?php endif; ?>
        <div class="hc-corner tl"></div><div class="hc-corner tr"></div>
        <div class="hc-corner bl"></div><div class="hc-corner br"></div>
        <div class="hc-num">01</div>
        <div class="hc-overlay">
          <p class="hc-tag">Collection</p>
          <h3 class="hc-title">For Her</h3>
          <p class="hc-desc">Luxury pieces curated for women</p>
          <div class="hc-line"></div>
          <div class="hc-cta"><div class="hc-bar"></div>Explore</div>
        </div>
      </a>

      <!-- For Him -->
      <a href="<?= APP_URL ?>/collections/for-him" class="hc-card reveal">
        <?php
          $himImages = [
            // APP_URL . '/uploads/him-1.jpg',
            // APP_URL . '/uploads/him-2.jpg',
            // APP_URL . '/uploads/him-3.jpg',
            // APP_URL . '/uploads/him-4.jpg',
            // APP_URL . '/uploads/him-5.jpg',
          ];
        ?>
        <?php if (!empty($himImages)): ?>
          <div class="hc-slider">
            <?php foreach ($himImages as $index => $img): ?>
              <img src="<?= $img ?>" class="hc-slide <?= $index === 0 ? 'active' : '' ?>" alt="">
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="hc-placeholder bg2">
            <i class="ti ti-crown hc-icon" aria-hidden="true"></i>
          </div>
        <?php endif; ?>
        <div class="hc-corner tl"></div><div class="hc-corner tr"></div>
        <div class="hc-corner bl"></div><div class="hc-corner br"></div>
        <div class="hc-num">02</div>
        <div class="hc-overlay">
          <p class="hc-tag">Collection</p>
          <h3 class="hc-title">For Him</h3>
          <p class="hc-desc">Premium selections for men</p>
          <div class="hc-line"></div>
          <div class="hc-cta"><div class="hc-bar"></div>Explore</div>
        </div>
      </a>

      <!-- Gift Ideas -->
      <a href="<?= APP_URL ?>/collections/gift-ideas" class="hc-card reveal">
        <?php
          $giftImages = [
            // APP_URL . '/uploads/gift-1.jpg',
            // APP_URL . '/uploads/gift-2.jpg',
            // APP_URL . '/uploads/gift-3.jpg',
            // APP_URL . '/uploads/gift-4.jpg',
            // APP_URL . '/uploads/gift-5.jpg',
          ];
        ?>
        <?php if (!empty($giftImages)): ?>
          <div class="hc-slider">
            <?php foreach ($giftImages as $index => $img): ?>
              <img src="<?= $img ?>" class="hc-slide <?= $index === 0 ? 'active' : '' ?>" alt="">
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="hc-placeholder bg3">
            <i class="ti ti-gift hc-icon" aria-hidden="true"></i>
          </div>
        <?php endif; ?>
        <div class="hc-corner tl"></div><div class="hc-corner tr"></div>
        <div class="hc-corner bl"></div><div class="hc-corner br"></div>
        <div class="hc-num">03</div>
        <div class="hc-overlay">
          <p class="hc-tag">Collection</p>
          <h3 class="hc-title">Gift Ideas</h3>
          <p class="hc-desc">Perfect gifts for every occasion</p>
          <div class="hc-line"></div>
          <div class="hc-cta"><div class="hc-bar"></div>Explore</div>
        </div>
      </a>

      <!-- Customised -->
      <a href="<?= APP_URL ?>/collections/customised" class="hc-card reveal">
        <?php
          $customImages = [
            // APP_URL . '/uploads/custom-1.jpg',
            // APP_URL . '/uploads/custom-2.jpg',
            // APP_URL . '/uploads/custom-3.jpg',
            // APP_URL . '/uploads/custom-4.jpg',
            // APP_URL . '/uploads/custom-5.jpg',
          ];
        ?>
        <?php if (!empty($customImages)): ?>
          <div class="hc-slider">
            <?php foreach ($customImages as $index => $img): ?>
              <img src="<?= $img ?>" class="hc-slide <?= $index === 0 ? 'active' : '' ?>" alt="">
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="hc-placeholder bg4">
            <i class="ti ti-sparkles hc-icon" aria-hidden="true"></i>
          </div>
        <?php endif; ?>
        <div class="hc-corner tl"></div><div class="hc-corner tr"></div>
        <div class="hc-corner bl"></div><div class="hc-corner br"></div>
        <div class="hc-num">04</div>
        <div class="hc-overlay">
          <p class="hc-tag">Collection</p>
          <h3 class="hc-title">Customised</h3>
          <p class="hc-desc">Personalised and custom made</p>
          <div class="hc-line"></div>
          <div class="hc-cta"><div class="hc-bar"></div>Explore</div>
        </div>
      </a>

    </div>
  </section>

</main>