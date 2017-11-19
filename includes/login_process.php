

<?php 
include_once 'session.php';
include_once 'database_connect.php';
include_once 'function.php';
include_once 'commonMsg.php';

    // First we execute our common code to connection to the database and start the session 
    sec_session_start(); // Our custom secure way of starting a PHP session.
    
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST) And (isset($_POST['username'], $_POST['password']))) 
    {
      
      $username = $_POST['username'];
      if(login($username, $db)==true)
      {
  print $username;
        //header('Location: ../www/dashboard.php');
      } else {
        // Login failed 
        header('Location: ../www/login.php?error=1');
        
      }
    }else{
      $GLOBALS['errorMsg'] = $GLOBALS['usernamePassword'];
    }
?> 
