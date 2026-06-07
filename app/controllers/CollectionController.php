<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

// Get collection slug from URL
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$basePath = '/JomiGlobal/public/collections/';
$slug = str_replace($basePath, '', $url);
$slug = strtok($slug, '?');
$slug = trim($slug, '/');

if (!$slug) {
  $stmt = $pdo->prepare('SELECT * FROM collections WHERE is_active = 1 ORDER BY name ASC');
  $stmt->execute();
  $collections = $stmt->fetchAll();
  $pageTitle = 'Collections';
  require_once ROOT . '/app/views/layouts/header.php';
  require_once ROOT . '/app/views/layouts/nav.php';
  require_once ROOT . '/app/views/pages/collections.php';
  require_once ROOT . '/app/views/layouts/footer.php';
  exit;
}

// Get collection
$stmt = $pdo->prepare('SELECT * FROM collections WHERE slug = ? AND is_active = 1');
$stmt->execute([$slug]);
$collection = $stmt->fetch();

if (!$collection) {
  http_response_code(404);
  echo "Collection not found";
  exit;
}

// Get sort
$sort = $_GET['sort'] ?? 'newest';
$orderBy = match($sort) {
  'price_asc'  => 'p.price ASC',
  'price_desc' => 'p.price DESC',
  'name_asc'   => 'p.name ASC',
  default      => 'p.created_at DESC',
};

// Get products in this collection
$stmt = $pdo->prepare("
  SELECT p.*, c.name as category_name
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.id
  LEFT JOIN product_collections pc ON p.id = pc.product_id
  WHERE pc.collection_id = ? AND p.is_active = 1
  ORDER BY $orderBy
");
$stmt->execute([$collection['id']]);
$products = $stmt->fetchAll();

$pageTitle = $collection['name'];

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/collection.php';
require_once ROOT . '/app/views/layouts/footer.php';