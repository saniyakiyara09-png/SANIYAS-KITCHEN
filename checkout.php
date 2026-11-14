<?php
require_once __DIR__ . '/includes/auth.php'; require_login();
$pageTitle = 'Checkout';
$items = cart_items($pdo); $total = array_sum(array_column($items, 'line_total'));
if (!$items) { set_flash('warning','Your cart is empty.'); redirect('menu.php'); }
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact"><p class="eyebrow">ALMOST THERE</p><h1>Place your <em>order</em></h1></section>
<section class="section narrow">
<form class="form-card" method="post" action="<?= BASE_URL ?>/actions/place_order.php">
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
<label>Delivery / pickup notes<textarea name="notes" rows="3" placeholder="Any special instructions?"></textarea></label>
<div class="cart-total"><span>Order total</span><strong><?= money($total) ?></strong></div>
<p class="muted">Payment method: UPI QR (demo). Your order will be created with payment pending.</p>
<button class="btn btn-gold full-width">Place order & view QR</button>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
