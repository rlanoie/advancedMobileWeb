<?php
require_once 'Microsoft/WindowsAzure/Storage/Table.php';
require_once 'Microsoft/WindowsAzure/SessionHandler.php';
$storageClient = new Microsoft_WindowsAzure_Storage_Table('table.core.windows.net', 
                                                          'your storage account name', 
                                                          'your storage account key');
$sessionHandler = new Microsoft_WindowsAzure_SessionHandler($storageClient , 'sessionstable');
$sessionHandler->register();
session_start();
include_once '../includes/session.php'; //start the session
  // Our custom secure way of starting a PHP session.
include_once 'commonMsg.php';
$errorMsg;
print ('user is');
  print ($_SESSION['user']);
		print ($_SESSION['username']);
    print ('<br>');
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
        print("$count");
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
    die($GLOBALS['somethingWrong']); 
  }
   // If the user exists get variables from result.
  $row = $stmt->fetchAll(); 
  $queryResults ['row'] = $row;
  $queryResults ['stmt'] = $stmt;
  
 return $queryResults;
}
/*Function checks the login credentials*/
function login($username, $db) {
  session_start();
        //run query against the users table to check if user exists.
          $query = " SELECT id, username, password, salt, email 
                   FROM users 
                   WHERE username = :username 
                   LIMIT 1"; 
        // The parameter values 
            $query_params = array( 
            ':username' => $username);  
  print('login query');
  print_r($query_params);
          
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
              // hashing the submitted password and comparing it to the hashed version in the database. 
              $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
              for($round = 0; $round < 65536; $round++) 
              { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
              } 
             
              // Using the password submitted by the user and the salt stored in the database, see if passwords match. 
              if($check_password === $row['password']) 
              {
                $login_ok = true; 
                print($login_ok);
              } else
              {
                // Password is not correct
                    // We record this attempt in the database
                    recordAttempt($row['id'], $db);
                    $login_ok = false; 
                    return false;          
              }
            }

            // If the user logged in successfully, then we send them to the dashboard page. 
            if($login_ok) 
            { 
                // store the $row array into the $_SESSION by and removing the salt and password values from it.  
                unset($row['salt']); 
                unset($row['password']); 
                // This stores the user's data into the session at the index 'user'. 
                $_SESSION['user'] = $row; 
              print($_SESSION['user']);
                $_SESSION['username'] = $row['username'];
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                print($_SERVER['HTTP_USER_AGENT']);
                $_SESSION['login_string'] = hash('sha512', $row['password'] . $user_browser);
              return true;
            } 
            else 
            { 
                // Tell the user they failed 
                 return false;
            } 
        

}
print($_SESSION['user']);
function login_check($db){
    // Check if all session variables are set 
    if (isset($_SESSION['user'], $_SESSION['username'])) 
    {
      
        $user_ID = $_SESSION['user']['id'];
      
        $username = $_SESSION['username'];
         
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
      
         $query ="SELECT password 
                  FROM members 
                  WHERE id = :userID
                  LIMIT 1";
         // The parameter values 
         $query_params = array(':userID', $user_ID);    
         
         $queryResults = sqlQuery($query, $query_params, $db);      
   
         if($queryResults['row']) {
              $login_password = hash('sha256', $_POST['password'] . $queryResults['row']['salt']);       
               $login_check = hash('sha512', $login_password . $user_browser);
         }
          if ($login_check = $_SESSION['login_string'])
          {
              // Logged In!!!! 
              return true;
          } else {
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

?>