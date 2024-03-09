<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve user data from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $profile_picture = $row["profile_picture"];
    $phone_number = $row["phone_number"];
} else {
    echo "User not found";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">💙គេហទំព័រ</a></li>
            <li><a href="contact.php">📲ទំនាក់ទំនង</a></li>
            <li><a href="profile.php">👦👧គណនីយ</a></li>
            <li><a href="search.php">🔎</a></li>
        </ul>
    </nav>
    <div id="profile">
        <?php if(isset($profile_picture)): ?>
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
        <?php endif; ?>
        <h2><?php echo $username; ?></h2>
        <?php if(isset($phone_number)): ?>
            <p>📲លេខទូរសព្ទ: <?php echo $phone_number; ?></p>
        <?php endif; ?>
        <a href="edit_profile.php">💟ប្តូររូបភាព</a></div>
</body>
</html>
