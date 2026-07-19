<?php

function loadCartFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('
    SELECT p.id, p.name, p.slug, p.image, p.stock,
      COALESCE(p.sale_price, p.price) as base_price,
      ci.quantity, ci.variant_id, ci.variant_label, ci.variant_price
    FROM cart_items ci
    LEFT JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ? AND p.is_active = 1
  ');
  $stmt->execute([$userId]);
  $items = $stmt->fetchAll();

  $cart = [];
  foreach ($items as $item) {
    $key = $item['id'] . ($item['variant_id'] ? '_' . $item['variant_id'] : '');
    $price = $item['variant_price'] ?? $item['base_price'];
    $cart[$key] = [
      'id'            => $item['id'],
      'name'          => $item['name'],
      'price'         => $price,
      'base_price'    => $item['base_price'],
      'image'         => $item['image'],
      'slug'          => $item['slug'],
      'stock'         => $item['stock'],
      'quantity'      => $item['quantity'],
      'variant_id'    => $item['variant_id'],
      'variant_label' => $item['variant_label'],
      'variant_price' => $item['variant_price'],
    ];
  }
  return $cart;
}

function saveCartToDB($pdo, $userId, $productId, $quantity, $variantId = null, $variantLabel = null, $variantPrice = null) {
  if ($quantity <= 0) {
    if ($variantId) {
      $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ? AND product_id = ? AND variant_id = ?');
      $stmt->execute([$userId, $productId, $variantId]);
    } else {
      $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ? AND product_id = ? AND variant_id IS NULL');
      $stmt->execute([$userId, $productId]);
    }
  } else {
    if ($variantId) {
      $stmt = $pdo->prepare('
        INSERT INTO cart_items (user_id, product_id, quantity, variant_id, variant_label, variant_price)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = ?, variant_label = ?, variant_price = ?
      ');
      $stmt->execute([$userId, $productId, $quantity, $variantId, $variantLabel, $variantPrice, $quantity, $variantLabel, $variantPrice]);
    } else {
      $stmt = $pdo->prepare('
        INSERT INTO cart_items (user_id, product_id, quantity)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = ?
      ');
      $stmt->execute([$userId, $productId, $quantity, $quantity]);
    }
  }
}

function clearCartFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ?');
  $stmt->execute([$userId]);
}

function mergeGuestCartToDB($pdo, $userId, $guestCart) {
  foreach ($guestCart as $key => $item) {
    $productId = $item['id'];
    $stmt = $pdo->prepare('SELECT stock FROM products WHERE id = ? AND is_active = 1');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
    if (!$product) continue;

    $newQty = min($item['quantity'], $product['stock']);
    saveCartToDB(
      $pdo,
      $userId,
      $productId,
      $newQty,
      $item['variant_id'] ?? null,
      $item['variant_label'] ?? null,
      $item['variant_price'] ?? null
    );
  }
}