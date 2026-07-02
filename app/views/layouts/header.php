<?php
$pageTitle = $pageTitle ?? APP_NAME;
$pageDescription = $pageDescription ?? 'Luxury Jewelry, Perfume and Glasses';

if (isset($_SESSION['user_id']) && !isset($_SESSION['cart_db_loaded'])) {
  $pdo = connectDB();
  require_once ROOT . '/app/helpers/cart.php';
  require_once ROOT . '/app/helpers/wishlist.php';
  $_SESSION['cart']    = loadCartFromDB($pdo, $_SESSION['user_id']);
  $_SESSION['wishlist'] = loadWishlistFromDB($pdo, $_SESSION['user_id']);
  $_SESSION['cart_db_loaded'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <title><?= htmlspecialchars($pageTitle) ?> | JomiGlobal</title>
    <link rel="icon" type="image/png" href="<?= APP_URL ?>/assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/animate.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/shop.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/product.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/cart.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/checkout.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/pages.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/wishlist.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/login.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/account.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/category.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/collections.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/order-tracking.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/about.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/contact.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/privacy-policy.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/faq.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/returns.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/shipping-delivery.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <link rel="icon" type="image/svg+xml" href="<?= APP_URL ?>/assets/images/icon.svg">
    <link rel="alternate icon" href="<?= APP_URL ?>/assets/images/Icon-54.svg">
    <script>
        const APP_URL = '<?= APP_URL ?>';
        <?php
            $cartIds = [];
            if (isset($_SESSION['cart'])) {
            $cartIds = array_keys($_SESSION['cart']);
            }
            $wishlistIds = [];
            if (isset($_SESSION['wishlist'])) {
            $wishlistIds = array_keys($_SESSION['wishlist']);
            }
        ?>
        const cartItemIds = <?= json_encode(array_map('intval', $cartIds)) ?>;
        const wishlistIds = <?= json_encode(array_map('intval', $wishlistIds)) ?>;
        </script>
</head>
<body class="<?= !empty($showPageLoader) ? 'show-loader' : '' ?>">
    <div class="page-loader" id="pageLoader">
  <div class="page-loader-inner">
    <div class="loader-track"></div>
    <div class="loader-ring"></div>
    <div class="loader-logo">
      <img src="<?= APP_URL ?>/assets/images/Icon-54.png" alt="JomiGlobal">
    </div>
  </div>
  <p class="loader-text">Loading</p>
</div>
    <script>document.documentElement.classList.add('js-enabled');</script>