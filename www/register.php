<!DOCTYPE html>
<?php 
include_once '../includes/registration_process.php'; //start the session
    
?> 
<h1>Register</h1> 
<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Username:<br /> 
    <input type="text" name="username" value="" /> 
    <br /><br /> 
    E-Mail:<br /> 
    <input type="text" name="email" value="" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    
  	<button type="submit" >Register</button>	
</form>