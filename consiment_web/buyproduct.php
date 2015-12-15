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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
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
					  <li><a href="/consiment_web/profilePage.php " >PROFILE</a></li>
					  <li><a href="/consiment_web/myproduct.php">MY PRODUCT</a></li>
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
        <br><br> <?php include("show_product.php") ?> <br><br>
        </div>
    </div>
 </div>
</body>
</html>
