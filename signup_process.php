<?php
session_start();
include 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO users (username, password, phone_number) VALUES ('$username', '$hashed_password', '$phone')";

    if ($conn->query($sql) === TRUE) {
        // Set session variable
        $_SESSION['username'] = $username;
        header("Location: index.html");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
