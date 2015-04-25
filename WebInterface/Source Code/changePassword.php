<?php

  $conn = mysqli_connect("localhost","root","","android");
  
  $password=$_POST["password"];
  $studentId = $_POST["studentId"];

   //username will unity id and password is password
   
  if (!empty($_POST)) {
  if (empty($_POST['password'])) {
          $response["success"] = 0;
          $response["message"] = "Password field is empty";
          die(json_encode($response));
      }

	$password = hash("sha256", $password);
	
 //INSERT QUERY
	$query1 = "SELECT * FROM students WHERE studentId='$studentId'";
	$sql1=mysqli_query($conn,$query1);
	$rowcount=mysqli_num_rows($sql1);
	if($rowcount >0){
		$query = "UPDATE students SET password='$password' WHERE studentId='$studentId';";
		if (mysqli_query($conn, $query)) {
			$response["success"] = 1;
			$response["message"] = "Password changed successfully";
			die(json_encode($response));
		}
	 
		else {
			$response["success"] = 0;
			$response["message"] = "Error while changing the password";
			die(json_encode($response));
		}
	}
	else{
		$response["success"] = 0;
		$response["message"] = "No records available";
		die(json_encode($response));
	}	
  }
  else{   
	$response["success"] = 0;
    $response["message"] = "Error while changing the password";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>