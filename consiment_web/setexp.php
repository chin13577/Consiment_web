

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
		echo "EXP date completed";
		}
	
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sadmin Set Expiration</title>
</head>

<body>
	<div id="inDetailProfileBlk">
        <div class="login-box animated fadeInUp">
        	<div class="box-header">
				<h2>Set EXP date</h2>
			</div>
                <form action='admin_setexp.php' method='post'>

<select name="DOBDay">
	<option> - Day - </option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
</select>
                <select name="DOBMonth">
	<option> - Month - </option>
	<option value="January">January</option>
	<option value="Febuary">Febuary</option>
	<option value="March">March</option>
	<option value="April">April</option>
	<option value="May">May</option>
	<option value="June">June</option>
	<option value="July">July</option>
	<option value="August">August</option>
	<option value="September">September</option>
	<option value="October">October</option>
	<option value="November">November</option>
	<option value="December">December</option>
</select>

<select name="DOBYear">
	<option> - Year - </option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	<option value="2017">2017</option>
	<option value="2018">2018</option>
	<option value="2019">2019</option>
	<option value="2020">2020</option>
	<option value="9999">9999</option>
</select>
<br>
User ID
<input name='id' type='input'>
            <input name='submit' type='submit'><br><br>

            	</form>
        </div>
    </div>
</body>
</html>
