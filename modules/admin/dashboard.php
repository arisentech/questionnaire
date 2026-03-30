<?php
include __DIR__ . '/../../includes/auth.php';
include __DIR__ . '/../../config/db.php';
$result = $conn->query("
SELECT a.id, u.name as vendor_name
FROM assignments a
JOIN users u ON a.vendor_id = u.id
");
?>

<h2>Admin Dashboard</h2>

<a href="questions.php">Questions</a> |
<a href="assign.php">Assign</a> |
<a href="categories.php">Categories</a> |
<a href="../auth/logout.php">Logout</a>

<hr>

<h3>Assignments</h3>

<?php while ($row = $result->fetch_assoc()) { ?>
    <div>
    Assignment ID: <?php echo $row['id']; ?> |
    Vendor: <?php echo $row['vendor_name']; ?>

    <a href="view_report.php?id=<?php echo $row['id']; ?>" 
       style="margin-left:10px;color:blue;">
       View Report
    </a>
</div>
<?php } ?>