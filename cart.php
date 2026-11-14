<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Your Cart';
$items = cart_items($pdo); $total = array_sum(array_column($items, 'line_total'));
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact"><p class="eyebrow">READY WHEN YOU ARE</p><h1>Your <em>cart</em></h1></section>
<section class="section narrow">
<?php if (!$items): ?><div class="empty-state"><h2>Your cart is waiting for something delicious.</h2><a class="btn btn-gold" href="<?= BASE_URL ?>/menu.php">Browse menu</a></div>
<?php else: ?>
<?php foreach($items as $item): ?><div class="cart-row"><div><h3><?= e($item['name']) ?></h3><p><?= money($item['price']) ?> each</p></div><form class="quantity-form" method="post" action="<?= BASE_URL ?>/actions/cart_action.php"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>"><input type="number" min="0" max="20" name="quantity" value="<?= $item['quantity'] ?>"><button class="btn btn-small btn-outline">Update</button></form><strong><?= money($item['line_total']) ?></strong></div><?php endforeach; ?>
<div class="cart-total"><span>Total</span><strong><?= money($total) ?></strong></div><a class="btn btn-gold full-width" href="<?= BASE_URL ?>/checkout.php">Continue to checkout</a>
<?php endif; ?></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
