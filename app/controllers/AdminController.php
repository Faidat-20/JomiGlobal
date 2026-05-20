<?php

session_name(SESSION_NAME);
session_start();

require_once ROOT . '/app/helpers/auth.php';

requireAdmin();

$pageTitle = 'Dashboard';
$activePage = 'dashboard';

require_once ROOT . '/app/views/admin/dashboard.php';