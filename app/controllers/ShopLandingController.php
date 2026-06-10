<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

$stmt = $pdo->prepare('SELECT * FROM categories WHERE is_active = 1');
$stmt->execute();
$categories = $stmt->fetchAll();

$pageTitle = 'Shop';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/shop-landing.php';
require_once ROOT . '/app/views/layouts/footer.php';