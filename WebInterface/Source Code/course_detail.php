<?php
//Start PHP session
session_start();
//Unset unused PHP SESSION variables
unset($_SESSION['numTests']);
unset($_SESSION['pID']);  //pageID
unset($_SESSION['tID']);  //termID
unset($_SESSION['teID']); //testID

//Extract URL variable values
$uname=$_GET['username'];
$pageID=$_GET['pageID'];
$flag=999;

//URL Tampering prevention mechanism
//Check if pageID(i.e courseID) sent through URL belongs to a particular User.
for($i=0;$i<$_SESSION['numCourses'];$i++)
{
 if($_SESSION['pageID'][$i]==$pageID)
 {
	 $flag=0;
	 break;
 }
}
//Logout if unauthorized access
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
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">  
<title>Course Detail</title>      
</head>
<body background="background.jpg">
<p>
<h4><a href="welcome.php?id=0">Home</a>
|
<a href="term_operation.php?op=1&pageID=<?php echo $pageID; ?>">Add Term</a>
|
<a href="term_operation.php?op=2&pageID=<?php echo $pageID; ?>">Delete Term</a>
</h4></p>

<?php
//SELECT all terms which have a particular pageID (i.e. courseID)
$sql="select * from terms where pageID='$pageID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$i=0;
$_SESSION['numTerms']=$num;
//if terms are available, display as Hyper-links
if($num>0)
{
 while($row=mysqli_fetch_assoc($result))
 {
	 $termInfo[$i++]=$row['termID'];
     $_SESSION['termID']=$termInfo;
  ?>
  <br/>
  <table border="0">
  <tr><td><a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $row['termID']; ?>&username=<?php echo $uname; ?>"><?php echo $row['term']; ?></a></td></tr>
  <?php
 }
}
else
{
	echo "<br/><h3>You have no terms added yet!</h3>";
}
?>
</body>
</html>
<?php
?> 