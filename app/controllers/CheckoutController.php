<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
  header('Location: ' . APP_URL . '/cart');
  exit;
}

$pdo = connectDB();

// Calculate totals
$cartItems = $_SESSION['cart'];
$subtotal  = 0;

foreach ($cartItems as $item) {
  $subtotal += $item['price'] * $item['quantity'];
}

// Get user details if logged in
$currentUser = null;
if (isLoggedIn()) {
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
  $stmt->execute([$_SESSION['user_id']]);
  $currentUser = $stmt->fetch();
}

$pageTitle = 'Checkout';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/checkout.php';
require_once ROOT . '/app/views/layouts/footer.php';