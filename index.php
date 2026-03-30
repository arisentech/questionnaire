<?php
session_start();

if (isset($_SESSION['user'])) {

    $role = $_SESSION['user']['role'];

    if ($role == 'admin') {
        header("Location: modules/admin/dashboard.php");
    } elseif ($role == 'vendor') {
        header("Location: modules/vendor/dashboard.php");
    } elseif ($role == 'customer') {
        header("Location: modules/admin/dashboard.php");
    }
    exit;
}

// Not logged in
header("Location: modules/auth/login.php");
exit;