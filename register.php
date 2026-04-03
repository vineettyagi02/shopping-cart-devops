<?php
require_once 'db/config.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        $success = "Registration successful! Please login.";
    } catch(PDOException $e) {
        $error = "Email already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ShopKart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">🛒 ShopKart</div>
    <div class="nav-links">
        <a href="login.php">Login</a>
        <a href="index.php">Home</a>
    </div>
</nav>

<div class="auth-container">
    <h2>Create Account</h2>

    <?php if($error): ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn-full">Register</button>
    </form>
    <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
