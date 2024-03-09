<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission to update profile picture
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];

    // Upload profile picture
    $target_dir = "profile_pictures/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);

    // Update database with new profile picture
    $sql = "UPDATE users SET profile_picture='$target_file' WHERE username='$username'";
    if ($conn->query($sql) === TRUE) {
        echo "រូបភាពគណនីយរបស់អ្នកត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ";
    } else {
        echo "មានបញ្ហាក្នុងការផ្លាស់ប្តូររូបភាពគណនីយ: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ប្តូររូបភាព</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">📖គេហទំព័រ</a></li>
            <li><a href="contact.php">📲ទំនាក់ទំនង</a></li>
            <li><a href="profile.php">👦👧គណនីយ</a></li>
            <li><a href="search.php">🔎</a></li>
        </ul>
    </nav>
    <div id="edit-profile">
        <h2>💟ប្តូរូបភាព</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="profile_picture">🗿រូបភាពគណនីយ:</label>
            <input type="file" id="profile_picture" name="profile_picture" required><br>
            <button type="submit">បញ្ជូន</button>
        </form>
    </div>
</body>
</html>
