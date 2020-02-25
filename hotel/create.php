<?php
	if( (isset($_POST['hotel'])&&!empty($_POST['hotel']))&&(isset($_POST['room'])&&!empty($_POST['room']))&&(isset($_POST['date'])&&!empty($_POST['date']))){
		$varHotel=$_POST['hotel'];
		$varRoom=$_POST['room'];
		$varDate=$_POST['date'];
		$fp=fopen("reserve.csv","a");
		fputcsv($fp, array($varHotel,$varRoom,$varDate));
		fclose($fp);
	}
?>
<html>
	<body style="font-size:30px">
		<form action="create.php" method="POST">
			Hotel
		<br>
		<input type="text" name="hotel"></textarea><br>
			Room Number
		<br>
		<input type="text" name="room"><br>
			Date
		<br>
		<input type="date" name="date"><br>
		<br>
		<button type="submit" value="Submit" style="font-size:25px">Submit</button>
		</form>
	</body>
</html>