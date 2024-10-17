<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into a table named "your_table_name"
$tableName = "delivery";


$sql = "INSERT INTO $tableName (firstname, lastname, email)
        VALUES ('$_POST[name]', '$_POST[lastname]', '$_POST[email]')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . $conn->error;
}

// Close connection
$conn->close();
?>
