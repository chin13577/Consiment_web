<?PHP
	session_start();
		$key ='';
	$tid='';
	// Create connection to Oracle
	$conn = oci_connect("system", "chinchin999", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

<?PHP
$tid=-1;
if(isset($_GET["T_ID"]))
{
	$tid=$_GET["T_ID"];
}

?>
<?php
// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
	$str ="";
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
    $str = "ERROR: Please browse for a file before clicking the upload button.";
    exit();
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    $str = "ERROR: Your file was larger than 5 Megabytes in size.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
     // This condition is only if you wish to allow uploading of specific file types    
     $str = "ERROR: Your image was not .gif, .jpg, or .png.";
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
     exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    $str = "ERROR: An error occured while processing the file. Try again.";
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
    $str = "ERROR: File not uploaded. Try again.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
}
}
?>

<?PHP
	if(isset($_POST['submit'])){ 
			$query = "UPDATE CON_TRANSACTION SET STATUS = 'Completed', TRANSFER_PROOF = '$key' WHERE T_ID = '$tid'";
			$parseRequest = oci_parse($conn,$query);
			oci_execute($parseRequest);
				echo '<script>window.location = "/consiment_Web/show_list_admin_tran.php";</script>';
			}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>ConsimentWeb_Login</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
	<div>
    	<div class="top">
			<h1 id="title" class="hidden"><span id="logo">CONSIMENT WEB</span></h1>
		</div>
        <div class="login-box animated fadeInUp">
        	<div class="box-header">
				<h2>Choose Proof Picture</h2>
			</div>
            <form action='up_admin.php?T_ID=<?php echo $tid; ?>'enctype="multipart/form-data" method='post'>
			
			<input name="uploaded_file" type="file"/><br /><br />
			<input name='submit' type='submit' value='Add product'>
			</form>
        </div>
    </div>
</body>
</html>
