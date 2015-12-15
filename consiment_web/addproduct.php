<?PHP
	session_start();
	$key = '';
	// Create connection to Oracle
	$conn = oci_connect("system", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>


<?php
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
// START PHP Image Upload Error Handling --------------------------------------------------
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
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
// END PHP Image Upload Error Handling ----------------------------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function

    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < 50; $i++) {
        $key .= $keys[array_rand($keys)];
    }
	$key .='.';
	$key .=$fileExt;
$moveResult = move_uploaded_file($fileTmpLoc, "uploads/$key");
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
    echo "ERROR: File not uploaded. Try again.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/sytle.css" rel="stylesheet" type="text/css">
<title>CONSIMENT_WEB - Home</title>
<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
                  <li><a href="/consiment_web/addproduct.php"class="active">ADD PRODUCT</a></li>
                  <li><a href="/consiment_web/buytransaction.php">PURCHASE HISTORY</a></li>
                  <li><a href="/consiment_web/selltransaction.php" >SALES HISTORY</a></li>
                  <li><a href="/consiment_web/contact_us.php">CONTACT</a></li>
                  <ul style="float:right;">
                        <li><a href="/consiment_web/buyproduct.php" class="active">BUY PRODUCT</a></li>
                      </ul>
            </ul>
        </div>
        <div id="inDetailBlk" class="addproduct-box">
        <div class="box-header">
				<h2>ADD PRODUCT</h2>
			</div>
<?PHP
	if(isset($_POST['submit'])){
		$userid = $_SESSION['ID'];
		$pname = trim($_POST['Pname']);
		$detail = trim($_POST['Detail']);
		$type = trim($_POST['type']);
		$price = trim($_POST['price']);
			$query = "INSERT INTO CON_PRODUCT (P_NAME,P_ID,DETAIL,START_DATE,TYPE,PRICE,SELLER_ID,BUY_STATUS) VALUES ('$pname',pseq.nextval,'$detail',to_date(sysdate,'DD-MON-YY'),'$type','$price','$userid','Sell')";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
			$query = "INSERT INTO CON_PHOTO (P_ID,PHOTO) VALUES (pseq.CURRVAL,'$key')";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
				
			}
?>

<form action='addproduct.php' enctype="multipart/form-data" method='post'>	 
	Name :
	<input name='Pname' type='input'><br><br>
	Type :
  <input list="Type" name="type"><br><br>
  <datalist id="Type">
    <option value="Food">
    <option value="Apparrel">
    <option value="Electronics">
    <option value="Digital Products">
    <option value="Vehicle">
    <option value="Pets">
    <option value="Books">
    <option value="Toys">
    <option value="Other">
  </datalist>
	Price :
	<input name='price' type='input'><br><br>
    Description :
	<input name='Detail' type='input'><br><br>
	Choose Product Picture :
	<input name="uploaded_file" type="file"/><br /><br />
	<button name='submit' type="submit" >ADD Product</button>
</form> <br><br>
        </div>
    </div>
 </div>
</body>
</html>
