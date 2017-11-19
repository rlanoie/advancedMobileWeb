<html>
		<head>
	<title>Find a Contact</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/custom.css" />
<link rel="stylesheet" href="themes/rasmussenthemeroller.min.css" />
<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
 <link rel="stylesheet" href="mod2css.css" type="text/css" media="all">			
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="javascript/storage.js"></script>
</head>
	<body>
		<div id="page" data-role="page" data-theme="b" >
	<div data-role="header" data-theme="b">
<h1>
	Find your contact
		</h1>	</div>
				<div data-role="content">


					<?php
					include '../common.php';
					$conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

					$conf_num = (isset($_POST['conf_num'])    ? $_POST['conf_num']   : '');

					$sql= "SELECT customers.customerid, customers.fname, customers.lname, customers.state, orders.conf_num, orders.salesrep
						FROM customers
						JOIN orders on customers.customerid = orders.customerid
						WHERE conf_num LIKE '$conf_num' LIMIT 100";
					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {
					    // output data of each row
					    while($row = mysqli_fetch_assoc($result)) {
									echo "ID: " . $row["customerid"]. "<br>";
					        echo "First Name: " . $row["fname"]. "<br>";
					        echo "Last Name: " . $row["lname"]. "<br>";
									echo "State: " . $row["state"]. "<br>";
									echo "Conf. #: " . $row["conf_num"]. "<br>";
									echo "Sales Rep: " . $row["salesrep"]. "<br>";
					    }
					} else {
					    echo "0 results";
					}

					mysqli_close($conn);

					?>

				<div data-role="footer" data-theme="b">
	  <h4>Darice Corey-Gilbert &copy; 2017</h4>
	</div>
	</body>
</html>
