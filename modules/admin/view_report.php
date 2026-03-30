<?php
include __DIR__ . '/../../includes/auth.php';
include '../../config/db.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$aid = intval($_GET['id']);

// Fetch answers with questions + category
$q = $conn->query("
SELECT 
    q.question_text,
    q.what_to_see,
    c.name as category_name,
    a.answer_text
FROM answers a
JOIN questions q ON a.question_id = q.id
LEFT JOIN categories c ON q.category_id = c.id
WHERE a.assignment_id = $aid
ORDER BY c.id, q.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Report</title>

<style>
body {
    font-family: Arial;
    background: #f1f5f9;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 30px auto;
}

.category {
    margin-top: 30px;
    border-bottom: 2px solid #ccc;
}

.box {
    background: white;
    padding: 15px;
    margin-top: 10px;
    border-radius: 8px;
}

.answer {
    margin-top: 10px;
    padding: 10px;
    background: #ecfdf5;
}

.check {
    margin-top: 10px;
    padding: 10px;
    background: #eef2ff;
}
</style>
</head>

<body>

<div class="container">

<h2>Vendor Response Report</h2>

<?php
$current_category = '';

while ($row = $q->fetch_assoc()) {

    if ($current_category != $row['category_name']) {
        $current_category = $row['category_name'];
        echo "<h2 class='category'>$current_category</h2>";
    }
?>

<div class="box">

    <h4><?php echo $row['question_text']; ?></h4>

    <div class="answer">
        <strong>Vendor Answer:</strong><br>
        <?php echo nl2br($row['answer_text']); ?>
    </div>

    <div class="check">
        <strong>What to Check:</strong><br>
        <?php echo $row['what_to_see']; ?>
    </div>

</div>

<?php } ?>

</div>

</body>
</html>