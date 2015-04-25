<?php

  $conn = mysqli_connect("localhost","root","","android");
  
  $questionId=$_POST["questionId"];
  $testId = $_POST["testId"];
  $answer = $_POST["answer"];

   
  if (!empty($_POST)) {
  if (empty($_POST['questionId']) || empty($_POST['testId'])) {
          $response["success"] = 0;
          $response["message"] = "One or more fields are empty";
          die(json_encode($response));
      }
	
 //INSERT QUERY

		$query = "INSERT INTO anonymous values('$testId','$questionId','$answer');";
		if ($conn->query($query) == TRUE) {
			$response["success"] = 1;
			$response["message"] = "Answers saved";
			die(json_encode($response));
		} 
		else {
			$response["success"] = 0;
			$response["message"] = "Answers not saved/ Already available";
			die(json_encode($response));
		}	
	}
  else{   
	$response["success"] = 0;
    $response["message"] = " Error saving answers ";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>