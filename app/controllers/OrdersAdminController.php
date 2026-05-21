<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireAdmin();

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update-status') {
  $status = $_POST['status'];
  $tracking = trim($_POST['tracking_number'] ?? '');
  $notes = trim($_POST['notes'] ?? '');

  $stmt = $pdo->prepare('
    UPDATE orders SET status = ?, tracking_number = ?, notes = ?
    WHERE id = ?
  ');
  $stmt->execute([$status, $tracking, $notes, $id]);
  header('Location: ' . APP_URL . '/admin/orders');
  exit;
}

// Get all orders
$stmt = $pdo->prepare('
  SELECT o.*, u.first_name, u.last_name, u.email
  FROM orders o
  LEFT JOIN users u ON o.user_id = u.id
  ORDER BY o.created_at DESC
');
$stmt->execute();
$orders = $stmt->fetchAll();

// Get single order
if ($action === 'view' && $id) {
  $stmt = $pdo->prepare('
    SELECT o.*, u.first_name, u.last_name, u.email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
  ');
  $stmt->execute([$id]);
  $order = $stmt->fetch();

  $stmt = $pdo->prepare('
    SELECT oi.*, p.image
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
  ');
  $stmt->execute([$id]);
  $orderItems = $stmt->fetchAll();
}

$activePage = 'orders';
$pageTitle = 'Orders';

if ($action === 'view' && $id) {
  require_once ROOT . '/app/views/admin/order-view.php';
} else {
  require_once ROOT . '/app/views/admin/orders.php';
}