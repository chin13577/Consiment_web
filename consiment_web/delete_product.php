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
$pid=-1;
if(isset($_GET["P_ID"]))
{
	$pid=$_GET["P_ID"];
}

?>




<?PHP
			$query = "DELETE FROM con_product WHERE P_ID = '$pid'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			echo '<script>window.location = "/consiment_Web/myproduct.php";</script>';

?>
