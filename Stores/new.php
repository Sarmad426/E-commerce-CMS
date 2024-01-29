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

    $user_id = $_SESSION["user_id"];
    $store_name = $_POST["store_name"];
    $store_description = $_POST["store_description"];

    // Insert store information into the database
    $sql = "INSERT INTO store (user_id, name, description) 
            VALUES ($user_id, '$store_name', '$store_description')";

    if ($conn->query($sql) === TRUE) {
        echo "Store created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new.css">
    <title>Create Store</title>
</head>
<body>

<div class="container">
    <h1>Create Store</h1>

    <form action="create-store.php" method="post">
        <label for="store_name">Store Name:</label>
        <input type="text" name="store_name" required>
        <button type="submit">Create Store</button>
    </form>
</div>

</body>
</html>
