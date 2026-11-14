<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin();
$pageTitle='Admin Dashboard';
$stats=[
 'Orders'=>$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
 'Bookings'=>$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
 'Customers'=>$pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
 'Pending payments'=>$pdo->query("SELECT COUNT(*) FROM payments WHERE status='pending'")->fetchColumn()
];
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><p class="eyebrow">CONTROL CENTRE</p><h1>Admin <em>dashboard</em></h1><p>Welcome, <?= e($_SESSION['user_name']) ?>.</p></section>
<section class="section"><div class="stats-grid"><?php foreach($stats as $label=>$value): ?><div class="stat-card"><strong><?= (int)$value ?></strong><span><?= e($label) ?></span></div><?php endforeach; ?></div>
<div class="admin-links"><a href="menu.php">Manage menu →</a><a href="orders.php">Manage orders →</a><a href="bookings.php">Manage bookings →</a><a href="payments.php">Verify payments →</a></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
