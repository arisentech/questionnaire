<?php
require_once __DIR__ . '/../auth/auth.php';
include '../../config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$aid = intval($_GET['id']);

// ✅ Fetch answers + files
$q = $conn->query("
SELECT 
    q.id as question_id,
    q.question_text,
    q.what_to_see,
    c.name as category_name,
    a.id as answer_id,
    a.answer_text,
    f.file_path
FROM answers a
JOIN questions q ON a.question_id = q.id
LEFT JOIN categories c ON q.category_id = c.id
LEFT JOIN files f ON f.answer_id = a.id
WHERE a.assignment_id = $aid
ORDER BY c.id, q.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Report</title>
<link rel="stylesheet" href="../css/style.css">

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

.files {
    margin-top: 10px;
    padding: 10px;
    background: #fff7ed;
}

.files a {
    display: block;
    color: #2563eb;
    text-decoration: none;
    margin-top: 5px;
}
</style>
</head>

<body>

<div class="container">

<h2>Vendor Response Report</h2>

<?php
$current_category = '';
$current_question = '';
$files = [];

while ($row = $q->fetch_assoc()) {

    // Category change
    if ($current_category != $row['category_name']) {
        $current_category = $row['category_name'];
        echo "<h2 class='category'>$current_category</h2>";
    }

    // New question block
    if ($current_question != $row['question_id']) {

        // Print previous files if exist
        if (!empty($files)) {
            echo "<div class='files'><strong>Uploaded Files:</strong>";
            foreach ($files as $file) {
                echo "<a href='$file' target='_blank'>View File</a>";
            }
            echo "</div></div>";
        }

        // Reset files
        $files = [];

        // Start new box
        echo "<div class='box'>";
        echo "<h4>{$row['question_text']}</h4>";

        echo "<div class='answer'>
                <strong>Vendor Answer:</strong><br>"
                . nl2br($row['answer_text']) .
             "</div>";

        echo "<div class='check'>
                <strong>What to Check:</strong><br>
                {$row['what_to_see']}
              </div>";

        $current_question = $row['question_id'];
    }

    // Collect files
    if (!empty($row['file_path'])) {
        $files[] = $row['file_path'];
    }
}

// Print last question files
if (!empty($files)) {
    echo "<div class='files'><strong>Uploaded Files:</strong>";
    foreach ($files as $file) {
        echo "<a href='$file' target='_blank'>View File</a>";
    }
    echo "</div></div>";
}
?>

</div>

</body>
</html>