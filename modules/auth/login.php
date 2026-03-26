<?php
session_start();
include '../../config/db.php';

if ($_POST) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $q = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if ($q->num_rows > 0) {
        $_SESSION['user'] = $q->fetch_assoc();

        $role = $_SESSION['user']['role'];

        if ($role == 'admin' || $role == 'customer') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../vendor/dashboard.php");
        }
    } else {
        echo "Invalid login";
    }
}
?>

<form method="POST">
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    <button>Login</button>
</form>