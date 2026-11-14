<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? SITE_NAME;
$flash = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | <?= e(SITE_NAME) ?></title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<script defer src="<?= BASE_URL ?>/assets/js/script.js"></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="<?= BASE_URL ?>/index.php"><span class="brand-mark">SK</span><span>SANIYA'S <b>KITCHEN</b><small>THE ART OF FINE DINING</small></span></a>
  <button class="menu-toggle" aria-label="Toggle navigation">☰</button>
  <nav class="main-nav">
    <a href="<?= BASE_URL ?>/index.php">Home</a>
    <a href="<?= BASE_URL ?>/menu.php">Menu</a>
    <a href="<?= BASE_URL ?>/booking.php">Reservations</a>
    <a href="<?= BASE_URL ?>/about.php">Our Story</a>
    <a href="<?= BASE_URL ?>/contact.php">Contact</a>
    <a href="<?= BASE_URL ?>/cart.php">Cart (<?= cart_count() ?>)</a>
    <?php if (is_logged_in()): ?><a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
    <?php else: ?><a href="<?= BASE_URL ?>/auth/login.php">Login</a><?php endif; ?>
    <?php if (is_admin()): ?><a href="<?= BASE_URL ?>/admin/dashboard.php">Admin</a><?php endif; ?>
  </nav>
</header>
<main>
<?php if ($flash): ?><div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
