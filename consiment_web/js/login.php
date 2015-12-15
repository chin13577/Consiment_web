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
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){ 
		$user = trim($_POST['username']);
		$pw = trim($_POST['password']);
		$systemPass = trim($_POST['sysPass']);
		if($systemPass=='1234'){
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
				echo '<script>window.location = "/Consiment_Web/index.php";</script>';
				
			}else{
				echo "Login fail.";
			}
		}
		else{
			echo "SystemPassWord is not correct";
		}
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Password<br>
	<input name='password' type='password'><br><br>
	SystemPassWord<br>
	1234<br>
	<input name='sysPass' type='input'><br><br>
	<input name='submit' type='submit' value='Login'>
</form>
