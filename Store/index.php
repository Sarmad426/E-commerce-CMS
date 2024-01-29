<?php
session_start();

// Check if the user is not logged in, redirect them to the sign-in page
if (!isset($_SESSION["id"])) {
    header("Location: ../Sign-in");
    exit();
}

// Database connection (replace username, password with your actual values)
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["id"];

// Fetch user's stores from the store table
$stores_sql = "SELECT * FROM store WHERE user_id = $user_id";
$stores_result = $conn->query($stores_sql);

$stores = array();

if ($stores_result && $stores_result->num_rows > 0) {
    while ($store_row = $stores_result->fetch_assoc()) {
        $stores[] = $store_row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>

<div class="container">
    <h1>Welcome to Your Dashboard, <?php echo $_SESSION["name"]; ?>!</h1>

    <form action="dynamic_store.php" method="get">
        <label for="storeSelect">Select a Store:</label>
        <select id="storeSelect" name="store_id">
            <?php foreach ($stores as $store) : ?>
                <option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Go to Store</button>
    </form>
</div>

</body>
</html>
