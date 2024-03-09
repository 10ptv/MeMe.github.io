<?php
session_start();
include 'db.php';

// Check if the user is logged in and has an admin role
$admin_id = null; // Initialize admin_id variable
if (isset($_SESSION['username'])) {
    // Fetch the admin_id of the logged-in user from the database
    $username = $_SESSION['username'];
    $sql = "SELECT id, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the admin_id and role from the result
        $row = $result->fetch_assoc();
        $admin_id = $row['id'];
        $role = $row['role'];
        
        // Check if the user has admin privileges
        if ($role !== 'admin') {
            // Redirect or display an error message
            echo "Error: You do not have permission to upload news articles.";
            exit;
        }
    }
}

// Proceed with news article upload logic here

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input values
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // Check if file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File information
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        
        // Move uploaded file to desired directory
        $upload_directory = 'uploads/'; // Directory where you want to store uploaded files
        $upload_path = $upload_directory . $file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            // File uploaded successfully, proceed with database insertion
            $sql = "INSERT INTO news (title, content, news_image_path, news_image_filename, admin_id) 
                    VALUES ('$title', '$content', '$upload_path', '$file_name', $admin_id)";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Error: No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update News</title>
</head>
<body>
    <h2>Add or Update News</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
