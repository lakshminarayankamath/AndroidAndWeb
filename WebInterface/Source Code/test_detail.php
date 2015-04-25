<?php
session_start();
unset($_SESSION['teID']);
unset($_SESSION['qID']);

//Extract URL variable values
$testID=$_GET['testID'];
$_SESSION['teID']=$testID;
$flag=999;

//URL Tampering prevention mechanism
//Check if testID sent through URL belongs to a particular term.
for($i=0;$i<$_SESSION['numTests'];$i++)
{
 if($_SESSION['testID'][$i]==$testID)
 {
	 $flag=0;
	 break;
 }
}

//Logout on unauthorized access
if(!($_SESSION['login'])||$flag==999)
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
<title>Test Detail</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p><h4>
<a href="welcome.php?id=0">Home</a>
|
<a href="term_detail.php?pageID=<?php echo $_SESSION['pID']; ?>&termID=<?php echo $_SESSION['tID']; ?>&username=<?php echo $_SESSION['login']; ?>">Back</a>
|
<a href="question_operation.php?op=1">Add Question</a>
|
<a href="question_operation.php?op=2">Delete Question</a>
|
<a href="display_stats.php">Display Statistics</a>
</h4></p>
<br/>

<?php
//Select all questions from a particular testID
$sql="select * from question_pool where testID='$testID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$_SESSION['numQuestions']=$num;
$i=0;
if($num>0)
{
 //Display each question as a HyperLink
 while($row=mysqli_fetch_assoc($result))
 {
	 $questionInfo[$i++]=$row['qID'];
     $_SESSION['questionID']=$questionInfo;
  ?>
  <table border="0">
  <tr><td><?php echo ($i); echo "."; ?></td>
  <td><a href="question_detail.php?qID=<?php echo $row['qID']; ?>"><?php echo $row['question']; ?></a></td></tr>
  <?php
 }
}
else
{
	echo "<h4>You have no questions added yet!</h4>";
}
?>
</body>
</html>
<?php
?> 