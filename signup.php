<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចុះឈ្មោះប្រើប្រាស់</title>
    <link href="https://fonts.googleapis.com/css2?family=Battambang&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>👉ចុះឈ្មោះប្រើប្រាស់</h2>
    <form action="signup_process.php" method="post">
        <label for="username">👦👧ឈ្មោះអ្នកប្រើប្រាស់:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">🔗កូដសម្ងាត់:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="phone">📲លេខទូរសព្ទ:</label>
        <input type="text" id="phone" name="phone" required><br>
        <button type="submit">👉ដាក់បញ្ជូន</button>
    </form>
    <p>😍មានគណនីយហើយមែនទេ?<a href="login.php">😎ចូលប្រើនៅទីនេះ👌</a>.</p>
</body>
</html>
