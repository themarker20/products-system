<?php
$host = "sql209.infinityfree.com"; // Replace with your actual database host
$username = "if0_38282911"; // Replace with your database username
$password = "02Lml6GuHxk"; // Replace with your database password
$database = "if0_38282911_product_gallery"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
