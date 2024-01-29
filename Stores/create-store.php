<?php

session_start();

// Check if the user is not logged in, redirect them to the sign-in page
if (!isset($_SESSION["id"])) {
    header("Location: ../Sign-in");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    // ... (your form processing logic)

    // Example: Insert store information into the database
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION["id"];
    $store_name = $_POST["store_name"];

    // Insert store information into the database
    $sql = "INSERT INTO store (user_id, name) 
            VALUES ($user_id, '$store_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Store created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>