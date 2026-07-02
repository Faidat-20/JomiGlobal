<?php

session_name(SESSION_NAME);
session_start();

$showPageLoader = true;
require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

$stmt = $pdo->prepare('SELECT * FROM collections WHERE is_active = 1');
$stmt->execute();
$collections = $stmt->fetchAll();

$pageTitle = 'Collections';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/collections.php';
require_once ROOT . '/app/views/layouts/footer.php';