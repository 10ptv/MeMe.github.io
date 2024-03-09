<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $article_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the specific news article from the database based on the provided ID
    $sql = "SELECT news.*, users.username AS admin_username
            FROM news
            INNER JOIN users ON news.admin_id = users.id
            WHERE news.id = '$article_id'";
    $result = $conn->query($sql);

    // Check if the article exists
    if ($result && $result->num_rows > 0) {
        $article = $result->fetch_assoc();
        $admin_username = $article['admin_username']; // Get the admin username from the query result
    } else {
        // If the article doesn't exist, you can redirect the user or display a message
        echo "Article not found";
        exit(); // Stop further execution of the script
    }
} else {
    // If the 'id' parameter is not set, you can redirect the user or display a message
    echo "Article ID not provided";
    exit(); // Stop further execution of the script
}

// Fetch the creation timestamp
$created_at = $article['created_at'];

// Format the creation timestamp to display both date and time
$creation_date_time = date("Y-m-d H:i:s", strtotime($created_at));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>រឿងរ៉ាវថ្ងៃនេះ</title>
    <link rel="stylesheet" href="news_view.css">
</head>
<body>
    <header>
        <h1>រឿងរ៉ាវថ្ងៃនេះ</h1>
    </header>

    <div class="container">
        <div class="news-article">
            <img src="<?php echo $article['news_image_path']; ?>" alt="<?php echo $article['title']; ?>">
            <h2><?php echo $article['title']; ?></h2>
            <p><?php echo $article['content']; ?></p>
            
            <p><strong>បរិច្ឆេទ:</strong> <?php echo $creation_date_time; ?></p>
            <p><strong>អ្នកយកការ:</strong> <?php echo $admin_username; ?></p>
        </div>
    </div>

    <a href="index.php">គេហទំព័រ</a>

    <footer>
        <p>&copy; 2024 meme_news</p>
    </footer>
</body>
</html>
