<?php
//start PHP session
session_start();

//Extract values of URL variables
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

//Logout if unauthorized access
if(!$_SESSION['login']||$flag==999)
{
	header("Location: logout.php");
}

//Initialize DB variables
$servername="localhost";
$username="root";
$password="";
$dbname="android";

// Create connection
$conn=mysqli_connect($servername,$username,$password,$dbname);
// Check connection
if(!$conn)
{
	die("Connection failed : ".mysqli_connect_error);
}
?>

<html>
<head>
<title>Question Update</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">

<p><h4>
<a href="welcome.php?id=0">Home</a>
|
<a href="test_detail.php?testID=<?php echo $testID; ?>">Back</a>
</h4></p></br>
<?php
//SELECT question from table for a particular qID
$sql="select * from question_pool where qID='$qID'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$i=0;
//if question exists
if($num==1)
{
	while($row=mysqli_fetch_assoc($result))
	{
		//display question form depending on the type of question selected
		?>
		<form method="post" action="update_question.php?qID=<?php echo $qID; ?>">
		<table border="0">
		<tr>
		<td>Question</td>
		<td><textarea rows="10" cols="50" name="question"><?php echo $row['question']; ?></textarea></td>
		</tr>
		<?php
		
		//form for multiChoice question type
		if($row['question_type']=="multiChoice")
		{
			$_SESSION['qtype']=$row['question_type'];
			?>
			<tr><td>1</td><td><input type="text" name="1" value="<?php echo $row['A']; ?>"></td></tr>
			<tr><td>2</td><td><input type="text" name="2" value="<?php echo $row['B']; ?>"></td></tr>
			<tr><td>3</td><td><input type="text" name="3" value="<?php echo $row['C']; ?>"></td></tr>
			<tr><td>4</td><td><input type="text" name="4" value="<?php echo $row['D']; ?>"></td></tr>
			
			<tr><td>Solution</td>
	        <td><select name="answer[]">
			<?php 
			//set option 1 as selected
			if($row['answer']=="1")
			{
				?>
				
	            <option selected value="1">1</option>
	            <option value="2">2</option>
	            <option value="3">3</option>
	            <option value="4">4</option>
	            </select></td></tr>
				<?php
			}
			//set option 2 as selected
			else if($row['answer']=="2")
			{
				?>
				
	            <option value="1">1</option>
	            <option selected value="2">2</option>
	            <option value="3">3</option>
	            <option value="4">4</option>
	            </select></td></tr>
				<?php
			}
			//set option 3 as selected
			else if($row['answer']=="3")
			{
				?>
				
	            <option value="1">1</option>
	            <option value="2">2</option>
	            <option selected value="3">3</option>
	            <option value="4">4</option>
	            </select></td></tr>
				<?php
			}
			//set option 4 as selected
			else if($row['answer']=="4")
			{
				?>
				
	            <option value="1">1</option>
	            <option value="2">2</option>
	            <option value="3">3</option>
	            <option selected value="4">4</option>
	            </select></td></tr>
				<?php
			}
		} //End of Multichoice type
		//form for textAnswer question type
		else if($row['question_type']=="textAnswer")
		{
			$_SESSION['qtype']=$row['question_type'];
			?>
			<tr><td>Solution</td><td><input type="text" name="answer" value="<?php echo $row['answer']; ?>"></td></tr>
			<?php
		}
		//form for numericAnswer question type
		else if($row['question_type']=="numericAnswer")
		{
			$_SESSION['qtype']=$row['question_type'];
			?>
			<tr><td>Solution</td><td><input type="number" name="answer" value="<?php echo $row['answer']; ?>"></td></tr>
			<?php
		}
		//form for checkBox question type
		else if($row['question_type']=="checkBox")
		{
			$string=$row['answer'];
			$choices=explode(";",$string);
			$_SESSION['qtype']=$row['question_type'];
			//keep relevant checkBox checked
			?>
			<tr><td>Solution</td><td>
			<tr><td>1</td><td><input  type="checkbox" name="answer[]" value="1"><?php echo $row['A']; ?></td></tr>
			<tr><td>2</td><td><input  type="checkbox" name="answer[]" value="2"><?php echo $row['B']; ?></td></tr>
			<tr><td>3</td><td><input  type="checkbox" name="answer[]" value="3"><?php echo $row['C']; ?></td></tr>
			<tr><td>4</td><td><input  type="checkbox" name="answer[]" value="4"><?php echo $row['D']; ?></td></tr>
			<?php
		}
		//form for trueFlase question type
		else if($row['question_type']=="trueFalse")
		{
			$_SESSION['qtype']=$row['question_type'];
			//keep True option selected
			if($row['answer']=="True")
			{
				?>
				<tr><td>Solution</td>
		        <td><input type="radio" name="answer" value="True" checked="checked">True
				<input type="radio" name="answer" value="False">False</td>
				</tr>
				<?php
			}
			//keep false option selected
			else if($row['answer']=="False")
			{
				?>
				<tr><td>Solution</td>
				<td><input type="radio" name="answer" value="True">True
				<input type="radio" name="answer" value="False" checked="checked">False</td>
				</tr>
				<?php
		    }
		}
		?>
		<tr><td>Weight</td><td><input type="text" name="weight" value="<?php echo $row['weight']; ?>"></td></tr>
		</table>
                <br/>
		<input type="submit" value="Update">
		<?php
	}
}