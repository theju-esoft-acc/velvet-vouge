<?php
session_start();
require_once 'includes/db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') die("Access Denied.");

$id = (int)$_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM products WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $price = (float) $_POST['price'];
    $cat = mysqli_real_escape_string($con, $_POST['category']);
    $size = mysqli_real_escape_string($con, $_POST['size']);
    $stock = (int) $_POST['stock'];
    
    $query = "UPDATE products SET name='$name', description='$desc', price=$price, category='$cat', size='$size', stock_quantity=$stock";
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target = "img/" . time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $query .= ", image_path='$target'";
        }
    }
    
    $query .= " WHERE id = $id";
    mysqli_query($con, $query);
    header("Location: admin.php");
    exit;
}

include 'includes/header.php';
?>
<h2>Edit Product</h2>
<form method="POST" enctype="multipart/form-data" class="p-3 border">
    <input name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="form-control mb-2">
    <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($product['description']) ?></textarea>
    <input name="price" type="number" step="0.01" value="<?= $product['price'] ?>" required class="form-control mb-2">
    <input name="category" value="<?= htmlspecialchars($product['category']) ?>" class="form-control mb-2">
    <input name="size" value="<?= htmlspecialchars($product['size']) ?>" class="form-control mb-2">
    <input name="stock" type="number" value="<?= $product['stock_quantity'] ?>" class="form-control mb-2">
    <input type="file" name="image" class="form-control mb-2">
    <button class="btn btn-primary">Update Product</button>
</form>
<?php include 'includes/footer.php'; ?>
