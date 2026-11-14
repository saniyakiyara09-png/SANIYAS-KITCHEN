<?php
require_once __DIR__ . '/../includes/auth.php';
if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('booking.php');
verify_csrf();
$name=trim($_POST['customer_name']??''); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL);
$phone=trim($_POST['phone']??''); $date=$_POST['booking_date']??''; $time=$_POST['booking_time']??''; $guests=(int)($_POST['guests']??1);
if(!$name||!$email||!$phone||!$date||!$time||$guests<1||$guests>12){set_flash('danger','Please complete all required booking fields.');redirect('booking.php');}
if(strtotime($date.' '.$time)<time()){set_flash('danger','Please choose a future date and time.');redirect('booking.php');}
$stmt=$pdo->prepare("INSERT INTO bookings(user_id,customer_name,email,phone,booking_date,booking_time,guests,notes) VALUES(?,?,?,?,?,?,?,?)");
$stmt->execute([$_SESSION['user_id']??null,$name,$email,$phone,$date,$time,$guests,trim($_POST['notes']??'')]);
set_flash('success','Reservation request received! The restaurant will confirm it.'); redirect('booking.php');
