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
	$str ="";
	if(isset($_POST['submit'])){ 
		$user = trim($_POST['username']);
		$pw = trim($_POST['password']);
		$query = "SELECT * FROM CON_USER WHERE USER_ID ='$user' and user_pw='$pw'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$_SESSION['ID'] = $row['USER_ID'];
				$_SESSION['NAME'] = $row['NAME'];
				$_SESSION['ADDRESS'] = $row['ADDRESS'];
				$_SESSION['PASSWORD'] = $row['USER_PW'];
				$_SESSION['PIC'] = $row['USER_PHOTO'];
				$_SESSION['SSN'] = $row['SSN'];
				$_SESSION['B_ACCOUNT'] = $row['B_ACCOUNT'];
				echo '<script>window.location = "/Consiment_Web/index.php";</script>';
				
			}else{
				$str ='<font color="#FF0004">Login fail</font>';
			}
	};
	oci_close($conn);
?>


<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>ConsimentWeb_Login</title>

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
			<h1 id="title" class="hidden"><span id="logo">CONSIMENT WEB</span></h1>
		</div>
        <div class="login-box animated fadeInUp">
        	<div class="box-header">
				<h2>Log In</h2>
			</div>
            <form action='login.php' method='post'>
            Username <br>
            <input name='username' type='input'><br>
            Password<br>
            <input name='password' type='password'><br>
            <?php 
				echo $str.'<br>';
			?>
            <br>
            <button name='submit' type="submit" >Sign In</button>
            <!--<input name='submit' type='submit' value='Login'>-->
            </form>
        </div>
    </div>
</body>
</html>
