<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (replace dbname, username, password with your actual values)
    $conn = new mysqli("localhost", "root", "", "ecommerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["name"] = $name;  // Store the name in the session
        $_SESSION["email"] = $email;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
