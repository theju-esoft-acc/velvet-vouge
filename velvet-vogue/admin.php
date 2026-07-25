<?php
session_start();
require_once 'includes/db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') die("Access Denied.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $price = (float) $_POST['price'];
    $cat = mysqli_real_escape_string($con, $_POST['category']);
    $size = mysqli_real_escape_string($con, $_POST['size']);
    $stock = (int) $_POST['stock'];
    
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target = "img/" . time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $target;
        }
    }
    
    mysqli_query($con, "INSERT INTO products (name, description, price, image_path, category, size, stock_quantity) 
                        VALUES ('$name', '$desc', $price, '$image_path', '$cat', '$size', $stock)");
}
include 'includes/header.php';
$products = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM products"), MYSQLI_ASSOC);
?>
<h2>Add Product</h2>
<form method="POST" enctype="multipart/form-data" class="p-3 border mb-4">
    <input name="name" placeholder="Name" required class="form-control mb-2">
    <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
    <input name="price" type="number" step="0.01" placeholder="Price" required class="form-control mb-2">
    <input name="category" placeholder="Category" class="form-control mb-2">
    <input name="size" placeholder="Size" class="form-control mb-2">
    <input name="stock" type="number" placeholder="Stock" class="form-control mb-2">
    <input type="file" name="image" class="form-control mb-2">
    <button class="btn btn-primary">Add Product</button>
</form>
<h2>Current Products</h2>
<table class="table">
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['price'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include 'includes/footer.php'; ?>
