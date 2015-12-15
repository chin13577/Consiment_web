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
			$query = "SELECT PRODUCT_ID FROM CON_TRANSACTION WHERE T_ID = '$tid'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			$object=oci_fetch_array($parseRequest, OCI_ASSOC);
			$id=$object['PRODUCT_ID'];
			

			$query = "UPDATE CON_TRANSACTION SET STATUS = 'Cancelled by Buyer' WHERE T_ID = '$tid'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			
			$query = "UPDATE CON_PRODUCT SET BUY_STATUS = 'Sell' WHERE P_ID = '$id'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			echo '<script>window.location = "/consiment_Web/buytransaction.php";</script>';

?>
