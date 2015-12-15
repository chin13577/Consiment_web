
<?php

$id="1";
if(isset($_GET["page"]))
{
	$id=$_GET["page"];
}

function get_products()
{
/////////////////////////////////////////////////////////////////////
$conn = mysqli_connect("localhost","root","","consimentweb_sql");
	
if(!$conn)
{
	echo "Error: ";
}

$query='select * from con_product order by start_date desc';
$data=mysqli_query($conn,$query);

$products= array();

while($object=mysqli_fetch_object($data))
{
	$products[]=$object;
}
mysqli_close($conn);
///////////////////////////////////////////////////////////////////////////////////////////////////////
return $products;
}

function get_table()
{
	////////////////////////////////////////////////////////////////////////////////////////////////////
	$conn = mysqli_connect("localhost","root","","consimentweb_sql");
	
	if(!$conn)
	{
		echo "Error: ";
	}

	//create table
	$table_str='<table id="product_table">';
	
	$table_str.="<tr>";
	$table_str.='<th>Image</th><th>Name</th><th>Price</th><th>Date</th><th>Detail</th>';
	$table_str.="</tr>";
	$products=get_products();
	$pic="";
	$class="article current";
	$all=count($products);
	$pad=ceil($all/4);
	
	foreach($products as $product)
	{
		$query="select * from con_photo where $product->P_ID=con_photo.p_id limit 1";
		$data=mysqli_query($conn,$query);
		$pic=mysqli_fetch_array($data, MYSQLI_ASSOC);
		$table_str.="<tr>";
		$table_str.='<td width="20%" height="100px"><center><img src="images/'.$pic["PHOTO"].'"></center></td>
					<td><center>'.$product->P_NAME.'</center></td>
					<td><center>'.$product->PRICE.'<center></td>
					<td><center>'.$product->START_DATE.'<center></td>
					<td><div style="cursor: pointer;" class="'.$class.'"><center>View detail</center></div>
		<div class="pop">
			<div style="position:absolute; width:50%; height:100%; left:0px; top:0px;";>
    			<div style="position:relative; top:25%; left:10%; border-style: solid; border-width: 1px; width:80%; height:50%;">
					<img src="#" style="width:100%; height:100%;">
				</div>
			</div>
    		<div style="position:absolute; width:50%; height:100%; right:0px; top:0px;">
            	<div style="height:15%; width:200%; border-style:solid; border-width:1px; margin-left:-100%;">'.$product->P_ID.'
            	</div>
            	<div style="height:30%; width:100%; border-style: solid; border-width: 1px;">
                	<div style="margin:5%; border-style: solid; border-width:1px; word-wrap:break-word;">'.$product->P_NAME.$product->PRICE.$product->START_DATE.$pic["PHOTO"].'</div>		
				</div>
            	<div style="height:55%; width:100%; border-style: solid; border-width: 1px;">
                	<div style="margin:5%; border-style: solid; border-width:1px; word-wrap:break-word;">'.$product->DETAIL.'</div>
					
				  <div style="position:absolute; bottom: 2vh;right: 2vw;"><a href="create_transaction.php?P_ID='.$product->P_ID.'">BUY</a></div>
				</div>
			</div>
    	</div>
		</td>';
		$table_str.='</tr>';
		$class="article";
	}
	$table_str.='</table><div class="padding">';
	for($b=1;$b<=$pad;$b++)
	{
		$table_str.='<a href="show_list_product_sql.php?page='.$b.'" style="text-decoration:none ">'.$b.' </a>';
	}
	$table_str.='</div><div id="pop_close">X</div>';
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	mysqli_close($conn);
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	return $table_str;
}


?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="CSS/product_sytle.css" rel="stylesheet" type="text/css">
</head>
<body style="width:100vw;">
	<?PHP echo get_table(); ?>
	
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/app.js"></script>                           
</body>
</html>