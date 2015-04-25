<?php

  $conn = mysqli_connect("localhost","root","","android");
  
  $firstName=$_POST["firstName"];
  $lastName=$_POST["lastName"];
  $unityId=$_POST["unityId"];
  $password=$_POST["password"];
  $studId=$_POST["studId"];
  $secQuestion=$_POST["secQuestion"];
  $secAnswer=$_POST["secAnswer"];
   
   //username will unity id and password is password
   
  if (!empty($_POST)) {
  if (empty($_POST['unityId']) || empty($_POST['password'])) {
          $response["success"] = 0;
          $response["message"] = "One or both of the fields are empty .";
          die(json_encode($response));
      }

	$password = hash("sha256", $password);
	
 //INSERT QUERY
	
	$test = "SELECT * FROM student WHERE studentID='$studId';";
	$sql1=mysqli_query($conn,$test);
	$rowcount=mysqli_num_rows($sql1);	
	
	if($rowcount != 0){
		$response["success"] = 0;
		$response["message"] = "Account Already exists";
		die(json_encode($response));
	}
	
	else{
	
		$query = "INSERT INTO students values('$studId','$firstName','$lastName','$password', '$secQuestion', '$secAnswer','$unityId' );";
	if ($conn->query($query) === TRUE) {
		$response["success"] = 1;
		$response["message"] = "Registration Successful";
		die(json_encode($response));
	} 
	else {
		$response["success"] = 0;
		$response["message"] = "Registration Unsuccessful";
		die(json_encode($response));
	}
	}

  }
  else{   
	$response["success"] = 0;
    $response["message"] = " One or both of the fields are empty ";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>