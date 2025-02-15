<?php
include 'db.php';
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['phone'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$product_id = $_POST['product_id'];

// Get the product name
$stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$product_name = $product['name'];

// Save to "cart" table
$stmt = $conn->prepare("INSERT INTO cart (name, phone, product_name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $phone, $product_name);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "تم إضافة منتج فى السلة وسوف نتواصل معك قريبا جداً"]);
} else {
    echo json_encode(["status" => "error", "message" => "عفواً يوجد عطل بسيط وسوف يتم التواصل معك فوراً"]);
}
?>
