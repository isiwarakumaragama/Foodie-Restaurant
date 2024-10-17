<?php
session_start();

// Check if the username is set in the session
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the username is not set
    header("Location: user_login.php");
    exit();
}

// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_website";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission for order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    // Get the form data
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];
    $total_price = $unit_price * $quantity;

    // Fetch user_id based on the username from the user table
    $email = $_SESSION['email'];
    $userQuery = "SELECT id FROM user WHERE email = '{$_SESSION['email']}'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $user_id = $userData['user_id'];

        // Insert data into the cart table
        $insertQuery = "INSERT INTO cart (id, item_id, item_name, quantity, price) VALUES ('$id', '$item_id', '$item_name', '$quantity', '$unit_price')";

        if ($conn->query($insertQuery) === TRUE) {
            echo '<p>Item added to the cart successfully.</p>';
        } else {
            echo '<p>Error adding item to the cart: ' . $conn->error . '</p>';
        }
    } else {
        echo '<p>Error fetching user data.</p>';
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-cart.css">
    <!--<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }

        .cart-section, .cart-summary {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 48%;
        }

        .cart-title {
            color: #333;
        }

        .ordered-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .delete-button {
            background-color: #ff5555;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-summary h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select, button {
            padding: 10px;
            margin-bottom: 16px;
            width: 100%;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style> -->
    <title>Cart</title>
</head>
<body>

<!-- header section starts  -->

<header>
    <a href="#" class="logo"><i class="fas-fa-untensils"></i>Foodie Restuarant</a>

    <nav class ="navbar">
        <a class="active" href="logged_home_page.php">Home</a>
        
        <a href="#featured">Featured Items</a>
        <a href="#catalog">Catalog</a>
        <a href="login.php">Login</a>
    </nav>
    
    <div class="icons">
        <i class="fas fa-bars" id="bars"></i>
        <a href="home_page.php" class="fas fa-sign-out-alt" id="search-icon"></i>
        <a href="#" class="fas fa-heart"></a>
        <a href="cart.php" class="fas fa-shopping-cart"></a>
    </div>
    



</header>

<!-- header section end-->

    <div class="container" style="margin-top:150px">
        <div class="cart-section">
            <h1 class="cart-title">Ordered Items</h1>
            <div class="ordered-items">
                


        <?php
         // Assuming you have a database connection established
            $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the cart table for the logged-in user
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $sql = "SELECT SUM(quantity * price) AS total, GROUP_CONCAT(cart_id) AS cart_ids FROM cart WHERE user_id = $userId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalAmount = $row['total'];
        $cartIds = $row['cart_ids'];
        echo '<p>Total Payable Amount: Rs. ' . $totalAmount . '</p>';
        } else {
            echo '<p>No items in the cart.</p>';
        }
        ?>

            </div>
        </div>

        <div class="cart-summary">
            <h2>Order Summary</h2>
             
<?php
    // Handle payment submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPayment"])) {
        $selectedPaymentMethod = $_POST['payment'];

        // Insert payment data into the payment table
        $insertPaymentQuery = "INSERT INTO payment (user_id, cart_id, total_payment, payment_type) 
                               VALUES ('$userId', '$cartIds', '$totalAmount', '$selectedPaymentMethod')";

        // Perform the payment insertion query
        if ($conn->query($insertPaymentQuery) === TRUE) {
            echo '<p>Payment successful!</p>';
            
            // Delete existing cart items
            $deleteCartItemsQuery = "DELETE FROM cart WHERE user_id = $userId";
            if ($conn->query($deleteCartItemsQuery) === TRUE) {
                echo '<p>Cart items deleted successfully.</p>';
            } else {
                echo '<p>Error deleting cart items: ' . $conn->error . '</p>';
            }

            // Redirect to index_2.php
            header("Location: logged.php");
            exit();
        } else {
            echo '<p>Error inserting payment data: ' . $conn->error . '</p>';
        }
    }

    // Close connection after the payment query
    $conn->close();
    ?>

            <form method="post" action="">
                <label for="payment">Select Payment Method:</label>
                <select name="payment" id="payment">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
                <button type="submit" name="submitPayment">Confirm Payment</button>
            </form>
        </div>
    </div>
</body>
</html>
