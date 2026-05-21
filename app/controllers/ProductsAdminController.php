<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';
require_once ROOT . '/app/models/Product.php';

requireAdmin();

$product = new Product();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($action === 'add') {
    $data = [
      'category_id' => $_POST['category_id'],
      'name'        => trim($_POST['name']),
      'slug'        => $product->generateSlug($_POST['name']),
      'description' => trim($_POST['description']),
      'price'       => $_POST['price'],
      'sale_price'  => $_POST['sale_price'] ?: null,
      'stock'       => $_POST['stock'],
      'sku'         => trim($_POST['sku']),
      'brand'       => trim($_POST['brand']),
      'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
      'is_active'   => isset($_POST['is_active']) ? 1 : 0,
    ];

    // Handle image upload — images[] array
    if (!empty($_FILES['images']['name'][0])) {
      $file = [
        'name'     => $_FILES['images']['name'][0],
        'type'     => $_FILES['images']['type'][0],
        'tmp_name' => $_FILES['images']['tmp_name'][0],
        'error'    => $_FILES['images']['error'][0],
        'size'     => $_FILES['images']['size'][0],
      ];
      $uploadResult = uploadProductImage($file);
      if ($uploadResult['success']) {
        $data['image'] = $uploadResult['filename'];
      } else {
        $error = $uploadResult['error'];
      }
    }

    if (!isset($error)) {
      $newId = $product->create($data);
      if ($newId) {
        header('Location: ' . APP_URL . '/admin/products');
        exit;
      } else {
        $error = 'Failed to add product. Please try again.';
      }
    }
  }

  if ($action === 'edit' && $id) {
    $data = [
      'category_id' => $_POST['category_id'],
      'name'        => trim($_POST['name']),
      'slug'        => $_POST['slug'],
      'description' => trim($_POST['description']),
      'price'       => $_POST['price'],
      'sale_price'  => $_POST['sale_price'] ?: null,
      'stock'       => $_POST['stock'],
      'sku'         => trim($_POST['sku']),
      'brand'       => trim($_POST['brand']),
      'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
      'is_active'   => isset($_POST['is_active']) ? 1 : 0,
    ];

    // Handle image upload — images[] array
    if (!empty($_FILES['images']['name'][0])) {
      $file = [
        'name'     => $_FILES['images']['name'][0],
        'type'     => $_FILES['images']['type'][0],
        'tmp_name' => $_FILES['images']['tmp_name'][0],
        'error'    => $_FILES['images']['error'][0],
        'size'     => $_FILES['images']['size'][0],
      ];
      $uploadResult = uploadProductImage($file);
      if ($uploadResult['success']) {
        $data['image'] = $uploadResult['filename'];
        $product->updateImage($id, $data['image']);
      } else {
        $error = $uploadResult['error'];
      }
    }

    if (!isset($error)) {
      $product->update($id, $data);
      header('Location: ' . APP_URL . '/admin/products');
      exit;
    }
  }
}

// Handle delete
if ($action === 'delete' && $id) {
  $product->delete($id);
  header('Location: ' . APP_URL . '/admin/products');
  exit;
}

// Image upload helper
function uploadProductImage($file) {
  if ($file['error'] !== UPLOAD_ERR_OK) {
    return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
  }

  $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
  $maxSize = 5 * 1024 * 1024;
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

  if (!in_array($ext, $allowedTypes)) {
    return ['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, WEBP allowed.'];
  }

  if ($file['size'] > $maxSize) {
    return ['success' => false, 'error' => 'File too large. Maximum size is 5MB.'];
  }

  $filename = 'product_' . uniqid() . '.' . $ext;
  $uploadPath = ROOT . '/public/uploads/' . $filename;

  if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    return ['success' => true, 'filename' => $filename];
  }

  return ['success' => false, 'error' => 'Failed to move file to: ' . $uploadPath];
}

// Load views
$activePage = 'products';

if ($action === 'add') {
  $pageTitle = 'Add Product';
  $categories = $product->getCategories();
  require_once ROOT . '/app/views/admin/add-product.php';
} elseif ($action === 'edit' && $id) {
  $pageTitle = 'Edit Product';
  $categories = $product->getCategories();
  $editProduct = $product->getById($id);
  require_once ROOT . '/app/views/admin/add-product.php';
} else {
  $pageTitle = 'Products';
  $products = $product->getAll();
  require_once ROOT . '/app/views/admin/products.php';
}