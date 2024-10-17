<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) && !isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_website";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding items to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];

    // Fetch user_id based on email or username
    $user_identifier = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['username'];
    $userQuery = "SELECT id FROM user WHERE email = '$user_identifier' OR first_name = '$user_identifier'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $user_id = $userData['id'];

        $insertQuery = "INSERT INTO cart (user_id, item_id, item_name, quantity, price) 
                        VALUES ('$user_id', '$item_id', '$item_name', '$quantity', '$unit_price')";

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
    <link rel="stylesheet" href="css/cart.css">
    <title>Cart</title>
</head>
<body>
    <header>
        <a href="#" class="logo"><i class="fas-fa-utensils"></i>Foodie Restaurant</a>
        <nav class="navbar">
            <a class="active" href="logged_home_page.php">Home</a>
            <a href="#featured">Featured Items</a>
            <a href="#catalog">Catalog</a>
        </nav>
        <div class="icons">
            <i class="fas fa-bars" id="bars"></i>
            <a href="home_page.php" class="fas fa-sign-out-alt" id="search-icon"></a>
            <a href="#" class="fas fa-heart"></a>
            <a href="cart.php" class="fas fa-shopping-cart"></a>
        </div>
    </header>

    <div class="container" style="margin-top:150px">
        <div class="cart-section">
            <h1 class="cart-title">Ordered Items</h1>
            <div class="ordered-items">
                <?php
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
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPayment"])) {
                $selectedPaymentMethod = $_POST['payment'];

                $insertPaymentQuery = "INSERT INTO payment (user_id, cart_id, total_payment, payment_type) 
                                       VALUES ('$userId', '$cartIds', '$totalAmount', '$selectedPaymentMethod')";

                if ($conn->query($insertPaymentQuery) === TRUE) {
                    echo '<p>Payment successful!</p>';
                    
                    $deleteCartItemsQuery = "DELETE FROM cart WHERE user_id = $userId";
                    if ($conn->query($deleteCartItemsQuery) === TRUE) {
                        echo '<p>Cart items deleted successfully.</p>';
                    } else {
                        echo '<p>Error deleting cart items: ' . $conn->error . '</p>';
                    }

                    header("Location: logged.php");
                    exit();
                } else {
                    echo '<p>Error inserting payment data: ' . $conn->error . '</p>';
                }
            }
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