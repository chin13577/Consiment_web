<?PHP
		session_start();
		// Create connection to Oracle
		$conn = oci_connect("system", "chinchin999", "//localhost/XE");
		if (!$conn) {
			$m = oci_error();
			echo $m['message'], "\n";
			exit;
		} 
		if($_SESSION['ID'] != 'admin'){
		echo '<script>window.location = "/consiment_Web/index.php";</script>';
	}

	
?>

<?PHP
	if(isset($_POST['submit'])){
		$id = $_POST['id'];
		$dater ='';
		$dater.= $_POST['DOBDay'];
		$dater.= ' ';
		$dater.= $_POST['DOBMonth'];
		$dater.= ' ';
		$dater.= $_POST['DOBYear'];
		//echo $dater;
		$query = "UPDATE CON_USER SET EXP=TO_DATE('$dater') WHERE USER_ID = '$id'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
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
             	  <li><a href="/consiment_web/index.php">HOME</a></li>
                  <li><a href="/consiment_web/profilePageAdmin.php">PROFILE</a></li>
                  <li><a href="/consiment_web/show_list_admin_tran.php">TRANSACTIONS</a></li>
                  <li><a href="/consiment_web/admin_setexp.php"class ="active">SET EXP</a></li>
            </ul>
        </div>
        <div id="inDetailBlk">
        <br><br> <?php include("setexp.php"); ?> <br><br>
        </div>
    </div>
 </div>
</body>
</html>
