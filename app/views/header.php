<?php
$pageTitle = $pageTitle ?? 'Book Catalog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - Book Catalog</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="index.php">
        <span class="brand-icon">📖</span>
        <div class="brand-copy">
            <strong>
                Book Catalog
                <span class="env-badge">
                    <?= htmlspecialchars(ENVIRONMENT_NAME) ?>
                    • v<?= htmlspecialchars(APP_VERSION) ?>
                </span>
            </strong>
            <span class="brand-subtitle">Discover · Organize · Learn</span>
        </div>
    </a>

    <nav class="nav" aria-label="Main navigation">
        <a class="active" href="index.php">⌂ Home</a>
        <a href="index.php">▣ Books</a>
        <a href="index.php">▦ Categories</a>
        <a href="index.php">ⓘ About</a>
    </nav>
    <div class="nav-spacer"></div>
</header>
<main class="container">
