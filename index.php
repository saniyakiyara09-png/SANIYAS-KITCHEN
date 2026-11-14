<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Welcome';
$featured = $pdo->query("SELECT m.*, c.name AS category_name FROM menu_items m LEFT JOIN categories c ON c.id=m.category_id WHERE m.is_available=1 ORDER BY m.id DESC LIMIT 3")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-content">
    <p class="eyebrow">A LITTLE LUXURY ON EVERY PLATE</p>
    <h1>Good food.<br><em>Beautiful</em> moments.</h1>
    <p>Discover carefully prepared favourites, warm hospitality and an experience worth coming back for.</p>
    <div class="hero-actions"><a class="btn btn-gold" href="<?= BASE_URL ?>/menu.php">Explore our menu</a><a class="text-link" href="<?= BASE_URL ?>/booking.php">Reserve a table →</a></div>
  </div>
  <div class="hero-image"><div class="image-caption">THE SIGNATURE EXPERIENCE <span>EST. 2026</span></div></div>
</section>
<section class="section">
  <div class="section-heading"><p class="eyebrow">A TASTE OF OUR KITCHEN</p><h2>Guest favourites</h2><p>Made with care, served with a little something extra.</p></div>
  <div class="food-grid">
  <?php foreach ($featured as $food): ?>
    <article class="food-card">
      <img src="<?= e($food['image_url'] ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800') ?>" alt="<?= e($food['name']) ?>">
      <div class="food-card-body"><span class="eyebrow"><?= e($food['category_name'] ?? 'SPECIAL') ?></span><h3><?= e($food['name']) ?></h3><p><?= e($food['description']) ?></p><div class="food-bottom"><strong><?= money($food['price']) ?></strong><a href="<?= BASE_URL ?>/menu.php">View menu →</a></div></div>
    </article>
  <?php endforeach; ?>
  <?php if (!$featured): ?><p>No menu items yet. Add some from the admin panel.</p><?php endif; ?>
  </div>
</section>
<section class="booking-banner"><p class="eyebrow">YOUR TABLE IS WAITING</p><h2>Make an evening of it.</h2><a class="btn btn-outline" href="<?= BASE_URL ?>/booking.php">Book a table</a></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
