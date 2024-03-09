<?php
session_start();
include 'db.php';

// Check if product ID is provided in the URL
if(isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare and execute SQL query to fetch product details
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch product details
        $row = $result->fetch_assoc();
        $productName = $row["product_name"];
        $price = $row["price"];
        $width = $row["width"];
        $height = $row["height"];
        $depth = $row["depth"];
        $imagePath1 = $row["image_path"];
        $imagePath2 = $row["image_path2"];
        $imagePath3 = $row["image_path3"];
    } else {
        // No product found with the provided ID
        $productName = "Product not found";
        $price = "";
        $width = "";
        $height = "";
        $depth = "";
        $imagePath1 = "";
        $imagePath2 = "";
        $imagePath3 = "";
    }
} else {
    // Redirect to the search page if product ID is not provided
    header("Location: search.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .product-details {
            max-width: 1224px;
            height: auto;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .product-details img {
            width: 100%;
            height: auto;
            margin-bottom: 10px; /* Add margin between images */
        }

        .button-container {
            position: absolute;
            top: 50%;
            transform: translateY(50%);
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
</head>
<body>
    <div class="product-details">
        <?php if($result->num_rows > 0): ?>
            <?php $row = $result->fetch_assoc(); ?>
            <h1><?php echo $productName; ?></h1>
            <p><strong>Price:</strong> $<?php echo $price; ?></p>
            <p><strong>Width:</strong> <?php echo $width; ?> mm</p>
            <p><strong>Height:</strong> <?php echo $height; ?> mm</p>
            <p><strong>Depth:</strong> <?php echo $depth; ?> mm</p>
            <img src="<?php echo $imagePath1; ?>" alt="<?php echo $productName; ?>">
            <img src="<?php echo $imagePath2; ?>" alt="<?php echo $productName; ?>">
            <img src="<?php echo $imagePath3; ?>" alt="<?php echo $productName; ?>">
        <?php else: ?>
            <p>No product found.</p>
        <?php endif; ?>
        <div class="button-container">
            <button onclick="goBack()">Back</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
</body>
</html>
