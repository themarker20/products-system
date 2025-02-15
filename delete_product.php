<?php
session_start();
include "db.php";

// Ensure only the admin can delete products
if (!isset($_SESSION['admin'])) {
    die("Access Denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    // Delete the product from the database
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin page
    header("Location: admin.php");
    exit();
}
?>
