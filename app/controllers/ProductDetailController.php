<?php

session_name(SESSION_NAME);
session_start();

$showPageLoader = true;
require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/models/Product.php';

$pdo = connectDB();
$product = new Product();

// Get slug from URL
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$basePath = '/JomiGlobal/public/product/';
$slug = str_replace($basePath, '', $url);
$slug = strtok($slug, '?');
$slug = trim($slug, '/');

// Get product
$currentProduct = $product->getBySlug($slug);

if (!$currentProduct) {
  http_response_code(404);
  echo "Product not found";
  exit;
}

// Get related products
$stmt = $pdo->prepare('
  SELECT p.*, c.name as category_name
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.id
  WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1
  LIMIT 4
');
$stmt->execute([$currentProduct['category_id'], $currentProduct['id']]);
$relatedProducts = $stmt->fetchAll();

$pageTitle = $currentProduct['name'];
$pageDescription = $currentProduct['description'];

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/product.php';
require_once ROOT . '/app/views/layouts/footer.php';