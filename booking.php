<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Reserve a Table';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact"><p class="eyebrow">SAVE YOUR SEAT</p><h1>Reserve a <em>table</em></h1><p>Tell us when you'd like to visit.</p></section>
<section class="section narrow"><form class="form-card" method="post" action="<?= BASE_URL ?>/actions/booking_action.php">
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
<label>Your name<input required name="customer_name" maxlength="100" value="<?= e($_SESSION['user_name'] ?? '') ?>"></label>
<label>Email<input required type="email" name="email" value="<?= e($_SESSION['user_email'] ?? '') ?>"></label>
<label>Phone<input required name="phone" maxlength="20"></label>
<div class="form-row"><label>Date<input required type="date" name="booking_date" min="<?= date('Y-m-d') ?>"></label><label>Time<input required type="time" name="booking_time"></label></div>
<label>Number of guests<select name="guests"><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>"><?= $i ?> guest<?= $i>1?'s':'' ?></option><?php endfor; ?></select></label>
<label>Special request<textarea name="notes" rows="3"></textarea></label>
<button class="btn btn-gold full-width">Request reservation</button></form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
