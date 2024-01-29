<?php
session_start();

// Check if the user is not logged in, redirect them to the sign-in page
if (!isset($_SESSION["id"])) {
    header("Location: ../Sign-in");
    exit();
}

// Check if the product ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Invalid access. Please select a product to edit.";
    exit();
}

$product_id = $_GET['id'];

// Database connection (replace username, password with your actual values)
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Check if the user is the owner of the product
if ($_SESSION['id'] != $product['user_id']) {
    echo "You don't have permission to edit this product.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    // ... (your form processing logic)

    // Example: Update product information in the database
    $new_title = $_POST["title"];
    $new_description = $_POST["description"];
    $new_price = $_POST["price"];

    $sql_update = "UPDATE products 
                   SET title = '$new_title', description = '$new_description', price = $new_price
                   WHERE id = $product_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Product updated successfully!";
        $product['title'] = $new_title;
        $product['description'] = $new_description;
        $product['price'] = $new_price;
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Product</title>
</head>
<body>

<div class="container">
    <h1>Edit Product</h1>

    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $product['title']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required><?php echo $product['description']; ?></textarea>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

        <button type="submit">Update Product</button>
    </form>
</div>

</body>
</html>
