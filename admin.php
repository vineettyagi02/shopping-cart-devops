<?php
require_once 'db/config.php';

// Simple admin check
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Add product
if(isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock]);
    header("Location: admin.php");
    exit();
}

// Delete product
if(isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: admin.php");
    exit();
}

// Get all products
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Get all users
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - ShopKart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🛒 ShopKart Admin</div>
    <div class="nav-links">
        <a href="index.php">View Site</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Admin Panel</h2>

    <!-- Stats -->
    <div class="admin-stats">
        <div class="stat-card">
            <h3><?php echo count($products); ?></h3>
            <p>Total Products</p>
        </div>
        <div class="stat-card">
            <h3><?php echo count($users); ?></h3>
            <p>Total Users</p>
        </div>
    </div>

    <!-- Add Product -->
    <div class="admin-form">
        <h3>Add New Product</h3>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" placeholder="Product name" required>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" name="price" placeholder="Price" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Product description"></textarea>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" placeholder="Stock quantity" required>
            </div>
            <button type="submit" name="add_product" class="btn-full">Add Product</button>
        </form>
    </div>

    <!-- Products List -->
    <div class="admin-table">
        <h3>All Products</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td>₹<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><a href="admin.php?delete=<?php echo $product['id']; ?>" class="btn-remove">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Users List -->
    <div class="admin-table">
        <h3>Registered Users</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>© 2026 ShopKart | MCA Mini Project | Vineet Tyagi</p>
</footer>

</body>
</html>
