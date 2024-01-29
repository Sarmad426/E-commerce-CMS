<!-- welcome.php -->
<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ./");
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
        <h2>Welcome, <?php echo $_SESSION["name"]; ?>!</h2>
        <p>You have successfully signed in.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
