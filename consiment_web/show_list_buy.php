
<?php
	session_start();
	$key = '';
	// Create connection to Oracle
	$conn = oci_connect("system", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 

$id = $_SESSION['ID'];
$query="select * from (select * from con_transaction order by startdate desc) transaction join (select P_ID,P_NAME from con_product) product on(PRODUCT_ID=P_ID) where BUYER_ID like '$id'";
//$data=mysqli_query($conn,$query);
$parseRequest = oci_parse($conn,$query);
oci_execute($parseRequest);

//create table
$table_str='
<table>
  <thead>
    <tr>
      <th>Transaction No.</th>
      <th>Product Name</th>
      <th>Price</th>
      <th>Date</th>
      <th>Seller ID</th>
      <th>Status</th>
      <th>Upload Proof</th>
    </tr>
  </thead>
  <tbody>';
  
while($object=oci_fetch_array($parseRequest, OCI_ASSOC))
{
	$status="";
	if($object["STATUS"]=="buying")
	{
		$status='<a class="myButton" href="Up_Buy.php?T_ID='.$object["T_ID"].'">Upload</a>';
	}
	else if($object["STATUS"]=="sending")
	{
		$status= "&#x2713";
	}
	else if($object["STATUS"]=="transfer")
	{
		$status= "&#x2713";
	}
	else if($object["STATUS"]=="check")
	{
		$status='<a class="myButton" href="Up_complete.php?T_ID='.$object["T_ID"].'">Complete</a>';
	}
	$table_str.='
	<tr>
      <td><strong>'.$object["T_ID"].'</strong></td>
      <td>'.$object["P_NAME"].'</td>
      <td>'.$object["BUY_PRICE"].'</td>
      <td>'.$object["STARTDATE"].'</td>
      <td>'.$object["SELLER_ID"].'</td>
      <td>'.$object["STATUS"].'</td>
      <td><center>'.$status.'</center></td>
    </tr>';
}
$table_str.='
  </tbody>
</table>';
//mysqli_close($conn);

?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="CSS/tranbuy_style.css" rel="stylesheet" type="text/css">
</head>
<body style="width:100vw; height:100vh;">
<div style="width:50%; height:50%; margin:auto;">
<?php
echo $table_str;
?>
</div>
<script src="js/jquery-1.11.3.min.js"></script>                        
</body>
</html>