<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$status=$_POST['status']??'pending';if(in_array($status,['pending','confirmed','cancelled'],true))$pdo->prepare("UPDATE bookings SET status=? WHERE id=?")->execute([$status,(int)$_POST['id']]);set_flash('success','Booking updated.');redirect('admin/bookings.php');}
$pageTitle='Bookings';$rows=$pdo->query("SELECT * FROM bookings ORDER BY booking_date DESC,booking_time DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Table <em>bookings</em></h1></section><section class="section"><div class="table-wrap"><table><tr><th>Guest</th><th>Date & time</th><th>Guests</th><th>Phone</th><th>Status</th><th>Update</th></tr><?php foreach($rows as $b): ?><tr><td><?= e($b['customer_name']) ?><br><small><?= e($b['email']) ?></small></td><td><?= e($b['booking_date']) ?> <?= e(substr($b['booking_time'],0,5)) ?></td><td><?= (int)$b['guests'] ?></td><td><?= e($b['phone']) ?></td><td><?= e($b['status']) ?></td><td><form method="post" class="inline-form"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><select name="status"><?php foreach(['pending','confirmed','cancelled'] as $s): ?><option <?= $b['status']===$s?'selected':'' ?>><?= $s ?></option><?php endforeach; ?></select><button class="btn btn-small btn-gold">Save</button></form></td></tr><?php endforeach; ?></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
