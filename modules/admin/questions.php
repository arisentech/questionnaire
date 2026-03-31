<?php
require_once __DIR__ . '/../auth/auth.php';
include __DIR__ . '/../../config/db.php';



error_reporting(E_ALL);
ini_set('display_errors', 0);

if ($_POST) {

    $q = $_POST['question'];
    $w = $_POST['what'];
    $cat = $_POST['category'];

    $stmt = $conn->prepare("
        INSERT INTO questions (question_text, what_to_see, category_id) 
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("ssi", $q, $w, $cat);
    $stmt->execute();

    echo "Added!";
}

// categories
$cats = $conn->query("SELECT * FROM categories");
?>
<link rel="stylesheet" href="../css/style.css">
<h2>Add Question</h2>

<form method="POST">

<select name="category">
<?php while($c = $cats->fetch_assoc()){ ?>
<option value="<?php echo $c['id']; ?>">
<?php echo $c['name']; ?>
</option>
<?php } ?>
</select>

<br><br>

<textarea name="question" placeholder="Question"></textarea><br><br>

<textarea name="what" placeholder="What to See"></textarea><br><br>

<button>Add</button>

</form>