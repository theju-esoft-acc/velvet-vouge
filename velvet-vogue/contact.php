<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    
    // Simple implementation: log inquiry to a file or database
    // For this assignment, we store it in a new table 'inquiries'
    mysqli_query($con, "CREATE TABLE IF NOT EXISTS inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    mysqli_query($con, "INSERT INTO inquiries (name, email, message) VALUES ('$name', '$email', '$message')");
    echo "<div class='alert alert-success'>Thank you for your inquiry!</div>";
}
?>
<h2>Customer Support</h2>
<form method="POST" class="p-3 border">
    <input name="name" placeholder="Your Name" required class="form-control mb-2">
    <input name="email" type="email" placeholder="Your Email" required class="form-control mb-2">
    <textarea name="message" placeholder="Your Inquiry" required class="form-control mb-2"></textarea>
    <button class="btn btn-primary">Submit Inquiry</button>
</form>
<?php include 'includes/footer.php'; ?>
