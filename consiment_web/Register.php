<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>


<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$pw = trim($_POST['password']);
		$name = trim($_POST['name']);
		$address = trim($_POST['address']);
		$ssn = trim($_POST['ssn']);
		$bon = trim ($_POST['bno']);
			$query = "SELECT * FROM CON_USER WHERE USER_ID='$username'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			// Fetch each row in an associative array
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			
			if($row){
				echo 'USERNAME ALREADY EXIST';
			}
		else{
		$query = "INSERT INTO CON_USER (USER_ID,USER_PW,NAME,ADDRESS,EXP,SSN,B_ACCOUNT) VALUES ('$username','$pw','$name','$address',NULL,'$ssn','$bon')";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		echo 'REGISTERED, GO TO LOGIN';
		echo '<script>window.location = "/Consiment_Web/index.php";</script>';
		}
	};
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Daily UI - Day 1 Sign In</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
	<div>
    	<div class="top">
			<h1 id="title" class="hidden"><span id="logo">CONSIMENT <span>WEB</span></span></h1>
		</div>
        <div class="login-box animated fadeInUp">
        	<div class="box-header">
				<h2>Register</h2>
			</div>
                <form action='register.php' method='post'>
                Username <br>
                <input name='username' type='input'><br><br>
                Password<br>
                <input name='password' type='password'><br><br>
                Full Name<br>
                <input name='name' type='input'><br><br>
                Address<br>
                <input name='address' type='input'><br><br>
                Citizen ID<br>
                <input name='ssn' type='input'><br><br>
				Bank Account No.<br>
                <input name='bno' type='input'><br><br>
                <button name='submit' type="submit" >Register</button>
                <!--<input name='submit' type='submit' value='Register'>--->
            	</form>
        </div>
    </div>
</body>
</html>
