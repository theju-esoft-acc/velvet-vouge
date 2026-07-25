<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'] ?? 1; // Default to 1 if not logged in
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = mysqli_fetch_assoc(mysqli_query($con, "SELECT price FROM products WHERE id = '$id'"));
        $total += $p['price'] * $qty;
    }
    
    mysqli_query($con, "INSERT INTO orders (user_id, total_amount) VALUES ($userId, $total)");
    $orderId = mysqli_insert_id($con);
    
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = mysqli_fetch_assoc(mysqli_query($con, "SELECT price FROM products WHERE id = '$id'"));
        mysqli_query($con, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($orderId, $id, $qty, {$p['price']})");
    }
    
    $_SESSION['cart'] = [];
    echo "<h3>Order placed successfully! Order ID: $orderId</h3>";
}
?>
<form method="POST">
    <button type="submit" class="btn btn-success">Confirm Purchase</button>
</form>
<?php include 'includes/footer.php'; ?>
