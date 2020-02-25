<?php
	if( isset($_POST['index'])&&!empty($_POST['index'])){
		$index=$_POST['index'];
		$fp=fopen("reserve.csv","r");
		$output='';
		while(!feof($fp)) $output.=fgets($fp);
		fclose($fp);
		$output = explode("\n",$output);
		unset($output[count($output)-1]);
		for($i=0;$i<count($output);$i++) $output[$i]=explode(',',$output[$i]);
	}
	elseif( isset($_POST['modify'])){
		$varHotel=$_POST['hotel'];
		$varRoom=$_POST['room'];
		$varDate=$_POST['date'];
		$index=$_POST['index'];
		$fp=fopen("reserve.csv","r");
		$output='';
		while(!feof($fp)) $output.=fgets($fp);
		fclose($fp);
		$output = explode("\n",$output);
		unset($output[count($output)-1]);
		for($i=0;$i<count($output);$i++) $output[$i]=explode(',',$output[$i]);
		$output[$index][0] = $varHotel;
		$output[$index][1] = $varRoom;
		$output[$index][2] = $varDate;
		implode(",", $output);
		$fp = fopen("reserve.csv","w");
		fwrite($fp, $output);
		fclose($fp);
	}
?>
<html>
	<?php if(!(isset($_POST['index'])&&!empty($_POST['index']))){?>
		<body style="font-size:30px">
			<form action="modify.php" method="POST">
				Requested Index<br>
			<input type="number" name="index"></br>
				Hotel
			<br>
			<input type="text" name="hotel"><br>
				Room Number
			<br>
			<input type="text" name="room"><br>
				Date
			<br>
			<input type="date" name="date"><br>
			<br>
			<button type="submit" name="request" value="request" style="font-size:25px">Request</button>
			<button type="submit" name="modify" value="modify" style="font-size:25px">Modify</button>
			</form>
		</body>
	<?php }else{?>
		<body style="font-size:30px">
			<form action="modify.php" method="POST">
				Requested Index<br>
			<input type="number" name="index" value="<?php echo $_POST['index'];?>"></br>
				Hotel
			<br>
			<input type="text" name="hotel" value="<?php print_r($output[$_POST['index']][0]);?>"><br>
				Room Number
			<br>
			<input type="text" name="room" value="<?php print_r($output[$_POST['index']][1]);?>"><br>
				Date
			<br>
			<input type="date" name="date" value="<?php print_r($output[$_POST['index']][2]);?>"><br>
			<br>
			<button type="submit" name="request" value="request" style="font-size:25px">Request</button>
			<button type="submit" name="modify" value="modify" style="font-size:25px">Modify</button>
			</form>
		</body>	
	<?php } ?>
</html>



