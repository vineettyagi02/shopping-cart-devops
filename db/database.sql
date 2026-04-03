CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, description, price, image, stock) VALUES
('Laptop', 'High performance laptop', 45000.00, 'laptop.jpg', 10),
('Mobile Phone', 'Latest smartphone', 15000.00, 'mobile.jpg', 25),
('Headphones', 'Wireless headphones', 2500.00, 'headphones.jpg', 50),
('Keyboard', 'Mechanical keyboard', 3000.00, 'keyboard.jpg', 30),
('Mouse', 'Wireless mouse', 1200.00, 'mouse.jpg', 40);
