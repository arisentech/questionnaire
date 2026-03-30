<?php
session_start();
include '../../config/db.php';

// ✅ Validate assignment ID
if (!isset($_GET['id'])) {
    die("Invalid request");
}

$aid = intval($_GET['id']);

// ✅ Fetch questions with category + what_to_see
$q = $conn->query("
SELECT 
    q.id, 
    q.question_text,
    q.what_to_see,
    c.name as category_name
FROM assignment_questions aq
JOIN questions q ON aq.question_id = q.id
LEFT JOIN categories c ON q.category_id = c.id
WHERE aq.assignment_id = $aid
ORDER BY c.id, q.id
");

// ✅ Handle form submission (SAFE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        INSERT INTO answers (assignment_id, question_id, answer_text) 
        VALUES (?, ?, ?)
    ");

    foreach ($_POST['answers'] as $qid => $ans) {

        $qid = intval($qid);
        $ans = trim($ans);

        if ($ans == '') continue;

        $stmt->bind_param("iis", $aid, $qid, $ans);
        $stmt->execute();
    }

    echo "<h3 style='color:green;text-align:center;'>Submitted successfully!</h3>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Answer Questionnaire</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f5f9;
    margin: 0;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 30px auto;
}

.category {
    margin-top: 30px;
    padding-bottom: 5px;
    border-bottom: 2px solid #e2e8f0;
    color: #1e293b;
}

.question-box {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-top: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

textarea {
    width: 100%;
    height: 100px;
    margin-top: 10px;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
}

.what-to-see {
    margin-top: 10px;
    padding: 10px;
    background: #eef2ff;
    border-left: 4px solid #6366f1;
    font-size: 14px;
}

button {
    margin-top: 20px;
    padding: 12px 20px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="container">

<form method="POST">

<?php
$current_category = '';

while ($row = $q->fetch_assoc()) {

    // ✅ Show category heading
    if ($current_category != $row['category_name']) {
        $current_category = $row['category_name'];

        echo "<h2 class='category'>$current_category</h2>";
    }
?>

    <div class="question-box">

        <h4><?php echo $row['question_text']; ?></h4>

        <!-- ✅ Vendor Answer -->
        <textarea name="answers[<?php echo $row['id']; ?>]" required></textarea>

        <!-- ✅ What to See -->
        <div class="what-to-see">
            <strong>What evaluator will check:</strong><br>
            <?php echo $row['what_to_see']; ?>
        </div>

    </div>

<?php } ?>

<button type="submit">Submit</button>

</form>

</div>

</body>
</html>