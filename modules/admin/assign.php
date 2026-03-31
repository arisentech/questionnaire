<?php
require_once __DIR__ . '/../auth/auth.php';
include __DIR__ . '/../../config/db.php';

// fetch vendors
$vendors = $conn->query("SELECT * FROM users WHERE role='vendor'");

// fetch questions
$questions = $conn->query("SELECT * FROM questions");

$success = "";

if ($_POST) {

    $vendor = $_POST['vendor'];

    if (!empty($_POST['questions'])) {

        $conn->query("INSERT INTO assignments (vendor_id) VALUES ($vendor)");
        $aid = $conn->insert_id;

        foreach ($_POST['questions'] as $qid) {
            $conn->query("
                INSERT INTO assignment_questions (assignment_id, question_id) 
                VALUES ($aid, $qid)
            ");
        }

        $success = "Assignment created successfully!";
    } else {
        $success = "Please select at least one question.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Assign Questions</title>

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
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    font-weight: 500;
}

.back-btn {
    text-decoration: none;
    background: #334155;
    padding: 8px 14px;
    border-radius: 6px;
    color: white;
    font-size: 14px;
}

/* CONTAINER */
.container {
    max-width: 900px;
    margin: 40px auto;
}

/* CARD */
.card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
}

/* FORM */
label {
    font-size: 14px;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

select {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    margin-bottom: 20px;
}

/* QUESTIONS */
.questions {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.q-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}

.q-item:last-child {
    border-bottom: none;
}

.q-item input {
    margin-top: 4px;
}

.q-text {
    font-size: 14px;
    color: #111827;
}

/* BUTTON */
.btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
}

.btn:hover {
    background: #1d4ed8;
}

/* SUCCESS */
.success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 14px;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>Assign Questions</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<div class="container">

    <div class="card">

        <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
        <?php } ?>

        <form method="POST">

            <label>Select Vendor</label>
            <select name="vendor" required>
                <?php while($v = $vendors->fetch_assoc()){ ?>
                    <option value="<?php echo $v['id']; ?>">
                        <?php echo $v['name']; ?>
                    </option>
                <?php } ?>
            </select>

            <label>Select Questions</label>

            <div class="questions">
                <?php while($q = $questions->fetch_assoc()){ ?>
                    <div class="q-item">
                        <input type="checkbox" name="questions[]" value="<?php echo $q['id']; ?>">
                        <div class="q-text">
                            <?php echo $q['question_text']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <button class="btn">Assign Questions</button>

        </form>

    </div>

</div>

</body>
</html>