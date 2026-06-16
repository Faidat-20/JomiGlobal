<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireAdmin();

$pdo = connectDB();

// Get real stats
$totalOrders = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$totalRevenue = $pdo->query('SELECT COALESCE(SUM(total), 0) FROM orders WHERE status != "cancelled"')->fetchColumn();
$totalCustomers = $pdo->query('SELECT COUNT(*) FROM users WHERE role = "customer"')->fetchColumn();
$totalProducts = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$totalSubscribers = $pdo->query('SELECT COUNT(*) FROM newsletter_subscribers WHERE is_active = 1')->fetchColumn();

// Get recent orders
$stmt = $pdo->prepare('
  SELECT o.*, u.first_name, u.last_name
  FROM orders o
  LEFT JOIN users u ON o.user_id = u.id
  ORDER BY o.created_at DESC
  LIMIT 5
');
$stmt->execute();
$recentOrders = $stmt->fetchAll();

$pageTitle = 'Dashboard';
$activePage = 'dashboard';

require_once ROOT . '/app/views/admin/dashboard.php';