<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if (!empty($name) && !empty($phone)) {
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (name, phone) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $phone);
        $stmt->execute();
        $stmt->close();

        // Redirect to products page
        header("Location: products.php");
        exit();
    } else {
        $error = "Please enter your name and phone number!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="log-nav.css">
</head>
<body class="login-body">
    <nav>
        <div class="logo">
            Cotton Leaf
        </div>
    </nav>
    <form class="login-form" method="POST">
        <h2 class="headline">تسجيل الدخول</h2>
        <div>
            <label for="username">الإسم</label>
            <input id="username" type="text" name="name" placeholder="الإسم" required>
        </div>
        <div>
            <label for="number">رقم الجوال</label>
            <input id="number" type="text" name="phone" value="+966" placeholder="رقم الجوال" required>
        </div>
        <button type="submit">دخول</button>
    </form>
</body>
</html>
