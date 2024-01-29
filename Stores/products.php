<?php
session_start();

// Database connection (replace username, password with your actual values)
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="products.css">
    <title>Product List</title>
</head>
<body>

<div class="container">
    <h1>Product List</h1>
    <a href="./store.php">Go to Dashboard</a>

    <?php foreach ($products as $product) : ?>
        <div class="product">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
            <h2><?php echo $product['title']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p>Price: $<?php echo $product['price']; ?></p>
            <a href="dynamic_product.php?id=<?php echo $product['id']; ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
