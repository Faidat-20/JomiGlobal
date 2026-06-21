<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'Privacy Policy';
$pageDescription = 'JomiGlobal Privacy Policy — how we collect, use and protect your information.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/privacy-policy.php';
require_once ROOT . '/app/views/layouts/footer.php';