<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireLogin();

$pdo = connectDB();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name  = trim($_POST['last_name'] ?? '');
  $phone      = trim($_POST['phone'] ?? '');
  $address    = trim($_POST['address'] ?? '');
  $city       = trim($_POST['city'] ?? '');
  $state      = trim($_POST['state'] ?? '');

  $stmt = $pdo->prepare('
    UPDATE users SET
      first_name = ?,
      last_name = ?,
      phone = ?,
      address = ?,
      city = ?,
      state = ?
    WHERE id = ?
  ');
  $stmt->execute([
    $first_name, $last_name, $phone,
    $address, $city, $state, $user_id
  ]);

  // Update session
  $_SESSION['first_name'] = $first_name;
  $_SESSION['last_name']  = $last_name;

  $success = 'Profile updated successfully!';
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'password') {
  $current  = $_POST['current_password'];
  $new      = $_POST['new_password'];
  $confirm  = $_POST['confirm_password'];

  $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
  $stmt->execute([$user_id]);
  $user = $stmt->fetch();

  if (!password_verify($current, $user['password'])) {
    $error = 'Current password is incorrect';
  } elseif (strlen($new) < 8) {
    $error = 'New password must be at least 8 characters';
  } elseif ($new !== $confirm) {
    $error = 'Passwords do not match';
  } else {
    $hashed = password_hash($new, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->execute([$hashed, $user_id]);
    $success = 'Password changed successfully!';
  }
}

// Get user data
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Get user orders
$stmt = $pdo->prepare('
  SELECT * FROM orders
  WHERE user_id = ?
  ORDER BY created_at DESC
  LIMIT 10
');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

$wishlistItems = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];
$pageTitle = 'My Account';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/account.php';
require_once ROOT . '/app/views/layouts/footer.php';