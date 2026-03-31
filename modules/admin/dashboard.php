<?php
session_start();

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/db.php';

$result = $conn->query("
SELECT a.id, u.name as vendor_name
FROM assignments a
JOIN users u ON a.vendor_id = u.id
ORDER BY a.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f1f5f9;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            font-weight: 500;
        }

        .header .actions a {
            margin-left: 10px;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
        }

        .assign-btn {
            background: #2563eb;
            color: white;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
        }

        /* CONTAINER */
        .container {
            padding: 30px 40px;
        }

        .title {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 500;
            color: #111827;
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        /* ROW */
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s;
        }

        .row:hover {
            background: #f9fafb;
        }

        .row:last-child {
            border-bottom: none;
        }

        .info strong {
            font-size: 15px;
            color: #111827;
        }

        .info small {
            display: block;
            color: #6b7280;
            margin-top: 4px;
        }

        .view-btn {
            text-decoration: none;
            background: #e0edff;
            color: #2563eb;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .view-btn:hover {
            background: #d0e2ff;
        }

        /* EMPTY */
        .empty {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>Customer Dashboard</h2>

    <div class="actions">
        <a href="assign.php" class="assign-btn">+ Assign Vendor</a>
        <a href="../auth/change_password.php" 
   style="background:#f59e0b;color:white;" 
   class="assign-btn">
   Change Password
</a>

<a href="../auth/logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="title">Assignments</div>

    <div class="card">

        <?php if ($result->num_rows == 0) { ?>
            <div class="empty">No assignments yet</div>
        <?php } ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="row">

                <div class="info">
                    <strong>Assignment #<?php echo $row['id']; ?></strong>
                    <small>Vendor: <?php echo $row['vendor_name']; ?></small>
                </div>

                <div>
                    <a class="view-btn" href="view_report.php?id=<?php echo $row['id']; ?>">
                        View Report
                    </a>
                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>