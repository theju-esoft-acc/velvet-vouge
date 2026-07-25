<?php
session_start();
require_once 'includes/db.php';
if ($_SESSION['role'] !== 'admin')
    die("Access Denied.");
$id = mysqli_real_escape_string($con, $_GET['id'] ?? 0);
mysqli_query($con, "DELETE FROM products WHERE id = '$id'");
header("Location: admin.php");
