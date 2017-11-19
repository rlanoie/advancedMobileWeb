<?php
include_once 'function.php';

			//Build query to post changes to hr_change_request table
			$sql_ChBuild = "";
			$input="";
			$inputChanges="";
		$inputField="";

"SELECT users.id, username, email, userFirstName, userLastName
		FROM users 
    INNER JOIN userInfo 
    ON users.id = userInfo.id
		$sql_Search
		ORDER BY userLastName ASC";
			$query_EmpChanges = "UPDATE  `users` SET  `username` =  'rlan' WHERE  `id` =2
			VALUES ($sql_ChBuild)";

		if(isset($_POST['formEmployeeChange']))
		{
			if (isset($_POST['newFirst']) AND $_POST['newFirst'] != ''){
				$inputField = sqlPost($_POST['newFirst']);
				$inputChanges = ''
			}
			
				$sql_ChBuild = sqlPost($_POST['newLast']);
				
				$sql_ChBuild = $sql_ChBuild . sqlPost($_POST['newUsername']);
				$sql_ChBuild = $sql_ChBuild . sqlPost($_POST['newPassword']);
				$sql_ChBuild = $sql_ChBuild . sqlPost($_POST['newEmail']);		
		}
			
			$sqlBuildCount = 0;

			function sqlPost($value)
			{
				global $sqlBuildCount;
				
				$sqlBuildCount++;
				
				if($sqlBuildCount > 1)
				{
					return ", '$value'";
					//return " AND $field$Radio'$wildCard$Name$wildCard'";
				}else{
					return "'$value'";					
				}	
			}
			
	

			$query_EmpChanges = "UPDATE  `users` SET  `username` =  'rlan' WHERE  `id` =2
			VALUES ($sql_ChBuild)";

			$paramaters[0]="";
			$paramaters[1]="";

//Start
			//$queryResults = sqlQuery($query_EmpChanges,$paramaters,$db);
			//Second Table Update
//end
      echo $query_EmpChanges;
//echo '<br>';
 //"INSERT INTO `svOperations`.`users` (`id` ,`username` ,`email`)  - use this to add new to the table