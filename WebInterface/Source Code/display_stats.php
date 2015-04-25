<?php
//Start PHP session
session_start();

$testID=$_SESSION['teID'];

//Logout if unauthorized access
if(!($_SESSION['login']))
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
<title>Statistics</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css" />
</head>
<body background="background.jpg">
<p><h4>
<a href="welcome.php?id=0">Home</a>
|
<a href="test_detail.php?testID=<?php echo $_SESSION['teID']; ?>">Back</a>
</h4></p>
<br/>
<?php
$sql="SELECT * from test where testID='$testID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($num>0)
{
	if($row['testType']=="anonymous")
	{
	//SELECT all questions from questions table for a particular testID  
	$sql="select * from question_pool where testID='$testID'";
	$result=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($result);
	$_SESSION['numQuestions']=$num;
	$j=0;
	$c=0;
	//if questions exist
	if($num>0)
	{
	 while($row=mysqli_fetch_assoc($result))
	 {
	  ?>
	  <table border="1" cellspacing="10" cellpadding="10">
	  <p>
	  <b><?php //Display question 
		  echo "<h3>Question"." ".(++$j); echo "."; ?></b>
	  <b><?php echo $row['question']; ?></b></h4>
	  <tr><td><b>Option</b></td><td><b>Count</b></td></tr>
	  <?php $qID=$row['qID'];
	  //statistics based on the type of question
	  if($row['question_type']=="multiChoice")
	  {
		  for($c=1;$c<=4;++$c)
		  {
		  $sql2="";	  
		  $answer=$c;
		  $sql2="select * from anonymous where qID='$qID' and answer='$answer'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  $count[$c]=$num2;
		  }
		  //Display statistics
		  ?>
		  <tr><td><?php echo $row['A']; echo "  "; ?></td><td><?php echo $count[1]; ?></td></tr>
		  <tr><td><?php echo $row['B']; echo "  ";?></td><td><?php echo $count[2]; ?></td></tr>
		  <tr><td><?php echo $row['C']; echo "  ";?></td><td><?php echo $count[3]; ?></td></tr>
		  <tr><td><?php echo $row['D']; echo "  ";?></td><td><?php echo $count[4]; ?></td></tr>
		  <?php
		  
	  }
	  if($row['question_type']=="trueFalse")
	  {
		  $answer="True";
		  for($c=1;$c<=2;++$c)
		  {
		  $sql2="";	  
		  $sql2="select * from anonymous where qID='$qID' and answer='$answer'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  $count[$c]=$num2;
		  $answer="False";
		  }
		  //Display statistics
		 ?>
		 <tr><td><?php echo "True"; echo "  ";?></td><td><?php echo $count[1]; ?></td></tr>
		 <tr><td><?php echo "False"; echo "  ";?></td><td><?php echo $count[2]; ?></td></tr>
		 <?php
	  }
	  if($row['question_type']=="textAnswer"||$row['question_type']=="numericAnswer")
	  {
		  $answer=$row['answer']; 
		  $sql2="select * from anonymous where qID='$qID'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  $count['total']=$num2;
		  
		  $sql2="select * from anonymous where qID='$qID' and answer='$answer'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  //Number of correct answers
		  $count['correct']=$num2;
		  //Number of incorrect answers
		  $count['incorrect']=$count['total']-$count['correct'];
		  
		  //Display statistics
		  ?>
		  <tr><td><?php echo "Correct"; echo "  ";?></td><td><?php echo $count['correct']; ?></td></tr>
		 <tr><td><?php echo "Incorrect"; echo "  ";?></td><td><?php echo $count['incorrect']; ?></td></tr>
		 <?php
	  }
	  if($row['question_type']=="checkBox")
	  {
		  $answer=$row['answer'];
		  $answer=substr($answer,0,strlen($answer)-1);
		  echo $answer;	  
		  $sql2="select * from anonymous where qID='$qID'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  $count['total']=$num2;
		  
		  $sql2="select * from anonymous where qID='$qID' and answer='$answer'";
		  $result2=mysqli_query($conn,$sql2);
		  $num2=mysqli_num_rows($result2);
		  //Number of correct answers
		  $count['correct']=$num2;
		  //Number of incorrect answers
		  $count['incorrect']=$count['total']-$count['correct'];
		  
		  //Display statistics
		  ?>
		  <tr><td><?php echo "Correct"; echo "  ";?></td><td><?php echo $count['correct']; ?></td></tr>
		 <tr><td><?php echo "Incorrect"; echo "  ";?></td><td><?php echo $count['incorrect']; ?></td></tr>
		 <?php
	  }
	  
	  ?>
	  </p>
	  </table><br/>
	  <?php
	 }
    }
}
//else testType=graded
else
{
	//SELECT all from results table for a matching testID
	$sql2="SELECT * from results where testID='$testID'";
	$result2=mysqli_query($conn,$sql2);
	$num2=mysqli_num_rows($result2);
	if($num>0)
	{
		?>
		<center>
		<table border="1" cellpadding="10" cellspacing="10">
		<tr><td><b>STUDENT ID</b></td><td><b>MARKS</b></td></tr>
		<?php
		while($row2=mysqli_fetch_assoc($result2))
		{
			?>
			<tr><td><?php echo $row2['studentID']; ?></td><td><?php echo $row2['score']; ?></td></tr>
			<?php
		}
		?>
		</table>
		</center>
		<?php
	}
}
}
else
{
	echo "Test Not Yet Taken!";
}
?>