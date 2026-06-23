<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'Returns & Exchanges';
$pageDescription = 'JomiGlobal Returns and Exchanges policy — hassle free returns within 7 days.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/returns.php';
require_once ROOT . '/app/views/layouts/footer.php';