<main class="home-page">

  <!-- Hero Section -->
  <section class="hero" id="hero">

    <!-- Swap this src for your hero image later -->
    <div class="hero-bg">
      <!-- <img src="<?= APP_URL ?>/uploads/hero.jpg" alt="" class="hero-bg-img"> -->
    </div>

    <div class="hero-glow" id="heroGlow"></div>

    <div class="hero-content">
      <div class="hero-label-row">
        <div class="hero-label-bar"></div>
        <p class="hero-subtitle">Exclusively Yours</p>
        <div class="hero-label-bar"></div>
      </div>
      <h1 class="hero-title">
        Luxury Redefined <br>
        <span>For You</span>
      </h1>
      <div class="hero-gold-divider"></div>
      <p class="hero-text">Discover our exclusive collection of jewelry, perfume and glasses crafted for the discerning individual.</p>
      <div class="hero-btns">
        <a href="<?= APP_URL ?>/shop" class="btn btn-primary">Shop Now</a>
        <a href="<?= APP_URL ?>/collections" class="btn btn-outline-white">Our Collections</a>
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
      <div class="cat-section-header">
        <span class="cat-section-label">Browse By Category</span>
        <h2 class="cat-section-title reveal">Shop By Category</h2>
        <div class="cat-section-divider"></div>
      </div>
      <div class="categories-grid">

        <a href="<?= APP_URL ?>/category/jewelry" class="cat-card reveal">
          <div class="cat-card-bg cat-bg-1"></div>
          <div class="cat-corner tl"></div><div class="cat-corner tr"></div>
          <div class="cat-corner bl"></div><div class="cat-corner br"></div>
          <!-- Swap for image later -->
          <!-- <img src="<?= APP_URL ?>/uploads/cat-jewelry.jpg" class="cat-card-img" alt="Jewelry"> -->
          <div class="cat-card-inner">
            <div class="cat-icon-wrap">
              <i class="ti ti-diamond" aria-hidden="true"></i>
            </div>
            <h3 class="cat-name">Jewelry</h3>
            <p class="cat-sub">Rings · Necklaces · More</p>
          </div>
          <div class="cat-card-overlay"></div>
        </a>

        <a href="<?= APP_URL ?>/category/perfume" class="cat-card reveal">
          <div class="cat-card-bg cat-bg-2"></div>
          <div class="cat-corner tl"></div><div class="cat-corner tr"></div>
          <div class="cat-corner bl"></div><div class="cat-corner br"></div>
          <!-- <img src="<?= APP_URL ?>/uploads/cat-perfume.jpg" class="cat-card-img" alt="Perfume"> -->
          <div class="cat-card-inner">
            <div class="cat-icon-wrap">
              <i class="ti ti-bottle" aria-hidden="true"></i>
            </div>
            <h3 class="cat-name">Perfume</h3>
            <p class="cat-sub">Exclusive Fragrances</p>
          </div>
          <div class="cat-card-overlay"></div>
        </a>

        <a href="<?= APP_URL ?>/category/glasses" class="cat-card reveal">
          <div class="cat-card-bg cat-bg-3"></div>
          <div class="cat-corner tl"></div><div class="cat-corner tr"></div>
          <div class="cat-corner bl"></div><div class="cat-corner br"></div>
          <!-- <img src="<?= APP_URL ?>/uploads/cat-glasses.jpg" class="cat-card-img" alt="Glasses"> -->
          <div class="cat-card-inner">
            <div class="cat-icon-wrap">
              <i class="ti ti-eyeglass" aria-hidden="true"></i>
            </div>
            <h3 class="cat-name">Glasses</h3>
            <p class="cat-sub">Premium Eyewear</p>
          </div>
          <div class="cat-card-overlay"></div>
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

      <a href="<?= APP_URL ?>/collections/for-her" class="hc-card reveal">
        <?php $herImages = []; ?>
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

      <a href="<?= APP_URL ?>/collections/for-him" class="hc-card reveal">
        <?php $himImages = []; ?>
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

      <a href="<?= APP_URL ?>/collections/gift-ideas" class="hc-card reveal">
        <?php $giftImages = []; ?>
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

      <a href="<?= APP_URL ?>/collections/customised" class="hc-card reveal">
        <?php $customImages = []; ?>
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