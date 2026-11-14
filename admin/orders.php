<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$status=$_POST['status']??'pending';if(in_array($status,['pending','preparing','completed','cancelled'],true))$pdo->prepare("UPDATE orders SET status=? WHERE id=?")->execute([$status,(int)$_POST['id']]);set_flash('success','Order status updated.');redirect('admin/orders.php');}
$pageTitle='Orders';$orders=$pdo->query("SELECT o.*,u.name customer FROM orders o LEFT JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Manage <em>orders</em></h1></section><section class="section"><div class="table-wrap"><table><tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th>Update</th></tr><?php foreach($orders as $o): ?><tr><td><?= (int)$o['id'] ?></td><td><?= e($o['customer']??'Guest') ?></td><td><?= money($o['total_amount']) ?></td><td><?= e($o['status']) ?></td><td><form method="post" class="inline-form"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= (int)$o['id'] ?>"><select name="status"><?php foreach(['pending','preparing','completed','cancelled'] as $s): ?><option <?= $o['status']===$s?'selected':'' ?>><?= $s ?></option><?php endforeach; ?></select><button class="btn btn-small btn-gold">Save</button></form></td></tr><?php endforeach; ?></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
