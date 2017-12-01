	<?php
		include_once'../includes/dBconnect.php';
		include_once 'function.php';
    
		$GLOBALS['countFilter']="";
  	//DECLARE VARIABLES
		$formFilterID_field = $formLastName_field = $formFirstName_field = "";
    $formFilterID_radio = $formLastName_radio = $formFirstName_radio = "=";
		//search variables
		$sql_SearchCriteria=0;
		$sql_Search = "";
		$field ="";
		//Result variables
		$countFilter="";

		if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['formSubmit'])) 
		{
			if (isset($_POST['formFilterID']) AND $_POST['formFilterID'] != ''){
				$formFilterID_field = test_input($_POST['formFilterID']);	
				$formFilterID_radio = $_POST['formFilterID_radio'];
				$field = "id";
				$sql_Search = search($formFilterID_field, $formFilterID_radio, $field);
			}			
			if (isset($_POST['formLastName']) AND $_POST['formLastName'] != ''){	 
				$formLastName_field = test_input($_POST['formLastName']);
				$formLastName_radio = $_POST['formLastName_radio'];
				$field = "ResLName";
				$sql_Search = $sql_Search . search($formLastName_field, $formLastName_radio, $field);
			}
			if (isset($_POST['formFirstName']) AND $_POST['formFirstName'] != ''){
				$formFirstName_field = test_input($_POST['formFirstName']);
				$formFirstName_radio = $_POST["formFirstName_radio"];
				$field = "ResFName";
				$sql_Search = $sql_Search . search($formFirstName_field, $formFirstName_radio, $field);
			}

  
    $query_UserFilter = "SELECT id, ResFName, ResLName
		FROM residents 
		$sql_Search
		ORDER BY ResLName ASC";		
		
		
    $paramaters[0]="";
    $paramaters[1]="";

    $queryResults = sqlQuery($query_UserFilter,$paramaters,$db);
    $GLOBALS['countFilter'] = $queryResults['stmt']->rowCount();

  }
function defaultQuery($db){
    //Default queary when the employee page is loaded.
    $query_UserFilter = "SELECT id, ResFName, ResLName
              FROM residents 
              ORDER BY ResLName ASC"; 


    $paramaters[0]="";
    $paramaters[1]="";
    $queryResults = sqlQuery($query_UserFilter,$paramaters,$db);
    $GLOBALS['countFilter'] = $queryResults['stmt']->rowCount();
	print($query_UserFilter);
	return $queryResults;
}

//check integrity of input
		function test_input($data) {
  		$data = trim($data);
	  	$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
		}
//search function returns syntax for sql search for each field
function search($Name, $Radio, $field)
{
  global $sql_SearchCriteria;
						
  $wildCard="";
	$sql_SearchCriteria++;
	if($Radio==" LIKE ")
	{	
	  $wildCard="%";
  }else{
		$wildCard="";									
	}
	if($sql_SearchCriteria > 1)
	{
		return " AND $field$Radio'$wildCard$Name$wildCard'";
	}else{
		$sql_Field = "$field";
	  return "WHERE $field$Radio'$wildCard$Name$wildCard'";
				
	}
}


		//echo "<br>$sql<br>";
		//query department list to populate department dropdown search
		//$sqlDepartment = "SELECT DEPARTMENT_ID, DEPARTMENT_NAME 
		//FROM  `department`";
	
		//$resDep = $db->query($sqlDepartment);

	?>

