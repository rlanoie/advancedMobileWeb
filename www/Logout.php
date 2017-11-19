<?php	
include_once '../includes/session.php';
sec_session_start();
// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();

// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);

session_destroy();

// Redirect to main page
header('location:../index.html');
?>

