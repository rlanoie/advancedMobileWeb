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
echo "<p style='font-weight: bold;font-size: 18px;'>" . $query_UserFilter . "</p>";

print('<br>');
    $paramaters[0]="";
    $paramaters[1]="";
    $queryResults = sqlQuery($query_UserFilter,$paramaters,$db);
    $count = $queryResults['stmt']->rowCount();

	if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
		{
			if (isset($_POST['formFilterID']) AND $_POST['formFilterID'] != ''){
				$formFilterID_field = test_input($_POST['formFilterID']);	
				$formFilterID_radio = $_POST['formFilterID_radio'];
				$field = "users.id";
				$sql_Search = search($formFilterID_field, $formFilterID_radio, $field);
			}			
			if (isset($_POST['formLastName']) AND $_POST['formLastName'] != ''){	 
				$formLastName_field = test_input($_POST['formLastName']);
				$formLastName_radio = $_POST['formLastName_radio'];
				$field = "userLastName";
				$sql_Search = $sql_Search . search($formLastName_field, $formLastName_radio, $field);
			}
			if (isset($_POST['formFirstName']) AND $_POST['formFirstName'] != ''){
				$formFirstName_field = test_input($_POST['formFirstName']);
				$formFirstName_radio = $_POST["formFirstName_radio"];
				$field = "userFirstName";
				$sql_Search = $sql_Search . search($formFirstName_field, $formFirstName_radio, $field);
			}
									
			if (isset($_POST['FormDepartment']) AND $_POST['FormDepartment'] != '')
			{
				$varDepartment = $_POST['FormDepartment'];
				$varDRadio = "=";
				$field = "DEPARTMENT_ID";
				$sql_Search = $sql_Search . search($varDepartment, $varDRadio, $field);
			}

  
    $query_UserFilter = "SELECT users.id, username, email, userFirstName, userLastName
		FROM users 
    INNER JOIN userInfo 
    ON users.id = userInfo.id
		$sql_Search
		ORDER BY userLastName ASC";		

    $queryResults = sqlQuery($query_UserFilter,$paramaters,$db);
    $count = $queryResults['stmt']->rowCount();
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

