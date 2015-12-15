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
$query="select * from (select * from (select * from con_transaction order by startdate desc) transaction join (select P_ID,P_NAME from con_product) product on(PRODUCT_ID=P_ID) where SELLER_ID like '$id' AND STATUS NOT LIKE 'Cancelled%' AND STATUS NOT LIKE 'Completed') abc join (select * from con_user) usere on (usere.USER_ID=abc.BUYER_ID)";
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
      <th>Buyer ID</th>
      <th>Buyer Address</th>
      <th>Status</th>
      <th>Upload Proof</th>
      <th>Cancel</th>
    </tr>
  </thead>
  <tbody>';
  
while($object=oci_fetch_array($parseRequest, OCI_ASSOC))
{
	$status="";
	$cancel='';
	if($object["STATUS"]=="Pending")
	{
		$status= "<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel='<a class="myButton" href="s_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Sent")
	{
		$status= "<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel='<a class="myButton" href="s_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="BTransfered")
	{
		$status='<a class="myButton" href="up_sell.php?T_ID='.$object["T_ID"].'">Upload</a>';
		$cancel='<a class="myButton" href="s_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Buyer Recieved The Product")
	{
		$status= "<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel='<a class="myButton" href="s_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Have Problem")
	{
		$status= '<i class="fa fa-remove" style="font-size:22px;color:red"></i>';
		$cancel= '<i class="fa fa-remove" style="font-size:22px;color:red"></i>';
	}
	else
	{
		$status="<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel="<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
	}
	$amount= $object["BUY_PRICE"];
	$table_str.='
	<tr>
      <td><strong>'.$object["T_ID"].'</strong></td>
      <td>'.$object["P_NAME"].'</td>
      <td>'.$amount.'</td>
      <td>'.$object["STARTDATE"].'</td>
      <td>'.$object["BUYER_ID"].'</td>
      <td>'.$object["ADDRESS"].'</td>
      <td>'.$object["STATUS"].'</td>
      <td><center>'.$status.'</center></td>
      <td><center>'.$cancel.'</center></td>
    </tr>';
}
$table_str.='
  </tbody>
</table>';
//mysqli_close($conn);

?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<link href="CSS/tranbuy_style.css" rel="stylesheet" type="text/css">
<title>CONSIMENT_WEB - Home</title>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<body id="body" bgcolor="#C7C7C7" >
<div id="all">
    <div id="banner_wrapper_small">
        <center>
            <img id="bannerImg" src="images/banner.png" align="middle">
        </center>
        <?php
          include_once("menu.php");
        ?>
    </div>
    <div id="detailBlk">
    	<div id="menuBlk">
             <ul >
                  <li><a href="/consiment_web/">HOME</a></li>
                  <li><a href="/consiment_web/profilePage.php">PROFILE</a></li>
                  <li><a href="/consiment_web/myproduct.php">MY PRODUCT</a></li>
                  <li><a href="/consiment_web/addproduct.php">ADD PRODUCT</a></li>
                  <li><a href="/consiment_web/buytransaction.php ">PURCHASE HISTORY</a></li>
                  <li><a class="active" href="/consiment_web/selltransaction.php" >SALES HISTORY</a></li>
                  <li><a href="/consiment_web/contact_us.php">CONTACT</a></li>
                  <ul style="float:right;">
                        <li><a href="/consiment_web/buyproduct.php" class="active">BUY PRODUCT</a></li>
                      </ul>
            </ul>
        </div>
        <div id="inDetailBlk">
        <div style="width:100%; height:50%; margin:auto;">
<?php
echo $table_str;
?>
</div>
        </div>
    </div>
 </div>
</body>
</html>
