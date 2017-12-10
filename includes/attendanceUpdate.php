<?php
include_once 'function.php';
//include_once 'dBconnect.php';
			//Build query to post changes to hr_change_request table
$GLOBALS['countAttendance']="";

function addAttendance($date, $db){
			$inputValues="";
			$inputField="";
			$sqlInput="";
			$sqlID="";

			//NEW VARIABLES
			$frmDate = "";
			$resID="";
			$userID="";
	
		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST['formSubmit']) )
		{
				$frmDate = $_POST['frmDate'];
				$resID = $_POST['formResID'];
				$user_ID = $_POST['formUserID'];
		
			$query_attendanceUpdate = "INSERT INTO `attendance` (`date`, `UserID`, `ResID`)
				VALUES(:frmDate, :userID, :resID)";
			
			$query_params1 = array(':frmDate' => $frmDate); 
			$query_params2 = array(':userID' => $user_ID); 
			$query_params3 = array(':resID' => $resID); 
			print($query_attendanceUpdate);
			print('<br>');
			try{
	 			// Prepare statement
  	  	$stmt = $db->prepare($query_attendanceUpdate);
				$stmt->bindParam(':frmDate', $frmDate);
				$stmt->bindParam(':userID', $user_ID);
				$stmt->bindParam(':resID', $resID);
				// execute the query
				$result=$stmt->execute();
				   // echo a message to say the UPDATE succeeded
				
  		  print $stmt->rowCount() . " records UPDATED successfully";
				print('<br>');
			}catch(PDOException $ex) 
			{ 
				print($ex.message);
      	$GLOBALS['errorMsg'] = $GLOBALS['somethingWrong'];
        die($GLOBALS['somethingWrong']); 
      }
		}
	$results = attendanceList($date, $db);
	return $results;
}

function attendanceList($date, $db){
$filterDate = $date;
$queryAttendanceRecords = "SELECT attendance.date, userFirstName, userLastName, ResFName, ResLName,
			CONCAT(ResFName, ' ', ResLName) AS resident,
			CONCAT(userFirstName, ' ', userLastName) AS employee
			FROM attendance
			INNER JOIN userinfo
			ON userinfo.id = attendance.UserID
			INNER JOIN residents
			ON residents.id = attendance.ResID
			WHERE date = :date 
			ORDER BY ResLName ASC;";

		$query_params = array(':date' => $filterDate);
		
		try{
  		$stmt = $db->prepare($queryAttendanceRecords);
		  $stmt->bindParam(':date', $filterDate);
	  	$result = $stmt->execute();   // Execute the prepared query. 
		}catch(PDOException $ex) 
		{ 
		  die($GLOBALS['somethingWrong']); 
		}
		
		$row = $stmt->fetch();
    //$queryResults = sqlQuery($queryAttendanceRecords,$paramaters,$db);
    $GLOBALS['countFilter'] = $stmt->rowCount();;
	
		return $row;
}


			

 