<?php
include '../../config/db.php';

$aid = $_GET['id'];

$q = $conn->query("
SELECT q.id, q.question_text 
FROM assignment_questions aq
JOIN questions q ON aq.question_id=q.id
WHERE aq.assignment_id=$aid
");

if ($_POST) {
    foreach ($_POST['answers'] as $qid => $ans) {

        $conn->query("INSERT INTO answers (assignment_id, question_id, answer_text)
        VALUES ($aid, $qid, '$ans')");

        $ans_id = $conn->insert_id;

        foreach ($_FILES['files']['name'][$qid] as $k => $name) {
            $tmp = $_FILES['files']['tmp_name'][$qid][$k];
            $path = "../../uploads/" . time() . "_" . $name;

            move_uploaded_file($tmp, $path);

            $conn->query("INSERT INTO files (answer_id, file_path) VALUES ($ans_id, '$path')");
        }
    }

    echo "Submitted!";
}
?>

<form method="POST" enctype="multipart/form-data">

<?php while ($row = $q->fetch_assoc()) { ?>
    <h4><?php echo $row['question_text']; ?></h4>

    <textarea name="answers[<?php echo $row['id']; ?>]"></textarea><br>

    <input type="file" name="files[<?php echo $row['id']; ?>][]" multiple><br><br>
<?php } ?>

<button>Submit</button>
</form>