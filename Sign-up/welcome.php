<!-- welcome.php -->
<?php
session_start();

if (!isset($_SESSION["email"])) {
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
        <?php if (isset($_SESSION["name"])) : ?>
            <h2>Welcome, <?php echo $_SESSION["name"]; ?>!</h2>
            <p>You have successfully signed up.</p>
            <a href="logout.php">Logout</a>
        <?php else : ?>
            <p>Welcome!</p>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
</body>
</html>
