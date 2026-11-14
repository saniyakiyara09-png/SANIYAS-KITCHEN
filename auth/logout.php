<?php
require_once __DIR__ . '/../includes/auth.php';
$_SESSION=[]; session_regenerate_id(true);
set_flash('success','You have been logged out.');
redirect('index.php');
