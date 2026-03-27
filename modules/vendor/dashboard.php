<?php
session_start();

// ✅ FIXED ABSOLUTE PATHS
include __DIR__ . '/../../config/db.php';

// ✅ SESSION CHECK
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user = $_SESSION['user'];
$user_id = $user['id'];

// ✅ FETCH ASSIGNMENTS
$stmt = $conn->prepare("SELECT id FROM assignments WHERE vendor_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Dashboard</title>

<style>
* {
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    margin: 0;
    background: #f1f5f9;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #111827, #1e293b);
    color: white;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    font-size: 22px;
}

.logout {
    background: #ef4444;
    padding: 8px 14px;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

/* CONTAINER */
.container {
    width: 90%;
    max-width: 1000px;
    margin: 40px auto;
}

/* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: 0.2s;
}

.card:hover {
    transform: translateY(-3px);
}

/* EMPTY STATE */
.empty {
    text-align: center;
    color: #64748b;
    margin-top: 50px;
}

/* TITLE */
.section-title {
    font-size: 20px;
    margin-bottom: 20px;
}
</style>
</head>

<body>

<div class="header">
    <h2>Vendor Dashboard</h2>
    <a class="logout" href="../auth/logout.php">Logout</a>
</div>

<div class="container">

    <div class="section-title">Your Assignments</div>

    <?php if ($result->num_rows == 0) { ?>
        <div class="empty">
            No assignments yet.
        </div>
    <?php } ?>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <strong>Assignment ID:</strong> <?php echo $row['id']; ?>
        </div>
    <?php } ?>

</div>

</body>
</html>