<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/helpers/wishlist.php';

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$userId = $_SESSION['user_id'] ?? null;
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

// Initialize wishlist
if (!isset($_SESSION['wishlist'])) {
  $_SESSION['wishlist'] = [];
}

// Helper
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

function buildWishlistItem($product) {
  return [
    'id'            => (int)$product['id'],
    'name'          => $product['name'],
    'price'         => $product['sale_price'] ? (float)$product['sale_price'] : (float)$product['price'],
    'image'         => $product['image'] ?? '',
    'slug'          => $product['slug'],
    'category_name' => $product['category_name'] ?? '',
  ];
}

function jsonResponse($data) {
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

// ============ ADD ============
if ($action === 'add') {
  $productId = (int)$_GET['id'];
  if ($productId > 0 && !isset($_SESSION['wishlist'][$productId])) {
    $product = getProduct($pdo, $productId);
    if ($product) {
      $_SESSION['wishlist'][$productId] = buildWishlistItem($product);
      if ($userId) saveWishlistToDB($pdo, $userId, $productId);
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
  if ($userId) removeWishlistFromDB($pdo, $userId, $productId);

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
    if ($userId) removeWishlistFromDB($pdo, $userId, $productId);
    $inWishlist = false;
  } else {
    $product = getProduct($pdo, $productId);
    if ($product) {
      $_SESSION['wishlist'][$productId] = buildWishlistItem($product);
      if ($userId) saveWishlistToDB($pdo, $userId, $productId);
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
  if ($userId) clearWishlistFromDB($pdo, $userId);
  header('Location: ' . APP_URL . '/wishlist');
  exit;
}

// ============ VIEW ============
// Load from DB if logged in
if ($userId) {
  $_SESSION['wishlist'] = loadWishlistFromDB($pdo, $userId);
}

$wishlistItems = array_filter($_SESSION['wishlist'], function($item) {
  return !empty($item['id']) && !empty($item['name']) && !empty($item['slug']);
});

$_SESSION['wishlist'] = $wishlistItems;
$pageTitle = 'My Wishlist';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/wishlist.php';
require_once ROOT . '/app/views/layouts/footer.php';