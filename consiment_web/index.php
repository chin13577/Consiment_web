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
	<link rel="stylesheet" href="css/animate.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      
    </head>

<body id="body">
    <div id="banner_wrapper">
        <center>
        <img src="images/banner.png"  >
        </center>
         
        <div onclick="location.href='<?php if(empty($_SESSION['ID'])){
			 echo '/consiment_web/login.php';
		}
		else
		{
			echo'/consiment_web/buyproduct.php';
		}?>'" class="buy_button animated fadeInUp"style="cursor: pointer;">
       		<img class="imgBtn" src="images/forBuy.png">
        </div>
        <div  onclick="location.href='<?php if(empty($_SESSION['ID'])){
			 echo '/consiment_web/login.php';
		}
		else
		{
			echo'/consiment_web/addproduct.php';
		}?>'" class="sell_button animated fadeInUp"style="cursor: pointer;">
        	<img class="imgBtn" src="images/forSell.png">
        </div>
		 <div id="menu">
        <div id="memberBlock">
         <?PHP
		if(isset($_SESSION['ID'])){
		 
			 $TARGET ='';
		 	if($_SESSION['ID']=='admin'){
				 $TARGET ='/consiment_web/show_list_admin_tran.php';
			}
			else
			{
				$TARGET ='/consiment_web/profilePage.php';
			}
			echo "<font id='userId'>USER : $_SESSION[ID]</font>";
			echo '<a href="/Consiment_web/logout.php"><font class ="myButton" id="logOut"> logout </font></a>';
			echo '<a href="'.$TARGET.'"><font class ="myButton" id="member"> member </font></a>';
		}
		else{
		echo "<a href='/Consiment_web/login.php'><font id='userId' style='cursor:pointer'><center>WELCOME</center></font></a>";
		echo '<a href="/Consiment_web/register.php"><font class ="myButton" id="signUp">SignUp</font> </a>';
		echo '<a href="/Consiment_web/login.php"><font class ="myButton" id="login">Login</font> </a>';
		}
		?>
        </div>
   </div>
</body>
</html>