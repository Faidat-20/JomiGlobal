<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'Terms & Conditions';
$pageDescription = 'JomiGlobal Terms and Conditions — please read before using our website.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/terms.php';
require_once ROOT . '/app/views/layouts/footer.php';