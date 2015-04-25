<?php
//Start PHP session
session_start();

//Extract values of URL variables
$uname=$_GET['username'];
$pwd1=$_POST['password'];
$pwd2=$_POST['password2'];
?>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<h4><a href="index.html">Login</a></h4>

<?php
//Logout if unauthorized access
if($_SESSION['reset']!=$uname)
{
 header("Location: index.html");
}
else
{
//If new passwords are equal then Reset the password	
if($pwd1==$pwd2)
{
$pwd1 = hash("sha256", $pwd1);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE users SET password='$pwd1' WHERE username='$uname'";

if (mysqli_query($conn, $sql)) 
{
    echo "<script>alert('Password Reset Successfully')</script>";
    session_destroy();
} 
else 
{
    echo "<script>alert('Error Updating password. Try again')</script>";
    session_destroy();
}

mysqli_close($conn);
}
//If new passwords are not equal
else
{
 echo "<script>alert('Passwords DO not match. Try again')</script>";
 session_destroy();
}
}
?>