<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/helpers/email.php';
require_once ROOT . '/app/helpers/email-templates.php';

$pdo = connectDB();

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$name  = trim($_POST['name'] ?? 'Subscriber');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
  exit;
}

// Check if already subscribed
$stmt = $pdo->prepare('SELECT id FROM newsletter_subscribers WHERE email = ?');
$stmt->execute([$email]);
$existing = $stmt->fetch();

if ($existing) {
  echo json_encode(['success' => false, 'message' => 'You are already subscribed!']);
  exit;
}

// Save to database
$stmt = $pdo->prepare('INSERT INTO newsletter_subscribers (email, name) VALUES (?, ?)');
$stmt->execute([$email, $name]);

// Send welcome newsletter email
sendEmail(
  $email,
  $name,
  'Welcome to JomiGlobal Updates!',
  newsletterWelcomeTemplate()
);

echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
exit;