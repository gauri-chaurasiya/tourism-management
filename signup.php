<?php
// Connect to MySQL database
$con = new mysqli('localhost', 'root', '', 'travel'); 

// Check if the connection failed
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form is submitted
if (isset($_POST['signup'])) {
    // Get the form input data
    $firstname = trim($_POST['fname']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $city = trim($_POST['city']);
    $phone = trim($_POST['phone']);

    // Validate phone number (ensure it's only numbers and exactly 10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        echo "<script>alert('Please enter a valid 10-digit phone number.'); window.location.href='signup.html';</script>";
        exit();
    }

    // Check if the username already exists
    $stmt = $con->prepare("SELECT fname FROM customer WHERE fname = ?");
    $stmt->bind_param("s", $firstname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already taken'); window.location.href='signup.html';</script>";
        exit();
    } else {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL to insert the data securely
        $stmt = $con->prepare("INSERT INTO customer (fname, password, email, city, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $hashedPassword, $email, $city, $phone);

        if ($stmt->execute()) {
            echo "<script>alert('Signup successful!'); window.location.href='mainPage.html';</script>";
        } else {
            // Log the error and show a generic message to the user
            error_log("Error inserting user: " . $stmt->error);
            echo "<script>alert('There was an issue with the signup process. Please try again.'); window.location.href='signup.html';</script>";
        }
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$con->close();
?>
