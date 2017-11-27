<?php
include_once'../includes/dBconnect.php';
include_once 'function.php';

$selectionID = $_POST['getID'];
$query = "SELECT users.id, username, email, userFirstName, userLastName
  					FROM users 
  					INNER JOIN userinfo 
  					ON users.id = userinfo.id
            WHERE users.id = :selectionID
  					ORDER BY userLastName ASC
            Limit 1";
    $query_params = array(':selectionID' => $selectionID);  

try{
  //$queryResults = sqlQuery($query, $query_params, $db);      
  $stmt = $db->prepare($query);
  $stmt->bindParam(':selectionID', $selectionID);
  $result = $stmt->execute();   // Execute the prepared query. 
}catch(PDOException $ex) 
{ 
  die($GLOBALS['somethingWrong']); 
}

$row = $stmt->fetch();

echo "ID: " . $row['id'] . "<br>" .
    $row['userFirstName'] . " " . $row['userLastName'] . "<br>" .
    "Email: " . $row['email'] . "<br><br>" .
    "Username: " . $row['username'] . "<br>";
  $_POST['formEmployeeID'] = $row['id'];

