<?php
session_start();

$uname=$_SESSION['login'];
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

$uname=$_SESSION['login'];
$sql="SELECT * from courses where username='$uname'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
if($num>0)
{
while($row=mysqli_fetch_assoc($result))
{
	$pageID=$row['pageID'];
	$sql2="SELECT * from terms where pageID='$pageID'";
	$result2=mysqli_query($conn,$sql2);
    $num2=mysqli_num_rows($result2);

	if($num2>0)
	{
	while($row2=mysqli_fetch_assoc($result2))
	{
		$termID=$row2['termID'];
		$sql3="SELECT * from test where termID='$termID'";
		$result3=mysqli_query($conn,$sql3);
		$num3=mysqli_num_rows($result3);
		
		if($num3>0)
		{
			while($row3=mysqli_fetch_assoc($result3))
			{		
			$testID=$row3['testID'];
			$sql4="UPDATE question_pool SET state='0' where testID='$testID'";
			$result4=mysqli_query($conn,$sql4);
			}
		}
		
	}
	}
}
}

//Destroy session with all Session variables
session_destroy();  

//Redirect 
header("Location: index.html");
?>  