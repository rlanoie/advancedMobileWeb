<?php
include_once 'function.php';
//include_once 'dBconnect.php';
			//Build query to post changes to hr_change_request table
			$inputValues="";
			$inputField="";
			$sqlInput="";
			$sqlID="";

		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST['submitModal']) )
		{
				$id = $_POST['frm_id'];
			if (isset($_POST['newFirst']) AND $_POST['newFirst'] != ''){
				$firstName = $_POST['newFirst'];
				$inputField = "`userFirstName` = :userFirst";
			}
			if (isset($_POST['newLast']) AND $_POST['newLast'] != ''){
				$lastName = $_POST['newLast'];
				$inputField =$inputField.",`userLastName` = :userLast";
			}
		
$query_UserInfo = "UPDATE `userinfo` SET $inputField WHERE `id` = :id";	

$query_params1 = array(':id' => $id); 
$query_params2 = array(':userFirst' => $firstName); 
$query_params3 = array(':userLast' => $lastName); 

			try{
	 			// Prepare statement
  	  	$stmt = $db->prepare($query_UserInfo);
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':userFirst', $firstName);
				$stmt->bindParam(':userLast', $lastName);
				// execute the query
				$result=$stmt->execute();
				   // echo a message to say the UPDATE succeeded
  		  print $stmt->rowCount() . " records UPDATED successfully";
				

			}catch(PDOException $ex) 
			{ 
				print($ex.message);
      	$GLOBALS['errorMsg'] = $GLOBALS['somethingWrong'];
        die($GLOBALS['somethingWrong']); 
      }
		}	

		
		print('<br>');
		print($sqlID);
		print($sqlInput);
print('<br>');

			$sqlBuildCount = 0;

			function sqlPost($value)
			{
				global $sqlBuildCount;
				
				$sqlBuildCount++;
				
				if($sqlBuildCount > 1)
				{
					return "'$value'";
				}else{
					return "'$value'";					
				}	
			}
			

 