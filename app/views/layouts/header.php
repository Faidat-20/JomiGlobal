<?php
$pageTitle = $pageTitle ?? APP_NAME;
$pageDescription = $pageDescription ?? 'Luxury Jewelry, Perfume and Glasses';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <title><?= htmlspecialchars($pageTitle) ?> | JomiGlobal</title>
    <link rel="icon" type="image/png" href="<?= APP_URL ?>/assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/animate.css">
    <link rel="icon" type="image/svg+xml" href="<?= APP_URL ?>/assets/images/icon.svg">
    <link rel="alternate icon" href="<?= APP_URL ?>/assets/images/Icon-54.svg">
</head>
<body>