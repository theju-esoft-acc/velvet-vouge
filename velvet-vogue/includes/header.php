<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container"><a class="navbar-brand" href="index.php">Velvet Vogue</a>
            <div class="navbar-nav ms-auto"><a class="nav-link" href="index.php">Home</a><a class="nav-link"
                    href="shop.php">Shop</a><a class="nav-link" href="cart.php">Cart</a>
                <?php if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['role'] === 'admin')
                        echo '<a class="nav-link" href="admin.php">Admin</a>';
                    echo '<a class="nav-link" href="logout.php">Logout</a>';
                } ?>
            </div>
        </div>
    </nav>
    <div class="container">