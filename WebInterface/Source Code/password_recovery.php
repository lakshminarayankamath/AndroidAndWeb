<?php
session_start();

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

<head>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body background="background.jpg">

<h4><a href="password_recovery.html">Back</a></h4>
<br/>

<?php
//Extract values of URL variables
$uname=$_POST['username'];
$passcode=$_POST['passcode'];
$_SESSION['reset']=$uname;
$flag=999;

//Select all passcodes
$sql="select * from passcode";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
 //if passcode matches passcode entered by user
 while($row=mysqli_fetch_assoc($result))
{
 if($row['passcode']==$passcode)
{
 $flag=0;
}
}
}

//if match successful
if($flag==0)
{
	//select security question for username
$sql="select question from users where username='$uname'";
$result=mysqli_query($conn,$sql);

if (mysqli_num_rows($result) ==1) 
{
    
    while($row = mysqli_fetch_assoc($result)) 
   { ?>
        <form method="post" action="password_recovery2.php?question=<?php echo $row['question']; ?>&username=<?php echo $uname; ?>">
        <table style="padding:15px;" border="0"><tr><td><label>Security Question</td>
	    <td align="center"><?php echo "\"".$row['question']."\""; ?></td></tr>
        <tr><td><label>Answer</td><td align="center"><input type="password" name="answer"></td></tr>
		<?php
   }
   echo "</table>";
   echo "<input type=\"submit\" value=\"Submit\">";
}
else
{
 echo "Username doesnot exist in database ";
}
}
else
{
echo "Invalid Passcode. Try Again";
}
?>
