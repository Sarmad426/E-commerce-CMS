<!-- welcome.php -->
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome</title>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <p>You have successfully signed up.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
