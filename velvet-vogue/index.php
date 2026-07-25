<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'includes/db.php';
include 'includes/header.php';
$products = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM products LIMIT 4"), MYSQLI_ASSOC); ?>
<div class="bg-dark text-white text-center py-5 mb-4">
    <h1>Velvet Vogue</h1>
</div>
<h2>New Arrivals</h2>
<div class="row"><?php foreach ($products as $p): ?>
        <div class="col-md-3">
            <div class="card p-3">
                <h5><?= $p['name'] ?></h5>
                <p>$<?= $p['price'] ?></p><a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary">View</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'includes/footer.php'; ?>