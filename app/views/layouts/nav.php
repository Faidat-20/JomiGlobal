<nav class="navbar">
  <div class="nav-container">
    
    <!-- Logo -->
    <a href="<?= APP_URL ?>" class="nav-logo">
      <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal" class="logo-img">
    </a>

    <!-- Main Navigation -->
    <ul class="nav-links">
      <li><a href="<?= APP_URL ?>">Home</a></li>
      
      <!-- Shop Dropdown -->
      <li class="dropdown">
        <a href="<?= APP_URL ?>/shop">Shop <i class="ti ti-chevron-down"></i></a>
        <ul class="dropdown-menu">
          <li><a href="<?= APP_URL ?>/shop/jewelry">Jewelry</a></li>
          <li><a href="<?= APP_URL ?>/shop/perfume">Perfume</a></li>
          <li><a href="<?= APP_URL ?>/shop/glasses">Glasses</a></li>
        </ul>
      </li>

      <!-- Collections Dropdown -->
      <li class="dropdown">
        <a href="#">Collections <i class="ti ti-chevron-down"></i></a>
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
      <!-- Search -->
      <button class="nav-icon-btn" id="searchToggle">
        <i class="ti ti-search"></i>
      </button>

      <!-- Wishlist -->
      <a href="<?= APP_URL ?>/wishlist" class="nav-icon-btn">
        <i class="ti ti-heart"></i>
      </a>

      <!-- Cart -->
      <a href="<?= APP_URL ?>/cart" class="nav-icon-btn cart-btn">
        <i class="ti ti-shopping-bag"></i>
        <span class="cart-count">
          <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
        </span>
      </a>

      <!-- Account -->
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="<?= APP_URL ?>/account" class="nav-icon-btn">
          <i class="ti ti-user"></i>
        </a>
      <?php else: ?>
        <a href="<?= APP_URL ?>/login" class="nav-btn">Login</a>
      <?php endif; ?>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-btn" id="mobileMenuToggle">
      <i class="ti ti-menu-2"></i>
    </button>
  </div>

  <!-- Search Bar -->
  <div class="search-bar" id="searchBar">
    <div class="search-container">
      <input type="text" placeholder="Search for jewelry, perfume, glasses..." id="searchInput">
      <button class="search-submit">
        <i class="ti ti-search"></i>
      </button>
      <button class="search-close" id="searchClose">
        <i class="ti ti-x"></i>
      </button>
    </div>
  </div>
</nav>