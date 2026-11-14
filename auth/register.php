<?php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = 'Create Account';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf();
 $name=trim($_POST['name']??''); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $password=$_POST['password']??'';
 if (!$name || !$email || strlen($password)<8) { set_flash('danger','Enter a name, valid email and password of at least 8 characters.'); }
 else {
  $check=$pdo->prepare("SELECT id FROM users WHERE email=?"); $check->execute([$email]);
  if ($check->fetch()) set_flash('danger','An account with this email already exists.');
  else { $stmt=$pdo->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)"); $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]); set_flash('success','Account created. Please log in.'); redirect('auth/login.php'); }
 }
}
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Create <em>account</em></h1></section>
<section class="section narrow"><form class="form-card" method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><label>Full name<input required name="name" maxlength="100"></label><label>Email<input required type="email" name="email"></label><label>Password<input required type="password" name="password" minlength="8"></label><button class="btn btn-gold full-width">Register</button><p class="muted">Already registered? <a href="login.php">Log in</a></p></form></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
