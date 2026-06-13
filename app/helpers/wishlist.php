<?php

function loadWishlistFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('
    SELECT p.id, p.name, p.slug, p.image,
      COALESCE(p.sale_price, p.price) as price,
      c.name as category_name
    FROM wishlist_items wi
    LEFT JOIN products p ON wi.product_id = p.id
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE wi.user_id = ? AND p.is_active = 1
  ');
  $stmt->execute([$userId]);
  $items = $stmt->fetchAll();

  $wishlist = [];
  foreach ($items as $item) {
    $wishlist[$item['id']] = [
      'id'            => $item['id'],
      'name'          => $item['name'],
      'price'         => $item['price'],
      'image'         => $item['image'],
      'slug'          => $item['slug'],
      'category_name' => $item['category_name'] ?? '',
    ];
  }
  return $wishlist;
}

function saveWishlistToDB($pdo, $userId, $productId) {
  $stmt = $pdo->prepare('
    INSERT IGNORE INTO wishlist_items (user_id, product_id)
    VALUES (?, ?)
  ');
  $stmt->execute([$userId, $productId]);
}

function removeWishlistFromDB($pdo, $userId, $productId) {
  $stmt = $pdo->prepare('DELETE FROM wishlist_items WHERE user_id = ? AND product_id = ?');
  $stmt->execute([$userId, $productId]);
}

function clearWishlistFromDB($pdo, $userId) {
  $stmt = $pdo->prepare('DELETE FROM wishlist_items WHERE user_id = ?');
  $stmt->execute([$userId]);
}

function mergeGuestWishlistToDB($pdo, $userId, $guestWishlist) {
  foreach ($guestWishlist as $productId => $item) {
    saveWishlistToDB($pdo, $userId, $productId);
  }
}