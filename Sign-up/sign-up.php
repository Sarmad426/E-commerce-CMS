<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (replace dbname, username, password with your actual values)
    $conn = new mysqli("localhost", "root", "", "dbname");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password == $confirm_password) {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["username"] = $username;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Passwords do not match.";
    }

    $conn->close();
}
?>
