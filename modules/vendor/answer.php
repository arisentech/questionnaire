<?php
session_start();
include __DIR__ . '/../../config/db.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$aid = intval($_GET['id']);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        INSERT INTO answers (assignment_id, question_id, answer_text) 
        VALUES (?, ?, ?)
    ");

    foreach ($_POST['answers'] as $qid => $ans) {

        if (trim($ans) == '') continue;

        $stmt->bind_param("iis", $aid, $qid, $ans);
        $stmt->execute();

        $answer_id = $stmt->insert_id;

        if (isset($_FILES['files']['name'][$qid])) {

            $count = count($_FILES['files']['name'][$qid]);

            for ($i = 0; $i < $count; $i++) {

                if ($_FILES['files']['name'][$qid][$i] == '') continue;

                $name = $_FILES['files']['name'][$qid][$i];
                $tmp  = $_FILES['files']['tmp_name'][$qid][$i];

                $new = time().'_'.rand(1000,9999).'_'.basename($name);
                $path = "../../uploads/".$new;

                if (move_uploaded_file($tmp, $path)) {

                    $conn->query("
                        INSERT INTO files (answer_id, file_path)
                        VALUES ($answer_id, '$path')
                    ");
                }
            }
        }
    }

    echo "<div class='success'>Submitted successfully</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Questionnaire</title>

<style>
* {
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    margin: 0;
    background: #f8fafc;
}

/* HEADER */
.header {
    background: #0f172a;
    color: white;
    padding: 16px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 18px;
    font-weight: 600;
}

.nav a {
    color: #cbd5f5;
    margin-left: 20px;
    text-decoration: none;
    font-size: 14px;
}

.nav a:hover {
    color: white;
}

/* MAIN */
.container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
}

/* TITLE */
.title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* CATEGORY */
.category {
    margin-top: 35px;
    font-size: 16px;
    font-weight: 600;
    color: #475569;
}

/* CARD */
.card {
    background: white;
    padding: 22px;
    border-radius: 14px;
    margin-top: 15px;
    border: 1px solid #e2e8f0;
}

/* QUESTION */
.question {
    font-weight: 500;
    margin-bottom: 10px;
}

/* TEXTAREA */
textarea {
    width: 100%;
    height: 110px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 10px;
    font-size: 14px;
}

/* FILE */
.file {
    margin-top: 10px;
    font-size: 13px;
}

/* INFO BOX */
.info {
    margin-top: 12px;
    padding: 12px;
    background: #f1f5f9;
    border-left: 4px solid #6366f1;
    font-size: 13px;
}

/* BUTTON */
.btn {
    margin-top: 30px;
    background: #2563eb;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    width: 100%;
    font-size: 15px;
    cursor: pointer;
}

.btn:hover {
    background: #1d4ed8;
}

/* SUCCESS */
.success {
    background: #dcfce7;
    color: #166534;
    padding: 12px;
    text-align: center;
}

/* BACK */
.back {
    display: inline-block;
    margin-bottom: 20px;
    font-size: 14px;
    color: #2563eb;
    text-decoration: none;
}
</style>
</head>

<body>

<div class="header">
    <div class="logo">Vendor Panel</div>
    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="container">

<a href="dashboard.php" class="back">← Back</a>

<div class="title">Complete Your Questionnaire</div>

<form method="POST" enctype="multipart/form-data">

<?php
$current = '';

while ($row = $q->fetch_assoc()) {

    if ($current != $row['category_name']) {
        $current = $row['category_name'];
        echo "<div class='category'>$current</div>";
    }
?>

<div class="card">

    <div class="question">
        <?php echo $row['question_text']; ?>
    </div>

    <textarea name="answers[<?php echo $row['id']; ?>]" required></textarea>

    <div class="file">
        Upload supporting files (multiple allowed):
        <input type="file" name="files[<?php echo $row['id']; ?>][]" multiple>
    </div>

    <div class="info">
        <strong>What evaluator will check:</strong><br>
        <?php echo $row['what_to_see']; ?>
    </div>

</div>

<?php } ?>

<button class="btn">Submit Questionnaire</button>

</form>

</div>

</body>
</html>