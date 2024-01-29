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

    // Example: Insert product information into the database
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // Example: Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert product information into the database
    $sql = "INSERT INTO products (user_id, title, description, price, category, image) 
            VALUES ($user_id, '$title', '$description', $price, '$category', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "Product submitted successfully!";
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
    <link rel="stylesheet" href="form.css">
    <title>Product Submission</title>
</head>
<body>

<div class="container">
    <h1>Product Submission</h1>

    <form action="product_submission.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label for="price">Price:</label>
        <input type="number" name="price" required>

        <label for="category">Category:</label>
        <select name="category" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="kids">Kids</option>
        </select>

        <label for="image">Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="submit">Submit Product</button>
    </form>
</div>

</body>
</html>
