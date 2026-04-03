<?php require_once 'db/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopKart - Online Shopping</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">🛒 ShopKart</div>
    <div class="nav-links">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span>Welcome, <?php echo $_SESSION['user_name']; ?></span>
            <a href="cart.php">🛒 Cart</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <h1>Welcome to ShopKart</h1>
    <p>Best deals on electronics!</p>
</div>

<!-- Products -->
<div class="container">
    <h2>Our Products</h2>
    <div class="products-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM products");
        while($product = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="product-card">
            <div class="product-img">📦</div>
            <h3><?php echo $product['name']; ?></h3>
            <p><?php echo $product['description']; ?></p>
            <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
            <p class="stock">Stock: <?php echo $product['stock']; ?></p>
            <?php if(isset($_SESSION['user_id'])): ?>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn">Login to Buy</a>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<footer>
    <p>© 2026 ShopKart | MCA Mini Project | Vineet Tyagi</p>
</footer>

</body>
</html>
