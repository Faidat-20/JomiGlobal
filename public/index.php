<?php

// Define root path
define('ROOT', dirname(__DIR__));

// Load config
require_once ROOT . '/config/app.php';
require_once ROOT . '/config/database.php';

// Get the URL path
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

// Remove the base path (for localhost)
$basePath = '/JomiGlobal/public';
$url = str_replace($basePath, '', $url);

// Remove query strings
$url = strtok($url, '?');

// Remove leading slash
$url = trim($url, '/');

// Route the request
switch ($url) {
    case '':
    case 'home':
        require_once ROOT . '/app/controllers/HomeController.php';
        break;

    case 'shop':
        if (isset($_GET['category']) || isset($_GET['subcategory']) || isset($_GET['sort']) || isset($_GET['min_price']) || isset($_GET['max_price'])) {
            require_once ROOT . '/app/controllers/ShopController.php';
        } else {
            require_once ROOT . '/app/controllers/ShopLandingController.php';
        }
        break;

    case 'cart':
        require_once ROOT . '/app/controllers/CartController.php';
        break;

        case 'cart/add':
        require_once ROOT . '/app/controllers/CartController.php';
        break;

        case 'cart/update':
        require_once ROOT . '/app/controllers/CartController.php';
        break;

        case 'cart/remove':
        require_once ROOT . '/app/controllers/CartController.php';
        break;

        case 'cart/clear':
        require_once ROOT . '/app/controllers/CartController.php';
        break;

    case 'login':
    case 'register':
        require_once ROOT . '/app/controllers/AuthController.php';
        break;

    case 'logout':
        session_name(SESSION_NAME);
        session_start();
        require_once ROOT . '/app/helpers/auth.php';
        logoutUser();
        break;

    case 'checkout':
        require_once ROOT . '/app/controllers/CheckoutController.php';
        break;

    case 'admin':
        require_once ROOT . '/app/controllers/AdminController.php';
        break;

    case 'admin/products':
        require_once ROOT . '/app/controllers/ProductsAdminController.php';
        break;

    case 'admin/products/add':
        $_GET['action'] = 'add';
        require_once ROOT . '/app/controllers/ProductsAdminController.php';
        break;

    case 'admin/orders':
        require_once ROOT . '/app/controllers/OrdersAdminController.php';
        break;
    
    case 'admin/customers':
        require_once ROOT . '/app/controllers/CustomersAdminController.php';
        break;

    case 'admin/shipping':
        require_once ROOT . '/app/controllers/ShippingAdminController.php';
        break;
    case 'search':
        require_once ROOT . '/app/controllers/SearchController.php';
        break;

    case 'wishlist':
        require_once ROOT . '/app/controllers/WishlistController.php';
        break;

    case 'wishlist/add':
        require_once ROOT . '/app/controllers/WishlistController.php';
        break;

    case 'wishlist/remove':
        require_once ROOT . '/app/controllers/WishlistController.php';
        break;

    case 'wishlist/toggle':
        require_once ROOT . '/app/controllers/WishlistController.php';
        break;

    case 'account':
        require_once ROOT . '/app/controllers/AccountController.php';
        break;

    case 'collections':
        require_once ROOT . '/app/controllers/CollectionsController.php';
        break;

    case 'order-tracking':
        require_once ROOT . '/app/controllers/OrderTrackingController.php';
        break;

    case 'newsletter/subscribe':
        require_once ROOT . '/app/controllers/NewsletterController.php';
        break;

    case 'about':
        require_once ROOT . '/app/controllers/AboutController.php';
        break;

    case 'contact':
        require_once ROOT . '/app/controllers/ContactController.php';
        break;
        
    case 'privacy-policy':
        require_once ROOT . '/app/controllers/PrivacyController.php';
        break;
        
    case 'faq':
        require_once ROOT . '/app/controllers/FaqController.php';
        break;

    default:
        if (strpos($url, 'product/') === 0) {
            require_once ROOT . '/app/controllers/ProductDetailController.php';
            break;
        }
        if (strpos($url, 'category/') === 0) {
            require_once ROOT . '/app/controllers/CategoryController.php';
            break;
        }
        if (strpos($url, 'collections/') === 0) {
            require_once ROOT . '/app/controllers/CollectionController.php';
            break;
        }
        http_response_code(404);
        echo "Page not found";
        break;
}