<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Sign Up</title>
  </head>
  <body>
    <div class="container">
      <?php
        session_start();
        if (isset($_SESSION["email"])) {
            header("Location: welcome.php");
            exit();
        }
        ?>
      <form action="sign-up.php" method="post">
        <h2>Sign Up</h2>
        <label for="name">Name:</label>
        <input type="text" name="name" required />

        <label for="email">Email:</label>
        <input type="email" name="email" required />

        <label for="password">Password:</label>
        <input type="password" name="password" required />

        <button type="submit">Sign Up</button>
      </form>
    </div>
  </body>
</html>
