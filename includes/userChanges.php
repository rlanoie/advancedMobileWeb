<?php
include_once 'function.php';

//include_once 'dBconnect.php';
			//Build query to post changes to hr_change_request table
			//$inputValues="";
			
			//$sqlInput="";
			//$sqlID="";
			
		$input_Userinfo_Fields="";//userinfo Table
		$sqlUICount = 0; //track the number of fields for userinfo
		$input_Users_Fields="";//users table
		$sqlUCount = 0; //track the number of fields for userinfo
		$input_permission_Fields="";//users table
		$sqlPCount = 0; //track the number of fields for userinfo

		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST['submitModal']) )
		{
				$id = $_POST['frm_id'];
			
		//USERINFO TABLE VALUES
			if (isset($_POST['newFirst']) AND $_POST['newFirst'] != ''){
				$firstName = $_POST['newFirst'];
				$sqlUICount++;
				$input_Userinfo_Fields = qryBuildCount("`userFirstName` = :userFirst", $sqlUICount);
				$query_params2 = array(':userFirst' => $firstName);
			}
			if (isset($_POST['newLast']) AND $_POST['newLast'] != ''){
				$lastName = $_POST['newLast'];
				$sqlUICount++;
				$input_Userinfo_Fields = $input_Userinfo_Fields.qryBuildCount("`userLastName` = :userLast", $sqlUICount);
				$query_params3 = array(':userLast' => $lastName); 
			}
			
		//USER TABLE VALUES
			if (isset($_POST['newUsername']) AND $_POST['newUsername'] != ''){
				$username = $_POST['newUsername'];
				$sqlUCount++;
				$input_Users_Fields = qryBuildCount("`username` = :username",$sqlUCount);
				$query_params4 = array(':username' => $username);
			}
			if(isset($_POST['newPassword']) AND $_POST['newPassword']!=''){
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
				$password = hash('sha256', $_POST['newPassword'] . $salt);
				for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        }
				$sqlUCount++;
				$input_Users_Fields = $input_Users_Fields.qryBuildCount("`password` = :password, `salt` = :salt", $sqlUCount);
				$query_params5 = array(':password' => $password);
				$query_params6 = array(':salt' => $salt);
			}
			if(isset($_POST['newEmail']) AND $_POST['newEmail']!=''){
				$email = $_POST['newEmail'];
				$sqlUCount++;
				$input_Users_Fields = $input_Users_Fields.qryBuildCount("`email` = :email",$sqlUCount);
				$query_params6 = array(':email' => $email);
			}
			
		//USERS PERMISSIONS TABLE VALUES
			/*For each checkbox check if the box is checked then assign the appropriate sql query.
			For fields that have multiple checkboxes first check if the user is granted write permission, 
			if not check if the user has been granted read permission.  If neither are true enter 'none' 
			as the sql input value*/
			//ATTENDANCE PERMISSION
			if(isset($_POST['attendance']) AND $_POST['attendance'] =='write'){
				$attendance = $_POST['attendance'];
			}else
			{
				$attendance = "none";
			}
			$sqlPCount++;
			$input_permission_Fields = qryBuildCount("`attendance` = :attendance", $sqlPCount);
			$query_params7 = array('attendance' => $attendance);

			//RESIDENT PERMISSION
			if(isset($_POST['writeResidents']) AND $_POST['writeResidents'] =='write'){
				$residents = $_POST['writeResidents'];
			}elseif(isset($_POST['readResident']) AND $_POST['readResident'] =='read'){
				$residents = $_POST['readResident'];
			}else{
				$residents = "none";
			}
				$sqlPCount++;
				$input_permission_Fields = $input_permission_Fields.qryBuildCount("`residents` = :residents", $sqlPCount);
				$query_params8 = array('residents' => $residents);
			
			//ADMIN PERMISSION
			if(isset($_POST['writeadmin']) AND $_POST['writeadmin'] =='write'){
				$admin = $_POST['writeadmin'];
			}else{
				$admin = "none";
			}
				$sqlPCount++;
				$input_permission_Fields = $input_permission_Fields.qryBuildCount("`admin` = :admin", $sqlPCount);
				$query_params9 = array('admin' => $admin);
			
			//USERS PERMISSION
			if(isset($_POST['writeUsers']) AND $_POST['writeUsers'] =='write'){
				$users = $_POST['writeUsers'];
			}elseif(isset($_POST['readUsers']) AND $_POST['readUsers'] =='read'){
				$users = $_POST['readUsers'];
			}else{
				$users = "none";
			}
				$sqlPCount++;
				$input_permission_Fields = $input_permission_Fields.qryBuildCount("`users` = :users", $sqlPCount);
				$query_params10 = array('users' => $users);
			
		//Query to update userinfo table
			$query_UserInfo = "UPDATE `userinfo` SET $input_Userinfo_Fields WHERE `id` = :id";	

			$query_params1 = array(':id' => $id); 
			print($query_UserInfo);
			print("<br>");

		//Query to update users table
			$query_Users = "UPDATE `users` SET $input_Users_Fields WHERE `id` = :id";	
			print($query_Users);
			print("<br>");				
			
		//Query to update permissions table
			$query_Permission = "UPDATE `userpermissions` SET $input_permission_Fields WHERE `userid` = :id";	
			print($query_Permission);				
		// Prepare statements
			
			$db->beginTransaction();
			try{
				//Build sql query for userinfo table
					if($sqlUICount>0){
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
					print $stmt_UI->rowCount() . " records UPDATED successfully";// echo a message to say the UPDATE succeeded
				}
				//Build sql query for users table
					if($sqlUCount>0){
					$stmt_U = $db->prepare($query_Users);
					$stmt_U->bindParam(':id', $id);
					if($_POST['newUsername']!=""){
						$stmt_U->bindParam(':username', $username);
					}
					if($_POST['newPassword']!=""){
						$stmt_U->bindParam(':password', $password);
						$stmt_U->bindParam(':salt', $salt);
					}
					if($_POST['newEmail']!=""){
						$stmt_U->bindParam(':email', $email);
					}
					$result_U=$stmt_U->execute();
					print $stmt_U->rowCount() . "users records UPDATED successfully";// echo a message to say the UPDATE succeeded
				}
				//Build sql query for users permissions
					if($sqlPCount>0){
						$stmt_UP = $db->prepare($query_Permission);
						
						$stmt_UP->bindParam(':id', $id);
						$stmt_UP->bindParam(':attendance', $attendance);	
						$stmt_UP->bindParam(':residents', $residents);	
						$stmt_UP->bindParam(':users', $users);
						$stmt_UP->bindParam(':admin', $admin);
						$result_UP=$stmt_UP->execute();
						print $stmt_UP->rowCount() . " permissions records UPDATED successfully";// echo a message to say the UPDATE succeeded
					}
			}catch(PDOException $ex) 
			{ 
				$db->rollBack();
      	$GLOBALS['errorMsg'] = $GLOBALS['somethingWrong'];
        die($GLOBALS['somethingWrong']); 
      }
			$db->commit();
		}
		
			
			//Keep track of the number of fields in the sql statement for comma placement
			function qryBuildCount($value, $sqlCount)
			{
				if($sqlCount > 1)
				{
					return ",$value";
				}else{
					return "$value";					
				}	
			}
			

 