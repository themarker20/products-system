<?php
session_start();
include "db.php";

// Redirect if user is not logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['phone'])) {
    header("Location: index.php");
    exit();
}

// Fetch products from database
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="products.css">
</head>
<body>
    <h2 class="welcome">مرحباً بك, <?= $_SESSION['name'] ?>!</h2>
    <h3 class="headline">منتجاتنا</h3>

    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="images/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                <h4><?= $row['name'] ?></h4>
                <p><?= $row['description'] ?></p>
                <p><strong>جنية <?= $row['price'] ?></strong></p>
                <button onclick="addToCart('<?= $row['id']; ?>')">إضافة إلى السلة</button>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="script.js"></script>

    <script src="products.js"></script>

</body>
</html>
