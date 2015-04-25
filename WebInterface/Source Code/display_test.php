<?php
//Start PHP session
session_start();
unset($_SESSION['teID']);
unset($_SESSION['qID']);
unset($_SESSION['questionID']);

//Extract URL variable values
$testID=$_GET['testID'];
$_SESSION['teID']=$testID;
$flag=999;

//URL Tampering prevention mechanism
//Check if testID sent through URL belongs to a particular course.
for($i=0;$i<$_SESSION['numTests'];$i++)
{
 if($_SESSION['testID'][$i]==$testID)
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
  <title>Test #<?php echo $testID; ?></title>
  </head>
  <body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
    <a href="display_list.php?pageID=<?php echo $_SESSION['pID']; ?>&termID=<?php echo $_SESSION['tID']; ?>">Back</a>
    | 
	<a href="logout.php">Logout</a>
	</h4></p>
	<br/>
	<?php 
	//SELECT all questions from table with a particular testID 
	$sql="select * from question_pool where testID='$testID'";
	$result=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($result);
	$_SESSION['numQuestions']=$num;
	$i=0;
	//if questions exist
	if($num>0)
	{
		?>
		<center><b><h3>Test#<?php echo $testID; ?></h3></b></center>
		<p>
		Question &nbsp
		<?php
		while($row=mysqli_fetch_assoc($result))
		{
			//store qID for future URL tampering check
			$questionInfo[$i++]=$row['qID'];
            $_SESSION['questionID']=$questionInfo;
			?>
			
			<a href="activate.php?qID=<?php echo $row['qID']; ?>&qnum=<?php echo $i; ?>"><?php echo $i; ?></a>
			|
			<?php
		}
		?>
		</p>
		<?php
	}
	else
	{
		echo "<h4>You have no questions added yet!</h4>";
	}
	?>