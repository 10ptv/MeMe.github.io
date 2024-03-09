<?php
session_start();
include 'db.php';



// Fetch product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if there are any products
if ($result->num_rows > 0) {
    $products = [];
    // Fetch each product and store it in an array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = []; // If no products found, initialize an empty array
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
    
    <title>ផលិតផល</title>
    <style>
        body {
            font-family: 'battambang', sans-serif;
            margin: 0;
            padding: 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }

        .product {
            position: relative;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden; /* Ensure the image fits within the card */
            cursor: pointer; /* Add cursor pointer to indicate clickable */
        }

        .product img {
            width: 100%; /* Ensure the image fills the entire space */
            height: auto;
            object-fit: cover; /* Scale the image while preserving aspect ratio */
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            box-sizing: border-box;
            opacity: 0; /* Initially hidden */
            transition: opacity 0.3s ease;
        }

        .product:hover .overlay {
            opacity: 1; /* Show overlay when product is hovered */
        }

        .overlay h2,
        .overlay p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
    <header>
        <h1>ផលិតផល</h1></h1>
        <div>
            <a href="add_product.php">បន្ថែមផលិតផល</a> <!-- Link to add more products -->
            <a href="index.php">គេហទំព័រដើម</a> <!-- Link to go back to home page -->
        </div>
    </header>

    <main>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <a href="product_details.php?id=<?php echo $product['id']; ?>">
                        <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['product_name']; ?>">
                        <div class="overlay">
                            <h2><?php echo $product['product_name']; ?></h2>
                            <p><?php echo '$' . number_format($product['price'], 2); ?></p>
                            <p>Dimensions: <?php echo $product['depth'] . ' mm x ' . $product['width'] . ' mm x ' . $product['height'] . ' mm'; ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; ២០២៤ គ្រឿងសង្ហារឹមវីនFurniture</p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
    </footer>
</body>
</html>
