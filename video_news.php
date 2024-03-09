<?php
session_start();
include 'db.php'; // Assuming you have a database connection file

// Check if the user is logged in and has an admin role
$admin_id = null; // Initialize admin_id variable
if (isset($_SESSION['username'])) {
    // Fetch the ID of the logged-in admin user from the database
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM users WHERE username = '$username' AND role = 'admin'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the admin_id from the result
        $row = $result->fetch_assoc();
        $admin_id = $row['id'];
    } else {
        // Handle the case where admin ID cannot be retrieved
        echo "Error: Admin ID not found.";
        exit(); // Stop further execution of the script
    }
}

// Handle form submission for uploading videos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded
    if (isset($_FILES['video'])) {
        // Define the directory where videos will be stored
        $uploadDir = "videos/";

        // Generate a unique filename for the uploaded video
        $videoFilename = uniqid() . '_' . $_FILES['video']['name'];

        // Define the path where the video file will be saved
        $videoPath = $uploadDir . $videoFilename;

        // Move the uploaded video to the designated directory
        if (move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
            // Get the title and news content from the form
            $title = $_POST['title'];
            $content = $_POST['content'];

            // Insert video information, title, and news content into the database
            $sql = "INSERT INTO news (title, video_path, video_filename, content, admin_id) 
                    VALUES ('$title', '$videoPath', '$videoFilename', '$content', '$admin_id')";
            if ($conn->query($sql) === TRUE) {
                echo "Video uploaded successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading video.";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Upload</title>
</head>
<body>
    <h2>Upload Video</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br><br>
        <label for="video">Select video to upload:</label><br>
        <input type="file" id="video" name="video"><br><br>
        <label for="content">News Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Upload Video">
    </form>
</body>
</html>
