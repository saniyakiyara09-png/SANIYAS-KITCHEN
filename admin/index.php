<?php
require_once __DIR__ . '/../includes/auth.php';
redirect(is_admin() ? 'admin/dashboard.php' : 'admin/login.php');
