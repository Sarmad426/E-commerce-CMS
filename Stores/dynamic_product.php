<?php
session_start();

// Database connection (replace username, password with your actual values)
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database based on the product ID
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // Handle case where product with the specified ID is not found
        echo "Product not found.";
        exit();
    }
} else {
    // Handle case where product ID is not provided in the URL
    echo "Invalid access. Please select a product.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $product['title']; ?> Details</title>
</head>
<body>

<div class="container">
    <h1><?php echo $product['title']; ?> Details</h1>

    <div class="product-details">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <!-- Additional product details can be added here -->
    </div>
</div>

</body>
</html>
