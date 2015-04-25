<?php
//start PHP session
session_start();
unset($_SESSION['qID']);

//extract variables values from URL
$qID=$_GET['qID'];
$_SESSION['qID']=$qID;
$flag=999;
$testID=$_SESSION['teID'];
$qnum=$_GET['qnum'];

//URL Tampering prevention mechanism
//Check if questionNumber sent through URL belongs to a particular test.
for($i=0;$i<$_SESSION['numQuestions'];$i++)
{
 if($_SESSION['questionID'][$i]==$qID)
 {
	 $flag=0;
	 break;
 }
}

//Logout if unauthorized access or URL tampering
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
  <title>Test #<?php echo $_SESSION['teID']; ?></title>
  </head>
  <body background="background.jpg">
    <p><h4>
	<a href="welcome.php?id=0">Home</a>
	|
    <a href="display_list.php?pageID=<?php echo $_SESSION['pID']; ?>&termID=<?php echo $_SESSION['tID']; ?>">Back</a>
    | 
	<a href="logout.php">Logout</a>
	</h4></p><br/>
	<?php 
	//SELECT ALL QUESTIONS FROM question_pool for a particular testID
	$sql="select * from question_pool where testID='$testID'";
	$result=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($result);
	$i=1;
	
	//if questions for a particular test exist
	if($num>0)
	{
		?>
		<p><h4>
		Question &nbsp
		<?php
		while($row=mysqli_fetch_assoc($result))
		{
            if($row['qID']!=$qID)
			{
				//Display each test as a Hyper-link
			?>
			<a href="activate.php?qID=<?php echo $row['qID']; ?>&qnum=<?php echo $i; ?>"><?php echo $i; $i++; ?></a>
			|
			<?php
			}
			else
			{
		     echo $i;
             $i++;
             echo "|";			 
			}
		}
		?>
		</h4></p><br/>
		<?php
		//SELECT all fields from question_pool for a particular Question ID
		$sql="select * from question_pool where qID='$qID'";
	    $result=mysqli_query($conn,$sql);
		$num=mysqli_num_rows($result);
		$i=1;
		while($row=mysqli_fetch_assoc($result))
		{
			?>
			<center>
			<h2>Question <?php echo $qnum; ?></h2>
			<table border="1"">
			<tr><td class="td-even"><b><?php echo "->"; echo "&nbsp"; echo $row['question']; ?><b></td></tr>
			<?php
			//Display multiChoice type questions
			if($row['question_type']=="multiChoice")
			{
				?>
				<tr><td class="td-odd"><b>A &nbsp <?php echo $row['A']; ?></b></td></tr>
				<tr><td class="td-even"><b>B &nbsp <?php echo $row['B']; ?></b></td></tr>
				<tr><td class="td-odd"><b>C &nbsp <?php echo $row['C']; ?></b></td></tr>
				<tr><td class="td-even"><b>D &nbsp <?php echo $row['D']; ?></b></td></tr>
				<tr><td><i>Choose one option</i></td></tr>
				<?php
			}
			//Display checkBox type questions
			if($row['question_type']=="checkBox")
			{
				?>
				<tr><td class="td-odd"><b>A &nbsp <?php echo $row['A']; ?></b></td></tr>
				<tr><td class="td-even"><b>B &nbsp <?php echo $row['B']; ?></b></td></tr>
				<tr><td class="td-odd"><b>C &nbsp <?php echo $row['C']; ?></b></td></tr>
				<tr><td class="td-even"><b>D &nbsp <?php echo $row['D']; ?></b></td></tr>
				<tr><td><i>Choose all that apply</i></td></tr>
				<?php
			}
			//Display trueFalse type questions
			else if($row['question_type']=="trueFalse")
			{
				?>
				<tr><td class="td-odd">True or False?</td></tr>
				<?php
			}
			//Display textAnswer type questions
			else if($row['question_type']=="textAnswer")
			{
				?>
				<tr><td class="td-odd">Enter one word answer in the Text Box</td></tr>
				<?php
			}
			//Display numericAnswer type questions
			else if($row['question_type']=="numericAnswer")
			{
				?>
				<tr><td class="td-odd">Enter numeric answer in the Text Box</td></tr>
				<?php
			}
			?>
			</table>
			<!-- CSS logic for changing button color -->
	<head>		
			<style type="text/css">
             .on  {  background:green; }
             .off { background:red; }
            </style>

     <script language="javascript">
        function toggleState(item)
		{
			//Function to Activate question. Turn activate button to Red on activation.
           if(item.className == "on") 
		   {
              item.className="off";
              item.value="Deactivate";
              window.open("activate2.php?qID=<?php echo $qID; ?>&qnum=<?php echo $qnum; ?>","_self");
           }
        }
     </script>
  </head>
  
  <br/>
  <input type="button" id="btn" value="Activate" class="on" onclick="toggleState(this)" />
  </center>
 
			<?php
		}
	}
	?>