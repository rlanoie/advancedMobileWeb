<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
 	<?php	
include_once'../includes/dBconnect.php';
include_once '../includes/session.php';
include_once '../includes/function.php';
sec_session_start(); //start the session
		// check if user has logged in.  If not redirect to index page
	/*	$password = $_SESSION['postpassword'];
		if(login_check($password, $db) == true) {
  		$username = $_SESSION['user']['username'];			
		} else { 
			header('location:../index.html');
		}*/
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

$status = attendanceStatus($today, $db);

	?>


<html>
<!-- Head -->
<head>
	<title>Associate Dashboard</title>
	
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
	<script src="../js/permission.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
 $(document).ready(function(){
		
		var attendanceStatus = '<?php echo $status ?>';

		switch(attendanceStatus){
			case 'no':
				toastr["warning"]("Attendance has not been started for today!<br /><br /><br />", "Attendance");
				break;
			case 'closed':
				toastr["success"]("Attendance has been completed!<br /><br />", "Attendance");	 
				break;
			case 'opened':
				toastr["info"]("Attendance is in progress!<br /><br />", "Attendance");
			}
	 
	 		
  });	

</script>

   <script>
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": true,
			"progressBar": false,
			"positionClass": "toast-top-full-width",
			"preventDuplicates": true,
			"onclick": null,
			"showDuration": "3000",
			"hideDuration": "1000",
			"timeOut": 0,
			"extendedTimeOut": 0,
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut",
			"tapToDismiss": false
		}
	</script>
	

</head>
<!-- //Head -->
<!-- Body -->
<body>
	<!-- Header -->
	<Header class="font">
		
			<div class="container">
				<nav class="nav-Header navList-Header" aria-label="Site Navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
						<ul class="navList">
							<li class="dropdown" style="padding: 0;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Account <b class="caret"></b></a>
									<ul class="dropdown-menu agile_short_dropdown">
										<li style="padding: 0;"><a href="Logout.php">Logout</a></li>
									</ul>
							</li>
							<li>							
									<a class="navHidden" href="Logout.php">Logout</a>
							</li>							
						</ul>
					</div>
				<!-- /navbar-collapse -->
				</nav>
					<div class = "TitlePosition TitleLeft">
						<!--<h1 class="TitleSm-view"><?php echo"$username"; ?></h1>
						<h1 class="TitleLg-view"><?php echo"$username"; ?></h1>-->
					</div>
			</div>
	</header>
	<!-- //Header -->
	

	<!-- Section -->
	<section class="SectionContent">
		<div class="container">
			<h1 class="section_head">Dashboard</h1>
			<div class="row">
				<div class="col-sm-4 dash-grids">
					<div class="dash-grid-img"> 
						<!--<a href="attendance.php" id="btn_attendance"><img src="../images/1485664694_Artboard_1.png" alt="Attendance"></a>-->
						<a href="#" id="btn_attendance" class="icons" onClick="permission_click(this,'<?php echo $_SESSION['permissions']['attendance'];?>')"><img src="../images/1485664694_Artboard_1.png" alt="Attendance"></a>
						 
					</div>
					<h4>Take Attendance</h4> 
					<p>Record daily attendance.</p>
					<p id="demo"></p>

				</div>
				<div class="col-sm-4 dash-grids">				
					<div class="dash-grid-img"> 
						<a href="#" id="btn_resident" onClick="permission_click(this,'<?php echo $_SESSION['permissions']['residents'];?>')"><img src="../images/1485663937_xmag.png" alt="search directory"></a>
					</div>
					<h4>Directory</h4>
					<p>Review resident information and make changes or additions. </p>
				</div>					
				<div class="col-sm-4 dash-grids">
					<div class="dash-grid-img"> 
						<a href="#" id="btn_admin" onClick="permission_click(this,'<?php echo $_SESSION['permissions']['admin'];?>')"><img src="../images/1485664349_Administrator.png" alt="img"></a>
					</div>
					<h4>Admin</h4> 
					<p>Manage user accounts.</p>
				</div>
				<div class="clearfix"> 
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
				<!--Modal HR Change Request Success message-->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body">
              </div>
							<div class="modal-footer">
							</div>
						</div>
					</div>
        </div>

	

</body>
<!-- //Body -->
</html>