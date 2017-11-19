<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
 	<?php
		include_once '../includes/session.php'; //start the session
 sec_session_start(); // Our custom secure way of starting a PHP session.
		//include_once '../includes/database_connect.php'; //start the session
		include_once '../includes/function.php';
		
print ('user is');
  $username = $_SESSION['user'];
		print ($_SESSION['username']);
    print ('<br>');
      
		// check if user has logged in.  If not redirect to index page
		// if(login_check($db) == true) {
  		// $username = $_SESSION['username'];
		// } else { 
				// header('location:../index.html');
		// }


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
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
	<!--Change the color of the employee ID after an employee is selected from the dropdown box-->
	<script>
		$(document).ready(function(){
    	$(".employee").change(function(){
				$(formEmployeeID).css("background-color", "#D6D6FF");
    	});
		});
	</script>

	
<!--When employee dropdown name changes, show the values of the employee information-->	
<script>
	$(document).ready(function(){
    $("#formEmployee").change(function(){	
			var current = $('#formEmployee').val();
			var splitcurrent = current.split(" ");
			
			var spCurrSize = splitcurrent.length;
			
			$("#formEmployeeID").val(splitcurrent[0]);
			
			var DDid = "", DDfirst = "", DDlast = "", DDphone = "", DDdepart = "";
			if (spCurrSize > 1)
			{
				DDid = splitcurrent[0];
				DDfirst = splitcurrent[2]
				DDlast = splitcurrent[1];
				DDphone = splitcurrent[3] + splitcurrent[4]
				DDdepart = splitcurrent[5];		
			}
			
			
			//update values
			document.getElementById("currentheading").innerHTML="Current Information:";
			document.getElementById("hID").innerHTML="ID";
			document.getElementById("hLast").innerHTML="Last";
			document.getElementById("hFirst").innerHTML="First";
			document.getElementById("hPhone").innerHTML="Phone";
			document.getElementById("hDept").innerHTML="Dept";
			document.getElementById("ResEmployeeID").innerHTML= DDid;
			document.getElementById("ResEmployeeLast").innerHTML= DDlast;
			document.getElementById("ResEmployeeFirst").innerHTML= DDfirst;
			document.getElementById("ResEmployeePhone").innerHTML= DDphone;
			document.getElementById("ResEmployeeDept").innerHTML=DDdepart;
	    });
	});
</script>

	
	
<script>
    /*Submit HR Change Request Modal Form and get confirmation of success*/
    $(document).ready(function () {
        $("#contact_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
										$('#myModal .modal-header .modal-title').html("Submission Sent!");
                    $('#myModal .modal-body').html(data);
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
											
            e.preventDefault();
        });
         
        $("#submitForm").on('click', function() {
          
					$("#contact_form").submit();
					
					//Reset all HR Change Request form values 
					document.getElementById("contact_form").reset();
					
					document.getElementById("currentheading").innerHTML="";
					document.getElementById("hID").innerHTML="";
					document.getElementById("hLast").innerHTML="";
					document.getElementById("hFirst").innerHTML="";
					document.getElementById("hPhone").innerHTML="";
					document.getElementById("hDept").innerHTML="";
					document.getElementById("ResEmployeeID").innerHTML="";
					document.getElementById("ResEmployeeLast").innerHTML="";
					document.getElementById("ResEmployeeFirst").innerHTML="";
					document.getElementById("ResEmployeePhone").innerHTML="";
					document.getElementById("ResEmployeeDept").innerHTML="";

					
        });
    });
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
						<h1 class="TitleSm-view"><?php echo"$username"; ?></h1>
						<h1 class="TitleLg-view"><?php echo"$username"; ?></h1>
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
						<a href="#"  data-toggle="modal" data-target="#contact_dialog"><img src="../images/1485664694_Artboard_1.png" alt="Change Request Form"></a>
					</div>
					<h4>Take Attendance</h4> 
					<p>Record daily attendance.</p>
				</div>
				<div class="col-sm-4 dash-grids">				
					<div class="dash-grid-img"> 
						<a href="search.php"><img src="../images/1485663937_xmag.png" alt="search directory"></a>
					</div>
					<h4>Directory</h4>
					<p>Review resident information and make changes or additions. </p>
				</div>					
				<div class="col-sm-4 dash-grids">
					<div class="dash-grid-img"> 
						<a href="adminPage.php"><img src="../images/1485664349_Administrator.png" alt="img"></a>
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

	        <!-- modal HR Change Request form -->
        <div class="modal fade" id="contact_dialog" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">HR Change Request</h4>
							</div>
							<div class="modal-body">
								<div class="sectionSearch">
									<form id="contact_form" action="hrChangeRequest.php" method="POST">
<!--row-->												
										<div class="row rowHRChange">
											<div class="col-sm-6">
												<h4>Employee</h4>
												<select name="formEmployee" id="formEmployee" class="employee">
													<option value =""> - select - </option>
													<?php 
													if ($resNSearch->num_rows > 0) 
													{
														while ($row = $resNSearch->fetch_assoc())
														{
														/*sql query option for dropdown*/
															echo "<option value = '{$row['EMPLOYEE_ID']} {$row['LAST_NAME']}, {$row['FIRST_NAME']} {$row['PHONE_NUMBER']} {$row['DEPARTMENT_ID']}'>";
															echo"<div class='col-sm-2'>" . $row["LAST_NAME"] . " " . "</div>";	
															echo"<div class='col-sm-2'>" . $row["FIRST_NAME"] . " " . "</div>";																		
															echo "</option>";
														/*end of sql query option*/			
														}
													}												
													?>
												</select>
											</div>	
										</div>
<!--row-->
										<div class="row rowHRChange underline">
											<div class="col-sm-12">
											<!--heading and paragraph are populated when an option is selected in the dropdown box.-->
												<h4 id="currentheading"></h4>
												<div class = "col-sm-1">
													<h5 id="hID"></h5>
													<p id="ResEmployeeID" ></p>	
												</div>
												<div class = "col-sm-2">
													<h5 id="hLast"></h5>
													<p id="ResEmployeeLast" ></p>															
												</div>
												<div class = "col-sm-2">
													<h5 id="hFirst"></h5>
													<p id="ResEmployeeFirst" ></p>															
												</div>
												<div class = "col-sm-4">
													<h5 id="hPhone"></h5>
													<p id="ResEmployeePhone" ></p>															
												</div>
												<div class = "col-sm-1">
													<h5 id="hDept"></h5>
													<p id="ResEmployeeDept" ></p>		
												</div>
											</div>
										</div>
<!--row-->
										<div class="row rowHRChange">
											<h2>New Employee Information</h2>
										</div>	
<!--row-->						<!--New employee information-->
										<div class="row rowHRChange">
											<div class="col-sm-6">
												<label for="formEmployeeID" >Employee ID:</label>
												<input type="text" name="formEmployeeID" id="formEmployeeID" readonly>
											</div>
										</div>												
										<div class="row rowHRChange">												
											<div class="col-sm-6">
												<label for="newFirst">First Name:</label>
												<input type="text" name = "newFirst" id="newFirst" >													
											</div>
											<div class="col-sm-6">
												<label for="newLast">Last Name:</label>
												<input type="text" name="newLast" id="newLast" >													
											</div>												
										</div>	
										<div class="row rowHRChange">
									  	<div class="col-sm-6">											
												<label for="newPhone">Phone Number:</label>
												<input type="text" name="newPhone" id="newPhone" >													
											</div>
									  	<div class="col-sm-6">
												<label for="newDept">Department:</label>
												<select name="FormDepartment" id="newDept" >
													<option value =""> - select - </option>
													<?php 
														if ($resDep->num_rows > 0) 
														{
															while ($row = $resDep->fetch_assoc())
															{
    														echo "<option value = '{$row['DEPARTMENT_ID']}'>{$row['DEPARTMENT_ID']} - {$row['DEPARTMENT_NAME']}</option>";
															}
															echo "</select>";
														}			
													?>
												</select>													
											</div>
										</div>
									</form>
								</div>	
              </div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal">Close</button>
								<button type="button" id="submitForm"  data-toggle="modal" data-target="#myModal" data-dismiss="modal">Submit</button>					
							</div>
						</div>
					</div>
        </div>

	
				<!-- //modal -->  

</body>
<!-- //Body -->
</html>