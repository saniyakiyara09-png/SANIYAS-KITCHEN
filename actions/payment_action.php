<?php
require_once __DIR__ . '/../includes/auth.php'; require_login();
$orderId=(int)($_GET['order']??$_POST['order_id']??0);
$stmt=$pdo->prepare("SELECT o.*,p.id AS payment_id,p.status AS payment_status FROM orders o JOIN payments p ON p.order_id=o.id WHERE o.id=? AND o.user_id=?");
$stmt->execute([$orderId,$_SESSION['user_id']]); $order=$stmt->fetch();
if (!$order) { http_response_code(404); exit('Order not found.'); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf();
 $reference=trim($_POST['reference']??'');
 $up=$pdo->prepare("UPDATE payments SET customer_reference=? WHERE id=? AND status='pending'");
 $up->execute([$reference,$order['payment_id']]);
 set_flash('success','Payment note submitted. The admin must verify the payment before it is marked paid.');
 redirect('actions/payment_action.php?order='.$orderId);
}
$pageTitle='Demo UPI Payment'; require __DIR__ . '/../includes/header.php';
$upi='upi://pay?pa='.rawurlencode(UPI_ID).'&pn='.rawurlencode(UPI_PAYEE).'&am='.number_format((float)$order['total_amount'],2,'.','').'&cu=INR&tn='.rawurlencode('Order '.$orderId);
?>
<section class="page-hero compact"><p class="eyebrow">DEMO PAYMENT</p><h1>Pay with <em>UPI QR</em></h1></section>
<section class="section narrow"><div class="form-card center">
<p>Order #<?= (int)$orderId ?> · <strong><?= money($order['total_amount']) ?></strong></p>
<div id="qrcode" class="qr-box"></div><p class="muted">UPI ID: <?= e(UPI_ID) ?></p>
<p class="notice">Demo only: scanning this QR does not notify this website or verify a bank transfer. After paying in your UPI app, submit the UTR/reference below. The admin must verify it manually.</p>
<form method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="order_id" value="<?= (int)$orderId ?>"><label>UPI UTR / reference (optional)<input name="reference" maxlength="100" placeholder="Enter transaction reference"></label><button class="btn btn-gold full-width">Submit payment reference</button></form>
<p>Payment status: <strong><?= e(strtoupper($order['payment_status'])) ?></strong></p>
</div></section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>new QRCode(document.getElementById("qrcode"), {text: <?= json_encode($upi) ?>, width:220, height:220});</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
