<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Battambang&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h2>ចូលប្រើ</h2>
    <form action="login_process.php" method="post">
        <label for="username">👦👧ឈ្មោះអ្នកប្រើ:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">👉កូដសម្ងាត់:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">👉ចូលប្រើ</button>
    </form>
    <p>មិនទាន់មានគណនីយមែនទេ😳? <a href="signup.php">👉ចុះឈ្មោះទីនេះ👌</a>.</p>
</body>
</html>
