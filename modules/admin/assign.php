<?php
include __DIR__ . '/../../includes/auth.php';
include __DIR__ . '/../../config/db.php';
// fetch vendors
$vendors = $conn->query("SELECT * FROM users WHERE role='vendor'");

// fetch questions
$questions = $conn->query("SELECT * FROM questions");

if ($_POST) {

    $vendor = $_POST['vendor'];

    // create assignment
    $conn->query("INSERT INTO assignments (vendor_id) VALUES ($vendor)");
    $aid = $conn->insert_id;

    foreach ($_POST['questions'] as $qid) {
        $conn->query("
            INSERT INTO assignment_questions (assignment_id, question_id) 
            VALUES ($aid, $qid)
        ");
    }

    echo "Assigned!";
}
?>

<h2>Assign Questions</h2>

<form method="POST">

<select name="vendor">
<?php while($v = $vendors->fetch_assoc()){ ?>
<option value="<?php echo $v['id']; ?>">
<?php echo $v['name']; ?>
</option>
<?php } ?>
</select>

<h3>Select Questions</h3>

<?php while($q = $questions->fetch_assoc()){ ?>
    <input type="checkbox" name="questions[]" value="<?php echo $q['id']; ?>">
    <?php echo $q['question_text']; ?><br>
<?php } ?>

<br>
<button>Assign</button>

</form>