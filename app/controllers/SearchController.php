<?php

session_name(SESSION_NAME);
session_start();

$showPageLoader = true;
require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

$query    = trim($_GET['q'] ?? '');
$category = $_GET['category'] ?? null;
$sort     = $_GET['sort'] ?? 'newest';

$products     = [];
$totalResults = 0;
$totalPages   = 0;
$page         = max(1, intval($_GET['page'] ?? 1));
$perPage      = 12;

if (!empty($query)) {
  $search = '%' . $query . '%';

  $where  = ['p.is_active = 1', '(p.name LIKE ? OR p.description LIKE ? OR p.brand LIKE ?)'];
  $params = [$search, $search, $search];

  if ($category) {
    $where[]  = 'c.slug = ?';
    $params[] = $category;
  }

  $whereClause = implode(' AND ', $where);

  $orderBy = match($sort) {
    'price_asc'  => 'p.price ASC',
    'price_desc' => 'p.price DESC',
    'name_asc'   => 'p.name ASC',
    default      => 'p.created_at DESC',
  };

  // Count
  $countStmt = $pdo->prepare("
    SELECT COUNT(*) FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE $whereClause
  ");
  $countStmt->execute($params);
  $totalResults = (int) $countStmt->fetchColumn();
  $totalPages   = (int) ceil($totalResults / $perPage);

  $offset = ($page - 1) * $perPage;

  // Get products with pagination
  $stmt = $pdo->prepare("
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE $whereClause
    ORDER BY $orderBy
    LIMIT {$perPage} OFFSET {$offset}
  ");
  $stmt->execute($params);
  $products = $stmt->fetchAll();

} // ← this was missing

// Get all categories for filter
$stmt = $pdo->prepare('SELECT * FROM categories WHERE is_active = 1');
$stmt->execute();
$allCategories = $stmt->fetchAll();

$pageTitle = $query ? 'Search: ' . $query : 'Search';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/search.php';
require_once ROOT . '/app/views/layouts/footer.php';