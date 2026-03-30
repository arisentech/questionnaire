<?php
include __DIR__ . '/../../includes/auth.php';
include __DIR__ . '/../../config/db.php';

if ($_POST) {
    $name = $_POST['name'];
    $conn->query("INSERT INTO categories (name) VALUES ('$name')");
}

$cats = $conn->query("SELECT * FROM categories");
?>

<h2>Manage Categories</h2>

<form method="POST">
<input type="text" name="name" placeholder="Category Name">
<button>Add</button>
</form>

<hr>

<?php while($c = $cats->fetch_assoc()){ ?>
<div><?php echo $c['name']; ?></div>
<?php } ?>