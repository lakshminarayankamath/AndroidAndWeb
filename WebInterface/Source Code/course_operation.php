<?php
//Start PHP session
session_start();

//Extract URL variable values
$option=$_GET['option'];
$uname=$_GET['username'];

//Logout if unauthorized access
if($_SESSION['login']!=$uname)
{
	header("Location: logout.php");
}
?>
<p>
<h4>
<a href="welcome.php?id=0">Home</a>
|
<a href="logout.php">Logout</a>
</h4>
</p>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">        
</head>
<body background="background.jpg">
<?php
//Display options to choose type of questions
if ($option ==1)
{ 
?>
	<h3>Add Course</h3><br/><br/>
	<form method="post" action="course_operation.php?option=add&username=<?php echo $uname; ?>">
		<select name="Courseop[]">
			<option>CSC</option> 
			<option>ECE</option>
			<option>MA</option>
			<option>BUS</option>
			<option>ISE</option>
			
		</select>
		<input type="text" name="Coursenum"><br/>
		<input type="submit" value="Add">
	</form>
	
<?php
}
$servername="localhost";
$username="root";
$password="";
$dbname="android";


if ($option=="add")
{
$Courseop=$_POST['Courseop'];
	foreach ($Courseop as $Courseop) 
		{
			//do nothing
		}
$Coursenum=$_POST['Coursenum'];
//Add coursename and current username to courses table
	if($Courseop && $Coursenum)
		{
		$Course=$Courseop.$Coursenum;
		$connect = mysqli_connect($servername, $username, $password, $dbname) or die ("Could not connect to the server");
		$query = "INSERT INTO courses(username,coursename) VALUES ('$uname','$Course')";
														

			if (mysqli_query($connect, $query)) 
			{
				echo "Course has been added";
                                header("Location: welcome.php?id=0");
	
			} 
			else 
			{
				echo "Course already exists";
			}
		}
		
	else
		{
		echo "Enter two valid values for each column";
		}		
}

//Delete courses
if($option==2)
{
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
<h3>Delete Courses</h3>
<?php

$sql="SELECT coursename from courses where username='$uname' ";
$result=mysqli_query($conn,$sql);
  	  if(mysqli_num_rows($result)>0)
	  { ?>
		<form method="post" action="course_operation.php?option=del&username=<?php echo $uname; ?>">
		<table border="0"> <?php
	  while($row=mysqli_fetch_assoc($result))
	  { ?>
		<tr>
		<td><input type="radio" name="course" value="<?php echo $row['coursename']; ?>"><?php echo $row['coursename']; ?></td>
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

if($option=="del")
{
	$temp=$_POST['course'];
	$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
//Delete chosen course from courses table 
$sql = "DELETE FROM courses WHERE coursename='$temp' AND username='$uname'";

if (mysqli_query($conn, $sql)) 
{
    echo "Course Deleted successfully"; ?>
    <script>window.open('welcome.php?id=0','_self')</script>;
<?php
} 
else 
{
    echo "Subject Doesn't Exist";
}
}
?>