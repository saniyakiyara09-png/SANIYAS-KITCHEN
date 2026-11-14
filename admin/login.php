<?php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle='Admin Login';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $password=$_POST['password']??'';
 $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? AND role='admin'");$stmt->execute([$email]);$u=$stmt->fetch();
 if($u&&password_verify($password,$u['password_hash'])){session_regenerate_id(true);$_SESSION['user_id']=$u['id'];$_SESSION['user_name']=$u['name'];$_SESSION['user_email']=$u['email'];$_SESSION['role']='admin';redirect('admin/dashboard.php');}
 set_flash('danger','Invalid admin credentials.');
}
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Admin <em>login</em></h1></section><section class="section narrow"><form class="form-card" method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><label>Email<input type="email" name="email" required></label><label>Password<input type="password" name="password" required></label><button class="btn btn-gold full-width">Enter dashboard</button></form></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
