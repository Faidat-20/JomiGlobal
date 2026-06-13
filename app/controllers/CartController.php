<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/helpers/cart.php';

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$userId = $_SESSION['user_id'] ?? null;

// Initialize session cart
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// If logged in load from DB on first load
if ($userId && $action === 'view' && empty($_SESSION['cart_loaded'])) {
  $_SESSION['cart'] = loadCartFromDB($pdo, $userId);
  $_SESSION['cart_loaded'] = true;
}

// ============ ADD ============
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = (int)$_POST['product_id'];
  $quantity  = (int)($_POST['quantity'] ?? 1);

  $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND is_active = 1');
  $stmt->execute([$productId]);
  $product = $stmt->fetch();

  if ($product && $quantity > 0) {
    // Set quantity (not add)
    $newQty = min($quantity, $product['stock']);
    $_SESSION['cart'][$productId] = [
      'id'       => $product['id'],
      'name'     => $product['name'],
      'price'    => $product['sale_price'] ?: $product['price'],
      'image'    => $product['image'],
      'slug'     => $product['slug'],
      'stock'    => $product['stock'],
      'quantity' => $newQty,
    ];

    // Save to DB if logged in
    if ($userId) {
      saveCartToDB($pdo, $userId, $productId, $newQty);
    }
  }

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

// ============ UPDATE ============
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = (int)$_POST['product_id'];
  $quantity  = (int)$_POST['quantity'];

  if ($quantity <= 0) {
    unset($_SESSION['cart'][$productId]);
    if ($userId) saveCartToDB($pdo, $userId, $productId, 0);
  } else {
    if (isset($_SESSION['cart'][$productId])) {
      $stock = $_SESSION['cart'][$productId]['stock'];
      $newQty = min($quantity, $stock);
      $_SESSION['cart'][$productId]['quantity'] = $newQty;
      if ($userId) saveCartToDB($pdo, $userId, $productId, $newQty);
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
      'item_total' => isset($_SESSION['cart'][$productId])
        ? number_format($_SESSION['cart'][$productId]['price'] * $_SESSION['cart'][$productId]['quantity'], 2)
        : '0.00',
    ]);
    exit;
  }

  header('Location: ' . APP_URL . '/cart');
  exit;
}

// ============ REMOVE ============
if ($action === 'remove') {
  $productId = (int)$_GET['id'];
  unset($_SESSION['cart'][$productId]);
  if ($userId) saveCartToDB($pdo, $userId, $productId, 0);

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

// ============ CLEAR ============
if ($action === 'clear') {
  $_SESSION['cart'] = [];
  if ($userId) clearCartFromDB($pdo, $userId);

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

// ============ VIEW ============
// Load from DB if logged in
if ($userId) {
  $_SESSION['cart'] = loadCartFromDB($pdo, $userId);
}

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