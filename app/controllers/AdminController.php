<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

// Protect this page — admins only
requireAdmin();

// Set page title
$pageTitle = 'Admin Dashboard';

// Load the view
require_once ROOT . '/app/views/layouts/header.php';
require_once ROOT . '/app/views/layouts/nav.php';
require_once ROOT . '/app/views/admin/dashboard.php';
require_once ROOT . '/app/views/layouts/footer.php';