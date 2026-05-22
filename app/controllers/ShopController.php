<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/models/Product.php';

$pdo = connectDB();
$product = new Product();

// Get filters from URL
$categorySlug    = isset($_GET['category']) ? $_GET['category'] : null;
$subcategorySlug = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;
$collectionSlug  = isset($_GET['collection']) ? $_GET['collection'] : null;
$sort            = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$minPrice        = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
$maxPrice        = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
$page            = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage         = ITEMS_PER_PAGE;
$offset          = ($page - 1) * $perPage;

// Get current category
$currentCategory = null;
if ($categorySlug) {
  $stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ?');
  $stmt->execute([$categorySlug]);
  $currentCategory = $stmt->fetch();
}

// Get current subcategory
$currentSubcategory = null;
if ($subcategorySlug) {
  $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE slug = ?');
  $stmt->execute([$subcategorySlug]);
  $currentSubcategory = $stmt->fetch();
}

// Get subcategories for sidebar
$subcategoriesForSidebar = [];
if ($currentCategory) {
  $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE category_id = ? AND is_active = 1');
  $stmt->execute([$currentCategory['id']]);
  $subcategoriesForSidebar = $stmt->fetchAll();
}

// Get all categories for sidebar
$stmt = $pdo->prepare('SELECT * FROM categories WHERE is_active = 1');
$stmt->execute();
$allCategories = $stmt->fetchAll();

// Build product query
$where = ['p.is_active = 1'];
$params = [];

if ($currentCategory) {
  $where[] = 'p.category_id = ?';
  $params[] = $currentCategory['id'];
}

if ($currentSubcategory) {
  $where[] = 'p.subcategory_id = ?';
  $params[] = $currentSubcategory['id'];
}

if ($minPrice !== null) {
  $where[] = 'p.price >= ?';
  $params[] = $minPrice;
}

if ($maxPrice !== null) {
  $where[] = 'p.price <= ?';
  $params[] = $maxPrice;
}

$whereClause = implode(' AND ', $where);

// Sort
$orderBy = match($sort) {
  'price_asc'  => 'p.price ASC',
  'price_desc' => 'p.price DESC',
  'name_asc'   => 'p.name ASC',
  default      => 'p.created_at DESC',
};

// Count total products
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM products p WHERE $whereClause");
$countStmt->execute($params);
$totalProducts = $countStmt->fetchColumn();
$totalPages = ceil($totalProducts / $perPage);

// Get products
$stmt = $pdo->prepare("
  SELECT p.*, c.name as category_name
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.id
  WHERE $whereClause
  ORDER BY $orderBy
  LIMIT $perPage OFFSET $offset
");
$stmt->execute($params);
$products = $stmt->fetchAll();

$pageTitle = $currentCategory ? $currentCategory['name'] : 'Shop All';
$pageDescription = 'Shop luxury jewelry, perfume and glasses at JomiGlobal';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/shop.php';
require_once ROOT . '/app/views/layouts/footer.php';