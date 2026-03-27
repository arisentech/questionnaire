<?php
session_start();
include '../../config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill all fields";
    } else {

        // Prepared statement (SECURE)
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            // PASSWORD VERIFY (IMPORTANT)
            if (password_verify($password, $user['password'])) {

                $_SESSION['user'] = $user;

                if ($user['role'] == 'vendor') {
                    header("Location: ../vendor/dashboard.php");
                } else {
                    header("Location: ../admin/dashboard.php");
                }
                exit;

            } else {
                $error = "Invalid password";
            }

        } else {
            $error = "User not found";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Questionnaire Platform</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            padding: 40px;
            width: 360px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }

        .login-box h2 {
            margin-bottom: 5px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            font-size: 13px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .input-group input:focus {
            border-color: #2563eb;
            outline: none;
        }

        .btn {
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .error {
            color: red;
            font-size: 13px;
            text-align: center;
            margin-bottom: 15px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Welcome Back</h2>
    <div class="subtitle">Login to your account</div>

    <?php if (!empty($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn">Login</button>

    </form>

    <div class="footer-text">
        Secure Vendor Assessment System
    </div>

</div>

</body>
</html>