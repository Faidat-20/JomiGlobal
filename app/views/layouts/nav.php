<nav class="navbar">
  <div class="nav-container">
    
    <!-- Logo -->
    <a href="<?= APP_URL ?>" class="nav-logo">
      <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal" class="logo-img">
    </a>

    <!-- Desktop Navigation -->
    <ul class="nav-links">
      <li><a href="<?= APP_URL ?>">Home</a></li>
      
      <li class="dropdown">
        <a href="<?= APP_URL ?>/shop">Shop <i class="ti ti-chevron-down"></i></a>
        <ul class="dropdown-menu">
          <li><a href="<?= APP_URL ?>/category/jewelry">Jewelry</a></li>
          <li><a href="<?= APP_URL ?>/category/perfume">Perfume</a></li>
          <li><a href="<?= APP_URL ?>/category/glasses">Glasses</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="<?= APP_URL ?>/collections">Collections <i class="ti ti-chevron-down"></i></a>
        <ul class="dropdown-menu">
          <li><a href="<?= APP_URL ?>/collections/for-her">For Her</a></li>
          <li><a href="<?= APP_URL ?>/collections/for-him">For Him</a></li>
          <li><a href="<?= APP_URL ?>/collections/gift-ideas">Gift Ideas</a></li>
          <li><a href="<?= APP_URL ?>/collections/customised">Customised</a></li>
        </ul>
      </li>

      <li><a href="<?= APP_URL ?>/about">About</a></li>
      <li><a href="<?= APP_URL ?>/contact">Contact</a></li>
    </ul>

    <!-- Nav Actions -->
    <div class="nav-actions">
      <a href="<?= APP_URL ?>/search" class="nav-icon-btn">
        <i class="ti ti-search"></i>
      </a>
      <a href="<?= APP_URL ?>/wishlist" class="nav-icon-btn">
        <i class="ti ti-heart"></i>
        <?php $wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?>
        <span class="wishlist-count" style="<?= $wishlistCount < 1 ? 'display:none;' : '' ?>">
          <?= $wishlistCount ?>
        </span>
      </a>
      <a href="<?= APP_URL ?>/cart" class="nav-icon-btn cart-btn">
        <i class="ti ti-shopping-bag"></i>
        <span class="cart-count">
          <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
        </span>
      </a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="<?= APP_URL ?>/account" class="nav-icon-btn">
          <i class="ti ti-user"></i>
        </a>
      <?php else: ?>
        <a href="<?= APP_URL ?>/login" class="nav-btn">Login</a>
      <?php endif; ?>
    </div>

    <!-- Mobile Hamburger -->
    <button class="mobile-menu-btn" id="mobileMenuToggle" aria-label="Open menu">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>
  </div>
</nav>

<!-- Mobile Slide Panel -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<div class="mobile-panel" id="mobilePanel">

  <!-- Panel Header -->
  <div class="mobile-panel-header">
    <a href="<?= APP_URL ?>" class="mobile-panel-logo">
      <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal" style="height:36px;width:auto;">
    </a>
    <button class="mobile-panel-close" id="mobilePanelClose">
      <i class="ti ti-x"></i>
    </button>
  </div>

  <div class="mobile-panel-divider"></div>

  <!-- Panel Links -->
  <div class="mobile-panel-links">

    <a href="<?= APP_URL ?>" class="mobile-panel-link">Home</a>

    <div class="mobile-panel-link mobile-dropdown-toggle" id="shopDropToggle">
      Shop
      <i class="ti ti-chevron-down mobile-drop-icon"></i>
    </div>
    <div class="mobile-panel-sub" id="shopDropSub">
      <a href="<?= APP_URL ?>/category/jewelry" class="mobile-panel-sub-link">Jewelry</a>
      <a href="<?= APP_URL ?>/category/perfume" class="mobile-panel-sub-link">Perfume</a>
      <a href="<?= APP_URL ?>/category/glasses" class="mobile-panel-sub-link">Glasses</a>
    </div>

    <div class="mobile-panel-link mobile-dropdown-toggle" id="colDropToggle">
      Collections
      <i class="ti ti-chevron-down mobile-drop-icon"></i>
    </div>
    <div class="mobile-panel-sub" id="colDropSub">
      <a href="<?= APP_URL ?>/collections/for-her" class="mobile-panel-sub-link">For Her</a>
      <a href="<?= APP_URL ?>/collections/for-him" class="mobile-panel-sub-link">For Him</a>
      <a href="<?= APP_URL ?>/collections/gift-ideas" class="mobile-panel-sub-link">Gift Ideas</a>
      <a href="<?= APP_URL ?>/collections/customised" class="mobile-panel-sub-link">Customised</a>
    </div>

    <a href="<?= APP_URL ?>/about" class="mobile-panel-link">About</a>
    <a href="<?= APP_URL ?>/contact" class="mobile-panel-link">Contact</a>

  </div>

  <!-- Panel Footer — Social Links -->
  <div class="mobile-panel-footer">
    <p class="mobile-panel-footer-label">Follow Us</p>
    <div class="mobile-panel-socials">
      <a href="#" class="mobile-social-link"><i class="ti ti-brand-instagram"></i></a>
      <a href="#" class="mobile-social-link"><i class="ti ti-brand-tiktok"></i></a>
      <a href="#" class="mobile-social-link"><i class="ti ti-brand-facebook"></i></a>
      <a href="#" class="mobile-social-link"><i class="ti ti-brand-twitter"></i></a>
    </div>
  </div>

</div>