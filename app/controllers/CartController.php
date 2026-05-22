<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

// Initialize cart
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Handle actions
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = (int)$_POST['product_id'];
  $quantity  = (int)($_POST['quantity'] ?? 1);

  // Get product from DB
  $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND is_active = 1');
  $stmt->execute([$productId]);
  $product = $stmt->fetch();

  if ($product && $quantity > 0) {
    if (isset($_SESSION['cart'][$productId])) {
      $newQty = $_SESSION['cart'][$productId]['quantity'] + $quantity;
      $newQty = min($newQty, $product['stock']);
      $_SESSION['cart'][$productId]['quantity'] = $newQty;
    } else {
      $_SESSION['cart'][$productId] = [
        'id'       => $product['id'],
        'name'     => $product['name'],
        'price'    => $product['sale_price'] ?: $product['price'],
        'image'    => $product['image'],
        'slug'     => $product['slug'],
        'stock'    => $product['stock'],
        'quantity' => $quantity,
      ];
    }
  }

  // Return JSON for AJAX
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    echo json_encode([
      'success'    => true,
      'cart_count' => count($_SESSION['cart']),
      'message'    => 'Product added to cart!'
    ]);
    exit;
  }

  header('Location: ' . APP_URL . '/cart');
  exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = (int)$_POST['product_id'];
  $quantity  = (int)$_POST['quantity'];

  if ($quantity <= 0) {
    unset($_SESSION['cart'][$productId]);
  } else {
    if (isset($_SESSION['cart'][$productId])) {
      $stock = $_SESSION['cart'][$productId]['stock'];
      $_SESSION['cart'][$productId]['quantity'] = min($quantity, $stock);
    }
  }

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }
    header('Content-Type: application/json');
    echo json_encode([
      'success'    => true,
      'cart_count' => count($_SESSION['cart']),
      'subtotal'   => number_format($subtotal, 2),
      'total'      => number_format($subtotal, 2),
      'item_total' => isset($_SESSION['cart'][$productId]) ? number_format($_SESSION['cart'][$productId]['price'] * $_SESSION['cart'][$productId]['quantity'], 2) : '0.00',
    ]);
    exit;
  }

  header('Location: ' . APP_URL . '/cart');
  exit;
}

if ($action === 'remove') {
  $productId = (int)$_GET['id'];
  unset($_SESSION['cart'][$productId]);

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }
    header('Content-Type: application/json');
    echo json_encode([
      'success'    => true,
      'cart_count' => count($_SESSION['cart']),
      'subtotal'   => number_format($subtotal, 2),
      'total'      => number_format($subtotal, 2),
      'empty'      => empty($_SESSION['cart']),
    ]);
    exit;
  }

  header('Location: ' . APP_URL . '/cart');
  exit;
}

if ($action === 'clear') {
  $_SESSION['cart'] = [];

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    echo json_encode([
      'success'    => true,
      'cart_count' => 0,
      'empty'      => true,
    ]);
    exit;
  }

  header('Location: ' . APP_URL . '/cart');
  exit;
}

// Calculate totals
$cartItems  = $_SESSION['cart'];
$subtotal   = 0;
$totalItems = 0;

foreach ($cartItems as $item) {
  $subtotal   += $item['price'] * $item['quantity'];
  $totalItems += $item['quantity'];
}

$shippingFee = 0;
$total = $subtotal;

$pageTitle = 'Shopping Cart';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/cart.php';
require_once ROOT . '/app/views/layouts/footer.php';