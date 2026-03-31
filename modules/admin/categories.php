<?php
require_once __DIR__ . '/../auth/auth.php';
include __DIR__ . '/../../config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

if ($_POST) {
    $name = $_POST['name'];
    $conn->query("INSERT INTO categories (name) VALUES ('$name')");
}

$cats = $conn->query("SELECT * FROM categories");
?>
<link rel="stylesheet" href="../css/style.css">
<h2>Manage Categories</h2>

<form method="POST">
<input type="text" name="name" placeholder="Category Name">
<button>Add</button>
</form>

<hr>

<?php while($c = $cats->fetch_assoc()){ ?>
<div><?php echo $c['name']; ?></div>
<?php } ?>