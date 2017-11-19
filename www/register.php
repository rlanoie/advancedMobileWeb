<?php 

    include_once '../includes/database_connect.php'; //start the session
 
    // This if statement checks to determine whether the registration form has been submitted 
    if(!empty($_POST)) 
    { 
        // Ensure that the user has entered a non-empty username 
        if(empty($_POST['username'])) 
        { 
            // exercise for you to implement yourself. 
            die("Please enter a username."); 
        } 
         
        // Ensure that the user has entered a non-empty password 
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        } 
         
        // Make sure the user entered a valid E-Mail address 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        // Check if username is unique
        $query = " SELECT 1 FROM users 
                  WHERE username = :username"; 
   
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // These two statements run the query against your database table.
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: "); 
        } 
         
        // The fetch() method returns an array representing the "next" row  
        $row = $stmt->fetch(); 
         
        // If a row was returned, then we know a matching username was found
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        // An INSERT query is used to add new rows to a database table. 
 
        $query = " 
            INSERT INTO users (username, password, salt, email ) 
            VALUES ( :username, :password, :salt, :email ) "; 
         
        // A salt is randomly generated here to protect again brute force attacks 
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        // This hashes the password with the salt so that it can be stored securely 
        $password = hash('sha256', $_POST['password'] . $salt); 
         
        // Next we hash the hash value 65536 more times.  The purpose of this is to 
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
         
        // Here we prepare our tokens for insertion into the SQL query.
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email']); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
         
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
          print($stmt);
        // This redirects the user back to the login page after they register 
        //header("Location: ../www/login.php"); 
         
     
        //die("Redirecting to login.php"); 
    } 
     
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