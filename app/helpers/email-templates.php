<?php

function emailWrapper($content) {
  return '
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <style>
      body { margin:0; padding:0; background:#f5ede0; font-family: Arial, sans-serif; }
      .container { max-width: 600px; margin: 0 auto; background:#ffffff; }
      .header { background:#414042; padding: 32px; text-align:center; }
      .header img { height: 40px; }
      .body { padding: 40px 32px; color:#414042; }
      .body h2 { font-size: 22px; margin-bottom: 16px; }
      .body p { font-size: 14px; line-height: 1.7; color:#666; margin-bottom: 16px; }
      .btn { display:inline-block; background:#ffd05c; color:#414042; padding: 14px 32px; border-radius: 8px; text-decoration:none; font-weight:600; font-size:14px; margin-top: 8px; }
      .footer { background:#faf6f0; padding: 24px 32px; text-align:center; font-size:12px; color:#999; }
      .order-table { width:100%; border-collapse: collapse; margin: 20px 0; }
      .order-table th, .order-table td { text-align:left; padding: 10px; font-size: 13px; border-bottom: 1px solid #eee; }
      .total-row { font-weight: bold; font-size: 15px; }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <img src="' . APP_URL . '/assets/images/logo.png" alt="JomiGlobal">
      </div>
      <div class="body">
        ' . $content . '
      </div>
      <div class="footer">
        <p>&copy; ' . date('Y') . ' JomiGlobal. All rights reserved.</p>
        <p>Luxury Jewelry, Perfume & Glasses</p>
      </div>
    </div>
  </body>
  </html>
  ';
}

function welcomeEmailTemplate($firstName) {
  $content = '
    <h2>Welcome to JomiGlobal, ' . htmlspecialchars($firstName) . '! 🎉</h2>
    <p>Thank you for joining JomiGlobal — your destination for exquisite jewelry, perfumes, and eyewear.</p>
    <p>Explore our latest collections and find pieces that speak to your style.</p>
    <a href="' . APP_URL . '/shop" class="btn">Start Shopping</a>
  ';
  return emailWrapper($content);
}

function orderConfirmationTemplate($order, $items) {
  $rows = '';
  foreach ($items as $item) {
    $rows .= '<tr>
      <td>' . htmlspecialchars($item['product_name']) . '</td>
      <td>' . $item['quantity'] . '</td>
      <td>' . CURRENCY_SYMBOL . number_format($item['price'], 2) . '</td>
      <td>' . CURRENCY_SYMBOL . number_format($item['total'], 2) . '</td>
    </tr>';
  }

  $content = '
    <h2>Order Confirmed! ✅</h2>
    <p>Hi ' . htmlspecialchars($order['shipping_first_name']) . ', thank you for your order. We\'ve received it and will begin processing shortly.</p>
    <p><strong>Order Number:</strong> ' . htmlspecialchars($order['order_number']) . '</p>
    <table class="order-table">
      <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
      ' . $rows . '
      <tr class="total-row"><td colspan="3">Total</td><td>' . CURRENCY_SYMBOL . number_format($order['total'], 2) . '</td></tr>
    </table>
    <p>We\'ll notify you when your order ships.</p>
    <a href="' . APP_URL . '/order-tracking" class="btn">Track Your Order</a>
  ';
  return emailWrapper($content);
}

function orderShippedTemplate($order) {
  $trackingInfo = $order['tracking_number']
    ? '<p><strong>Tracking Number:</strong> ' . htmlspecialchars($order['tracking_number']) . '</p>'
    : '';

  $content = '
    <h2>Your Order Has Shipped! 🚚</h2>
    <p>Hi ' . htmlspecialchars($order['shipping_first_name']) . ', great news — your order is on its way!</p>
    <p><strong>Order Number:</strong> ' . htmlspecialchars($order['order_number']) . '</p>
    ' . $trackingInfo . '
    <a href="' . APP_URL . '/order-tracking" class="btn">Track Your Order</a>
  ';
  return emailWrapper($content);
}

function orderDeliveredTemplate($order) {
  $content = '
    <h2>Your Order Has Been Delivered! 📦</h2>
    <p>Hi ' . htmlspecialchars($order['shipping_first_name']) . ', your order has arrived!</p>
    <p><strong>Order Number:</strong> ' . htmlspecialchars($order['order_number']) . '</p>
    <p>We hope you love your new pieces. If you have a moment, we\'d appreciate your feedback.</p>
    <a href="' . APP_URL . '/shop" class="btn">Shop More</a>
  ';
  return emailWrapper($content);
}

function newsletterWelcomeTemplate() {
  $content = '
    <h2>You\'re Subscribed! ✨</h2>
    <p>Thank you for subscribing to JomiGlobal updates. You\'ll be the first to know about new collections, exclusive offers, and luxury finds.</p>
    <a href="' . APP_URL . '/shop" class="btn">Explore Now</a>
  ';
  return emailWrapper($content);
}