   <div id="menu">
        <div id="memberBlock">
         <?PHP
		if(isset($_SESSION['ID'])){
			echo "<font id='userId'>USER : $_SESSION[ID]</font>";
			echo '<a href="/Consiment_web/logout.php"><font class ="myButton" id="logOut"> logout </font></a>';
			echo '<a href="/Consiment_web/profilePage.php "><font class ="myButton" id="member"> member </font></a>';
		}
		else{
		echo "<font id='userId'><center>WELLCOME</center></font>";
		echo '<a href="/Consiment_web/register.php"><font class ="myButton" id="signUp">SignUp</font> </a>';
		echo '<a href="/Consiment_web/login.php"><font class ="myButton" id="login">Login</font> </a>';
		}
		?>
        </div>
   </div>