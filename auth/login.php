<?php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Login';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf(); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $password=$_POST['password']??'';
 $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?"); $stmt->execute([$email]); $user=$stmt->fetch();
 if ($user && password_verify($password,$user['password_hash'])) {
  session_regenerate_id(true); $_SESSION['user_id']=$user['id']; $_SESSION['user_name']=$user['name']; $_SESSION['user_email']=$user['email']; $_SESSION['role']=$user['role'];
  set_flash('success','Welcome back, '.$user['name'].'!'); redirect('index.php');
 } else set_flash('danger','Email or password is incorrect.');
}
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Welcome <em>back</em></h1></section>
<section class="section narrow"><form class="form-card" method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><label>Email<input required type="email" name="email"></label><label>Password<input required type="password" name="password"></label><button class="btn btn-gold full-width">Log in</button><p class="muted">New here? <a href="register.php">Create an account</a></p></form></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
