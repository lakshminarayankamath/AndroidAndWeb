<?php
session_start();
unset($_SESSION['pageID']);

//
$id=$_GET['id'];

if($id==0)
{	
$uname=$_SESSION['login'];
$connect = mysqli_connect("localhost", "root", "", "android") or die ("Could not connect to the server");
?>
        <head>
        <link rel="stylesheet" type="text/css" href="bootstrap.css">
        </head>
        <body background="background.jpg">
        <p>
        <h4>
	<a href="logout.php">Logout</a>
        |
	<a href="course_operation.php?option=1&username=<?php echo $uname; ?>">Add Course</a>
	|
	<a href="course_operation.php?option=2&username=<?php echo $uname; ?>">Delete Course</a>
        </h4>
	</p>
	<?php
courselist($uname,$connect);
}

if ($id == 1)
{
$username = $_POST['myusername'];
$password = $_POST['mypassword'];
$password = hash("sha256", $password);
$passcode = $_POST['passcode'];


$connect = mysqli_connect("localhost", "root", "", "android") or die ("Could not connect to the server");
$query2 = "SELECT * FROM passcode";
$query = mysqli_query($connect, $query2);
if($row = mysqli_fetch_assoc($query))
{
	if ($row['passcode'] == $passcode)
	{
 
	if($username && $password)
	{
     ?>
        <head>
        <link rel="stylesheet" type="text/css" href="bootstrap.css">
        </head>
        <body background="background.jpg">
	<p>
        <h4>
	<a href="logout.php">Logout</a>
        |
	<a href="course_operation.php?option=1&username=<?php echo $username; ?>">Add Course</a>
	|
	<a href="course_operation.php?option=2&username=<?php echo $username; ?>">Delete Course</a>
        </h4>
	</p>
	
	<?php
	$query1 = "SELECT * FROM users WHERE username = '$username' and password ='$password'";
	$query = mysqli_query($connect, $query1);

	$numrows = mysqli_num_rows($query);
   
		if ($numrows !=0)
		{
		$row = mysqli_fetch_assoc($query);
			
			$dbusername = $row['username'];
			$dbpassword = $row['password'];
			
			if ($username == $dbusername && $password == $dbpassword)
			{
			$_SESSION ['login'] = $username;
			$current = 1;
			courselist($username, $connect);
			}
			else 
			echo "Your Login credentials are incorrect";
		}
else
die("This user does not exist");
	}
else
	die("Enter all three values");
}
else 
	echo "Wrong Passcode!";
}
}

function courselist ($username, $connect)
{
	echo "<br/><br/><h3>Welcome   " .$username."!"; 
	echo "</h3><br/>";
	
	echo "Your Courses: <br/><br/>";
	  
	  $sql="select * from courses where username='$username'";
          $result=mysqli_query($connect,$sql);
	  $num=mysqli_num_rows($result);
	  $_SESSION['numCourses']=$num;
	  $i=0;
		if($num>0)
		{
			while($row=mysqli_fetch_assoc($result))
			{ 
		     $pageInfo[$i++]=$row['pageID'];
             $_SESSION['pageID']=$pageInfo;?>      
		        
				<a href="course_detail.php?pageID=<?php echo $row['pageID']; ?>&username=<?php echo $username; ?>"><?php echo $row['coursename']; ?></a>
				<br/>
			<?php
			}
			echo "<br/><br/>";
		}
		else
		{
			echo "You do not have any courses currently";
			
		}
         
}
?>