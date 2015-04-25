<?php
//Initialize DB variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

//Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//Check COnnection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$pageID = $_SESSION['pID'];
$termID =$_SESSION['tID'];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p>
<h4><a href="student_operations.php?action=1">Back</a></h4>
</p>
<?php

if(isset($_POST['student_1']))
{
	$studentlist = "";
	$flag = TRUE;
	$i = 1;
	$coursename=$_SESSION['cname'];
	while($flag)
	{
		if(isset($_POST['student_'.$i]) && ($_POST['student_'.$i] != ""))
                {
			$studentID = $_POST['student_'.$i];
			echo "<br/>";
			$query = "INSERT INTO enroll (studentID,pageID,termID,coursename) VALUES ('$studentID','$pageID', '$termID','$coursename')";
			
                       if (mysqli_query($conn, $query)) 
			{
				echo "<h4>Student with ID ".$studentID." successfully enrolled.</h4>";
			}   
			else 
			{
				echo "<h4>Sorry! Student with ID ".$studentID." does not exist! Try again</h4>";
			}
			
                }
                else 
		{
		 $flag = FALSE;
		}
 		$i++;
       } 
}
?>
</body>
</html>