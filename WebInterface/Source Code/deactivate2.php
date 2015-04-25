<?php
//Start PHP session
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
//Logout if unauthorized access
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

//UPDATE state field in question_pool to 0 to indicate that the current Question is deactivated.
$state=0;
$sql="UPDATE question_pool SET state='$state' WHERE qID='$qID'";

if(mysqli_query($conn,$sql))
{
	header("Location: activate.php?qID=$qID&qnum=$qnum");
}
?>