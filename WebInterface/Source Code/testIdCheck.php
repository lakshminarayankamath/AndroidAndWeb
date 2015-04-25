
<?php

  $conn = mysqli_connect("localhost","root","","android");

  $testId=$_POST["testId"];  
  $selectedCourse = $_POST["selectedCourse"];
  $studentId = $_POST["studentId"]; 
  if (!empty($_POST)) {
  if (empty($_POST['testId'])) {
          $response["success"] = 0;
          $response["message"] = "Test not available";
          die(json_encode($response));
      } 
	$query = " SELECT * FROM test WHERE testID='$testId' and pageID='$selectedCourse'";
   
    $sql1=mysqli_query($conn,$query);	
	$rowcount=mysqli_num_rows($sql1);
	
	if ($rowcount!=0) {

		$query2 = " SELECT * FROM results WHERE testID='$testId' and studentID='$studentId'";      
		$sql2=mysqli_query($conn,$query2);	
		$rowcount2=mysqli_num_rows($sql2);
		if ($rowcount!=0) {
			$response["success"] = 1;
			$response["message"] = "Test available";
			die(json_encode($response));
		}
		else{
			$response["success"] = 0;
			$response["message"] = "Test already taken";
			die(json_encode($response));
		}
	}
	else{
		$response["success"] = 0;
        $response["message"] = "Test not available ";
		die(json_encode($response));
	}
}
  else{   
	$response["success"] = 0;
    $response["message"] = " Test not available";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>