<?php
	session_start();
	require_once('../functions.php');
	
	if (isset($_SESSION['email'])) {
		$user= new Customer($_SESSION['name'], $_SESSION['email']);
	}
	else{
		$user = new Customer();
	}

    if(!($user->isAdmin())){
		echo 'You do not have admin privileges on this account, click here to return to the <a href="../index.php">index page</a>';
		die();
	}
	
	if(isset($_POST['hotelID'])){
		createRoom($_POST);
	}
	
?>
<!doctype html>
<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
	<label for="hotelID">Hotel ID</label><br>
	<input type="text" id="hotelID" name="hotelID"><br>
	
	<label for="price">Price</label><br>
	<input type="text" id="price" name="price"><br>
	
	<label for="size">Size</label><br>
	<input type="text" id="size" name="size"><br>
	
	<label for="picture">Picture File Name</label><br>
	<input type="text" id="picture" name="picture"><br>
	
	<label for="description">Description</label><br>
	<textarea id="description" name="description" rows="5" cols="20"></textarea><br>
	
	<input type="submit" value="Submit">
	<a href="adminMain.php">Go Back</a>
</form>
	