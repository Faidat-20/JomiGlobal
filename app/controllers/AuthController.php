<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

// Auto-login via remember me cookie
if (!isLoggedIn() && isset($_COOKIE['remember_token'])) {
  $pdo = connectDB();
  $stmt = $pdo->prepare('SELECT * FROM users WHERE remember_token = ? AND is_active = 1');
  $stmt->execute([$_COOKIE['remember_token']]);
  $rememberedUser = $stmt->fetch();
  if ($rememberedUser) {
    loginUser($rememberedUser);
  }
}

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
    $rememberMe = isset($_POST['remember_me']);

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

        // Remember me — set cookie for 30 days
        if ($rememberMe) {
          $token = bin2hex(random_bytes(32));
          $stmt = $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?');
          $stmt->execute([$token, $user['id']]);
          setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
        }

        if (isAdmin()) {
          header('Location: ' . APP_URL . '/admin');
        } else {
          header('Location: ' . APP_URL);
        }
        exit;
      } else {
        $error = 'Invalid email or password';
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

        $user = [
          'id' => $pdo->lastInsertId(),
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
          'role' => 'customer'
        ];
        loginUser($user);

        require_once ROOT . '/app/helpers/email.php';
        require_once ROOT . '/app/helpers/email-templates.php';
        sendEmail(
          $email,
          $first_name,
          'Welcome to JomiGlobal!',
          welcomeEmailTemplate($first_name)
        );

        header('Location: ' . APP_URL);
        exit;
      }
    }
  }

  // Forgot password — send reset link
  if ($action === 'forgot-password') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
      $error = 'Please enter your email address';
    } else {
      $pdo = connectDB();
      $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
      $stmt->execute([$email]);
      $user = $stmt->fetch();

      // Always show success message even if email doesn't exist (security)
      $success = 'If an account exists with that email, a password reset link has been sent.';

      if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Delete old tokens for this email
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE email = ?');
        $stmt->execute([$email]);

        $stmt = $pdo->prepare('
          INSERT INTO password_resets (email, token, expires_at)
          VALUES (?, ?, ?)
        ');
        $stmt->execute([$email, $token, $expiresAt]);

        $resetLink = APP_URL . '/reset-password?token=' . $token;

        require_once ROOT . '/app/helpers/email.php';
        require_once ROOT . '/app/helpers/email-templates.php';

        $resetHtml = '
        <!DOCTYPE html>
        <html><head><style>
          body { font-family:Arial,sans-serif; background:#f5ede0; margin:0; padding:0; }
          .container { max-width:600px; margin:0 auto; background:#fff; }
          .header { background:#414042; padding:32px; text-align:center; }
          .header img { height:40px; }
          .body { padding:40px 32px; color:#414042; }
          .body h2 { font-size:22px; margin-bottom:16px; }
          .body p { font-size:14px; line-height:1.7; color:#666; margin-bottom:16px; }
          .btn { display:inline-block; background:#ffd05c; color:#414042; padding:14px 32px; text-decoration:none; font-weight:700; font-size:13px; letter-spacing:0.1em; }
          .footer { background:#faf6f0; padding:24px 32px; text-align:center; font-size:12px; color:#999; }
        </style></head>
        <body>
          <div class="container">
            <div class="header"><img src="' . APP_URL . '/assets/images/logo.png" alt="JomiGlobal"></div>
            <div class="body">
              <h2>Reset Your Password</h2>
              <p>We received a request to reset your password. Click the button below to set a new password. This link expires in 1 hour.</p>
              <a href="' . $resetLink . '" class="btn">Reset Password</a>
              <p style="margin-top:24px;font-size:12px;color:#999;">If you did not request this, you can safely ignore this email.</p>
            </div>
            <div class="footer">&copy; ' . date('Y') . ' JomiGlobal. All rights reserved.</div>
          </div>
        </body></html>';

        sendEmail($email, $user['first_name'], 'Reset Your JomiGlobal Password', $resetHtml);
      }
    }
  }

  // Reset password — set new password
  if ($action === 'reset-password') {
    $token = $_POST['token'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
      $error = 'Please fill in all fields';
    } elseif (strlen($newPassword) < 8) {
      $error = 'Password must be at least 8 characters';
    } elseif ($newPassword !== $confirmPassword) {
      $error = 'Passwords do not match';
    } else {
      $pdo = connectDB();
      $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()');
      $stmt->execute([$token]);
      $reset = $stmt->fetch();

      if (!$reset) {
        $error = 'This reset link is invalid or has expired. Please request a new one.';
      } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([$hashedPassword, $reset['email']]);

        // Delete used token
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE email = ?');
        $stmt->execute([$reset['email']]);

        $success = 'Your password has been reset successfully! You can now login.';
      }
    }
  }
}

// Handle reset-password GET (validate token before showing form)
if ($action === 'reset-password' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $token = $_GET['token'] ?? '';
  if (empty($token)) {
    header('Location: ' . APP_URL . '/login?action=forgot-password');
    exit;
  }
  $pdo = connectDB();
  $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()');
  $stmt->execute([$token]);
  $resetCheck = $stmt->fetch();
  if (!$resetCheck) {
    $error = 'This reset link is invalid or has expired. Please request a new one.';
  }
}

// Load the view
$pageTitles = [
  'register' => 'Create Account',
  'forgot-password' => 'Forgot Password',
  'reset-password' => 'Reset Password',
];
$pageTitle = $pageTitles[$action] ?? 'Login';

require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/' . $action . '.php';
require_once ROOT . '/app/views/layouts/footer.php';