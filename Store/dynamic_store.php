<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../Sign-in");
    exit();
}

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    // Database connection (replace username, password with your actual values)
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch store information based on the store ID from the URL
    $store_sql = "SELECT * FROM store WHERE id = $store_id";
    $store_result = $conn->query($store_sql);

    if ($store_result && $store_result->num_rows > 0) {
        $storeInfo = $store_result->fetch_assoc();
        $store_name = $storeInfo["name"];
        $owner_user_id = $storeInfo["user_id"];

        // Fetch owner's name from the users table
        $owner_sql = "SELECT name FROM users WHERE id = $owner_user_id";
        $owner_result = $conn->query($owner_sql);

        if ($owner_result && $owner_result->num_rows > 0) {
            $ownerInfo = $owner_result->fetch_assoc();
            $owner_name = $ownerInfo["name"];
        } else {
            $owner_name = "Unknown";
        }

        $conn->close();
    } else {
        // Handle store not found
        $store_name = "Unknown";
        $owner_name = "Unknown";
    }
} else {
    // Handle missing store_id parameter
    $store_name = "Unknown";
    $owner_name = "Unknown";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Store Page</title>
</head>
<body>

<div class="container">
    <h1>Welcome to the Store: <?php echo $store_name; ?></h1>
    <p>This store is owned by: <?php echo $owner_name; ?></p>
</div>

</body>
</html>
