<?php
//start SESSION
session_start();

//Logout if unauthorized access
if(!$_SESSION['reset'])
{
header("Location: logout.php");
}
//initialize DB variables 
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

//Extract values of URL variables
$question=$_GET['question'];
$uname=$_GET['username'];
$ans=$_POST['answer'];

//select answer for security question for a given user
$sql="select answer from users where username='$uname' AND question='$question'";
$result=mysqli_query($conn,$sql);
?>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">

<?php
if (mysqli_num_rows($result) ==1) 
{
    // display form for resetting password
    $row = mysqli_fetch_assoc($result);
    {
	if($row['answer']==$ans)
	{ ?>
        <form method="post" action="check_password.php?username=<?php echo $uname;?>">
        <?php
	    echo "<h3>Reset Password</h3>";
        echo "<table border=\"0\"><tr><td><label>Enter Password</td>";
	    echo "<td><input type=\"password\" name=\"password\"></td></tr>";
        echo "<tr><td><label>Re-type Password</td><td><input type=\"password\" name=\"password2\"></td></tr>";
        echo "</table>";
        echo "<input type=\"submit\" value=\"Reset\">";
	}
	else
        { //Redirect to previous page on wrong answer
          ?>
		  
          <h4><a href="password_recovery.html">Back</a></h4>
          <br/>
          <?php
          echo "Wrong Answer to Security Question. Try Again";
        }
    }   
}
else
	echo "Unexpected Error!";
?>
