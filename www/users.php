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
    include_once '../includes/usersSearch.php';
		include_once '../includes/userChanges.php';
sec_session_start(); //start the session

// check if user has logged in.  If not redirect to index page
	$password = $_SESSION['postpassword'];
	if(login_check($password, $db) == true) {
  	$username = $_SESSION['user']['username'];	
	} else { 
		header('location:../index.html');
	}

	//used to determine if this is a page (load or modal submit) or if the filter form has been submitted.
	//This will print the default query on the page load and modal submit.
	//TO BE ADDED mehtod to revert back to the default query.
	if($_SERVER["REQUEST_METHOD"] == "GET" OR ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['submitModal'])))
	{
		$queryResults = defaultQuery($db);	
	}

	?>
<html>
<!-- Head -->
<head>
	<title>User Page</title>
	<!-- Meta-Tawgs -->
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!--When employee dropdown name changes, show the values of the employee information-->	
  	<!--Change the color of the employee ID after an employee is selected from the dropdown box-->
	<script>
		$(document).ready(function(){
    	$(".employee").change(function(){
				$(formEmployeeID).css("background-color", "#D6D6FF");
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

										<li style="padding: 0;"><a href="adminPage.php">Admin Page</a></li>                    
										<li style="padding: 0;"><a href="dashboard.php">Dashboard</a></li>                    
										<li style="padding: 0;"><a href="Logout.php">Logout</a></li>
									</ul>
							</li>
							<li>
									<a class="navHidden" href="adminPage.php">Admin</a>
									<a class="navHidden" href="dashboard.php">Dashboard</a>
									<a class="navHidden" href="Logout.php">Logout</a>
							</li>							
						</ul>
					</div>
<!--Handle the dropdown for this page-->
<script>
	$(function() {                       
  	$(".dropdown").click(function() {  
    	$(this).addClass("open");      
  	});
	});
	//Not working properly
	
</script>
												
				<!-- /navbar-collapse -->
				</nav>
					<div class = "TitlePosition TitleLeft">
						<h1 class="TitleSm-view"><?php echo"$username"; ?></h1>
						<h1 class="TitleLg-view"><?php echo"$username"; ?></h1>
					</div>
			</div>    
  </Header>
	<!-- Section -->
	  <section id = "sectionEmployee" class="SectionContent sqlRes_table">
		<div class="container">
			<h1 class="section_head">Users</h1>
				<div class="body">
					<div class="team-row search">
						<div class="col-md-3 team-grids">
							<div id="flip"><a>Additional Search Features</a></div>																
						</div>
						<div class="clearfix"> </div>
					</div>
					<form method="POST" name="filterEmployees" id="filterEmployees" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
								<div class="col-md-3">
									<h4>ID</h4> 
									<input type="text" name="formFilterID" id="formFilterID" value="<?php echo($formFilterID_field)?>"/> 
			  			    <div data-role="fieldcontain">
			      			  <fieldset data-role="controlgroup">
    	  		    			<input type="radio" name="formFilterID_radio" id="radio3_0" value="=" <?php echo ($formFilterID_radio=='=')?'checked':'' ?>>
  	        					<label for="radio3_0">Exact Match</label>
	          					<input type="radio" name="formFilterID_radio" id="radio3_1" value=" LIKE " <?php echo ($formFilterID_radio==' LIKE ')?'checked':'' ?>/>
											<label for="radio3_1">Contains</label>
        						</fieldset>
      						</div>
								</div>
								<div class="col-md-4">
				    	  	<h4>Last Name:</h4>
									<input type="text" name="formLastName" id="formLastName" value="<?php echo($formLastName_field)?>"/> 
									<div data-role="fieldcontain">
	    			  			<fieldset data-role="controlgroup">
  		    		  	  	<input type="radio" name="formLastName_radio" id="formLastName_radio_0" value="=" <?php echo ($formLastName_radio=='=')?'checked':'' ?>/>
  	  	    		  		<label for="radio1_0">Exact Match</label>
	      	    				<input type="radio" name="formLastName_radio" id="formLastName_radio_1" value=" LIKE " <?php echo ($formLastName_radio==' LIKE ')?'checked':'' ?>/>
        	  					<label for="radio1_1">Contains</label>
		        				</fieldset>
  		    				</div>
								</div>
								<div class="col-md-4">
									<h4>First Name</h4>
									<input type="text" name="formFirstName" id="formFirstName" value="<?php echo($formFirstName_field)?>"/> 
						      <div data-role="fieldcontain">
      						  <fieldset data-role="controlgroup">
        	  					<input type="radio" name="formFirstName_radio" id="formFirstName_radio_0" value="=" <?php echo ($formFirstName_radio=='=')?'checked':'' ?>>
          						<label for="radio2_0">Exact Match</label>
	          					<input type="radio" name="formFirstName_radio" id="formFirstName_radio_1" value=" LIKE " <?php echo ($formFirstName_radio==' LIKE ')?'checked':'' ?>/>
											<label for="radio2_1">Contains</label>
    	    					</fieldset>
      						</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						<div class="team-row">
								<div class="col-md-4">
									<button type="submit" name="formSubmit">Filter</button>	
								</div>
								<div class="col-md-4">									
									<a href="#"data-toggle="modal" data-target="#contact_dialog">add user</a>
								</div> 
								<div class="clearfix"> </div>
							</div>
					</form>
					<?php
          	if($_SERVER["REQUEST_METHOD"]=="POST" )
            {
							echo "<div class='resultCount'>";
								echo "<h4>$countFilter result(s) returned.</h4>";
							echo "</div>";
            }
					?>
					<div class="team-row resultsheader">	
								<div class = "row" rowResults> 
								<div class = "col-sm-3">ID</div>                  
								<div class = "col-sm-4">LAST NAME</div>
								<div class = "col-sm-4">FIRST NAME</div>
								</div>
							</div> 
					<?php
						if ($GLOBALS['countFilter'] > 0) {
									echo"<div class='team-row sectionResults'>";	
  	                foreach($queryResults ['row'] as $column) {
											echo "<a href='#' class='linkClick' data-toggle='modal'>";
												echo"<div class='row rowResults rowResID_".$column['id']."'>"; 
													echo"<div class='col-sm-3 rowId'>". $column['id'] . "</div>";
													echo"<div class='col-sm-4 row_nameLast'>" . $column['userLastName'] . "</div>";
													echo"<div class='col-sm-4 row_nameFirst'>" . $column['userFirstName'] . "</div>";                  
												echo"</div>";
											echo"</a>";
    								}
									echo"</div>";
								}
					?>
					<script>
								$('.linkClick').click(function(){
									var $row = $(this);
									var rowID = $row.find('.rowId').text();
									var nameLast =  $row.find('.row_nameLast').text();
									var nameFirst =  $row.find('.row_nameFirst').text();
									
									var xhr;
 									if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    								xhr = new XMLHttpRequest();
 									} else if (window.ActiveXObject) { // IE 8 and older
    								xhr = new ActiveXObject("Microsoft.XMLHTTP");
 									}
									var data = "getID=" + rowID;
										xhr.open("POST", "../includes/userSelect.php", true); 
										xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
										xhr.send(data);
									
									xhr.onreadystatechange = display_data;
									function display_data() {
										if (xhr.readyState == 4) {
      								if (xhr.status == 200) {
       								
												document.getElementById("Modal_CurrResult").innerHTML = xhr.responseText;
												$('#modal_User').modal('show');
      								} else {
        								alert('There was a problem with the request.');
      								}
     								}
									}
									$('#frm_id').val(rowID);
								});
							</script>
				</div>      
		</div>
	</section>
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
  <!-- modal HR Change Request form -->
    <div class="modal fade" id="modal_User" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">User Information</h4>
							</div>
							<div class="modal-body">
								<div class="sqlRes_table">
									<div class = "body">
<!--row-->	
										<!--Displays the user's current information-->	
										<div class="row underline">
											<div class="col-sm-6">
												<h4>User</h4>
													<p id="Modal_CurrResult">
													</p>												
											</div>	
										</div>
										<form id="formUserChange" name="formUserChange" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">	
<!--row-->
											<div class="row">
												<h2>New Employee Information</h2>
											</div>
											<div class="row">
												<div class="col-sm-6">
												<input type="hidden" class="form-control" name="frm_id" id="frm_id">
												</div>
											</div>
<!--row-->							<!--New employee information-->
											<div class="row">
												<div class="col-sm-6">
													<label for="newFirst">First Name:</label>
													<input type="text" name = "newFirst" id="newFirst" >													
												</div>
												<div class="col-sm-6">
													<label for="newLast">Last Name:</label>
													<input type="text" name="newLast" id="newLast" >													
												</div>												
											</div>	
											
											<div class="row">
										  	<div class="col-sm-6">											
													<label for="newUsername">Username:</label>
													<input type="text" name="newUsername" id="newUsername" >	
												</div>
										  	<div class="col-sm-6">											
													<label for="newPassword">Password:</label>
													<input type="text" name="newPassword" id="newPassword" >													
												</div>                      
										  	<div class="col-sm-6">
													<label for="newEmail">Email:</label>
													<input type="text" name="newEmail" id="newEmail" >													
												</div>
											</div>
											<button type="submit" id="submitModal" name="submitModal" >Submit</button>															
										</form>
									</div>

									
								</div>	
              </div>
							<div class="modal-footer">

							</div>
						</div>
					</div>
        </div>
		<!-- //modal --> 
	  <!-- modal User Add form -->
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