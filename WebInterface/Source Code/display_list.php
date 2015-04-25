<?php
//Start PHP session
session_start();
unset($_SESSION['pID']);
unset($_SESSION['tID']);

//Initialize DB variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

//Extract URL variable values
$pageID=$_GET['pageID'];
$termID=$_GET['termID'];
$_SESSION['pID']=$pageID;
$_SESSION['tID']=$termID;

$flag=999;
$flag2=999;

//URL Tampering prevention mechanism
//Check if pageID sent through URL belongs to a particular user.
for($i=0;$i<$_SESSION['numCourses'];$i++)
{
 if($_SESSION['pageID'][$i]==$pageID)
 {
	 $flag=0;
	 break;
 }
}

//Logout if unauthorized usage
if(!$_SESSION['login']||$flag==999)
{
 header("Location: logout.php");
}
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
?>
    <head>
	<title>Display Test</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>
    <body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
    <a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $_SESSION['login']; ?>">Back</a>
    | 
	<a href="logout.php">Logout</a>
	</h4></p></br>
	<h1>Display Test</h1>
	<br/>
	
<?php
//SELECT all tests from test table for a particular term
$sql="select * from test where termID='$termID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$i=0;
$_SESSION['numTests']=$num;
$_SESSION['pID']=$pageID;
$_SESSION['tID']=$termID;
//if tests exist in a particular term
if($num>0)
{
 while($row=mysqli_fetch_assoc($result))
 {
     $testInfo[$i++]=$row['testID'];
     $_SESSION['testID']=$testInfo;
  ?>
  <table border="0">
  <tr><td><a href="display_test.php?testID=<?php echo $row['testID']; ?>"><?php echo $row['testName']; ?></a></td></tr>
  <?php
 }
}
else
{
	echo "<h4>You have no tests added yet!</h4>";
}
?>