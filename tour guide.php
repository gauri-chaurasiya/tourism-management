<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change this if you have a MySQL password
$dbname = "travel";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $user_email = $_POST["user_email"];
    $guide_name = $_POST["guide_name"];
    $booking_date = $_POST["booking_date"];

    // Insert booking into the database
    $sql = "INSERT INTO tour_guide (name, email, guide_name,  booking_date)
            VALUES ('$user_name', '$user_email', '$guide_name', '$booking_date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Your tour-guide has been booked successfully!');
                window.location.href = 'tour guide.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
