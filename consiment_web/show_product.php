<?PHP
		// Create connection to Oracle
		$conn = oci_connect("system", "chinchin999", "//localhost/XE");
		if (!$conn) {
			$m = oci_error();
			echo $m['message'], "\n";
			exit;
		} 
	
?>
<?php
$id = $_SESSION['ID'];
$query="select * from con_product where SELLER_ID != '$id' AND BUY_STATUS = 'Sell' order by start_date desc";
if(isset($_POST["Food"]))
{
	$type = $_POST["Food"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell' order by start_date desc";
}
else if(isset($_POST["Apparrel"]))
{
	$type = $_POST["Apparrel"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Electronics"]))
{
	$type = $_POST["Electronics"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Digital"]))
{
	$type = $_POST["Digital"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Vehicle"]))
{
	$type = $_POST["Vehicle"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Pets"]))
{
	$type = $_POST["Pets"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Books"]))
{
	$type = $_POST["Books"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Toys"]))
{
	$type = $_POST["Toys"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["Other"]))
{
	$type = $_POST["Other"];
	$query= "select * from con_product where SELLER_ID != '$id' AND TYPE = '$type' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["All"]))
{
	$query="select * from con_product where SELLER_ID != '$id' AND BUY_STATUS = 'Sell'  order by start_date desc";
}
else if(isset($_POST["bsearch"]))
{
	$type = $_POST["search"];
	$name="LOWER (P_NAME) LIKE '%$type%' ";
	$pieces = explode(" ", $type);
	foreach($pieces as $piece)
	{
		$name .= "OR LOWER (P_NAME) LIKE '%$piece%' ";
	}
	$query="select * from con_product where SELLER_ID != '$id' AND ($name) order by start_date desc";
}

//$data=mysqli_query($conn,$query);

$parseRequest = oci_parse($conn, $query);
oci_execute($parseRequest);


$products= array();
?>

<form method="post" action="buyproduct.php" style="position">
	<input type="submit" name="Food" value="Food" class="myButton">
	<input type="submit" name="Apparrel" value="Apparrel" class="myButton">
	<input type="submit" name="Electronics" value="Electronics" class="myButton">
	<input type="submit" name="Digital" value="Digital Products" class="myButton">
	<input type="submit" name="Vehicle" value="Vehicle" class="myButton">
	<input type="submit" name="Pets" value="Pets" class="myButton">
	<input type="submit" name="Books" value="Books" class="myButton">
	<input type="submit" name="Toys" value="Toys" class="myButton">
	<input type="submit" name="Other" value="Other" class="myButton">
	<input type="submit" name="All" value="All" class="myButton"><br><br>
	<input type="text" name="search" placeholder="Search Product">
	<input type="submit" name="bsearch" value="search" class="myButton">
</form>
<?php
while (($object = oci_fetch_object($parseRequest)) != false) {
$products[]=$object;
}
?>
<table>
  <thead>
    <tr>
      <th>Image</th>
      <th>Product Name</th>
      <th>Type</th>
      <th>Price</th>
      <th>Date</th>
      <th>Seller ID</th>
      <th>Status</th>
      <th>Detail</th>
    </tr>
  </thead>
  <tbody>
  <?php
  
foreach($products as $product)
{
	$pid = $product->P_ID;
	$query= "SELECT * FROM CON_PHOTO WHERE $pid=con_photo.p_id";
	$parseRequest_V = oci_parse($conn,$query);
	oci_execute($parseRequest_V);
	$pic=oci_fetch_array($parseRequest_V, OCI_RETURN_NULLS+OCI_ASSOC);
	?>
	<tr>
      <td><img src="uploads/<?php echo $pic["PHOTO"]?>" style ="width: 150px;height:100px;"></td>
      <td><strong><?php echo $product->P_NAME ?></strong></td>
      <td><?php echo $product->TYPE ?></td>
      <td><?php echo $product->PRICE ?></td>
      <td><?php echo $product->START_DATE ?></td>
      <td><?php echo $product->SELLER_ID ?></td>
      <td><?php if($product->BUY_STATUS=='Reserve'){echo $product->BUY_STATUS.'ed';}else{ echo $product->BUY_STATUS; } ?></td>
	  <td>
				<button onclick="myFunction(this)" value="<?php echo $product->P_ID ?>" class="myButton">View detail</button>
		</td>
    </tr>
	<div id="proof<?php echo $product->P_ID?>" style="background-color:rgba(0,0,0,0.7); width:80vw; margin-top:-86vh; position:fixed; display:none; z-index:999; ">
    <div style="div style="background-color:rgba(0,0,0,0.7); width:100%; position:relative;Top:10px; padding-bottom:5px;"">
		<div  style="width:3%; height:6vh; position:relative;margin-left:97%;">
        <button onclick="myHide(this)" value="<?php echo $product->P_ID ?>" class="myButton">X</button>
        </div>
    </div>
    <div style="background-color:rgba(255,255,255,0.9); width:100%; position:relative; padding-top:5vh; padding-bottom:5vh;">
		<center><div style="background-color:#F7F5F5;  width:90%; height:60vh; position:relative;">
        <img src="uploads/<?php echo $pic["PHOTO"]?>" style="width: 400px;height:350px;border-style:inset;margin-top:15px;">
        <?php
		while($object=oci_fetch_array($parseRequest, OCI_ASSOC))
		{
			?>
        	<img src="uploads/<?php echo $pic['PHOTO']?>">
            <?php
		}
		?>
        </div>
        <div style="background-color:#FFFFFF;  width:90%; height:20vh; position:relative;">
        	Product No. : <?php echo $product->P_ID ?><br>
        	Product Name : <?php echo $product->P_NAME ?><br>
        	Type : <?php echo $product->TYPE ?><br>
        	Price : <?php echo $product->PRICE ?><br>
        	Date : <?php echo $product->START_DATE ?><br>
        	Seller ID : <?php echo $product->SELLER_ID ?><br>
        	Detail : <?php echo $product->DETAIL ?><br>
            <?php
			if($product->BUY_STATUS!='Reserve')
			{
				?>
            <div style="position:absolute; bottom: 2vh;right: 2vw;"><a href="create_transaction.php?P_ID=<?php echo $product->P_ID ?>" class="a1">BUY</a>    </div><?php
			}
			else
			{
				?>
            <div style="position:absolute; bottom: 2vh;right: 2vw;"><a href="show_product.php">Reserved</a></div><?php
			}
			?>
        </div></center>
        </div>
        </div>
    <?php
}
?>
  </tbody>
</table>


<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<link href="CSS/tranbuy_style.css" rel="stylesheet" type="text/css">
 <script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/show_proof.js"></script>  

