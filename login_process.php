<?php
session_start();

// Include the database connection file
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the hashed password from the database based on the username
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // Fetch the hashed password from the result
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify if the provided password matches the hashed password
        if (password_verify($password, $hashed_password)) {
            // Passwords match, set session variables
            $_SESSION['username'] = $username;

            // Redirect to the home page or any other page after successful login
            header("Location: index.php");
            exit;
        } else {
            // Invalid password, redirect back to the login page with an error message
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: login.php");
            exit;
        }
    } else {
        // Invalid username, redirect back to the login page with an error message
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: login.php");
        exit;
    }
} else {
    // Redirect back to the login page if the form is not submitted
    header("Location: login.php");
    exit;
}
?>
