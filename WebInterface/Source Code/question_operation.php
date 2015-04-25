<?php
session_start();
//unset($_SESSION['qtype']);

//Extract URL variable values
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "android";

$op=$_GET['op'];

//Logout if unauthorized access
if(!$_SESSION['login'])
{
 header("Location: logout.php");
}

//op 1 is displaying page containing type of question to Add
if($op==1)
{
	?>
	<head>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>
    <body background="background.jpg">
	<p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
	<a href="test_detail.php?testID=<?php echo $_SESSION['teID']; ?>">Back</a>
	|
	<a href="logout.php">Logout</a>
	</h4></p>
	<br/>
	<h1>Add Question</h1>                                                 
	<br/>
	<form method="post" action="question_operation.php?op=addCont">
	<table border="0">
	<tr>
	<td>Question Type</td>
	<td><select name="questiontype[]" >
      <option selected value="multiChoice">Multiple Choice</option>
      <option value="textAnswer">Text Answer</option>
	  <option value="trueFalse">True or False</option>
	  <option value="numericAnswer">Numeric Answer</option>
	  <option value="checkBox">All that Apply</option>
    </select></td>
	</tr>
	</table>
	<input type="submit" value="Continue">
	</form>
	
	<?php
}

//op 2 is display list for choosing a question to delete
if($op==2)
{
	$termID=$_SESSION['tID'];
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
    <head>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>
    <body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
	<a href="test_detail.php?testID=<?php echo $_SESSION['teID']; ?>">Back</a>
	|
	<a href="logout.php">Logout</a>
	</h4></p>
	<br/>
	<h1>Delete Question</h1>                                                 
	<br/>
	<?php
$testID=$_SESSION['teID'];
$sql="SELECT * from question_pool where testID='$testID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
  	  if($num>0)
	  { ?>
		<form method="post" action="question_operation.php?op=del">
		<table border="0"> <?php
	  while($row=mysqli_fetch_assoc($result))
	  { ?>
		<tr>
		<td><input type="checkbox" name="qName[]" value="<?php echo $row['qID']; ?>"><?php echo $row['question']; ?></td>
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

//op adCont is displaying forms for selected type of question
if($op=="addCont")
{
$temp=$_POST['questiontype'];
foreach ($temp as $question_type) 
{
  //do nothing
}
$_SESSION['qtype']=$question_type;
?>
    <head>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>
    <body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0?>">Home</a>
	|
	<a href="question_operation.php?op=1">Back</a>
	|
	<a href="logout.php">Logout</a>
	</h4></p>
    <br/>
	
	<form method="post" action="question_operation.php?op=add">
    <table border="0">
    <tr>
    <td>Enter Question in Text Area</td>
    <td><textarea rows="10" cols="50" name="question"></textarea></td>
    </tr>
	<?php
	//display form for adding multiChoice type of question
    if($question_type=="multiChoice")
    {		
		?>
    <tr><td>1</td><td><input type="text" col="50" name="1"></td></tr>
	<tr><td>2</td><td><input type="text" col="50" name="2"></td></tr>
	<tr><td>3</td><td><input type="text" col="50" name="3"></td></tr>
	<tr><td>4</td><td><input type="text" col="50" name="4"></td></tr>
	
	<tr><td>Solution</td>
	<td><select name="answer[]">
	<option selected value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	</select></td></tr>
<?php
	}
	//display form for adding checkBox type of question
	if($question_type=="checkBox")
    {		
		?>
		
	<tr><td>1</td><td><input type="text" col="50" name="1"></td></tr>
	<tr><td>2</td><td><input type="text" col="50" name="2"></td></tr>
	<tr><td>3</td><td><input type="text" col="50" name="3"></td></tr>
	<tr><td>4</td><td><input type="text" col="50" name="4"></td></tr>
	
	<tr><td>Solution</td>
    <tr><td>1</td><td><input type="checkbox" col="50" name="answer[]" value="1"></td></tr>
	<tr><td>2</td><td><input type="checkbox" col="50" name="answer[]" value="2"></td></tr>
	<tr><td>3</td><td><input type="checkbox" col="50" name="answer[]" value="3"></td></tr>
	<tr><td>4</td><td><input type="checkbox" col="50" name="answer[]" value="4"></td></tr>
    </tr>
<?php
	}
	//display form for adding multiChoice type of question
	else if($question_type=="textAnswer")
	{
		?>
		<tr><td>Solution</td>
		<td><input type="text" name="answer"></td>
		</tr>
		<?php
	}
	//display form for adding numericAnswer type of question
	else if($question_type=="numericAnswer")
	{
		?>
		<tr><td>Solution</td>
		<td><input type="number" name="answer"></td>
		</tr>
		<?php
	}
	//display form for adding trueFalse type of question
	else if($question_type=="trueFalse")
	{
		?>
		<tr><td>Solution</td>
		<td><input type="radio" name="answer" value="True" checked="checked">True
		<input type="radio" name="answer" value="False">False</td>
		</tr>
		<?php
	}
	?>
	<tr><td>Weight</td><td><input type="text" name="weight" value="1"></td></tr>
	</table>
	<br/>
	<input type="submit" value="Add">
	</form>
	<?php
}

//op add is actual adding of questions to the test/DB
if($op=="add")
{
	$answer;
	$testID=$_SESSION['teID'];
	$qtype=$_SESSION['qtype'];
	$question=$_POST['question'];
	
	//extracting parameters for multiChoice type questions for storing in DB
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
	//extracting parameters for checkBox type questions for storing in DB
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
	//extracting parameters for textAnswer or numericAnswer type questions for storing in DB
	else if($_SESSION['qtype']=="textAnswer"||$_SESSION['qtype']=="numericAnswer")
	{
		$answer=$_POST['answer'];
		$A="";
		$B="";
		$C="";
		$D="";
	}
	//extracting parameters for trueFalse type questions for storing in DB
	else if($_SESSION['qtype']=="trueFalse")
	{
		$answer=$_POST['answer'];
		$A="True";
		$B="False";
		$C="";
		$D="";
	}
	
    $weight=$_POST['weight'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
//Insert question along with other parameters into the DB
$sql = "INSERT INTO question_pool (testID,question_type,question,weight,A,B,C,D,answer)
VALUES ('$testID','$qtype','$question','$weight','$A','$B','$C','$D','$answer')";

if (mysqli_query($conn, $sql)) 
{
    echo "Question Added successfully"; ?>
    <script>window.open('test_detail.php?testID=<?php echo $_SESSION['teID']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Question already exists";
}
mysqli_close($conn);
}

//op del is actual deleting of question
if($op=="del")
{
	$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
    $exit=0;
	$count=count($_POST['qName']);
	//for all selected questions
	for($i=0;$i<$count;$i++)
	{
		$del=$_POST['qName'][$i];
		
		//Delete questions from DB
		$sql= "delete from question_pool WHERE qID='$del'";
		if(!mysqli_query($conn,$sql))
		{
			$exit=-1;
			break;
		}
	}
	
if ($exit!=-1) 
{
    echo "Question Deleted successfully"; ?>
    <script>window.open('test_detail.php?testID=<?php echo $_SESSION['teID']; ?>','_self')</script>;
    <?php
} 
else 
{
    echo "Question Doesn't Exist";
}
}
?> 

