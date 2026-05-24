<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

// Initialize wishlist as empty array
if (!isset($_SESSION['wishlist'])) {
  $_SESSION['wishlist'] = [];
}

// Fetch product helper
function getProduct($pdo, $id) {
  $stmt = $pdo->prepare('
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ? AND p.is_active = 1
  ');
  $stmt->execute([$id]);
  return $stmt->fetch();
}

// Build wishlist item helper
function wishlistItem($product) {
  return [
    'id'            => (int)$product['id'],
    'name'          => $product['name'],
    'price'         => $product['sale_price'] ? (float)$product['sale_price'] : (float)$product['price'],
    'image'         => $product['image'] ?? '',
    'slug'          => $product['slug'],
    'category_name' => $product['category_name'] ?? '',
  ];
}

// JSON response helper
function jsonResponse($data) {
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

// Is AJAX?
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

// ============ ADD ============
if ($action === 'add') {
  $productId = (int)$_GET['id'];
  if ($productId > 0 && !isset($_SESSION['wishlist'][$productId])) {
    $product = getProduct($pdo, $productId);
    if ($product) {
      $_SESSION['wishlist'][$productId] = wishlistItem($product);
    }
  }
  if ($isAjax) {
    jsonResponse([
      'success'        => true,
      'in_wishlist'    => isset($_SESSION['wishlist'][$productId]),
      'wishlist_count' => count($_SESSION['wishlist']),
    ]);
  }
  header('Location: ' . APP_URL . '/wishlist');
  exit;
}

// ============ REMOVE ============
if ($action === 'remove') {
  $productId = (int)$_GET['id'];
  unset($_SESSION['wishlist'][$productId]);
  if ($isAjax) {
    jsonResponse([
      'success'        => true,
      'wishlist_count' => count($_SESSION['wishlist']),
    ]);
  }
  header('Location: ' . APP_URL . '/wishlist');
  exit;
}

// ============ TOGGLE ============
if ($action === 'toggle') {
  $productId = (int)$_GET['id'];
  if (isset($_SESSION['wishlist'][$productId])) {
    unset($_SESSION['wishlist'][$productId]);
    $inWishlist = false;
  } else {
    $product = getProduct($pdo, $productId);
    if ($product) {
      $_SESSION['wishlist'][$productId] = wishlistItem($product);
    }
    $inWishlist = true;
  }
  if ($isAjax) {
    jsonResponse([
      'success'        => true,
      'in_wishlist'    => $inWishlist,
      'wishlist_count' => count($_SESSION['wishlist']),
    ]);
  }
  header('Location: ' . APP_URL . '/wishlist');
  exit;
}

// ============ CLEAR ============
if ($action === 'clear') {
  $_SESSION['wishlist'] = [];
  header('Location: ' . APP_URL . '/wishlist');
  exit;
}

// ============ VIEW ============
// Only show valid items
$wishlistItems = [];
foreach ($_SESSION['wishlist'] as $key => $item) {
  if (
    isset($item['id'], $item['name'], $item['slug']) &&
    $item['id'] > 0 &&
    !empty($item['name']) &&
    !empty($item['slug'])
  ) {
    $wishlistItems[$key] = $item;
  }
}

// Update session with clean data
$_SESSION['wishlist'] = $wishlistItems;

$pageTitle = 'My Wishlist';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/wishlist.php';
require_once ROOT . '/app/views/layouts/footer.php';