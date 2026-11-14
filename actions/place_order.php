<?php
require_once __DIR__ . '/../includes/auth.php'; require_login();
if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('checkout.php');
verify_csrf(); $items=cart_items($pdo);
if (!$items) { set_flash('warning','Your cart is empty.'); redirect('menu.php'); }
$total=array_sum(array_column($items,'line_total'));
try {
 $pdo->beginTransaction();
 $stmt=$pdo->prepare("INSERT INTO orders(user_id,total_amount,notes) VALUES(?,?,?)");
 $stmt->execute([$_SESSION['user_id'],$total,trim($_POST['notes']??'')]);
 $orderId=(int)$pdo->lastInsertId();
 $line=$pdo->prepare("INSERT INTO order_items(order_id,menu_item_id,item_name,unit_price,quantity) VALUES(?,?,?,?,?)");
 foreach($items as $item) $line->execute([$orderId,$item['id'],$item['name'],$item['price'],$item['quantity']]);
 $pdo->prepare("INSERT INTO payments(order_id,amount,method,status) VALUES(?,?, 'UPI_QR_DEMO','pending')")->execute([$orderId,$total]);
 $pdo->commit(); unset($_SESSION['cart']); redirect('actions/payment_action.php?order='.$orderId);
} catch(Throwable $e) { if($pdo->inTransaction()) $pdo->rollBack(); http_response_code(500); exit('Could not place order. Please try again.'); }
