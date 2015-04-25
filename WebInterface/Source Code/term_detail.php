<?php
session_start();
unset($_SESSION['teID']);
unset($_SESSION['tID']);

//Extract URL variable values
$uname=$_GET['username'];
$pageID=$_GET['pageID'];
$termID=$_GET['termID'];
$_SESSION['tID']=$termID;
$flag=999;
$flag2=999;

//URL Tampering prevention mechanism
//Check if termID sent through URL belongs to a particular courseID (pageID).
for($i=0;$i<$_SESSION['numCourses'];$i++)
{
 if($_SESSION['pageID'][$i]==$pageID)
 {
	 $flag=0;
	 break;
 }
}

//Logout on unauthorized access
if(($_SESSION['login']!=$uname)||$flag==999)
{
 header("Location: logout.php");
}

//Initialize DB variables
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
//SELECT course with a particular ID 
$sql="select * from courses where pageID='$pageID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$cname;
if($num>0)
{
	$row=mysqli_fetch_assoc($result);
    $_SESSION['cname']=$row['coursename'];
}
?>
<html>
<head>
<title>Term Details</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p>
<h4><a href="welcome.php?id=0">Home</a>
|
<a href="course_detail.php?pageID=<?php echo $pageID; ?>&username=<?php echo $uname; ?>">Back</a>
|
<a href="test_operation.php?op=1&pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>">Add Test</a>
|
<a href="test_operation.php?op=2&pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>">Delete Test</a>
|
<a href="display_list.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>">Display Test</a>
|
<a href="student_operations.php?action=1">Add Student</a>
|
<a href="student_operations.php?action=2">Remove Student</a>
|
<a href="student_operations.php?action=3">Student List</a>
</h4></p>
<br/>

<?php
//Select tests with a particular testID
$sql="select * from test where termID='$termID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$i=0;
$_SESSION['numTests']=$num;
$_SESSION['pID']=$pageID;
$_SESSION['tID']=$termID;
if($num>0)
{
 //Display List of Tests as a HyperLink	
 while($row=mysqli_fetch_assoc($result))
 {
     $testInfo[$i++]=$row['testID'];
     $_SESSION['testID']=$testInfo;
  ?>
  <table border="0">
  <tr><td><a href="test_detail.php?testID=<?php echo $row['testID']; ?>"><?php echo $row['testName']; ?></a></td></tr>
  <?php
 }
}
else
{
	echo "<h4>You have no tests added yet!</h4>";
}
?>
</body>
</html>
<?php
?> 