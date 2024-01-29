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
        <?php
        session_start();
        if (isset($_SESSION["id"])) {
            header("Location: ../welcome.php");
            exit();
        }
        ?>
        <form action="sign-in.php" method="post">
            <h2>Sign In</h2>
            <?php if (isset($_GET['error'])) : ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
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
