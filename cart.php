<?php
require_once 'db/config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Add to cart
if(isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existing = $stmt->fetch();

    if($existing) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $user_id, $product_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
    header("Location: cart.php");
    exit();
}

// Remove from cart
if(isset($_GET['remove'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['remove'], $_SESSION['user_id']]);
    header("Location: cart.php");
    exit();
}

// Get cart items
$stmt = $pdo->prepare("
    SELECT c.id, p.name, p.price, c.quantity, (p.price * c.quantity) as subtotal
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = array_sum(array_column($cart_items, 'subtotal'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - ShopKart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🛒 ShopKart</div>
    <div class="nav-links">
        <span>Welcome, <?php echo $_SESSION['user_name']; ?></span>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Your Cart</h2>

    <?php if(empty($cart_items)): ?>
        <div class="empty-cart">
            <p>Your cart is empty!</p>
            <a href="index.php" class="btn">Continue Shopping</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
                    <td><a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn-remove">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>₹<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="checkout">
            <a href="index.php" class="btn">Continue Shopping</a>
            <button class="btn-checkout">Proceed to Checkout</button>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>© 2026 ShopKart | MCA Mini Project | Vineet Tyagi</p>
</footer>

</body>
</html>
