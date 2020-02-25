<?php
	if( isset($_POST['index'])&&!empty($_POST['index'])){
		$index=$_POST['index'];
		$fp=fopen("reserve.csv","r");
		$output='';
		while(!feof($fp)) $output.=fgets($fp);
		fclose($fp);
		$output = explode("\n",$output);
		unset($output[count($output)-1]);
		unset($output[$index]);
		$fp=fopen("reserve.csv","w");
		implode("\n",$output);
		fwrite($fp, $output);
		fclose($fp);
	}
?>
<html>
	<body style="font-size:30px">
		<form action="delete.php" method="POST">
			Requested Index<br>
		<input type="number" name="index"></br>
		<button type="submit" value="Submit" style="font-size:25px">Submit</button>
		</form>
	</body>
</html>