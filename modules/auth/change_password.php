<?php
include '../../includes/auth.php';
include '../../config/db.php';

$user = $_SESSION['user'];
$user_id = $user['id'];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $res = $conn->query("SELECT password FROM users WHERE id=$user_id");
    $row = $res->fetch_assoc();

    if (!password_verify($current, $row['password'])) {
        $error = "Current password incorrect";
    }
    elseif ($new !== $confirm) {
        $error = "Passwords do not match";
    }
    elseif (strlen($new) < 6) {
        $error = "Password must be at least 6 characters";
    }
    else {
        $hash = password_hash($new, PASSWORD_DEFAULT);

        $conn->query("UPDATE users SET password='$hash' WHERE id=$user_id");

        echo "<script>alert('Password Updated'); window.location='logout.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>

<style>
body {
    font-family: Arial;
    background: #f3f4f6;
}
.box {
    width: 400px;
    margin: 80px auto;
    background: white;
    padding: 25px;
    border-radius: 8px;
}
input {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}
button {
    margin-top: 15px;
    padding: 10px;
    width: 100%;
    background: #2563eb;
    color: white;
    border: none;
}
</style>
</head>

<body>

<div class="box">
<h3>Change Password</h3>

<?php if ($error) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
<input type="password" name="current_password" placeholder="Current Password" required>
<input type="password" name="new_password" placeholder="New Password" required>
<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button>Update Password</button>
</form>
</div>

</body>
</html>