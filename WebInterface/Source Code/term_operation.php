<?php
session_start();

//Initialize DB variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

//Extract URL variable values
$pageID=$_GET['pageID'];
$op=$_GET['op'];
$flag=999;
$flag2=999;

//URL Tampering prevention mechanism
//Check if courseID (pageID) sent through URL belongs to current user or not.
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
 header("Location: login.html");
}
?>
        <head>
        <link rel="stylesheet" type="text/css" href="bootstrap.css">
        </head>
        <body background="background.jpg">
        <p><h4>
        <a href="course_detail.php?pageID=<?php echo $pageID; ?>&username=<?php echo $_SESSION['login']; ?>">Back</a>
        |
	    <a href="logout.php">Logout</a>
        </h4></p>
<?php
//Display options of Different Terms to add
if($op==1)
{
	?>
	<br/>
	<h1>Add Term</h1>                                                 
	<br/>
	<form method="post" action="term_operation.php?op=add&pageID=<?php echo $pageID; ?>">
	<table border="0">
	<tr>
	<td>Term Type</td><td>Year</td></tr>
	<tr>
	<td><select name="termtype[]">
      <option value="Fall">Fall</option>
      <option value="Spring">Spring</option>
	  <option value="Summer">Summer</option>
    </select></td>
	<td><input type="text" name="year"></td>
	</tr>
	</table>
	<input type="submit" value="Add">
	</form>
	<?php
}

//Display terms to delete
if($op==2)
{
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
<br/>
<h1>Delete Term</h1>
<br/><?php

$sql="SELECT term from terms where pageID='$pageID'";
$result=mysqli_query($conn,$sql);

  	  if(mysqli_num_rows($result)>0)
	  { ?>
		<form method="post" action="term_operation.php?op=del&pageID=<?php echo $pageID; ?>">
		<table border="0"> <?php
	  while($row=mysqli_fetch_assoc($result))
	  { ?>
		<tr>
		<td><input type="radio" name="term" value="<?php echo $row['term']; ?>"><?php echo $row['term']; ?></td>
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
//Add terms to course
if($op=="add")
{
$termID=$_GET['termID'];
$temp=$_POST['termtype'];
foreach ($temp as $term_type) 
{
  //do nothing
}
$year=$_POST['year'];
$term=$term_type.$year;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO terms (pageID,term)
VALUES ('$pageID','$term')";

if (mysqli_query($conn, $sql)) 
{
    echo "Term Added successfully"; ?>
    <script>window.open('course_detail.php?pageID=<?php echo $pageID; ?>&username=<?php echo $_SESSION['login']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Term already exists";
}
mysqli_close($conn);
}

//Delete terms from course
if($op=="del")
{
	$termID=$_GET['termID'];
	$temp=$_POST['term'];
	$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "DELETE FROM terms WHERE pageID='$pageID' and term='$temp'";

if (mysqli_query($conn, $sql)) 
{
    echo "Term Deleted successfully"; ?>
    <script>window.open('course_detail.php?pageID=<?php echo $pageID; ?>&username=<?php echo $_SESSION['login']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Term Doesn't Exist";
}
}
?> 

