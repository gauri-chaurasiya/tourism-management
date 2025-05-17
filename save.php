<!-- <?php


$con=mysqli_connect('localhost','root','','travel');


$firstname=$_POST['fname'];
$password=$_POST['password'];
$email=$_POST['email'];
$city=$_POST['city'];
$phone=$_POST['phone'];


$sql="INSERT INTO `customer`(`id`,`fname`,`password`,`email`,`city`,`phone`) VALUES (0,'$firstname','$password','$email','$city','$phone')";
$result = mysqli_query($con,$sql);

if($result)
{
	if($firstname=="admin" && $password == "ad123"){
		header("location:admin.php");

	}
	else{
		header("location:mainPage.html");
	}
}
else{
	$que = "SELECT `fname` FROM `customer` WHERE fname='$firstname'";
	$result = mysqli_query($con,$que);
	if($result){
		?>
		<script type="text/javascript">
			alert("username already taken")
		</script>
		<?php
	}
}

?>

<?php
$con = mysqli_connect('localhost', 'root', '', 'travel');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($con, $_POST['fname']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    // Optional: Block signup as 'admin'
    if (strtolower($firstname) == 'admin') {
        echo "<script>alert('The username admin is reserved.'); window.location.href='signup.html';</script>";
        exit();
    }

    $checkQuery = "SELECT fname FROM signin WHERE fname='$firstname'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Username already taken'); window.location.href='signup.html';</script>";
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO signin (fname, password, email, city, phone) 
                VALUES ('$firstname', '$hashedPassword', '$email', '$city', '$phone')";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Signup successful!'); window.location.href='mainPage.html';</script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>
