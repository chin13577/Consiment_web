<?PHP
	session_start();
	$key = '';
	// Create connection to Oracle
	$conn = oci_connect("system", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

<?PHP
$tid=-1;
if(isset($_GET["T_ID"]))
{
	$tid=$_GET["T_ID"];
}

?>




<?PHP
			$query = "UPDATE CON_TRANSACTION SET STATUS = 'BTransfered' WHERE T_ID = '$tid'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			echo '<script>window.location = "/consiment_Web/show_list_admin_tran.php";</script>';

?>
