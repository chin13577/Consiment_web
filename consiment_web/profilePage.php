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
	  <meta name="author" content="Jake Rocheleau">
	<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/animate.css">
		<!-- Custom Stylesheet -->
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
					  <li><a href="/consiment_web/profilePage.php " class="active">PROFILE</a></li>
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
			<div id="inDetailProfileBlk">
				<div id="pro_detail">
				<?PHP
				
				if(isset($_POST["submit2"]))
				{
					$check='';
					$key='';
					// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
if (isset($_FILES['uploaded_file'])) {
$fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 = false | 1 = true
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
// END PHP Image Upload Error Handling ----------------------------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function

    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < 50; $i++) {
        $key .= $keys[array_rand($keys)];
    }
	$key .='.';
	$key .=$fileExt;
if ($fileTmpLoc) { // if file not chosen

// START PHP Image Upload Error Handling --------------------------------------------------
if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    echo "ERROR: Your file was larger than 5 Megabytes in size.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
     // This condition is only if you wish to allow uploading of specific file types    
     echo "ERROR: Your image was not .gif, .jpg, or .png.";
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
     exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    echo "ERROR: An error occured while processing the file. Try again.";
    exit();
}
	$check='1';
	$moveResult = move_uploaded_file($fileTmpLoc, "uploads/$key");
}
}
					$name = trim($_POST['name']);
					$address = trim($_POST['address']);
					$ssn = trim($_POST['ssn']);
					$bon = trim($_POST['bon']);
					if($check=='')
					{
					$query = "UPDATE CON_USER SET NAME = '$name', ADDRESS = '$address' ,SSN = '$ssn',B_ACCOUNT = '$bon' WHERE USER_ID = '$_SESSION[ID]'";
					}
					else
					{
					$query = "UPDATE CON_USER SET NAME = '$name', ADDRESS = '$address' ,SSN = '$ssn',USER_PHOTO ='$key',B_ACCOUNT = '$bon' WHERE USER_ID = '$_SESSION[ID]'";
					}
					$parseRequest = oci_parse($conn,$query);
					oci_execute($parseRequest);
					$query = "SELECT * FROM CON_USER WHERE USER_ID ='$_SESSION[ID]' and user_pw='$_SESSION[PASSWORD]'";
					$parseRequest = oci_parse($conn, $query);
					oci_execute($parseRequest);
					
					$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
					$_SESSION['NAME'] = $row['NAME'];
					$_SESSION['ADDRESS'] = $row['ADDRESS'];
					$_SESSION['SSN'] = $row['SSN'];
					$_SESSION['B_ACCOUNT'] = $row['B_ACCOUNT'];
					if($check!='')
					{
						$_SESSION['PIC'] = $row['USER_PHOTO'];
					}

				}
				if(isset($_POST["submit"]))
				{
					echo '<font>ID : </font><font>  '.$_SESSION["ID"].'</font><br>';?>
                    
            <form action="profilePage.php" method='post' enctype="multipart/form-data">
            <font>NAME : </font><input type="text" name="name" placeholder="First name and last name" value="<?php echo $_SESSION["NAME"] ?>"></input><br>
            <font>Address : </font><input type="text" name="address" placeholder="Address" value="<?php echo $_SESSION["ADDRESS"] ?>"></input><br>
            <font>Citizen ID : </font><input type="text" name="ssn" placeholder="Social Security Number" value="<?php echo $_SESSION["SSN"] ?>"></input><br>
            <font>Bank Account : </font><input type="text" name="bon" placeholder="Social Security Number" value="<?php echo $_SESSION["B_ACCOUNT"] ?>"></input><br>
					<input class="myButton" type="submit" name="submit2" value="submit"></input>
        			<input name="uploaded_file" type="file" id="uploadProfile" />
            	</form>
            	<?php
				}
				else
				{
					echo '<font>ID : </font><font>  '.$_SESSION["ID"].'</font><br><br>';
					echo '<font>NAME : </font><font>  '.$_SESSION["NAME"].'</font><br><br>';
					echo '<font>Address : </font><font>  '.$_SESSION["ADDRESS"].'</font><br><br>';
					echo '<font>Citizen ID : </font><font>  '.$_SESSION["SSN"].'</font><br><br>';
					echo '<font>Bank Account : </font><font>  '.$_SESSION["B_ACCOUNT"].'</font><br><br>';
					?>
                    
            	<form action="profilePage.php" method='post' >
					<input class="myButton" type="submit" name="submit" value="edit"></input>
            	</form>
                    <?php
				}
				?>
				
				</div>
					<img src="uploads/<?php echo $_SESSION['PIC'] ?>" id="pro_photo" style="border:inset" >
				<br><br>
			</div>
		</div>
	 </div>
	</body>
	</html>
