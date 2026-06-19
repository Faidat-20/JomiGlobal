<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if (empty($name) || empty($email) || empty($message)) {
    $error = 'Please fill in all required fields.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Please enter a valid email address.';
  } else {
    require_once ROOT . '/app/helpers/email.php';
    require_once ROOT . '/app/helpers/email-templates.php';
    require_once ROOT . '/config/email.php';

    // Email to owner
    $ownerHtml = '
    <!DOCTYPE html>
    <html>
    <head><style>
      body { font-family:Arial,sans-serif; background:#f5ede0; margin:0; padding:0; }
      .container { max-width:600px; margin:0 auto; background:#fff; }
      .header { background:#414042; padding:32px; text-align:center; }
      .header img { height:40px; }
      .body { padding:40px 32px; }
      .body h2 { font-size:20px; color:#414042; margin-bottom:16px; }
      .field { margin-bottom:16px; border-bottom:1px solid #f0f0f0; padding-bottom:16px; }
      .field label { font-size:11px; text-transform:uppercase; letter-spacing:0.1em; color:#888; display:block; margin-bottom:4px; }
      .field p { font-size:14px; color:#414042; margin:0; line-height:1.6; }
      .footer { background:#faf6f0; padding:20px 32px; text-align:center; font-size:12px; color:#999; }
    </style></head>
    <body>
      <div class="container">
        <div class="header">
          <img src="' . APP_URL . '/assets/images/logo.png" alt="JomiGlobal">
        </div>
        <div class="body">
          <h2>New Contact Message</h2>
          <div class="field"><label>Name</label><p>' . htmlspecialchars($name) . '</p></div>
          <div class="field"><label>Email</label><p>' . htmlspecialchars($email) . '</p></div>
          <div class="field"><label>Subject</label><p>' . htmlspecialchars($subject) . '</p></div>
          <div class="field"><label>Message</label><p>' . nl2br(htmlspecialchars($message)) . '</p></div>
        </div>
        <div class="footer">JomiGlobal Contact Form</div>
      </div>
    </body>
    </html>';

    // Send to owner
    sendEmail(MAIL_FROM_EMAIL, 'JomiGlobal', 'New Contact Message: ' . $subject, $ownerHtml);

    // Auto reply to customer
    $replyHtml = '
    <!DOCTYPE html>
    <html>
    <head><style>
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
        <div class="header">
          <img src="' . APP_URL . '/assets/images/logo.png" alt="JomiGlobal">
        </div>
        <div class="body">
          <h2>Thank you for reaching out, ' . htmlspecialchars($name) . '!</h2>
          <p>We have received your message and will get back to you within 24 hours.</p>
          <p>In the meantime, feel free to explore our latest collections.</p>
          <a href="' . APP_URL . '/shop" class="btn">Explore Collections</a>
        </div>
        <div class="footer">&copy; ' . date('Y') . ' JomiGlobal. All rights reserved.</div>
      </div>
    </body>
    </html>';

    sendEmail($email, $name, 'We received your message — JomiGlobal', $replyHtml);

    $success = 'Your message has been sent successfully! We\'ll get back to you within 24 hours.';
  }
}

$pageTitle = 'Contact Us';
require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/pages/contact.php';
require_once ROOT . '/app/views/layouts/footer.php';