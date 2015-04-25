<?php

  $conn = mysqli_connect("localhost","root","","android");

  $username=$_POST["username"]; 
  
  if (!empty($_POST)) {
  if (empty($_POST['username'])) {
          $response["success"] = 0;
          $response["message"] = "Account not available";
          die(json_encode($response));
      } 
	$query = "SELECT * FROM students WHERE unityId='$username'";
      
    $sql1=mysqli_query($conn,$query);		
	$row = mysqli_fetch_array($sql1,MYSQLI_NUM);

	if (!empty($row)) {
        $response["success"] = 1;
        $response["message"] = "Account available";
		$response["securityQuestion"] =$row[4];
		$response["securityAnswer"] =$row[5];
		$response["studId"] =$row[0];
		die(json_encode($response));
	}
	else{
		$response["success"] = 0;
        $response["message"] = "Account not available";
		die(json_encode($response));
	}
}
  else{   
	$response["success"] = 0;
    $response["message"] = "Account not available";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>