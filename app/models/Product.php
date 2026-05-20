<?php

class Product {
  private $pdo;

  public function __construct() {
    $this->pdo = connectDB();
  }

  // Get all products
  public function getAll() {
    $stmt = $this->pdo->prepare('
      SELECT p.*, c.name as category_name
      FROM products p
      LEFT JOIN categories c ON p.category_id = c.id
      ORDER BY p.created_at DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Get single product by id
  public function getById($id) {
    $stmt = $this->pdo->prepare('
      SELECT p.*, c.name as category_name
      FROM products p
      LEFT JOIN categories c ON p.category_id = c.id
      WHERE p.id = ?
    ');
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  // Get product by slug
  public function getBySlug($slug) {
    $stmt = $this->pdo->prepare('
      SELECT p.*, c.name as category_name
      FROM products p
      LEFT JOIN categories c ON p.category_id = c.id
      WHERE p.slug = ?
    ');
    $stmt->execute([$slug]);
    return $stmt->fetch();
  }

  // Create product
  public function create($data) {
    $stmt = $this->pdo->prepare('
      INSERT INTO products (
        category_id, name, slug, description,
        price, sale_price, stock, sku,
        brand, is_featured, is_active
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ');
    $stmt->execute([
      $data['category_id'],
      $data['name'],
      $data['slug'],
      $data['description'],
      $data['price'],
      $data['sale_price'] ?: null,
      $data['stock'],
      $data['sku'] ?: null,
      $data['brand'] ?: null,
      $data['is_featured'] ?? 0,
      $data['is_active'] ?? 1
    ]);
    return $this->pdo->lastInsertId();
  }

  // Update product
  public function update($id, $data) {
    $stmt = $this->pdo->prepare('
      UPDATE products SET
        category_id = ?,
        name = ?,
        slug = ?,
        description = ?,
        price = ?,
        sale_price = ?,
        stock = ?,
        sku = ?,
        brand = ?,
        is_featured = ?,
        is_active = ?
      WHERE id = ?
    ');
    return $stmt->execute([
      $data['category_id'],
      $data['name'],
      $data['slug'],
      $data['description'],
      $data['price'],
      $data['sale_price'] ?: null,
      $data['stock'],
      $data['sku'] ?: null,
      $data['brand'] ?: null,
      $data['is_featured'] ?? 0,
      $data['is_active'] ?? 1,
      $id
    ]);
  }

  // Delete product
  public function delete($id) {
    $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = ?');
    return $stmt->execute([$id]);
  }

  // Update product image
  public function updateImage($id, $image) {
    $stmt = $this->pdo->prepare('
      UPDATE products SET image = ? WHERE id = ?
    ');
    return $stmt->execute([$image, $id]);
  }

  // Generate slug from name
  public function generateSlug($name) {
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    // Check if slug exists and make unique
    $original = $slug;
    $count = 1;
    while ($this->slugExists($slug)) {
      $slug = $original . '-' . $count;
      $count++;
    }
    return $slug;
  }

  private function slugExists($slug) {
    $stmt = $this->pdo->prepare('SELECT id FROM products WHERE slug = ?');
    $stmt->execute([$slug]);
    return $stmt->fetch() ? true : false;
  }

  // Get all categories for dropdown
  public function getCategories() {
    $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE is_active = 1');
    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Count total products
  public function count() {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM products');
    $stmt->execute();
    return $stmt->fetch()['total'];
  }
}