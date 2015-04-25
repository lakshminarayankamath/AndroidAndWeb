<?php

  $conn = mysqli_connect("localhost","root","","android");

  $studentId=$_POST["studentId"];  
   
  if (!empty($_POST)) {
  if (empty($_POST['studentId'])) {
          $response["success"] = 0;
          $response["message"] = "Courses not available";
          die(json_encode($response));
      } 
	$sql = " SELECT * FROM enroll WHERE studentID='$studentId'";
      
    $result=mysqli_query($conn,$sql);	
	$num=mysqli_num_rows($result);
	$response["rowCount"]= $num;
	$i = 0;
	$course = "course";
	$courseName = "courseName";
	if ($num!=0)
	{
        $response["success"] = 1;
        $response["message"] = "You have been sucessfully login";
		while($row= mysqli_fetch_assoc($result)) 
		{
			$response["$course$i"] = $row['pageID'];
			$response["$courseName$i"] = $row['coursename'];
			$i++;
		}
        die(json_encode($response));
	}
	else{
		$response["success"] = 0;
        $response["message"] = "Courses not available. Here ";
		die(json_encode($response));
	}
}
  else{   
	$response["success"] = 0;
    $response["message"] = " Courses not available";
	die(json_encode($response));
  }

  mysqli_close($conn);
  ?>