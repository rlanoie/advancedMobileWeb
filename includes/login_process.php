

<?php 
include_once 'dBconnect.php';
include_once 'function.php';
include_once 'commonMsg.php';  
sec_session_start(); // Our custom secure way of starting a PHP session.
  $GLOBALS['errorMsg']="";
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST) And (isset($_POST['username'], $_POST['password']))) 
    {
      $username = $_POST['username'];
      
      if(login($username, $db)==true)
      {             
        header('Location: ../www/dashboard.php');
      } else {
        // Login failed 
        $GLOBALS['errorMsg'] = $usernamePassword;
        header('Location: ../www/login.php?error=1');
        
      }
    }else{
      $GLOBALS['errorMsg'] = $usernamePassword;
    }

?> 
