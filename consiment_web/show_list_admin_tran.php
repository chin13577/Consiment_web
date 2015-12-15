<?php
session_start();
	// Create connection to Oracle
	$conn = oci_connect("SYSTEM", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	}
	if($_SESSION['ID'] != 'admin'){
		echo '<script>window.location = "/consiment_Web/index.php";</script>';
	}

//$conn = mysqli_connect("localhost","root","","consimentweb_sql");
	
//if(!$conn)
//{
	//echo "Error: ";
//}

$query='select * from (select * from (select * from con_transaction order by startdate desc) transaction join (select P_ID,P_NAME from con_product) product on(PRODUCT_ID=P_ID)) abc join (select * from con_user) usere on (usere.USER_ID=abc.BUYER_ID)';
//$data=mysqli_query($conn,$query);

$parseRequest = oci_parse($conn, $query);
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
      <th>Buyer ID</th>
      <th>Buyer B No.</th>
      <th>Status</th>
      <th>Upload Proof</th>
      <th>Cancel</th>
      <th>Proof</th>
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
		$cancel='<a class="myButton" href="a_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Sent")
	{
		$status= "<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel='<a class="myButton" href="a_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Proof Sent"){
		$status='<a class="myButton" href="t_confirm.php?T_ID='.$object["T_ID"].'">Confirm</a>';
		$cancel='<a class="myButton" href="a_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="BTransfered")
	{
		$status= "<i class='fa fa-check-circle' style='font-size:20px;color:Green'></i>";
		$cancel='<a class="myButton" href="a_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
	}
	else if($object["STATUS"]=="Buyer Recieved The Product")
	{
		$status='<a class="myButton" href="up_admin.php?T_ID='.$object["T_ID"].'">Upload</a>';
		$cancel='<a class="myButton" href="a_cancel.php?T_ID='.$object["T_ID"].'">Cancel</a>';
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
	$amount= $object["BUY_PRICE"] - $object["FEE"];
	$table_str.='
	<tr>
      <td><strong>'.$object["T_ID"].'</strong></td>
      <td>'.$object["PRODUCT_ID"].'</td>
      <td>'.$amount.'</td>
      <td>'.$object["STARTDATE"].'</td>
      <td>'.$object["SELLER_ID"].'</td>
      <td>'.$object["BUYER_ID"].'</td>
      <td>'.$object["B_ACCOUNT"].'</td>
      <td>'.$object["STATUS"].'</td>
      <td><center>'.$status.'</center></td>
      <td><center>'.$cancel.'</center></td>
	  
	  <td>
				<button onclick="myFunction(this)" value="'.$object["T_ID"].'" class="myButton">View</button>
		</td>
    </tr>';
	?>
	<div id="proof<?php echo $object["T_ID"]?>" style="width:80vw; margin-left:10vw; margin-right:10vw; position:fixed; display:none; z-index:999; ">
    <div style="background-color:rgba(0,0,0,0.8); width:100%; position:relative;">
		<div  style=" width:3%; height:6vh; position:relative; margin-left:97%;">
        <button onclick="myHide(this)" value="<?php echo $object["T_ID"]?>" class="myButton">X</button>
        </div>
    </div>
    <div style="background-color:rgba(255,255,255,0.9); width:100%; position:relative; padding-top:5vh; padding-bottom:5vh;">
		<center><div style="background-color:#F7F5F5;  width:90%; height:80vh; position:relative;">
        <?php
			if(empty($object["BUY_PROOF"]))
			{
				?>
            	<h1> no buyer transfer</h1>
              <?php
			}
			else
			{
				?>
                <div style="width: 300px;">
        	<img src="uploads/<?php echo $object["BUY_PROOF"]?>"style="width: 300px;height:250px;"><center>Buyer</center>
            </div>
              <?php
			}
			
			if(empty($object["SEND_PROOF"]))
			{
				?>
            	<h1> no seller transfer</h1>
              <?php
			}
			else
			{
				
				?>
                <div style="width: 300px; position:absolute; top:0; right:0;">
            <img src="uploads/<?php echo $object["SEND_PROOF"]?>"style="width: 300px;height:250px;"><center>Seller</center>
            </div>
              <?php
			}
			
			if(empty($object["TRANSFER_PROOF"]))
			{
				?>
            	<h1> no admin transfer</h1>
              <?php
			}
			else
			{
				
				?>
                <div style="width: 300px; position:absolute; top:0; left:0;">
            <img src="uploads/<?php echo $object["TRANSFER_PROOF"]?>"style="width: 300px;height:250px;"><center>Admin</center>
            </div>
              <?php
			}
		?>
        </div></center>
    </div>
	</div>
    <?php
}
$table_str.='
  </tbody>
</table>';

?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<link href="CSS/tranbuy_style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<title>CONSIMENT_WEB - Home</title>
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
                  <li><a href="/consiment_web/index.php">HOME</a></li>
                  <li><a href="/consiment_web/profilePageAdmin.php">PROFILE</a></li>
                  <li><a href="/consiment_web/show_list_admin_tran.php" class ="active">TRANSACTIONS</a></li>
                  <li><a href="/consiment_web/admin_setexp.php">SET EXP</a></li>
            </ul>
        </div>
        <div id="inDetailBlk">
            <div style="width:100%; height:50%; margin:auto;">
                <?php
                echo $table_str;
                ?>
            </div>
        
 <script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/show_proof.js"></script>  
        </div>
    </div>
 </div>
</body>
</html>
