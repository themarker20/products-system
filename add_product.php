<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    $target_dir = "images/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('❌ Error: Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
        exit();
    }

    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        echo "<script>alert('❌ Upload Error Code: " . $_FILES["image"]["error"] . "'); window.history.back();</script>";
        exit();
    }

    if (!is_uploaded_file($_FILES["image"]["tmp_name"])) {
        echo "<script>alert('❌ Error: File was not uploaded.'); window.history.back();</script>";
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "<script>alert('✅ Image uploaded successfully: $image_name');</script>";

        $stmt = $conn->prepare("INSERT INTO products (name, image, description, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $name, $image_name, $description, $price);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Product added successfully!'); window.location.href = 'admin.php';</script>";
        } else {
            echo "<script>alert('❌ Database Error: " . $stmt->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('❌ Error uploading file. Check folder permissions.'); window.history.back();</script>";
        exit();
    }
}
?>
