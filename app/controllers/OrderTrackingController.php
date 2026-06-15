<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$pdo = connectDB();

$order = null;
$orderItems = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $orderNumber = trim($_POST['order_number'] ?? '');
  $email       = trim($_POST['email'] ?? '');

  if (empty($orderNumber) || empty($email)) {
    $error = 'Please enter both your order number and email address.';
  } else {
    $stmt = $pdo->prepare('
      SELECT * FROM orders
      WHERE order_number = ? AND shipping_email = ?
    ');
    $stmt->execute([$orderNumber, $email]);
    $order = $stmt->fetch();

    if (!$order) {
      $error = 'No order found with that order number and email. Please check and try again.';
    } else {
      // Get order items
      $stmt = $pdo->prepare('
        SELECT oi.*, p.image
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
      ');
      $stmt->execute([$order['id']]);
      $orderItems = $stmt->fetchAll();
    }
  }
}

$pageTitle = 'Track Your Order';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/order-tracking.php';
require_once ROOT . '/app/views/layouts/footer.php';