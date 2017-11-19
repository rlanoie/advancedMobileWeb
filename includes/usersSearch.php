	<?php
		include_once '../includes/database_connect.php'; //start the session
		include_once 'function.php';
    
  	//DECLARE VARIABLES
		$formFilterID_field = $formLastName_field = $formFirstName_field = "";
    $formFilterID_radio = $formLastName_radio = $formFirstName_radio = "=";
		//search variables
		$sql_SearchCriteria=0;
		$sql_Search = "";
		$field ="";
		//Result variables
		$count="";

    //Default queary when the employee page is loaded.
    $query_UserFilter = "SELECT users.id, username, email, userFirstName, userLastName
              FROM users 
              INNER JOIN userInfo 
              ON users.id = userInfo.id
              ORDER BY userLastName ASC"; 
print($query_UserFilter);

    $paramaters[0]="";
    $paramaters[1]="";
   // $queryResults = sqlQuery($query_UserFilter,$paramaters,$db);
    //$count = $queryResults['stmt']->rowCount();
print($queryResults);

	

	?>

