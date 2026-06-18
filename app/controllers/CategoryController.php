<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

// Get URL segments
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$basePath = '/JomiGlobal/public/';
$url = str_replace($basePath, '', $url);
$url = strtok($url, '?');
$url = trim($url, '/');

$segments = explode('/', $url);
// segments[0] = 'category'
// segments[1] = category slug e.g. 'jewelry'
// segments[2] = group slug e.g. 'jewelry-for-her' (optional)
// segments[3] = subcategory slug e.g. 'jewelry-her-rings' (optional)

$categorySlug = $segments[1] ?? null;
$groupSlug    = $segments[2] ?? null;
$subSlug      = $segments[3] ?? null;

if (!$categorySlug) {
  header('Location: ' . APP_URL . '/shop');
  exit;
}

// Get category
$stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ? AND is_active = 1');
$stmt->execute([$categorySlug]);
$category = $stmt->fetch();

if (!$category) {
  http_response_code(404);
  echo "Category not found";
  exit;
}

// ============ LEVEL 3: Subcategory products ============
if ($subSlug) {
  $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE slug = ?');
  $stmt->execute([$subSlug]);
  $subcategory = $stmt->fetch();

  $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE slug = ?');
  $stmt->execute([$groupSlug]);
  $group = $stmt->fetch();

  // Get products
  $sort = $_GET['sort'] ?? 'newest';
  $orderBy = match($sort) {
    'price_asc'  => 'p.price ASC',
    'price_desc' => 'p.price DESC',
    'name_asc'   => 'p.name ASC',
    default      => 'p.created_at DESC',
  };

  $stmt = $pdo->prepare("
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.subcategory_id = ? AND p.is_active = 1
    ORDER BY $orderBy
  ");
  $stmt->execute([$subcategory['id']]);
  $products = $stmt->fetchAll();

  $pageTitle = $subcategory['name'] . ' - ' . $category['name'];

  require_once ROOT . '/app/views/layouts/header.php';
  require_once ROOT . '/app/views/layouts/nav.php';
  require_once ROOT . '/app/views/pages/subcategory.php';
  require_once ROOT . '/app/views/layouts/footer.php';
  exit;
}

// ============ LEVEL 2: Group subcategories OR products ============
if ($groupSlug) {
  $stmt = $pdo->prepare('SELECT * FROM subcategories WHERE slug = ?');
  $stmt->execute([$groupSlug]);
  $group = $stmt->fetch();

  if (!$group) {
    http_response_code(404);
    echo "Group not found";
    exit;
  }

  // Get subcategories of this group
  $stmt = $pdo->prepare('
    SELECT * FROM subcategories
    WHERE parent_id = ? AND is_active = 1
  ');
  $stmt->execute([$group['id']]);
  $subcategories = $stmt->fetchAll();

  // If this group has no children, it's a leaf — show products directly
  if (empty($subcategories)) {
    unset($subcategories);

    $sort = $_GET['sort'] ?? 'newest';
    $orderBy = match($sort) {
      'price_asc'  => 'p.price ASC',
      'price_desc' => 'p.price DESC',
      'name_asc'   => 'p.name ASC',
      default      => 'p.created_at DESC',
    };

    $minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
    $maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;

    $sql = "
      SELECT p.*, c.name as category_name
      FROM products p
      LEFT JOIN categories c ON p.category_id = c.id
      WHERE p.subcategory_id = ? AND p.is_active = 1
    ";
    $params = [$group['id']];

    if ($minPrice !== null) {
      $sql .= " AND COALESCE(p.sale_price, p.price) >= ?";
      $params[] = $minPrice;
    }
    if ($maxPrice !== null) {
      $sql .= " AND COALESCE(p.sale_price, p.price) <= ?";
      $params[] = $maxPrice;
    }

    $sql .= " ORDER BY $orderBy";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    // Leaf group — no separate subcategory level
    $isLeafGroup = true;
  }

  $pageTitle = $group['name'] . ' - ' . $category['name'];

  require_once ROOT . '/app/views/layouts/header.php';
  require_once ROOT . '/app/views/layouts/nav.php';
  require_once ROOT . '/app/views/pages/subcategory.php';
  require_once ROOT . '/app/views/layouts/footer.php';
  exit;
}

// ============ LEVEL 1: Category landing ============
// Get top level groups (parent_id IS NULL)
$stmt = $pdo->prepare('
  SELECT * FROM subcategories
  WHERE category_id = ? AND parent_id IS NULL AND is_active = 1
');
$stmt->execute([$category['id']]);
$groups = $stmt->fetchAll();

$pageTitle = $category['name'];

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/category.php';
require_once ROOT . '/app/views/layouts/footer.php';