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

// Get sort, filters and pagination
$sort     = $_GET['sort'] ?? 'newest';
$minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float) $_GET['min_price'] : null;
$maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float) $_GET['max_price'] : null;
$page     = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage  = ITEMS_PER_PAGE;
$offset   = ($page - 1) * $perPage;

$orderBy = match ($sort) {
    'price_asc'  => 'p.price ASC',
    'price_desc' => 'p.price DESC',
    'name_asc'   => 'p.name ASC',
    default      => 'p.created_at DESC',
};

// Build WHERE clause
$where = [
    'pc.collection_id = ?',
    'p.is_active = 1'
];

$params = [$collection['id']];

if ($minPrice !== null) {
    $where[] = 'p.price >= ?';
    $params[] = $minPrice;
}

if ($maxPrice !== null) {
    $where[] = 'p.price <= ?';
    $params[] = $maxPrice;
}

$whereClause = implode(' AND ', $where);

// Count products
$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM products p
    LEFT JOIN product_collections pc ON p.id = pc.product_id
    WHERE $whereClause
");
$countStmt->execute($params);

$totalProducts = $countStmt->fetchColumn();
$totalPages = ceil($totalProducts / $perPage);

// Get products
$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN product_collections pc ON p.id = pc.product_id
    WHERE $whereClause
    ORDER BY $orderBy
    LIMIT $perPage OFFSET $offset
");

$stmt->execute($params);
$products = $stmt->fetchAll();

$pageTitle = $collection['name'];

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/collection.php';
require_once ROOT . '/app/views/layouts/footer.php';