<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireAdmin();

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($action === 'add') {
    $stmt = $pdo->prepare('
      INSERT INTO shipping_rates (name, description, price, estimated_days, is_active)
      VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([
      trim($_POST['name']),
      trim($_POST['description']),
      $_POST['price'],
      trim($_POST['estimated_days']),
      isset($_POST['is_active']) ? 1 : 0,
    ]);
    header('Location: ' . APP_URL . '/admin/shipping');
    exit;
  }

  if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare('
      UPDATE shipping_rates SET
        name = ?,
        description = ?,
        price = ?,
        estimated_days = ?,
        is_active = ?
      WHERE id = ?
    ');
    $stmt->execute([
      trim($_POST['name']),
      trim($_POST['description']),
      $_POST['price'],
      trim($_POST['estimated_days']),
      isset($_POST['is_active']) ? 1 : 0,
      $id
    ]);
    header('Location: ' . APP_URL . '/admin/shipping');
    exit;
  }
}

// Handle delete
if ($action === 'delete' && $id) {
  $stmt = $pdo->prepare('DELETE FROM shipping_rates WHERE id = ?');
  $stmt->execute([$id]);
  header('Location: ' . APP_URL . '/admin/shipping');
  exit;
}

// Handle toggle active
if ($action === 'toggle' && $id) {
  $stmt = $pdo->prepare('UPDATE shipping_rates SET is_active = !is_active WHERE id = ?');
  $stmt->execute([$id]);
  header('Location: ' . APP_URL . '/admin/shipping');
  exit;
}

// Get all shipping rates
$stmt = $pdo->prepare('SELECT * FROM shipping_rates ORDER BY price ASC');
$stmt->execute();
$shippingRates = $stmt->fetchAll();

// Get single rate for editing
$editRate = null;
if ($action === 'edit' && $id) {
  $stmt = $pdo->prepare('SELECT * FROM shipping_rates WHERE id = ?');
  $stmt->execute([$id]);
  $editRate = $stmt->fetch();
}

$activePage = 'shipping';
$pageTitle = 'Shipping Rates';
require_once ROOT . '/app/views/admin/shipping.php';