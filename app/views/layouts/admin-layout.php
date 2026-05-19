<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Admin' ?> | JomiGlobal Admin</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Tabler Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <!-- Admin CSS -->
  <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

  <!-- Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
      <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal">
      <span>Admin</span>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
      <ul>
        <li>
          <a href="<?= APP_URL ?>/admin" class="<?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <i class="ti ti-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="<?= APP_URL ?>/admin/products" class="<?= $activePage === 'products' ? 'active' : '' ?>">
            <i class="ti ti-package"></i>
            <span>Products</span>
          </a>
        </li>
        <li>
          <a href="<?= APP_URL ?>/admin/orders" class="<?= $activePage === 'orders' ? 'active' : '' ?>">
            <i class="ti ti-clipboard-list"></i>
            <span>Orders</span>
          </a>
        </li>
        <li>
          <a href="<?= APP_URL ?>/admin/customers" class="<?= $activePage === 'customers' ? 'active' : '' ?>">
            <i class="ti ti-users"></i>
            <span>Customers</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
      <div class="admin-user">
        <div class="admin-avatar">
          <?= strtoupper(substr($_SESSION['first_name'], 0, 1)) ?>
        </div>
        <div class="admin-user-info">
          <span class="admin-name"><?= $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></span>
          <span class="admin-role">Administrator</span>
        </div>
      </div>
      <a href="<?= APP_URL ?>/logout" class="sidebar-logout">
        <i class="ti ti-logout"></i>
      </a>
    </div>

  </aside>

  <!-- Main Content -->
  <main class="admin-main" id="adminMain">

    <!-- Top Bar -->
    <div class="admin-topbar">
      <button class="sidebar-toggle" id="sidebarToggle">
        <i class="ti ti-menu-2"></i>
      </button>
      <div class="topbar-right">
        <span class="topbar-date"><?= date('l, F j Y') ?></span>
        <a href="<?= APP_URL ?>" target="_blank" class="topbar-btn">
          <i class="ti ti-external-link"></i> View Site
        </a>
      </div>
    </div>

    <!-- Page Content -->
    <div class="admin-content">