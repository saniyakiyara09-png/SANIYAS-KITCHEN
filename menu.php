<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Our Menu';
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$category = (int)($_GET['category'] ?? 0);
$sql = "SELECT m.*, c.name AS category_name FROM menu_items m LEFT JOIN categories c ON c.id=m.category_id WHERE m.is_available=1";
$params = [];
if ($category) { $sql .= " AND m.category_id=?"; $params[] = $category; }
$sql .= " ORDER BY c.name, m.name";
$stmt = $pdo->prepare($sql); $stmt->execute($params); $items = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact"><p class="eyebrow">FRESH FROM OUR KITCHEN</p><h1>Our <em>menu</em></h1><p>Find your next favourite.</p></section>
<section class="section">
<div class="filters"><a class="<?= !$category?'active':'' ?>" href="menu.php">All</a><?php foreach($categories as $c): ?><a class="<?= $category===(int)$c['id']?'active':'' ?>" href="menu.php?category=<?= (int)$c['id'] ?>"><?= e($c['name']) ?></a><?php endforeach; ?></div>
<div class="food-grid">
<?php foreach($items as $item): ?>
<article class="food-card"><img src="<?= e($item['image_url'] ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800') ?>" alt="<?= e($item['name']) ?>"><div class="food-card-body"><span class="eyebrow"><?= e($item['category_name'] ?? 'MENU') ?></span><h3><?= e($item['name']) ?></h3><p><?= e($item['description']) ?></p><div class="food-bottom"><strong><?= money($item['price']) ?></strong><form method="post" action="<?= BASE_URL ?>/actions/cart_action.php"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>"><input type="hidden" name="action" value="add"><button class="btn btn-small btn-gold">Add to cart</button></form></div></div></article>
<?php endforeach; ?>
<?php if (!$items): ?><p>No items in this category yet.</p><?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
