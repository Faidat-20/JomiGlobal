<?php

function loadCartFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('
    SELECT p.id, p.name, p.slug, p.image, p.stock,
      COALESCE(p.sale_price, p.price) as price,
      ci.quantity
    FROM cart_items ci
    LEFT JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ? AND p.is_active = 1
  ');
  $stmt->execute([$userId]);
  $items = $stmt->fetchAll();

  $cart = [];
  foreach ($items as $item) {
    $cart[$item['id']] = [
      'id'       => $item['id'],
      'name'     => $item['name'],
      'price'    => $item['price'],
      'image'    => $item['image'],
      'slug'     => $item['slug'],
      'stock'    => $item['stock'],
      'quantity' => $item['quantity'],
    ];
  }
  return $cart;
}

function saveCartToDB($pdo, $userId, $productId, $quantity) {
  if ($quantity <= 0) {
    $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$userId, $productId]);
  } else {
    $stmt = $pdo->prepare('
      INSERT INTO cart_items (user_id, product_id, quantity)
      VALUES (?, ?, ?)
      ON DUPLICATE KEY UPDATE quantity = ?
    ');
    $stmt->execute([$userId, $productId, $quantity, $quantity]);
  }
}

function clearCartFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ?');
  $stmt->execute([$userId]);
}

function mergeGuestCartToDB($pdo, $userId, $guestCart) {
  foreach ($guestCart as $productId => $item) {
    // Get product stock
    $stmt = $pdo->prepare('SELECT stock FROM products WHERE id = ? AND is_active = 1');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
    if (!$product) continue;

    // Check if already in DB cart
    $stmt = $pdo->prepare('SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$userId, $productId]);
    $existing = $stmt->fetch();

    if ($existing) {
      // Keep higher quantity
      $newQty = max($existing['quantity'], $item['quantity']);
      $newQty = min($newQty, $product['stock']);
    } else {
      $newQty = min($item['quantity'], $product['stock']);
    }

    saveCartToDB($pdo, $userId, $productId, $newQty);
  }
}