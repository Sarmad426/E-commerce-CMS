<?php
session_start();

if (isset($_SESSION["email"])) {
    header("Location: welcome.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (replace dbname, username, password with your actual values)
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input
    if (empty($email) || empty($password)) {
        header("Location: sign-in.php?error=All fields are required");
        exit();
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
            header("Location: sign-in.php?error=Incorrect password");
            exit();
        }
    } else {
        header("Location: sign-in.php?error=User not found");
        exit();
    }

    $conn->close();
}
?>
