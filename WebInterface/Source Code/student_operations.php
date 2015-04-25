<?php
session_start();
$pageID = $_SESSION['pID'];
$termID =$_SESSION['tID'];
$uname = $_SESSION['login'];
$action=$_GET['action'];


?>
<html>
<head>
<?php
//Add student into current term
if($action==1)
{
?>
<script type="text/javascript">
var i = 1;
function addStudent(){
	if (i <= 200)
	{
		i++;	
    	var div = document.createElement('div');
		div.style.width = "300px";
		div.style.height = "50px";
		div.style.color = "black";
		div.setAttribute('class', 'myclass');
    	div.innerHTML = '<br/>Student ID : <input type="text" name="student_'+i+'" ><input type="button" id="add_kid()" onClick="addStudent()" value="+" /><input type="button" value="-" onclick="removeStudent(this)">';
    	document.getElementById('studentID').appendChild(div);
	}
}
function removeStudent(div) {	
    document.getElementById('studentID').removeChild( div.parentNode );
	i--;
}
</script>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p>
<h4><a href="welcome.php?id=0">Home</a>
|
<a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $uname; ?>">Back</a></h4></p>
<br/>

<form action="student_add.php" method="post" >
	
    <div id="studentID">
       Student ID : <input type="text" name="student_1" > <input type="button" id="add_kid()" onClick="addStudent()" value="+" />
    </div>
    <input type="submit" name="submit" value="Enroll" />
</form>
<?php
}
//Remove Student from current term
else if($action==2)
{
?>
<script type="text/javascript">
var i = 1;
function addStudent(){
	if (i <= 200)
	{
		i++;	
    	var div = document.createElement('div');
		div.style.width = "300px";
		div.style.height = "50px";
		div.style.color = "black";
		div.setAttribute('class', 'myclass');
    	div.innerHTML = '<br/>Student ID : <input type="text" name="student_'+i+'" ><input type="button" id="add_kid()" onClick="addStudent()" value="+" /><input type="button" value="-" onclick="removeStudent(this)">';
    	document.getElementById('studentID').appendChild(div);
	}
}
function removeStudent(div) {	
    document.getElementById('studentID').removeChild( div.parentNode );
	i--;
}
</script>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">
<p>
<h4><a href="welcome.php?id=0">Home</a>
|
<a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $uname; ?>">Back</a></h4></p>
<br/>

<form action="student_remove.php" method="post" >
	
    <div id="studentID">
       Student ID : <input type="text" name="student_1" > <input type="button" id="add_kid()" onClick="addStudent()" value="+" />
    </div>
    <input type="submit" name="submit" value="Unenroll" />
</form>
<?php
}
//Display students enrolled in current term
else if($action==3)
{
	?>
	<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	</head>
	<body background="background.jpg">
	<p>
	<h4><a href="welcome.php?id=0">Home</a>
	|
	<a href="term_detail.php?pageID=<?php echo $pageID; ?>&termID=<?php echo $termID; ?>&username=<?php echo $uname; ?>">Back</a></h4></p>
	<br/>
	<?php
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
	
    //Select all students enrolled in a particluar term
	$sql="SELECT * from enroll where termID='$termID'";
	$result=mysqli_query($conn,$sql);
	$num=mysqli_num_rows($result);
	if($num>0)
	{
		?>
		<table border="1" cellpadding="4" cellspacing="2">
		<tr><td><b>STUDENT ID</b></tr></tr><?php
		while($row=mysqli_fetch_assoc($result))
		{
			?>
			<tr><td><?php echo $row['studentID']; ?></td></tr>
			<?php
		}
	}
	else
	{
	 echo "<h4>No students enrolled in this Term!</h4>";	
	}
}