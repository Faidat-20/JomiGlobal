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
        require_once ROOT . '/app/controllers/ProductController.php';
        break;

    case 'cart':
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
        require_once ROOT . '/app/controllers/CartController.php';
        break;

    case 'admin':
        require_once ROOT . '/app/controllers/AdminController.php';
        break;

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}