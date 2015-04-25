<?php
//start PHP session
session_start();

//Initialize DB variables
$servername="localhost";
$username="root";
$password="";
$dbname="android";
$qID=$_GET['qID'];
$qnum=$_GET['qnum'];

//URL Tampering prevention mechanism
//Check if questionID sent through URL belongs to a particular test.
for($i=0;$i<$_SESSION['numQuestions'];$i++)
{
 if($_SESSION['questionID'][$i]==$qID)
 {
	 $flag=0;
	 break;
 }
}

//Logout if unauthorized access or URL tampering
if(!($_SESSION['login'])||$flag==999)
{
 header("Location: logout.php");
}

// Create connection
$conn=mysqli_connect($servername,$username,$password,$dbname);
// Check connection
if(!$conn)
{
	die("Connection failed: " . mysqli_connect_error());
}

//UPDATE state field in question_pool to 1 to indicate that the current Question is activated.
$state=1;
$sql="UPDATE question_pool SET state='$state' WHERE qID='$qID'";

//Redirect to Deactivate page once question is activated
if(mysqli_query($conn,$sql))
{
	header("Location: deactivate.php?qID=$qID&qnum=$qnum");
}
?>