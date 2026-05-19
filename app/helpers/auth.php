<?php

function isLoggedIn() {
  return isset($_SESSION['user_id']);
}

function isAdmin() {
  return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin() {
  if (!isLoggedIn()) {
    header('Location: ' . APP_URL . '/login');
    exit;
  }
}

function requireAdmin() {
  if (!isLoggedIn() || !isAdmin()) {
    header('Location: ' . APP_URL . '/login');
    exit;
  }
}

function loginUser($user) {
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['first_name'] = $user['first_name'];
  $_SESSION['last_name'] = $user['last_name'];
  $_SESSION['email'] = $user['email'];
  $_SESSION['role'] = $user['role'];
}

function logoutUser() {
  session_destroy();
  header('Location: ' . APP_URL . '/login');
  exit;
}

function getCurrentUser() {
  if (!isLoggedIn()) return null;
  return [
    'id' => $_SESSION['user_id'],
    'first_name' => $_SESSION['first_name'],
    'last_name' => $_SESSION['last_name'],
    'email' => $_SESSION['email'],
    'role' => $_SESSION['role']
  ];
}