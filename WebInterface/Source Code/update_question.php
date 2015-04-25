<?php
session_start();

//Extract URL variable values
$flag=999;
$qID=$_GET['qID'];
$testID=$_SESSION['teID'];

//URL Tampering prevention mechanism
//Check if questionID sent through URL belongs to a particular test.
for($i=0;$i<$_SESSION['numQuestions'];$i++)
{
 if($_SESSION['questionID'][$i]==$qID)
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

//Initialize parameters to be updated
$answer;
$question=$_POST['question'];
$weight=$_POST['weight'];
$A="";
$B="";
$C="";
$D="";

//Parameters for multiChoice type questions
if($_SESSION['qtype']=="multiChoice")
{
	$A=$_POST['1'];
	$B=$_POST['2'];
	$C=$_POST['3'];
	$D=$_POST['4'];
	$temp=$_POST['answer'];
        foreach ($temp as $ans) 
        {
          //do nothing
        }
		$answer=$ans;
}
//Parameters for check type questions
else if($_SESSION['qtype']=="checkBox")
{
	$A=$_POST['1'];
	$B=$_POST['2'];
	$C=$_POST['3'];
	$D=$_POST['4'];
	$ans="";
	$temp=$_POST['answer'];
		foreach ($temp as $value)
		{
			$ans=$ans.$value.",";
		}
		$answer=$ans;
}
//Parameters for other type questions
else if($_SESSION['qtype']=="trueFalse"||$_SESSION['qtype']=="textAnswer"||$_SESSION['qtype']=="numericAnswer")
{
	$answer=$_POST['answer'];
	$A="True";
	$B="False";	
}

//Initialize DB variables
$servername="localhost";
$username="root";
$password="";
$dbname="android";

//Create Connection
$conn=mysqli_connect($servername,$username,$password,$dbname);
//Check Connection
if(!$conn)
{
	die("Connection failed : ".mysqli_connect_error);
}

//Update question with a particular questionID
$sql="UPDATE question_pool SET question='$question',weight='$weight',A='$A',B='$B',C='$C',D='$D',answer='$answer' WHERE qID='$qID'";
if (mysqli_query($conn, $sql)) 
{
	?>
    <script>alert('Question updated successfully')</script>;
	<script>window.open('test_detail.php?testID=<?php echo $_SESSION['teID']; ?>','_self')</script>;
	<?php
} 
else 
{
   ?>
    <script>alert('Question could not be updated')</script>;
	<script>window.open('test_detail.php?testID=<?php echo $_SESSION['teID']; ?>','_self')</script>;
	<?php
}

mysqli_close($conn);
?>
