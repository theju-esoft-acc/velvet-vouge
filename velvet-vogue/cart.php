<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $pid = (int)$_POST['product_id'];
    if ($_POST['action'] == 'update') {
        $_SESSION['cart'][$pid] = (int)$_POST['quantity'];
    } elseif ($_POST['action'] == 'remove') {
        unset($_SESSION['cart'][$pid]);
    }
}
?>
<h2>Your Cart</h2>
<table class="table">
    <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>
    <tbody>
        <?php 
        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $id => $qty): 
            $res = mysqli_query($con, "SELECT * FROM products WHERE id = '$id'");
            $p = mysqli_fetch_assoc($res);
            $total = $p['price'] * $qty;
            $grandTotal += $total;
        ?>
            <tr>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td>$<?= $p['price'] ?></td>
                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="product_id" value="<?= $id ?>">
                        <input type="number" name="quantity" value="<?= $qty ?>" min="1" class="form-control" style="width: 70px;">
                        <button type="submit" class="btn btn-sm btn-primary ms-1">Update</button>
                    </form>
                </td>
                <td>$<?= $total ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="product_id" value="<?= $id ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Grand Total: $<?= $grandTotal ?></h3>
<a href="checkout.php" class="btn btn-success">Checkout</a>
<?php include 'includes/footer.php'; ?>
