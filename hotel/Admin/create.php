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
	
	
?>
<!doctype html>
<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
	<label for="Name">Name</label><br>
	<input type="text" id="Name" name="Name"><br>
	
	<label for="address">Address</label><br>
	<input type="text" id="address" name="address"><br>
	
	<label for="state">State</label><br>
	<input type="text" id="state" name="state"><br>
	
	<label for="email">E-mail</label><br>
	<input type="text" id="email" name="email"><br>
	
	<label for="picture">Picture Link</label><br>
	<input type="text" id="picture" name="picture"><br>
	
	<input type="submit" value="Submit">
</form>
	