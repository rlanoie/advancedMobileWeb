<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>

	<?php	
		require 'configure.php';

	// Create a form that will let the user input search criteria
	//and when the search runs, it will output all users with that surname from the accounts table.
	
	session_start();
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}else{
	  header('location:index.html');
	}

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) 
		{
			die("Connection failed: " . mysqli_connect_error());
		}
						
		//DECLARE VARIABLES
		//form variables		
		$varLName = $varFName = $varEmail = $varPhone = $varDepartment="";
		$varLRadio = $varFRadio = $varPRadio = $varERadio = $varDRadio ="";
		//search variables
		$sql_SearchCriteria=0;
		$sql_Search = "";
		$field ="";
						
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			if (isset($_POST['formLast']) AND $_POST['formLast'] != '')
			{
				$varLName = test_input($_POST['formLast']);																
				$varLRadio = $_POST["radio1"];
				$field = "LAST_NAME";
				$sql_Search = search($varLName, $varLRadio, $field);
			}
							
			if (isset($_POST['FormFirst']) AND $_POST['FormFirst'] != '')
			{
				$varFName = test_input($_POST['FormFirst']);
				$varFRadio = $_POST["radio2"];
				$field = "FIRST_NAME";
				$sql_Search = $sql_Search . search($varFName, $varFRadio, $field);
			}
			if (isset($_POST['FormRFID']) AND $_POST['FormRFID'] != '')
			{
				$varPhone = test_input($_POST['FormRFID']);
				$varPRadio = $_POST["radio3"];
				$field = "RFID";
				$sql_Search = $sql_Search . search($varPhone, $varPRadio, $field);
			}
									
			if (isset($_POST['FormDepartment']) AND $_POST['FormDepartment'] != '')
			{
				$varDepartment = $_POST['FormDepartment'];
				$varDRadio = "=";
				$field = "DEPARTMENT_ID";
				$sql_Search = $sql_Search . search($varDepartment, $varDRadio, $field);
			}
		}
//check integrity of input
		function test_input($data) {
  		$data = trim($data);
	  	$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
		}
		//search function returns syntax for sql search for each field
		function search($Name, $Radio, $field)
		{
			global $sql_SearchCriteria;
						
			$wildCard="";
			$sql_SearchCriteria++;
			if($Radio==" LIKE ")
			{	
				$wildCard="%";
			}else{
				$wildCard="";									
			}
			if($sql_SearchCriteria > 1)
			{
				return " AND $field$Radio'$wildCard$Name$wildCard'";
			}else{
				$sql_Field = "$field";
				return "WHERE $field$Radio'$wildCard$Name$wildCard'";
				
			}
		}

		$sql = "SELECT LAST_NAME, FIRST_NAME, RFID 
		FROM `residents` 
		$sql_Search
		ORDER BY LAST_NAME, FIRST_NAME ASC";		
		//echo "<br>$sql<br>";

		$result = $conn->query($sql);	

		//query department list to populate department dropdown search
		$sqlDepartment = "SELECT DEPARTMENT_ID, DEPARTMENT_NAME 
		FROM  `department`";
	
		$resDep = $conn->query($sqlDepartment);

	?>
<html>
<!-- Head -->
<head>
	<title>Associate Dashboard | About :: W3layouts</title>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Associate a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //Meta-Tags -->
	<!-- Custom-Theme-Files -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/SunnyViewTheme.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="css/InisopeDirectory.css" />
	<!-- //Custom-Theme-Files -->
	<!-- Web-Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" 	type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,700" 				type="text/css">
	<!-- //Web-Fonts -->
	<!-- Default-JavaScript-File -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script> 
		$(document).ready(function()
		{
			$("#panel").hide();
    	$("#flip").click(function()
			{
        $("#panel").slideToggle("slow");
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
										<li  style="padding: 0px;"><a href="dashboard.php" >Dashboard</a></li>
										<li  style="padding: 0px;"><a href="Logout.php">Logout</a></li>
									</ul>
							</li>
							<div class="navHidden">
								<li><a  href="dashboard.php">Dashboard</a></li>
								<li><a  href="Logout.php">Logout</a></li>								
							</div>
						</ul>
					</div>				</nav>
					<!-- /navbar-collapse -->
				<div class = "TitlePosition TitleLeft">
					<h1 class="TitleSm-view"><?php echo"$username"; ?></h1>					
					<h1 class="TitleLg-view"><?php echo"$username"; ?></h1>
				</div>
			</div>
		</Header>
	<!-- Section -->
		<section class="SectionContent">
			<div class="container">
				<h1 class="section_head">Resident List</h1>
					<div class="sectionSearch">
						<p>
							Filter List
						</p>
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<div class="row">
								<div class="col-md-4">
									<h4>RFID</h4> 
									<input type="text" name="FormRFID" id="FormRFID" value="<?php echo $varPhone; ?>"/> 
			  			    <div data-role="fieldcontain">
			      			  <fieldset data-role="controlgroup">
    	  		    			<input type="radio" name="radio3" id="radio3_0" value="=" <?php echo ($varFRadio=='=')?'checked':'' ?>/>
  	        					<label for="radio2_0">Exact Match</label>
	          					<input type="radio" name="radio3" id="radio3_1" value=" LIKE " <?php echo ($varPRadio==' LIKE ')?'checked':'' ?>/>
											<label for="radio2_1">Contains</label>
        						</fieldset>
      						</div>
								</div>
								<div class="col-md-4">
				    	  	<h4>Last Name</h4>
									<input type="text" name="formLast" id="formLast" value="<?php echo $varLName; ?>"/> 
						  
									<div data-role="fieldcontain">
	    			  			<fieldset data-role="controlgroup">
  		    		  	  	<input type="radio" name="radio1" id="radio1_0" value="=" <?php echo ($varLRadio=='=')?'checked':'' ?>/>
  	  	    		  		<label for="radio1_0">Exact Match</label>
	      	    				<input type="radio" name="radio1" id="radio1_1" value=" LIKE " <?php echo ($varLRadio==' LIKE ')?'checked':'' ?>/>
        	  					<label for="radio1_1">Contains</label>
		        				</fieldset>
  		    				</div>
								</div>
								<div class="col-md-4">
									<h4>First Name</h4>
									<input type="text" name="FormFirst" id="FormFirst" value="<?php echo $varFName; ?>"/> 

						      <div data-role="fieldcontain">
      						  <fieldset data-role="controlgroup">
        	  					<input type="radio" name="radio2" id="radio2_0" value="=" <?php echo ($varFRadio=='=')?'checked':'' ?>>
          						<label for="radio2_0">Exact Match</label>
	          					<input type="radio" name="radio2" id="radio2_1" value=" LIKE " <?php echo ($varFRadio==' LIKE ')?'checked':'' ?>/>
											<label for="radio2_1">Contains</label>
    	    					</fieldset>
      						</div>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="team-row">
								<div class="col-md-3 team-grids">
									<div id="flip"><a>Additional Search Features</a></div>																
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="team-row">	
								<div id="panel">
									<div class="col-md-4 team-grids">
										<h4>Department</h4>		
										<select name="FormDepartment" id="FormDepartment" >
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
								<div class="clearfix"> </div>
							</div>
							<div class="team-row">
								<div class="col-md-12">
									<button type="submit" name="formSubmit">Query</button>	
								</div>
				    	  
								<div class="clearfix"> </div>
							</div>
						</form>
					  <?php
					
								echo"<div class='row'>"; 
									echo "<h3>Search results for: $varFName $varLName $varEmail</h3>";  
							  	echo "<h4>$result->num_rows results returned.</h4>";
								echo"</div>";

							if ($result->num_rows > 0) 
							{
								echo"<section class='team-row resultsheader'>";	
									echo"<div class='row rowResults'>"; 
										echo"<div class='col-sm-2'>" . "LAST NAME" . "</div>";
										echo"<div class='col-sm-2'>" . "FIRST NAME" . "</div>";
										echo"<div class='col-sm-1'>" . "DEPART" . "</div>";	
										echo"<div class='col-sm-2'>" . "PHONE NUMBER" . "</div>";
										echo"<div class='col-sm-3'>" . "EMAIL" . "</div>";
									echo"</div>";
								echo"</section>";
								echo"<section class='team-row sectionResults'>";	
									while ($row = $result->fetch_assoc())
									{
										echo"<div class='row rowResults'>"; 
											echo"<div class='col-sm-2'>" . $row["LAST_NAME"] . "</div>";
											echo"<div class='col-sm-2'>" . $row["FIRST_NAME"] . "</div>";
											echo"<div class='col-sm-1'>" . $row["RFID"] . "</div>";	
										echo"</div>";
    							}
							echo"</section>";
							}
						?>	
				</div>
			
		<!-- //team -->
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
	<!-- //footer -->
</body>
<!-- //Body -->
</html>