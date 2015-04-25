<?php
session_start();

//Initialize DB variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

//Extract URL variable valies
$pageID=$_GET['pageID'];
$termID=$_GET['termID'];
$op=$_GET['op'];
$flag=999;

//URL Tampering prevention mechanism
//Check if courseID (pageID) sent through URL belongs to the current user
for($i=0;$i<$_SESSION['numCourses'];$i++)
{
 if($_SESSION['pageID'][$i]==$pageID)
 {
	 $flag=0;
	 break;
 }
}

//Logout on unauthorized access
if(!$_SESSION['login']||$flag==999)
{
 header("Location: logout.php");
}
?>
    <head>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>        
	<body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
    <a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $_SESSION['login']; ?>">Back</a>
    | 
	<a href="logout.php">Logout</a>
	</h4><p>
<?php
//Display types of tests to add
if($op==1)
{
$pageID=$_GET['pageID'];
	?>
	
	<h1>Add Test</h1>                                                 
	<br/>
	<form method="post" action="test_operation.php?op=add&pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>">
	<table border="0">
	<tr>
	<td>Test Type</td><td>Test Name</td></tr>
	<tr>
	<td><select name="testtype[]" >
      <option selected value="graded">Graded</option>
      <option value="anonymous">Anonymous</option>
    </select></td>
	<td><input type="text" name="testName"></td>
	</tr>
	</table>
	<br/>
	<input type="submit" value="Add">
	</form>
	<?php
}

//Display lists of tests to delete
if($op==2)
{
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
	<h1>Delete Test</h1>                                                 
	<br/>
	<?php

$sql="SELECT testName from test where termID='$termID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
  	  if($num>0)
	  { ?>
		<form method="post" action="test_operation.php?op=del&pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>">
		<table border="0"> <?php
	  while($row=mysqli_fetch_assoc($result))
	  { ?>
		<tr>
		<td><input type="radio" name="testName" value="<?php echo $row['testName']; ?>"><?php echo $row['testName']; ?></td>
		</tr>
		<?php
	  } ?>
	  </table>
	  <br/>
	  <input type="submit" value="Delete">
	  </form>
	  <?php
	  }
}

//Add a test to the current Term
if($op=="add")
{
$pageID=$_GET['pageID'];
$temp=$_POST['testtype'];
foreach ($temp as $test_type) 
{
  //do nothing
}
$testName=$_POST['testName'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO test (termID,testName,testType,pageID)
VALUES ('$termID','$testName','$test_type','$pageID')";

if (mysqli_query($conn, $sql)) 
{
    echo "Test Added successfully"; ?>
    <script>window.open('term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $_SESSION['login']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Test already exists";
}
mysqli_close($conn);
}

//Delete a test form a current term
if($op=="del")
{
	$temp=$_POST['testName'];
	$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

//delete test from term whose id is termID and with a particular testName
$sql = "DELETE FROM test WHERE termID='$termID' and testName='$temp'";

if (mysqli_query($conn, $sql)) 
{
    echo "Test Deleted successfully"; ?>
    <script>window.open('term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $_SESSION['login']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Test Doesn't Exist";
}
}
?> 

