<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pageTitle = 'About Us';
$pageDescription = 'Learn about JomiGlobal — our story, our founder, and our commitment to luxury.';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/about.php';
require_once ROOT . '/app/views/layouts/footer.php';