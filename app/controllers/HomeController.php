<?php

// Start session
session_name(SESSION_NAME);
session_start();

// Set page variables
$pageTitle = 'Welcome to JomiGlobal';
$pageDescription = 'Luxury Jewelry, Perfume and Glasses for the discerning individual';

// Load the view
$showPageLoader = true;
require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/home.php';
require_once ROOT . '/app/views/layouts/footer.php';