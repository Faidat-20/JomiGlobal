<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'FAQ';
$pageDescription = 'Frequently asked questions about JomiGlobal products, orders, shipping and returns.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/faq.php';
require_once ROOT . '/app/views/layouts/footer.php';