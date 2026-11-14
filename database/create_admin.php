<?php
// Run this file ONCE in your browser after importing restaurant.sql.
// Change the credentials below before running. Delete this file immediately afterwards.
require_once __DIR__ . '/../config/database.php';
$name = 'Saniya Islam';
$email = 'admin@example.com'; // CHANGE THIS
$password = 'ChangeThisPassword123!'; // CHANGE THIS
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,'admin')");
$stmt->execute([$name,$email,$hash]);
echo 'Admin created. Delete database/create_admin.php now.';
