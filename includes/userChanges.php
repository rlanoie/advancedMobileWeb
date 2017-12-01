<?php
include_once 'function.php';

//include_once 'dBconnect.php';
			//Build query to post changes to hr_change_request table
			//$inputValues="";
			
			//$sqlInput="";
			//$sqlID="";
			
		$input_Userinfo_Fields="";//userinfo Table
		$input_Users_Fields="";//users table
		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST['submitModal']) )
		{
				$id = $_POST['frm_id'];
			//Userinfo Table Values
			if (isset($_POST['newFirst']) AND $_POST['newFirst'] != ''){
				$firstName = $_POST['newFirst'];
				$input_Userinfo_Fields = qryBuildCount("`userFirstName` = :userFirst");
				$query_params2 = array(':userFirst' => $firstName);
			}
			if (isset($_POST['newLast']) AND $_POST['newLast'] != ''){
				$lastName = $_POST['newLast'];
				$input_Userinfo_Fields = $input_Userinfo_Fields.qryBuildCount("`userLastName` = :userLast");
				$query_params3 = array(':userLast' => $lastName); 
			}
			
			//Users Table Values
			if (isset($_POST['newUsername']) AND $_POST['newUsername'] != ''){
				$username = $_POST['newUsername'];
				$input_Users_Fields = "`username` = :username";
				$query_params4 = array(':username' => $username);
			}
			if(isset($_POST['newPassword']) AND $_POST['newPassword']!='')
			{
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
				$password = hash('sha256', $_POST['newPassword'] . $salt);
				for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        }
				
				$input_Users_Fields="`password` = :password, `salt` = :salt";
				$query_params4 = array(':password' => $password);
				$query_params4 = array(':salt' => $salt);
			}
				//Query to update userinfo table
				$query_UserInfo = "UPDATE `userinfo` SET $input_Userinfo_Fields WHERE `id` = :id";	

				$query_params1 = array(':id' => $id); 
				 print($query_UserInfo);
				 print("<br>");

				//Query to update users table
				$query_Users = "UPDATE `users` SET $input_Users_Fields WHERE `id` = :id";	
				print($query_Users);
				
		
		try{
				// Prepare statement
  	  	if($_POST['newFirst']!='' OR $_POST['newLast']!=''){
						$stmt_UI = $db->prepare($query_UserInfo);
						$stmt_UI->bindParam(':id', $id);
					if($_POST['newFirst']!=""){
						$stmt_UI->bindParam(':userFirst', $firstName);	
					}
					if($_POST['newLast']!=""){
						$stmt_UI->bindParam(':userLast', $lastName);
					}
					// execute the query
					$result=$stmt_UI->execute();
					print $stmt_UI->rowCount() . " records UPDATED successfully";
				}
				

			
				$stmt_U = $db->prepare($query_Users);
				$stmt_U->bindParam(':id', $id);
				if($_POST['newUsername']!=""){
					$stmt_U->bindParam(':username', $username);
				}
				if($_POST['newPassword']!=""){
					$stmt_U->bindParam(':password', $password);
					$stmt_U->bindParam(':salt', $salt);
				}
				
					
//				

				$result_U=$stmt_U->execute();
				   // echo a message to say the UPDATE succeeded

				print $stmt_U->rowCount() . " records UPDATED successfully";

			}catch(PDOException $ex) 
			{ 
				print($ex.message);
      	$GLOBALS['errorMsg'] = $GLOBALS['somethingWrong'];
        die($GLOBALS['somethingWrong']); 
      }
			
		}
		
			$sqlBuildCount = 0;

			function qryBuildCount($value)
			{
				global $sqlBuildCount;
				
				$sqlBuildCount++;
				
				if($sqlBuildCount > 1)
				{
					return ",$value";
				}else{
					return "$value";					
				}	
			}
			

 