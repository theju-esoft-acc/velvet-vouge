<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

$searchTerm = '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'All';
$priceFilter = isset($_GET['price_range']) ? $_GET['price_range'] : 'All';

$query = "SELECT * FROM products WHERE 1=1";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_GET['search']);
    $query .= " AND name LIKE '%$searchTerm%'";
}

if ($categoryFilter !== 'All') {
    $cat = mysqli_real_escape_string($con, $categoryFilter);
    $query .= " AND category = '$cat'";
}

if ($priceFilter !== 'All') {
    if ($priceFilter == 'low') $query .= " AND price < 50";
    elseif ($priceFilter == 'mid') $query .= " AND price BETWEEN 50 AND 100";
    elseif ($priceFilter == 'high') $query .= " AND price > 100";
}

$result = mysqli_query($con, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<h2 class="mb-4">Shop</h2>

<form method="GET" class="row mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($searchTerm) ?>">
    </div>
    <div class="col-md-2">
        <select name="category" class="form-select">
            <option value="All">All Categories</option>
            <?php foreach(['Male', 'Female', 'Children'] as $c): ?>
                <option value="<?= $c ?>" <?= $categoryFilter == $c ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="price_range" class="form-select">
            <option value="All">Any Price</option>
            <option value="low" <?= $priceFilter == 'low' ? 'selected' : '' ?>>Under $50</option>
            <option value="mid" <?= $priceFilter == 'mid' ? 'selected' : '' ?>>$50 - $100</option>
            <option value="high" <?= $priceFilter == 'high' ? 'selected' : '' ?>>Over $100</option>
        </select>
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="shop.php" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

<div class="row">
    <?php foreach ($products as $p): ?>
        <div class="col-md-3">
            <div class="card p-3 mb-4">
                <?php if(!empty($p['image_path'])): ?>
                    <img src="<?= htmlspecialchars($p['image_path']) ?>" class="card-img-top mb-2" alt="Product Image" style="max-height: 200px; object-fit: cover;">
                <?php endif; ?>
                <h5><?= htmlspecialchars($p['name']) ?></h5>
                <p>$<?= htmlspecialchars($p['price']) ?></p>
                <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-outline-primary">View</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
