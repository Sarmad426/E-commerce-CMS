<?php
session_start();

if (isset($_SESSION["email"])) {
    header("Location: welcome.php");
    exit();
}

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (replace username, password with your actual values)
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input
    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    }

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $email;
            header("Location: welcome.php");
            exit();
        } else {
            $errors[] = "Invalid password";
        }
    } else {
        $errors[] = "Invalid email";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign In</title>
</head>
<body>
    <div class="container">
        <form action="sign-in.php" method="post">
            <h2>Sign In</h2>
            <?php if (!empty($errors)) : ?>
                <div class="error-container">
                    <?php foreach ($errors as $error) : ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
