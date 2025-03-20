<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch cart items
$stmt = $conn->prepare("SELECT products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Your Cart</h1>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cart_items as $item): ?>
                <li><?php echo $item['name']; ?> - $<?php echo $item['price']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="account.php">Back to Account</a>
</body>
</html>