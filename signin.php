<?php
session_start(); // Start session for login management

// Connect to MySQL database
$con = new mysqli('localhost', 'root', '', 'travel');

// Check if connection failed
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $username = trim($_POST["user"]);
    $password = trim($_POST["pass"]);
    $d = date("Y-m-d H:i:s"); // Current timestamp
    $stmt = $con->prepare("SELECT fname, password FROM customer WHERE fname = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();

    if ($user_data && password_verify($password, $user_data['password'])) {


        header("Location: mainPage.html");
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='index.html';</script>";
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$con->close();
?>
