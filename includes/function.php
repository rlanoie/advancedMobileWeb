<?php
include_once 'session.php';
include_once 'commonMsg.php';

$errorMsg;

function checkbrute($user_id, $db) {

    // Get timestamp of current time 
  date_default_timezone_set('America/Los_Angeles');
    $now = date('Y-m-d G:i:s A');
    print("Now  " . $now . "<br>");
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = date("Y-m-d G:i:s A",strtotime("-30 minutes",strtotime($now)));

    $query = "SELECT time 
              FROM `login_attempts` 
              WHERE user_id = :userID 
              AND time > '$valid_attempts'";
print($valid_attempts);
  print($query);

        try 
        { 
          // Execute the query against the database    
          $stmt = $db->prepare($query); 
          $stmt->bindParam(':userID', $user_id);

          // Execute the prepared query. 
          //$result = $stmt->execute($query_params); 
          $stmt->execute(); 
          
        } 
        catch(PDOException $ex) 
        { 
          $GLOBALS['errorMsg'] = $GLOBALS['somethingWrong'];
          die($GLOBALS['somethingWrong']); 
        }
        $row = $stmt->fetch(); 
        $count = $stmt->rowCount();
        // If there have been more than 3 failed logins lock the account.
        if ($count >= 2) //count starts at 0
        {
            $GLOBALS['errorMsg'] = $GLOBALS['LockecAccount'];
            
            return true;
        } else {
            return false;
        }

}
function sqlQuery($query, $Paramaters, $db){
  try{    
    $stmt = $db->prepare($query);
    $stmt->bindParam($Paramaters[0],$Paramaters[1]);
    
    $result = $stmt->execute();   // Execute the prepared query.    
  }catch(PDOException $ex) 
  { 
    echo $ex->getMessage();
    //die($GLOBALS['somethingWrong']); 
  }
   // If the user exists get variables from result.
  $row = $stmt->fetchAll(); 
  $queryResults ['row'] = $row;
  $queryResults ['stmt'] = $stmt;
  
 return $queryResults;
}
/*Function checks the login credentials*/
function login($username, $db) {
        //run query against the users table to check if user exists.
          $query = " SELECT id, username, password, salt, email 
                   FROM users 
                   WHERE username = :username 
                   LIMIT 1"; 
        // The parameter values 
            $query_params = array( 
            ':username' => $username);  
        // Execute the query against the database  
        try 
        { 
          $stmt = $db->prepare($query); 
          $stmt->bindParam(':username', $username);
          $result = $stmt->execute(); 
        } 
        catch(PDOException $ex) 
        { 
            die($somethingWrong); 
        }
        
        $login_ok = false; // This variable used to track successfull/unsuccessfull log-in
        
        // Retrieve the user data from the database.
        $row = $stmt->fetch(); 
        
        //set global error to incorrect username/password msg.
        $GLOBALS['errorMsg']=$GLOBALS['usernamePassword'];
        
        //Check if row exists.  If $row is false, then username is not correct.
        if($row) 
       
            //Check the number of previously failed login-attempts.
           if (checkbrute($row['id'], $db) == true)  // Account is locked 
           {
                // record another failed attempt
                recordAttempt($row['id'], $db);
                return false;
            }else // Account is NOT locked       
            { 
              // hash the submitted password so that it can be compared to the hashed version in the database. 
              $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
              for($round = 0; $round < 65536; $round++) 
              { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
              } 
             print($check_password);
              // Using the password submitted by the user and the salt stored in the database, see if passwords match. 
              if($check_password === $row['password']) 
              {
                $login_ok = true; 
                $_SESSION['postpassword'] = $check_password;
              } else
              {
                // Password is not correct record this attempt in the database
                recordAttempt($row['id'], $db);
                $login_ok = false; 
                return false;          
              }
            }

            // If the user logged in successfully, then send them to the dashboard page. 
            if($login_ok) 
            { 
                //store users current browser information
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['login_string'] = hash('sha512', $row['password'] . $user_browser);
              
                // store the $row array into the $_SESSION by and removing the salt and password values from it.  
                unset($row['salt']); 
                unset($row['password']); 
              
              //Store the user's data into the session at the index 'user'. 
                $_SESSION['user'] = $row;
                userPermissions($db);
              
              return true;
            } 
            else 
            { 
                // Tell the user they failed 
                 return false;
            } 
        

}
function login_check($password, $db){
    // Check if all session variables are set 
  
    if (isset($_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['login_string'])) 
    {
      // Get the variables from the user login
      $user_ID = $_SESSION['user']['id'];
      $username = $_SESSION['user']['username'];
      $login_String = $_SESSION['login_string'];//$_SESSION['login_string'] = hash('sha512', $_POST['password'] . $user_browser);
      //get the user's current info
      $user_browser = $_SERVER['HTTP_USER_AGENT'];
      $submitted_Password = $password;
      //query the user
      $query ="SELECT password, salt
               FROM users 
               WHERE id = :userID
               LIMIT 1";
        // The parameter values 
        $query_params = array(':userID' => $user_ID);    
         //execute pdo query                
         try{
            //$queryResults = sqlQuery($query, $query_params, $db);      
            $stmt = $db->prepare($query);
            $stmt->bindParam(':userID', $user_ID);
            $result = $stmt->execute();   // Execute the prepared query.    
           }catch(PDOException $ex) 
           { 
             die($GLOBALS['somethingWrong']); 
           }
            // If the user exists get variables from result.
           $row = $stmt->fetch(); 
           //If row exists then user exists.
           if($row) 
           {
            $current_loginString = hash('sha512', $submitted_Password . $user_browser);
            }
            if ($current_loginString === $_SESSION['login_string'])
            {
              // Logged In!!!! 
              return true;
            } else {
              print('error');
            // Not logged in 
            return false;
          }
    }
}

//Record failed login attempts
function recordAttempt($user_id, $db){
  $now = date('Y-m-d G:i:s A');
  $quearyInsert = "INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')";
  $db->query($quearyInsert);
}


function userPermissions($db){
  $id = $_SESSION['user']['id'];
  
  $query = "SELECT users.id, attendance, residents, admin, users
  					FROM users 
  					INNER JOIN userpermissions
            ON userpermissions.userID = users.id
            WHERE users.id = :id
            Limit 1";
    $query_params = array(':id' => $id);
  print($query);
    try{
      //$queryResults = sqlQuery($query, $query_params, $db);      
      $stmt = $db->prepare($query);
      $stmt->bindParam(':id', $id);
      $result = $stmt->execute();   // Execute the prepared query. 
    }catch(PDOException $ex) 
    { 
      die($GLOBALS['somethingWrong']); 
    }
    $row = $stmt->fetch();
    $_SESSION['permissions'] = $row;
}

//Is the attendance still pending
function attendanceStatus($qryDate, $db){
	
	$date = $qryDate;
	
	$query = "SELECT * FROM `attendancedetails` WHERE `date`= :date";
	$query_params = array(':date' => $date);
	try{     
  	$stmt = $db->prepare($query);
  	$stmt->bindParam(':date', $date);
	  $result = $stmt->execute();   // Execute the prepared query. 
	}catch(PDOException $ex) 
	{ 
  	die($GLOBALS['somethingWrong']); 
	}
	$row = $stmt->fetch();
	if($row){
		
		if($row['closed']!='0000-00-00 00:00:00'){
			return 'closed';
		}elseif($row['opened']!='0000-00-00 00:00:00'){
			return 'opened';
		}else{
			return 'no';
		}
	}else{
		return 'no';
	}
}
  



?>