<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

$id = mysqli_real_escape_string($con, $_GET['id'] ?? 0);
$result = mysqli_query($con, "SELECT * FROM products WHERE id = '$id'");
$product = mysqli_fetch_assoc($result);

if (!$product) die("Product not found.");
?>
<div class="row">
    <div class="col-md-6">
        <img src="<?= htmlspecialchars($product['image_path'] ?? 'placeholder.jpg') ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="col-md-6">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p class="text-muted">Category: <?= htmlspecialchars($product['category']) ?> | Size: <?= htmlspecialchars($product['size']) ?></p>
        <h3>$<?= htmlspecialchars($product['price']) ?></h3>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p>Stock: <?= htmlspecialchars($product['stock_quantity']) ?></p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" class="form-control mb-2" style="width: 100px;">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
