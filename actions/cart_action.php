<?php
require_once __DIR__ . '/../includes/auth.php';
if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('menu.php');
verify_csrf();
$id=(int)($_POST['item_id']??0); $action=$_POST['action']??'update';
$stmt=$pdo->prepare("SELECT id FROM menu_items WHERE id=? AND is_available=1"); $stmt->execute([$id]);
if (!$stmt->fetch()) { set_flash('danger','That menu item is not available.'); redirect('menu.php'); }
if (!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if ($action==='add') $_SESSION['cart'][$id]=min(20,($_SESSION['cart'][$id]??0)+1);
else { $qty=(int)($_POST['quantity']??0); if($qty<=0) unset($_SESSION['cart'][$id]); else $_SESSION['cart'][$id]=min(20,$qty); }
set_flash('success','Cart updated.'); redirect('cart.php');
