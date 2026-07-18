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
        category_id, subcategory_id, name, slug, description,
        price, sale_price, stock, sku,
        brand, is_featured, is_active, image
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ');
    $stmt->execute([
      $data['category_id'],
      $data['subcategory_id'] ?? null,
      $data['name'],
      $data['slug'],
      $data['description'],
      $data['price'],
      $data['sale_price'],
      $data['stock'],
      $data['sku'] ?: null,
      $data['brand'] ?: null,
      $data['is_featured'],
      $data['is_active'],
      $data['image'] ?? null
    ]);
    return $this->pdo->lastInsertId();
  }

  // Update product
  public function update($id, $data) {
    $stmt = $this->pdo->prepare('
      UPDATE products SET
        category_id = ?,
        subcategory_id = ?,
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
      $data['subcategory_id'] ?? null,
      $data['name'],
      $data['slug'],
      $data['description'],
      $data['price'],
      $data['sale_price'],
      $data['stock'],
      $data['sku'] ?: null,
      $data['brand'] ?: null,
      $data['is_featured'],
      $data['is_active'],
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

  public function getSubcategories($category_id = null) {
    if ($category_id) {
      $stmt = $this->pdo->prepare('
        SELECT * FROM subcategories 
        WHERE category_id = ? AND is_active = 1
        ORDER BY parent_id ASC, name ASC
      ');
      $stmt->execute([$category_id]);
    } else {
      $stmt = $this->pdo->prepare('
        SELECT s.*, c.name as category_name 
        FROM subcategories s
        LEFT JOIN categories c ON s.category_id = c.id
        WHERE s.is_active = 1
        ORDER BY s.category_id, s.parent_id ASC, s.name ASC
      ');
      $stmt->execute();
    }
    return $stmt->fetchAll();
  }

  public function getProductCollections($productId) {
    $stmt = $this->pdo->prepare('
      SELECT collection_id FROM product_collections WHERE product_id = ?
    ');
    $stmt->execute([$productId]);
    return array_column($stmt->fetchAll(), 'collection_id');
  }

  public function saveCollections($productId, $collectionIds) {
    // Delete existing
    $stmt = $this->pdo->prepare('DELETE FROM product_collections WHERE product_id = ?');
    $stmt->execute([$productId]);

    // Insert new
    if (!empty($collectionIds)) {
      $stmt = $this->pdo->prepare('
        INSERT INTO product_collections (product_id, collection_id) VALUES (?, ?)
      ');
      foreach ($collectionIds as $collectionId) {
        $stmt->execute([$productId, (int)$collectionId]);
      }
    }
  }
  // Count total products
  public function count() {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM products');
    $stmt->execute();
    return $stmt->fetch()['total'];
  }

  // Get all images for a product
  public function getImages($productId) {
    $stmt = $this->pdo->prepare('
      SELECT * FROM product_images
      WHERE product_id = ?
      ORDER BY is_main DESC, sort_order ASC
    ');
    $stmt->execute([$productId]);
    return $stmt->fetchAll();
  }

  // Save product images
  public function saveImages($productId, $images, $mainIndex = 0) {
    // Delete existing images
    $stmt = $this->pdo->prepare('DELETE FROM product_images WHERE product_id = ?');
    $stmt->execute([$productId]);

    // Insert new images
    $stmt = $this->pdo->prepare('
      INSERT INTO product_images (product_id, image, is_main, sort_order)
      VALUES (?, ?, ?, ?)
    ');
    foreach ($images as $i => $image) {
      $stmt->execute([$productId, $image, ($i === $mainIndex) ? 1 : 0, $i]);
    }
  }

  // Get variants for a product
  public function getVariants($productId) {
    $stmt = $this->pdo->prepare('
      SELECT * FROM product_variants
      WHERE product_id = ? AND is_active = 1
      ORDER BY type, value
    ');
    $stmt->execute([$productId]);
    return $stmt->fetchAll();
  }

  // Save product variants
  public function saveVariants($productId, $variants) {
    // Delete existing variants
    $stmt = $this->pdo->prepare('DELETE FROM product_variants WHERE product_id = ?');
    $stmt->execute([$productId]);

    // Insert new variants
    if (!empty($variants)) {
      $stmt = $this->pdo->prepare('
        INSERT INTO product_variants (product_id, type, value, price_modifier, stock)
        VALUES (?, ?, ?, ?, ?)
      ');
      foreach ($variants as $variant) {
        if (!empty($variant['value'])) {
          $stmt->execute([
            $productId,
            $variant['type'],
            $variant['value'],
            $variant['price_modifier'] ?? 0,
            $variant['stock'] ?? 0,
          ]);
        }
      }
    }
  }

  // Get grouped variants
  public function getGroupedVariants($productId) {
    $variants = $this->getVariants($productId);
    $grouped = [];
    foreach ($variants as $variant) {
      $grouped[$variant['type']][] = $variant;
    }
    return $grouped;
  }
}