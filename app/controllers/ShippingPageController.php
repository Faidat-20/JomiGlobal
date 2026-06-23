<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'Shipping & Delivery';
$pageDescription = 'JomiGlobal Shipping and Delivery information — worldwide delivery available.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/shipping-delivery.php';
require_once ROOT . '/app/views/layouts/footer.php';