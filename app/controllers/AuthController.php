<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

// If already logged in redirect away
if (isLoggedIn()) {
  if (isAdmin()) {
    header('Location: ' . APP_URL . '/admin');
  } else {
    header('Location: ' . APP_URL);
  }
  exit;
}

// Get current action from URL
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      $error = 'Please fill in all fields';
    } else {
      $pdo = connectDB();
      $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND is_active = 1');
      $stmt->execute([$email]);
      $user = $stmt->fetch();

      if ($user && password_verify($password, $user['password'])) {
        require_once ROOT . '/app/helpers/cart.php';
        require_once ROOT . '/app/helpers/wishlist.php';
        $pdo = connectDB();

        // Merge guest cart
        if (!empty($_SESSION['cart'])) {
          mergeGuestCartToDB($pdo, $user['id'], $_SESSION['cart']);
        }

        // Merge guest wishlist
        if (!empty($_SESSION['wishlist'])) {
          mergeGuestWishlistToDB($pdo, $user['id'], $_SESSION['wishlist']);
        }

        loginUser($user);

        // Load fresh cart and wishlist from DB
        $_SESSION['cart']    = loadCartFromDB($pdo, $user['id']);
        $_SESSION['wishlist'] = loadWishlistFromDB($pdo, $user['id']);

        if (isAdmin()) {
          header('Location: ' . APP_URL . '/admin');
        } else {
          header('Location: ' . APP_URL);
        }
        exit;
      }
    }
  }

  if ($action === 'register') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
      $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Please enter a valid email address';
    } elseif (strlen($password) < 8) {
      $error = 'Password must be at least 8 characters';
    } elseif ($password !== $confirm_password) {
      $error = 'Passwords do not match';
    } else {
      $pdo = connectDB();

      // Check if email already exists
      $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
      $stmt->execute([$email]);

      if ($stmt->fetch()) {
        $error = 'An account with this email already exists';
      } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('
          INSERT INTO users (first_name, last_name, email, password)
          VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([$first_name, $last_name, $email, $hashedPassword]);

        // Log them in immediately
        $user = [
          'id' => $pdo->lastInsertId(),
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
          'role' => 'customer'
        ];
        loginUser($user);
        header('Location: ' . APP_URL);
        exit;
      }
    }
  }
}

// Load the view
$pageTitle = $action === 'register' ? 'Create Account' : 'Login';
require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/' . $action . '.php';
require_once ROOT . '/app/views/layouts/footer.php';