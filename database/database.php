<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS restaurant_website";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select the database
$conn->select_db("restaurant_website");

// Create user table
$sql = "CREATE TABLE IF NOT EXISTS user (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50),
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "User table created successfully\n";
} else {
    echo "Error creating user table: " . $conn->error . "\n";
}

// Create menu table
$sql = "CREATE TABLE IF NOT EXISTS menu (
    item_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Menu table created successfully\n";
} else {
    echo "Error creating menu table: " . $conn->error . "\n";
}

// Create cart table
$sql = "CREATE TABLE IF NOT EXISTS cart (
    cart_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    item_id INT(11),
    item_name VARCHAR(100) NOT NULL,
    quantity INT(11) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (item_id) REFERENCES menu(item_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Cart table created successfully\n";
} else {
    echo "Error creating cart table: " . $conn->error . "\n";
}

// Create payment table
$sql = "CREATE TABLE IF NOT EXISTS payment (
    payment_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    cart_id VARCHAR(255),
    total_payment DECIMAL(10, 2) NOT NULL,
    payment_type VARCHAR(50) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Payment table created successfully\n";
} else {
    echo "Error creating payment table: " . $conn->error . "\n";
}

// Create delivery table
$sql = "CREATE TABLE IF NOT EXISTS delivery (
    delivery_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    delivery_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Delivery table created successfully\n";
} else {
    echo "Error creating delivery table: " . $conn->error . "\n";
}

$conn->close();
?>