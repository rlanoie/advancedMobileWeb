<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
 	<?php	
		include_once '../includes/login_process.php';
print ($_SESSION['user']);
?>
<html>
<!-- Head -->
<head>
	<title>Associate Login</title>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Associate a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link rel="stylesheet" type="text/css" href="../css/InisopeDirectory.css" />
	<!-- //Meta-Tags -->
	<!-- Custom-Theme-Files -->
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="../css/SunnyViewTheme.css" type="text/css" media="all">
	<link rel="stylesheet" href="../css/font-awesome.min.css" />

	<!-- //Custom-Theme-Files -->
	<!-- Web-Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" 	type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,700" 	type="text/css">
	<!-- //Web-Fonts -->
	<!-- Default-JavaScript-File -->
	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	
	<script src="../js/main.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
</head>
<!-- //Head -->
<!-- Body -->
<body>
	<!-- Header -->
	<Header class="headerIndex font">
			<div class="container">
  			<!--<figure class="logo" title="Company Logo" aria-label="Sunny View Retirement Community">-->
					<img src ="../images/logo-2.png" alt="Sunny View Retirement Community" >
				<!--</figure>-->
					<div class = "TitlePosition TitleLeft">

					</div>
			</div>
	</header>
	<!-- //Header -->
	

	<!-- Section -->
	<section id="indexSection" class="SectionContent">
		<div class="container">
	<div>
		<div class="modal-dialog" role="document">
			<div class="login-content">
				<div class="login-header"> 
					<h4 class="modal-title">Associate Login</h4>
				</div> 
				<div class="login-body">
          <p class="loginError"><?php 
  $printError = $GLOBALS['errorMsg'];
    print("$printError");
    ?> </p>

					<div class="agileits-w3layouts-info">
						<img src="images/g1.jpg" class="img-responsive" alt="" />
						<!-- Login Form -->
							<form id="loginform" method="post" action="login.php" id="loginform" class="modalInput">
								<div class="login-Row">
									<div class="login-col-1">			
										<label for="username">Username:</label>
									</div>
									<div class="login-col-2">
										<input type="text" name="username" id="username" required/> 
									</div>
								</div>
								<div class="login-Row">
									<div class="login-col-1">
										<label for="password">Password:</label>
									</div>
									<div class="login-col-2">
										<input type="text" name="password" id="password" required/> 
									</div>
								</div>
								<button type="submit" name="formLogin" >Login</button>
							</form>	
						<!-- //Login Form -->
					</div>
				</div>
			</div>
		</div>
	</div>

		</div>
	</section>
	<!-- //about -->
	<!-- footer -->
		<footer>
			<div class="container">
				<div class="background">
					<div class="copywrite">
						<p>© 2017 All rights reserved.
					</div>
				</div>
			</div>
		</footer>
</body>
<!-- //Body -->
</html>