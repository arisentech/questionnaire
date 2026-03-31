<?php
session_start();

// ✅ CORRECT PATH
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../../config/db.php';

// ✅ SESSION CHECK
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // ✅ SAFE QUERY
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if (!$row || !password_verify($current, $row['password'])) {
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

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hash, $user_id);
        $stmt->execute();

        echo "<script>alert('Password Updated Successfully'); window.location='logout.php';</script>";
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
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
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
    border-radius: 6px;
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