<?php
session_start();
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search term from the form
    $searchTerm = $_POST["searchTerm"];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output the results
        while ($row = $result->fetch_assoc()) {
            // Wrap each product block in an anchor tag linking to the product details page
            echo '<a href="product_details.php?id=' . $row["id"] . '">';
            echo "Product Name: " . $row["product_name"] . "<br>";
            echo "Price: $" . $row["price"] . "<br>";
            echo "Width: " . $row["width"] . " mm<br>";
            echo "Height: " . $row["height"] . " mm<br>";
            echo "Depth: " . $row["depth"] . " mm<br>";
            echo "</a><hr>";
        }
    } else {
        // No results found
        echo "No products found matching your search.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Battambang&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="styles.css">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
    <title>ស្វែងរក</title>
</head>
<body>
    <h1>ស្វែងរកផលិតផល</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="searchTerm">Search Term:</label>
        <input type="text" id="searchTerm" name="searchTerm" required>
        <button type="submit">Search</button>
    </form>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
</body>
</html>
