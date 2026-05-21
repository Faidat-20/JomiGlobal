<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireAdmin();

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Toggle active status
if ($action === 'toggle' && $id) {
  $stmt = $pdo->prepare('UPDATE users SET is_active = !is_active WHERE id = ? AND role = "customer"');
  $stmt->execute([$id]);
  header('Location: ' . APP_URL . '/admin/customers');
  exit;
}

// Get all customers
$stmt = $pdo->prepare('
  SELECT u.*,
    COUNT(o.id) as total_orders,
    COALESCE(SUM(o.total), 0) as total_spent
  FROM users u
  LEFT JOIN orders o ON u.id = o.user_id
  WHERE u.role = "customer"
  GROUP BY u.id
  ORDER BY u.created_at DESC
');
$stmt->execute();
$customers = $stmt->fetchAll();

$activePage = 'customers';
$pageTitle = 'Customers';
require_once ROOT . '/app/views/admin/customers.php';