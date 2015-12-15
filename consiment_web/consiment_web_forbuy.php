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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consiment Web</title>
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
</head>
<body id="body">

    <div id="banner_wrapper_small">
    </div>
    <?php
      include_once("menu.php");
    ?>
    </div>
    <div id="select_type">
    </div>
    <div id="select_type">
    </div>
    <div id="buy_page">
    BUY
    </div>
    <div id="sell_page">
    SELL
    </div> 
    
</body>
</html>