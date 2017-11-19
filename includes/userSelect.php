<?php
include_once 'database_connect.php';
include_once 'login_process.php';
include_once 'function.php';

$detailEmp_ID = $_POST['getID'];
$queryCurrEmp = "SELECT users.id, username, email, userFirstName, userLastName
  					FROM users 
  					INNER JOIN userInfo 
  					ON users.id = userInfo.id
            WHERE users.id = :user_ID
  					ORDER BY userLastName ASC";

//$query_DetailParam = array(':user_ID' => $detailEmp_ID);   
$query_DetailParam[0]=':user_ID';
$query_DetailParam[1]=$detailEmp_ID;

$result_CurrEmp = sqlQuery($queryCurrEmp,$query_DetailParam,$db);

foreach($result_CurrEmp ['row'] as $column_CurrEmp) {
  echo "ID: " . $column_CurrEmp['id'] . "<br>" .
    $column_CurrEmp['userFirstName'] . " " . $column_CurrEmp['userLastName'] . "<br>" .
    "Email: " . $column_CurrEmp['email'] . "<br><br>" .
    "Username: " . $column_CurrEmp['username'] . "<br>";
  $_POST['formEmployeeID'] = $column_CurrEmp['id'];
}
