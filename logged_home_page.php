<?php
session_start();

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the username is not set
    header("Location: login.php");
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
    $username = $_SESSION['username'];
    $userQuery = "SELECT user_id FROM user WHERE first_name = '{$_SESSION['username']}'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $user_id = $userData['user_id'];

        // Insert data into the cart table
        $insertQuery = "INSERT INTO cart (user_id, item_id, item_name, quantity, price) VALUES ('$user_id', '$item_id', '$item_name', '$quantity', '$unit_price')";

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
    <title>e-commerce web site for a resturant </title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    
<!-- header section starts  -->

<header>

    <section class="flex">

        <a href="#" class="logo"><i class=""></i>Foodie Restaurant</a>

        <div id="menu-bar" class="fas fa-bars"></div>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#featured">Featured Items</a>
            <a href="#catalog">Catalog</a>
            <a href="home_page.php">Log Out</a>
            <a href="cart.php">Cart</a>
        </nav>

    </section>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<div class="home-container">

    <section class="home" id="home">

        <div class="content">
            <h3>food made with love</h3>
            <p>"Welcome to Foodie Restaurant where culinary excellence meets convenience! Explore our online restaurant hub offering a delectable array of flavors right at your fingertips. From sumptuous meals to tantalizing desserts, indulge in a seamless dining experience from the comfort of your home. Discover our carefully curated menu, crafted with premium ingredients and passion, ensuring every order is a delightful culinary journey. Order now and savor the taste of perfection delivered straight to your door!"</p>
            <a href="login.html" class="btn">login now</a>
        </div>
    
        <div class="image">
            <img src="images/home-img(1).png" alt="">
        </div>
    
    </section>

</div>

<!-- home section ends -->

<!-- featured section starts  -->

<section class="featureditems" id="featured">

    <h1 class="heading"> our <span>featured items</span> </h1>

    <div class="box-container">

        <div class="box">
            <img class="image" src="images/f-img-1.jfif" alt="">
            <div class="content">
                <img src="images/s-1.png" alt="">
                <h3>tasty burger</h3>
                <br><br><br><br>
                <p> We have burgers accompanied by various toppings such as lettuce, tomato, onion, cheese, pickles, and condiments like ketchup, mustard, or mayonnaise.It can be customized to individual tastes.</p>
            </div>
        </div>
        <div class="box">
            <img class="image" src="images/f-img-2.jfif" alt="">
            <div class="content">
                <img src="images/s-2.png" alt="">
                <h3>tasty pizza</h3>
                <br><br><br><br>
                <p> We have wide array of styles, including classic Italian<br/> versions like Margherita <br/>(tomato, mozzarella, basil) and more elaborate variations like pepperoni, Hawaiian, or vegetarian options.</p>
            </div>
        </div>

        <div class="box">
            <img class="image" src="images/f-img-3.1.jpeg" alt="">
            <div class="content">
                <img src="images/s-3.png" alt="">
                <h3>Fruit & Vegitable Juice</h3>
                <br><br><br>
                <p>We have fruit juices and vegitable juices made with natural ingredients and various flavors like lemon, orange, apple, alcado, carrot, tomato and green vegitable juices.</p>
            </div>
        </div>
        <div class="box">
            <img class="image" src="images/f-img-4.jfif" alt="">
            <div class="content">
                <img src="images/s-4.png" alt="">
                <h3>trendy fast foods</h3>
                <br><br><br><br>
                <p>we have trendy fast foods like taco ,sandwich, bacon, pasta, laksa, sushi etc.. . We are redefining fast food with fresh, bold flavors and quality ingredients, satisfying cravings for both taste and style.</p>
            </div>
        </div>
        

    </div>

</section>

<!-- featured section ends -->

<!-- steps section starts  -->

<section class="step-container">

    <h1 class="heading">how it <span>works</span></h1>

    <div class="steps">

        <div class="box">
            <img src="images/step-1.jpg" alt="">
            <h3>choose your favorite food</h3>
        </div>
        <div class="box">
            <img src="images/step-2.1.jpg" alt="">
            <h3>fast delivery</h3>
        </div>
        <div class="box">
            <img src="images/step-3.jpg" alt="">
            <h3>easy payments</h3>
        </div>
        <div class="box">
            <img src="images/step-4.jpg" alt="">
            <h3>and finally, enjoy your food</h3>
        </div>
    
    </div>

</section>

<!-- steps section ends -->

<!-- menu section starts  -->

<section class="catalog" id="catalog">
     
        <h1 class="heading"> our food <span> catalog </span> </h1>
        
        <div class="box-container">
        <?php
// Assuming $conn is your database connection
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = strtolower(str_replace(' ', '_', $row['item_name'])) . '.jpg';
?>
        <div class="box">
            <div class="image">
                <img src="images/<?php echo $imagePath; ?>" style="height: 250px;" alt="<?php echo $row['item_name']; ?>">
                <a href="#" class="fas fa-heart"></a>
            </div>
            <div class="content">
                <!--<div class="stars">
                     Add your star rating logic here 
                </div> -->
                <h3><?php echo $row['item_name']; ?></h3>  <!-- change me if you need -->
                <div class="price" style = "font-size:20px">Rs.<?php echo $row['price']; ?></div>
                <form method="post" action="">
                    <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                    <input type="hidden" name="item_name" value="<?php echo $row['item_name']; ?>">
                    <input type="hidden" name="unit_price" value="<?php echo $row['price']; ?>">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                </form>
               
            </div>
        </div>
<?php
    }
} else {
    echo '<p>No food items available.</p>';
}

$conn->close();
?>


        </div>
        
</section>

<!-- menu section ends -->

<!-- footer section  -->

<footer class="footer">

    <section>

        <div class="share">
            <a href="#" class="btn">facebook</a>
            <a href="#" class="btn">twitter</a>
            <a href="#" class="btn">instagram</a>
        </div>
    
        <h1 class="credit"> created by <span> Isiwara Kumaragama </span> | all rights reserved! </h1>
    
    </section>

</footer>

<!-- scroll top button  -->
<a href="#home" class="fas fa-angle-up" id="scroll-top"></a>

<!-- loader  -->
<div class="loader-container">
    <img src="images/loader2.gif" alt="">
</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/script-cart1.js"></script>

</body>
</html>