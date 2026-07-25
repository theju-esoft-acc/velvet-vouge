<?php
session_start();
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u = mysqli_real_escape_string($con, $_POST['username']);
    $p = $_POST['password'];
    $res = mysqli_query($con, "SELECT * FROM users WHERE username = '$u'");
    $user = mysqli_fetch_assoc($res);
    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    }
    $error = "Invalid credentials.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="POST" class="bg-white p-4 shadow rounded">
                    <h2 class="mb-3">Login</h2>
                    <?php if (isset($error))
                        echo "<p class='text-danger'>$error</p>"; ?>
                    <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>