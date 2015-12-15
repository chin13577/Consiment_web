
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
<?php 
$dynamicList = "";
$query = "SELECT * FROM con_product where '$_SESSION[ID]' like SELLER_ID  ORDER BY START_DATE DESC";
$parseRequest = oci_parse($conn, $query);
oci_execute($parseRequest);
$meow = 'OCI_BOTH';
//$result = mysqli_query($link, $query);
//$row_cnt = mysqli_num_rows($result);
$row_cnt = oci_fetch_all($parseRequest,$meow);//นับจำนวน แถวได้เลย แล้ว parseRe..ข้อมูลหายด้วย
$parseRequest = oci_parse($conn, $query);
oci_execute($parseRequest);
 $dynamicList ='
			<table>
				  <thead>
					<tr>
					  <th>Product No.</th>
					  <th>Product Name</th>
					  <th>Price</th>
					  <th>Date</th>
					  <th>Detail</th>
					  <th>Delete</th>
					</tr>
				  </thead>
				  <tbody>';
if ($row_cnt > 0) {
	while($row=oci_fetch_array($parseRequest, OCI_ASSOC))
	{
		
		$id = $row['P_ID'];
		$product_name = $row['P_NAME'];
		$price = $row['PRICE'];;
		$type = $row['TYPE'];
		$date_added = strftime("%b %d, %Y", strtotime($row['START_DATE']));
		$seller_id = $row['SELLER_ID'];
		$detail = $row['DETAIL'];
			
		$query= "SELECT * FROM CON_PHOTO WHERE $id=con_photo.p_id";
		$parseRequest_V = oci_parse($conn,$query);
		oci_execute($parseRequest_V);
		$pic=oci_fetch_array($parseRequest_V, OCI_RETURN_NULLS+OCI_ASSOC);
		
		$dynamicList .= '
        <tr>
          <td>'. $id .'</td>
          <td>' . $product_name . '</td>
            <td>' . $price . '</td>
			<td>' . $date_added . '</td>
			<td>
				<center><button onclick="myFunction(this)" value="'.$id.'" class="myButton">View detail</button></center>
		</td>
			
      <td><center><a class="myButton" href="delete_product.php?P_ID='.$id.'">Delete</a></center></td>
        </tr>'; ?>
         <div id="proof<?php echo $id?>" style=" width:80vw; margin-left:10vw; margin-right:10vw; position:fixed; display:none; z-index:999; ">
		 <div style="background-color:rgba(0,0,0,0.7); width:100%; position:relative;Top:10px; padding-bottom:5px;">
		<div  style="width:3%; height:6vh; position:relative; margin-left:97%;">
        <button onclick="myHide(this)" value="<?php echo $id ?>" class="myButton" style="z-index:999;" >X</button>
        </div>
    </div>
    <div style="background-color:rgba(255,255,255,0.9); width:100%; position:relative; padding-top:5vh; padding-bottom:5vh;">
		<center><div style="background-color:#F7F5F5;  width:90%; height:60vh; position:relative;">
        <img src="uploads/<?php echo $pic["PHOTO"]?>" style="width: 450px;height:350px;">
        <?php
		while($object=oci_fetch_array($parseRequest_V, OCI_ASSOC))
		{
			?>
        	<img src="uploads/<?php echo $pic["PHOTO"]?> "style="border-style:inset">
            <?php
		}
		?>
        </div>
        <div style="background-color:#FFFFFF;  width:90%; height:20vh; position:relative;">
        	Product No. : <?php echo $id ?><br>
        	Product Name : <?php echo $product_name ?><br>
        	Type : <?php echo $type ?><br>
        	Price : <?php echo $price ?><br>
        	Date : <?php echo $date_added ?><br>
        	Seller ID : <?php echo $seller_id ?><br>
        	Detail : <?php echo $detail ?><br>
        </div></center>
        </div>
        </div>
    <?php
	
	}
	$dynamicList.='
			</tbody>
			</table>';
} 
else {
	$dynamicList = "We have no products listed in our store yet";
}
?>
<!--
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consiment Web</title>
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<link href="sytle.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php include_once("banner.php");?>
<center>
<div id="pageContent" style="height:auto">
<?php echo $dynamicList; ?>
</div>
</center>

</body>
</html>
-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<link href="CSS/tranbuy_style.css" rel="stylesheet" type="text/css">
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
                  <li><a href="/consiment_web/">HOME</a></li>
                  <li><a href="/consiment_web/profilePage.php">PROFILE</a></li>
                  <li><a href="/consiment_web/myproduct.php" class="active">MY PRODUCT</a></li>
                  <li><a href="/consiment_web/addproduct.php">ADD PRODUCT</a></li>
                  <li><a href="/consiment_web/buytransaction.php">PURCHASE HISTORY</a></li>
                  <li><a href="/consiment_web/selltransaction.php" >SALES HISTORY</a></li>
                  <li><a href="/consiment_web/contact_us.php">CONTACT</a></li>
                  <ul style="float:right;">
                       <li><a href="/consiment_web/buyproduct.php" class="active">BUY PRODUCT</a></li>
                      </ul>
            </ul>
        </div>
        <div id="inDetailBlk">
        <br>
        <?php echo $dynamicList; ?>	
         <br>
        </div>
    </div>
 </div>
 <script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/show_proof.js"></script>  
</body>
</html>