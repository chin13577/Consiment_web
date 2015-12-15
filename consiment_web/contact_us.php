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
					  <li><a href="/consiment_web/profilePage.php " >PROFILE</a></li>
					  <li><a href="/consiment_web/myproduct.php">MY PRODUCT</a></li>
                 	 <li><a href="/consiment_web/addproduct.php">ADD PRODUCT</a></li>
					  <li><a href="/consiment_web/buytransaction.php">PURCHASE HISTORY</a></li>
					  <li><a href="/consiment_web/selltransaction.php" >SALES HISTORY</a></li>
					  <li><a href="/consiment_web/contact_us.php" class="active">CONTACT</a></li>
                       <ul style="float:right;">
                        <li><a href="/consiment_web/buyproduct.php" class="active">BUY PRODUCT</a></li>
                      </ul>
				</ul>
			</div>
			<div id="inDetailProfileBlk">
				
                <div id="login-box">
				<?php
			 	 include_once("map.php");
				?>
                </div>
			</div>
            <div id="inDetailProfileBlk">
            มีข้อสงสัยอะไร <br>
            สอบถามข้อมูลสินค้า/สั่งซื้อสินค้า/แจ้งการโอนเงิน/ติดตามสินค้า/เคลมสินค้า/และอื่นๆ<br>
            <hr>
            Internet Call Center: เฟสบุ๊คอินบ๊อกซ์ Email: Contactus@consimentweb.com<br>
            ติดต่อเราผ่าน Facebook<br>
            *** Facebook เป็นช่องทางที่ทาง CONSIMENT บริการได้มีประสิทธิภาพและรวดเร็วที่สุดครับผม Fun Facts: CONSIMENT ได้รับคัดเลือกจากทาง Facebook USA ให้เป็นตัวอย่าง "Success Story"ว่าใช้ Facebook ทั้งในด้านการพัฒนาธุรกิจและการบริการลูกค้า ในประเทศไทยแต่เพียงผู้เดียว<br><br>
          
            ตัวแทนจำหน่าย<br>
            Email: Wholesale@CONSIMENT.com<br>
            <hr>
            ต้องการเยี่ยมชมหน้าร้าน            <br>
            เวลาทำการหน้าร้าน: จันทร์-ศุกร์, 9:00-17:00 น. | หยุดทุกวันนักขัตฤกษ์ <br>ที่อยู่ติดต่อ: ตึก 30 ปี คณะวิศวกรรมศาสตร์ มหาวิทยาลัยเชียงใหม่<br>
			บัญชีธนาคาร Admin : นาย สมโชติ เกรดเอกำลังดี ธนาคารทิงนองนอย สาขาเถิดเทิง 125-5512454-1<br>
            <hr>
            </div>
					<!--<img src="uploads/<?php echo $_SESSION['PIC'] ?>" id="pro_photo" style="border:inset" >-->
				<br><br>
			</div>
		</div>
	 </div>
	</body>
	</html>
