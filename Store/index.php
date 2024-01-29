<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();

// Check if the user is not logged in, redirect them to the sign-in page
if (!isset($_SESSION["email"])) {
    header("Location: ../Sign-in");
    exit();
}

// Handle store selection from the URL
$selectedStore = isset($_GET['store']) ? $_GET['store'] : '';

// Simulate fetching stores for the logged-in user from the database
$userId = $_SESSION['email']; // Assuming your 'users' table has a 'user_id' column

$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM store WHERE user_id = 10";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$stores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stores[] = $row;
    }
}

$conn->close();
?>

<div class="sidenav">
    <select id="storeSelect" onchange="redirectToStore()">
        <option value="" disabled selected>Select Store</option>
        <?php foreach ($stores as $store) : ?>
            <option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="main">
    <!-- Page content goes here -->
    <h1>Welcome to the Responsive Page, <?php echo $_SESSION["name"]; ?>!</h1>

    <?php
    // Display store-specific content based on the selected store
    if ($selectedStore) {
        $storeInfo = getStoreInfo($selectedStore);
        echo "<p>{$storeInfo}</p>";
    }
    ?>
</div>

<script>
    function redirectToStore() {
        var selectedStore = document.getElementById("storeSelect").value;
        if (selectedStore) {
            window.location.href = 'responsive_page.php?store=' + selectedStore;
        }
    }
</script>

</body>
</html>

<?php
function getStoreInfo($storeId) {
    // Simulate fetching store info from the database based on the selected store ID
    // You can modify this function to fetch actual data from your database
    $storeName = "Store " . $storeId;
    $userName = $_SESSION["name"];
    return "{$storeName} is owned by {$userName}";
}
?>
