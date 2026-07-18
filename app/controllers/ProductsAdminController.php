<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/models/Product.php';

requireAdmin();

$product = new Product();
$action  = isset($_GET['action']) ? $_GET['action'] : 'list';
$id      = isset($_GET['id']) ? (int)$_GET['id'] : null;

// ============ IMAGE UPLOAD HELPER ============
function uploadProductImage($file) {
  if ($file['error'] !== UPLOAD_ERR_OK) {
    return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
  }
  $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
  $maxSize      = 5 * 1024 * 1024;
  $ext          = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

  if (!in_array($ext, $allowedTypes)) {
    return ['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, WEBP allowed.'];
  }
  if ($file['size'] > $maxSize) {
    return ['success' => false, 'error' => 'File too large. Maximum size is 5MB.'];
  }

  $filename   = 'product_' . uniqid() . '.' . $ext;
  $uploadPath = ROOT . '/public/uploads/' . $filename;

  if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    return ['success' => true, 'filename' => $filename];
  }
  return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

// ============ HANDLE POST ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // ---- ADD PRODUCT ----
  if ($action === 'add') {
    $data = [
      'category_id'    => $_POST['category_id'],
      'subcategory_id' => $_POST['subcategory_id'] ?: null,
      'name'           => trim($_POST['name']),
      'slug'           => $product->generateSlug($_POST['name']),
      'description'    => trim($_POST['description']),
      'price'          => $_POST['price'],
      'sale_price'     => $_POST['sale_price'] ?: null,
      'stock'          => $_POST['stock'],
      'sku'            => trim($_POST['sku']),
      'brand'          => trim($_POST['brand']),
      'is_featured'    => isset($_POST['is_featured']) ? 1 : 0,
      'is_active'      => isset($_POST['is_active']) ? 1 : 0,
    ];

    // Upload images
    $uploadedImages = [];
    if (!empty($_FILES['images']['name'][0])) {
      foreach ($_FILES['images']['name'] as $i => $name) {
        if (empty($name) || $_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
        $file = [
          'name'     => $_FILES['images']['name'][$i],
          'type'     => $_FILES['images']['type'][$i],
          'tmp_name' => $_FILES['images']['tmp_name'][$i],
          'error'    => $_FILES['images']['error'][$i],
          'size'     => $_FILES['images']['size'][$i],
        ];
        $result = uploadProductImage($file);
        if ($result['success']) {
          $uploadedImages[] = $result['filename'];
        }
      }
    }

    // Set main image
    if (!empty($uploadedImages)) {
      $data['image'] = $uploadedImages[0];
    }

    $newId = $product->create($data);

    if ($newId) {
      // Save images to product_images table
      if (!empty($uploadedImages)) {
        $product->saveImages($newId, $uploadedImages, 0);
      }

      // Save collections
      $collections = $_POST['collections'] ?? [];
      $product->saveCollections($newId, $collections);

      // Save variants
      $variantTypes  = $_POST['variant_type'] ?? [];
      $variantValues = $_POST['variant_value'] ?? [];
      $variantPrices = $_POST['variant_price'] ?? [];
      $variantStocks = $_POST['variant_stock'] ?? [];

      $variants = [];
      foreach ($variantValues as $i => $value) {
        if (!empty(trim($value))) {
          $variants[] = [
            'type'           => $variantTypes[$i] ?? 'size',
            'value'          => trim($value),
            'price_modifier' => $variantPrices[$i] ?? 0,
            'stock'          => $variantStocks[$i] ?? 0,
          ];
        }
      }
      if (!empty($variants)) {
        $product->saveVariants($newId, $variants);
      }

      header('Location: ' . APP_URL . '/admin/products');
      exit;
    } else {
      $error = 'Failed to add product. Please try again.';
    }
  }

  // ---- EDIT PRODUCT ----
  if ($action === 'edit' && $id) {
    $data = [
      'category_id'    => $_POST['category_id'],
      'subcategory_id' => $_POST['subcategory_id'] ?: null,
      'name'           => trim($_POST['name']),
      'slug'           => $_POST['slug'],
      'description'    => trim($_POST['description']),
      'price'          => $_POST['price'],
      'sale_price'     => $_POST['sale_price'] ?: null,
      'stock'          => $_POST['stock'],
      'sku'            => trim($_POST['sku']),
      'brand'          => trim($_POST['brand']),
      'is_featured'    => isset($_POST['is_featured']) ? 1 : 0,
      'is_active'      => isset($_POST['is_active']) ? 1 : 0,
    ];

    // Upload new images if provided
    $uploadedImages = [];
    if (!empty($_FILES['images']['name'][0])) {
      foreach ($_FILES['images']['name'] as $i => $name) {
        if (empty($name) || $_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
        $file = [
          'name'     => $_FILES['images']['name'][$i],
          'type'     => $_FILES['images']['type'][$i],
          'tmp_name' => $_FILES['images']['tmp_name'][$i],
          'error'    => $_FILES['images']['error'][$i],
          'size'     => $_FILES['images']['size'][$i],
        ];
        $result = uploadProductImage($file);
        if ($result['success']) {
          $uploadedImages[] = $result['filename'];
        }
      }
    }

   // Merge kept existing images with any newly uploaded ones
    $existingImages = $_POST['existing_images'] ?? [];
    $allImages = array_merge($existingImages, $uploadedImages);

    if (isset($_POST['images_section_present'])) {
      $mainImage = $allImages[0] ?? null;
      $data['image'] = $mainImage;
      $product->updateImage($id, $mainImage);
      $product->saveImages($id, $allImages, 0);
    }

    $product->update($id, $data);

    // Save collections
    $collections = $_POST['collections'] ?? [];
    $product->saveCollections($id, $collections);

    // Save variants
    $variantTypes  = $_POST['variant_type'] ?? [];
    $variantValues = $_POST['variant_value'] ?? [];
    $variantPrices = $_POST['variant_price'] ?? [];
    $variantStocks = $_POST['variant_stock'] ?? [];

    $variants = [];
    foreach ($variantValues as $i => $value) {
      if (!empty(trim($value))) {
        $variants[] = [
          'type'           => $variantTypes[$i] ?? 'size',
          'value'          => trim($value),
          'price_modifier' => $variantPrices[$i] ?? 0,
          'stock'          => $variantStocks[$i] ?? 0,
        ];
      }
    }
    $product->saveVariants($id, $variants);

    header('Location: ' . APP_URL . '/admin/products');
    exit;
  }
}

// ============ HANDLE DELETE ============
if ($action === 'delete' && $id) {
  $product->delete($id);
  header('Location: ' . APP_URL . '/admin/products');
  exit;
}

// ============ LOAD VIEWS ============
$activePage = 'products';
$pdo = connectDB();

if ($action === 'add') {
  $pageTitle        = 'Add Product';
  $categories       = $product->getCategories();
  $subcategories    = $product->getSubcategories();
  $productCollections = [];
  $editVariants     = [];
  $editImages       = [];
  require_once ROOT . '/app/views/admin/add-product.php';

} elseif ($action === 'edit' && $id) {
  $pageTitle          = 'Edit Product';
  $categories         = $product->getCategories();
  $subcategories      = $product->getSubcategories();
  $editProduct        = $product->getById($id);
  $productCollections = $product->getProductCollections($id);
  $editVariants       = $product->getVariants($id);
  $editImages = $product->getImages($id);
  if (empty($editImages) && !empty($editProduct['image'])) {
    $editImages = [['image' => $editProduct['image']]];
  }
  require_once ROOT . '/app/views/admin/add-product.php';

} else {
  $pageTitle = 'Products';
  $products  = $product->getAll();
  require_once ROOT . '/app/views/admin/products.php';
}