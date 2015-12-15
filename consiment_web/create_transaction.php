<?PHP
$id="1";
if(isset($_GET["P_ID"]))
{
	$id=$_GET["P_ID"];
}

?>
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
$uid = $_SESSION['ID'];
		$query = "SELECT NAME, USER_ID,P_ID FROM CON_USER,CON_PRODUCT WHERE '$id' = P_ID AND SELLER_ID = USER_ID";
		$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$sellername = $row['NAME'];
	$sellerid = $row['USER_ID'];
	
	
		$query = "SELECT PRICE FROM CON_PRODUCT WHERE '$id' = P_ID";
		$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$price = $row['PRICE'];
	
	$query = "SELECT NAME,EXP,SYSDATE FROM CON_USER WHERE '$uid' = USER_ID";
		$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$buyername = $row['NAME'];
	$sysdate = strtotime($row['SYSDATE']);
	$exp = strtotime($row['EXP']);
	if($exp-$sysdate >0){
	$fee =30;
	}
	else
	{
	$fee =50;
	}
	
	$status = "PENDING";
	$query = "INSERT INTO CON_TRANSACTION (T_ID, SELLER_NAME, STATUS, BUYER_NAME, BUY_PRICE, FEE, SELLER_ID, BUYER_ID, PRODUCT_ID, STARTDATE, LASTCHANGED) VALUES (tseq.nextval, '$sellername', 'Pending', '$buyername', '$price', '$fee', '$sellerid', '$uid', '$id', to_date(sysdate,'DD-MON-YY'), to_date(sysdate,'DD-MON-YY'))";
	//$query = "INSERT INTO con_transaction(T_ID,SELLER_NAME,STATUS,BUYER_NAME,BUY_PRICE,FEE,BUY_PROOF,SEND_PROOF,TRANSFER_PROOF,BUYER_ID,PRODUCT_ID,STARTDATE,LASTCHANGED) VALUES (tseq.nextval,'$SELLERNAME','$status','$BUYERNAME','$PRICE',50,NULL,NULL,NULL,'$uid','$sellerid',to_date(sysdate,'DD-MON-YY'),to_date(sysdate,'DD-MON-YY'))";
	$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	
	$query = "UPDATE CON_PRODUCT SET BUY_STATUS = 'Reserve' WHERE P_ID = '$id'";
	$parseRequest = oci_parse($conn,$query);
	oci_execute($parseRequest);
	
echo '<script>window.location = "/consiment_Web/buytransaction.php";</script>';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>