<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the user has admin role
$username = $_SESSION['username'];
$sql = "SELECT role FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] !== 'admin') {
        echo "ទំព័រនេះសម្រាប់តែអ្នកគ្រប់គ្រងប៉ុណ្ណោះ!";
        exit;
    }
} else {
    echo "Error fetching user role.";
    exit;
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $width = $_POST["width"];
    $height = $_POST["height"];
    $depth = $_POST["depth"];

    // Define the directory to save the uploaded files
    $target_dir = "uploads/";

    // File upload handling for image 1
    $target_file = $target_dir . uniqid() . '_' . basename($_FILES["product_image"]["name"]);
    // Handle file upload for image 1 similarly to image 1
    $image_filename = basename($_FILES["product_image"]["name"]);
    $image_path = $target_file;

    // File upload handling for image 2
    $target_file2 = $target_dir . uniqid() . '_' . basename($_FILES["product_image2"]["name"]);
    // Handle file upload for image 2 similarly to image 1
    $image_filename2 = basename($_FILES["product_image2"]["name"]);
    $image_path2 = $target_file2;

    // File upload handling for image 3
    $target_file3 = $target_dir . uniqid() . '_' . basename($_FILES["product_image3"]["name"]);
    // Handle file upload for image 3 similarly to image 1
    $image_filename3 = basename($_FILES["product_image3"]["name"]);
    $image_path3 = $target_file3;

    // Check if all files are uploaded successfully
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file) &&
        move_uploaded_file($_FILES["product_image2"]["tmp_name"], $target_file2) &&
        move_uploaded_file($_FILES["product_image3"]["tmp_name"], $target_file3)) {
        // Insert product into database
        $sql = "INSERT INTO products (product_name, price, width, height, depth, image_filename, image_path, image_filename2, image_path2, image_filename3, image_path3) 
                VALUES ('$product_name', '$price', '$width', '$height', '$depth', '$image_filename', '$image_path', '$image_filename2', '$image_path2', '$image_filename3', '$image_path3')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to product.php
            header("Location: product.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your files.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
    </header>

    <main>
        <form id="add-product" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required><br>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required><br>

            <label for="width">Width:</label>
            <input type="text" name="width" id="width" required><br>

            <label for="height">Height:</label>
            <input type="text" name="height" id="height" required><br>

            <label for="depth">Depth:</label>
            <input type="text" name="depth" id="depth" required><br>

            <label for="product_image">Product Image 1:</label>
            <input type="file" name="product_image" id="product_image" accept="image/*" required><br>

            <label for="product_image2">Product Image 2:</label>
            <input type="file" name="product_image2" id="product_image2" accept="image/*"><br>

            <label for="product_image3">Product Image 3:</label>
            <input type="file" name="product_image3" id="product_image3" accept="image/*"><br>

            <input type="submit" name="submit" value="Add Product">
        </form>
    </main>

    <footer>
        <p>&copy; 2023 Your Website</p>
    </footer>
</body>
</html>
