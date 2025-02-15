<?php
session_start();
$admin_password = "admin123"; // Change this password

if (isset($_POST['password']) && $_POST['password'] === $admin_password) {
    $_SESSION['admin'] = true;
}

if (!isset($_SESSION['admin'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST">
        <input type="password" name="password" placeholder="Enter Admin Password">
        <button type="submit">Login</button>
    </form>
</body>
</html>

<?php
exit();
}
include "db.php";

// Fetch users and products
$users = $conn->query("SELECT * FROM users");
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2 class="headline">جميع المستخدمين</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
        </tr>

        <?php
        $fetch_users_query = "SELECT * FROM users ORDER BY id ASC";
        $result = $conn->query($fetch_users_query);
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td><a href='https://wa.me/" . htmlspecialchars($row['phone']) . "' target='_blank'>" . htmlspecialchars($row['phone']) . "</a></td>";
            echo "</tr>";
        }
        
        ?>
    </table>

    <?php

        // $result = $conn->query("SELECT * FROM cart");
        $result = $conn->query("SELECT name, phone, GROUP_CONCAT(product_name SEPARATOR ', ') AS products FROM cart GROUP BY name, phone ORDER BY id ASC");

        echo "<h2 class='headline'>طلبات العملاء</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Phone</th><th>Product</th></tr>";

        while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td><a href='https://wa.me/" . htmlspecialchars($row['phone']) . "' target='_blank'>" . htmlspecialchars($row['phone']) . "</a></td>";
        echo "<td>" . htmlspecialchars($row['products']) . "</td>"; // Show all products in one cell
        echo "</tr>";
        }

        echo "</table>";
    ?>



    <h2 class="headline">المنتجات الحالية</h2>
    <ul class="products-ul">
        <?php while ($product = $products->fetch_assoc()): ?>
            <li>
                <span>
                    <?= $product['name'] ?> &#160;&#160;
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100" height="100">&#160; &#160;
                    <?= $product['price'] ?>
                </span>
                <form action="delete_product.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2 class="headline">إضافة منتجات جديدة</h2>
    <form class="add-form" action="add_product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="إسم المنتج" required>
        <input type="file" name="image" required>
        <textarea name="description" placeholder="وصف المنتج" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="السعر" required>
        <button type="submit">Add Product</button>
    </form>

</body>
</html>
