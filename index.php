<?php
session_start();
include 'db.php';

// Check if the user is logged in and has an admin role
$role = null; // Initialize role variable
if (isset($_SESSION['username'])) {
    // Fetch the role of the logged-in user from the database
    $username = $_SESSION['username'];
    $sql = "SELECT role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the role from the result
        $row = $result->fetch_assoc();
        $role = $row['role'];
    }
}

// Define how many news articles to display per page
$articlesPerPage = 3;

// Determine the current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $articlesPerPage;

// Fetch news articles from the database for the current page, ordered by created_at (newest first)
$sql = "SELECT *, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS formatted_created_at FROM news ORDER BY created_at DESC LIMIT $offset, $articlesPerPage";

$result = $conn->query($sql);

// Check if there are any news articles
if ($result && $result->num_rows > 0) {
    $news = [];
    // Fetch each news article and store it in an array
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
} else {
    $news = []; // If no news articles found, initialize an empty array
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Battambang&display=swap" rel="stylesheet">
    <title>📖គេហទំព័រ</title>
    <link rel="stylesheet" href="news.css">
    <link rel="stylesheet" href="news_view.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">📖គេហទំព័រ</a></li>
        <li><a href="contact.html">📲ទំនាក់ទំនង</a></li>
        <li><a href="profile.php">👦👧គណនី</a></li>
        <li><a href="search.php">🔎</a></li>
        <?php if ($role === 'admin'): ?>
            <li><a href="update_news.php">Update News</a></li>
            <li><a href="video_news.php">Video News</a></li>
        <?php endif; ?>
        <li><a href="product.php">ផលិតផល</a></li> 
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">✋ចាកចេញ</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Display news -->
<div class="news-container">
    <h2>ព័ត៌មាន</h2>
    <?php foreach ($news as $article): ?>
        <div class="news-article">
            <h3><a href="news.php?id=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></h3>
            <p><strong>ថ្ងៃខែឆ្នាំ:</strong> <?php echo $article['created_at']; ?></p>
            <?php if(isset($article['video_path']) && !empty($article['video_path'])): ?>
                <a href="video_news_player.php?video_id=<?php echo pathinfo($article['video_path'], PATHINFO_FILENAME); ?>">
                    <video controls width="400">
                        <source src="<?php echo $article['video_path']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </a>
            <?php else: ?>
                <a href="news.php?id=<?php echo $article['id']; ?>">
                    <img class="small-image" src="<?php echo $article['news_image_path']; ?>" alt="<?php echo $article['news_image_filename']; ?>">
                </a>
            <?php endif; ?>
            <p><?php echo substr($article['content'], 0, 100) . '... <a href="news.php?id=' . $article['id'] . '">ចុចមើលច្រើនទៀត</a>'; ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination heading -->
<h1 class="pagination">
    <?php
    // Calculate total number of pages
    $sql = "SELECT COUNT(*) AS count FROM news";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalPages = ceil($row['count'] / $articlesPerPage);

    // Output the pagination heading
    echo "Page $page - $totalPages";
    ?>
</h1>

<!-- Pagination links -->
<h1 class="pagination">
    <?php
    // Generate pagination links
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="index.php?page=' . $i . '">' . $i . '</a>';
    }
    ?>
</h1>

<!-- Display additional blog entries -->
<div class="blog-container">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495320177855355"
     crossorigin="anonymous"></script>
    
    <h2>ព័ត៌មានទូទៅ</h2>
    <!-- Add your additional blog entries here -->
    <div class="blog-entry">
        <h3>មតិយោបល់ទំនិញថ្មីលើគ្រ
