<?php

  $conn = mysqli_connect("localhost","root","","android");
  
  $studentId=$_POST["studentId"];
  $testId = $_POST["testId"];
  $score = $_POST["score"];

   
  if (!empty($_POST)) {
  if (empty($_POST['studentId']) || empty($_POST['testId']) || empty($_POST['score'])) {
          $response["success"] = 0;
          $response["message"] = "One or more fields are empty";
          die(json_encode($response));
      }
	
 //INSERT QUERY

		$query = "INSERT INTO results values('$studentId','$testId','$score');";
		if ($conn->query($query) == TRUE) {
			$response["success"] = 1;
			$response["message"] = "Marks saved";
			die(json_encode($response));
		} 
		else {
			$response["success"] = 0;
			$response["message"] = "Marks not saved/ Already available";
			die(json_encode($response));
		}	
	}
  else{   
	$response["success"] = 0;
    $response["message"] = " Error saving marks ";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>