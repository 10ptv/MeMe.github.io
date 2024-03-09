<?php
session_start();
include 'db.php';

// Check if video_id is provided in the URL
if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];

    // Query the database to get the video_path based on the provided video_id
    $sql = "SELECT video_path FROM news WHERE id = '$video_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $video_path = $row['video_path'];

        // Close the database connection
        $conn->close();
    } else {
        // Video not found, redirect or display an error message
        echo "Video not found.";
        exit;
    }
} else {
    // Video ID not provided, redirect or display an error message
    echo "Video ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player</title>
</head>
<body>
    <h1>Video Player</h1>
    <video controls>
        <source src="<?php echo $video_path; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</body>
</html>
