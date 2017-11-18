

<?php 
include_once 'session.php';
include_once 'database_connect.php';

    // First we execute our common code to connection to the database and start the session 
    sec_session_start(); // Our custom secure way of starting a PHP session.
    
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST) And (isset($_POST['fName'], $_POST['lName']))) 
    {
      
      $firstName = $_POST['fName'];
      
        echo "You have logged in";
      } else {
        // Login failed 
        echo "You are not logged in";
        
      }
    }else{
      echo "Error logging in";
    }
?> 
