<?php

  $conn = mysqli_connect("localhost","root","","android");
  
  // To check whether the connection is Valid:
  
  if (!$conn) {
	$response["success"] = 0;
	$response["message"] = mysqli_connect_error();
	die(json_encode($response));
  }
  else
  {
	  $unity=$_POST["unityId"];
	  $password=$_POST["password"];
	   
	   //username will unity id and password is password
	   
	  if (!empty($_POST)) {
	  if (empty($_POST['unityId']) || empty($_POST['password'])) {
			  $response["success"] = 0;
			  $response["message"] = "One or both of the fields are empty .";
			  die(json_encode($response));
		  }

		$password = hash("sha256", $password);
			
		$query = " SELECT * FROM students WHERE password='$password' and unityId='$unity' ";
		  
		$sql1=mysqli_query($conn,$query);	
		$row = mysqli_fetch_array($sql1,MYSQLI_ASSOC);

		if (!empty($row)) {
			$response["success"] = 1;
			$response["message"] = "You have been sucessfully login";
			$response["studentId"] = $row["studentID"];
			die(json_encode($response));
		}
		else{
			$response["success"] = 0;
			$response["message"] = "invalid username or password ";
			die(json_encode($response));
		}
	  }
	  else{   
		$response["success"] = 0;
		$response["message"] = " One or both of the fields are empty ";
		die(json_encode($response));
	  }
  
  }
    mysqli_close($conn);
  ?>