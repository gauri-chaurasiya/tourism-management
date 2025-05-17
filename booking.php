<?php
// Database connection
$con = mysqli_connect('localhost', 'root', '', 'travel'); 

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$firstname = $_POST['ffirst'];
$lastname = $_POST['flast'];
$email = $_POST['femail'];
$city = $_POST['city'];
$phone = $_POST['fphone'];
$destination = $_POST['fdesti'];
$startDate = $_POST['start_Date'];
$endDate = $_POST['end_Date'];
$total_payment = $_POST['total_payment'];

// Insert into database (make sure your booking table has a `total_payment` column)
$sql = "INSERT INTO `booking`(`ffirst`, `flast`, `femail`, `city`, `fphone`, `fdesti`, `start_Date`, `end_Date`, `total_payment`) 
        VALUES ('$firstname', '$lastname', '$email', '$city', '$phone', '$destination', '$startDate', '$endDate', '$total_payment')";

if (mysqli_query($con, $sql)) {
    // Redirect to booking.html with success message
    header("Location: booking_form.php?success=1");
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the connection
mysqli_close($con);
?>
