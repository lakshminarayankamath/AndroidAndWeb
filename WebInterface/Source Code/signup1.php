<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Extract URL variable values
$fname=$_POST['first_name'];
$lname=$_POST['last_name'];
$uname=$_POST['username'];
$pwd=$_POST['password'];
$pwd2=$_POST['password2'];
$question=$_POST['question'];
$answer=$_POST['answer'];
$emailID=$_POST['emailID'];
?>

<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>

<body background="background.html">
<a href="sign_up.html">Home</a>
</body>

<?php
$pwd = hash("sha256", $pwd);
$sql = "INSERT INTO users (first_name, last_name, username, password,question,answer,emailID)
VALUES ('$fname','$lname','$uname','$pwd','$question','$answer','$emailID')";

if (mysqli_query($conn, $sql)) 
{
    echo "<script>alert('User Registration Successful!')</script>";
    //header("Location: index.html");  
} 
else 
{
    echo "<script>alert('Username already exists. Try Again!')</script>";  
}
mysqli_close($conn);
?> 


