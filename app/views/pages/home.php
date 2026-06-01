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
  <section class="section collections-section">
    <div class="container">
      <p class="section-label reveal">Curated For You</p>
      <h2 class="section-title reveal">Our Collections</h2>
      <div class="collections-grid">
        <a href="<?= APP_URL ?>/collections/for-her" class="collection-card reveal">
          <div class="collection-overlay">
            <h3>For Her</h3>
            <p>Luxury pieces curated for women</p>
            <span class="collection-link">Explore <i class="ti ti-arrow-right"></i></span>
          </div>
        </a>
        <a href="<?= APP_URL ?>/collections/for-him" class="collection-card reveal">
          <div class="collection-overlay">
            <h3>For Him</h3>
            <p>Premium selections for men</p>
            <span class="collection-link">Explore <i class="ti ti-arrow-right"></i></span>
          </div>
        </a>
        <a href="<?= APP_URL ?>/collections/gift-ideas" class="collection-card reveal">
          <div class="collection-overlay">
            <h3>Gift Ideas</h3>
            <p>Perfect gifts for every occasion</p>
            <span class="collection-link">Explore <i class="ti ti-arrow-right"></i></span>
          </div>
        </a>
        <a href="<?= APP_URL ?>/collections/customised" class="collection-card reveal">
          <div class="collection-overlay">
            <h3>Customised</h3>
            <p>Personalised and custom made</p>
            <span class="collection-link">Explore <i class="ti ti-arrow-right"></i></span>
          </div>
        </a>
      </div>
    </div>
  </section>

</main>