<?php

  $conn = mysqli_connect("localhost","root","","android");

  $selectedCourse=$_POST["selectedCourse"];  
  $testId=$_POST["testId"];  
   
  if (!empty($_POST)) {
		if (empty($_POST['selectedCourse']) || empty($_POST['testId'])) {
			  $response["success"] = 0;
			  $response["message"] = "Test id/Course id not received!";
			  die(json_encode($response));
		} 
		 
		$query = " SELECT * FROM question_pool WHERE testID='$testId'";
		$sql=mysqli_query($conn,$query);  
		$rowcount=mysqli_num_rows($sql);
		if($rowcount == 0){
			$response["success"] = 0;
			$response["message"] = "No active Questions for this course";
			die(json_encode($response));
		}
		else{
			$state = 1;
			$query1 = " SELECT * FROM question_pool WHERE testId='$testId' and state = '$state';";
			$type;  
			$sql1=mysqli_query($conn,$query1);	
			$row = mysqli_fetch_array($sql1,MYSQLI_NUM);
			$rowcount1=mysqli_num_rows($sql1);
			
			if ($rowcount1 == 1) {
			$query3 = " SELECT * FROM test WHERE testID='$testId'";
			$sql3=mysqli_query($conn,$query3);	
			$row3 = mysqli_fetch_array($sql3,MYSQLI_NUM);
			$response["testType"] = $row3[3];
			
				$response["success"] = 1;
				$response["message"] = "You have been sucessfully login";
				$response["noOfQuestions"]=$rowcount;
				
				if($row[2] == "multiChoice"){
					$type = 1;
				}
				else if($row[2] == "checkBox"){
					$type = 2;
				}
				else if($row[2] == "numericAnswer"){
					$type = 3;
				}
				else if($row[2] == "textAnswer"){
					$type = 4;
				}
				else if($row[2] == "trueFalse"){
					$type = 5;
				}
				
				else{
					$type = 0;
				}
				$response["questionType"] = $type;
				$response["question"] = $row[3];
				
				$response["correctAnswer"] = $row[9];
				if($type !=5){
							
					$response["choice1"] = $row[5];
					$response["choice2"] = $row[6];
					$response["choice3"] = $row[7];
					$response["choice4"] = $row[8];
				}
				else{
					
				$response["choice1"] = "True";
				$response["choice2"] = "False";
				$response["choice3"] = "";
				$response["choice4"] = "";
				}
				$response["weightage"] = $row[4];
				
				$query2 = " SELECT state FROM question_pool WHERE testID='$testId'";
				$sql2=mysqli_query($conn,$query2);
				$rowcount2 = mysqli_num_rows($sql2);
				$flag=0;
				while($rowcount2 != 0){
					if($row2=mysqli_fetch_assoc($sql2))
					{
						if($row2['state']!=0)
							$flag=1;
					}
					$rowcount2--;
				}
				$response["state"] = $flag;
				
				$response["questionId"] = $row[1];
				
				die(json_encode($response));
			}
			else{
				$response["success"] = 0;
				$response["message"] = "No active Questions for this test id";
				die(json_encode($response));
			}
		}
  }
		else{   
			$response["success"] = 0;
			$response["message"] = " Courses not available";
			die(json_encode($response));
		}
		

  mysqli_close($conn);
  ?>