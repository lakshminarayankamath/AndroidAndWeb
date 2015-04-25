<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

$pageID = $_SESSION['pID'];
$termID =$_SESSION['tID'];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p><h4>
<a href="student_operations.php?action=2">Back</a>
</h4></p>
<?php	
if(isset($_POST['student_1']))
{	
$flag = TRUE;
$i = 1;
	
	while($flag=="TRUE")
	{
		if(isset($_POST['student_'.$i]) && ($_POST['student_'.$i] != ""))
			{
			$studentID = $_POST['student_'.$i];
			$query = "SELECT * from enroll where studentID = '$studentID'";
                        $result=mysqli_query($conn, $query);
                        $num=mysqli_num_rows($result);
			if ($num==1) 
			{
                              $query = "delete from enroll where studentID = '$studentID'";
                              $result=mysqli_query($conn, $query);
                              if($result)
				echo "Student with ID ".$studentID." has been unenrolled.";
                           
			} 
			else 
			{
                                echo "Student with ID ".$studentID." does not exist. Try again!.";
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