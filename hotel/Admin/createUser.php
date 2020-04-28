<?php

	session_start();
	require_once('../functions.php');
	
	$settings=[
		'host'=>'localhost',
		'db'=>'roomdb',
		'user'=>'root',
		'password'=>''
	];

	$opt=[
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false
	];
	$pdo = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4',$settings['user'],$settings['password'],$opt);
	
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
	
	createUser($_POST);
	

?>
<!doctype html>
<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
	<label for="name">Name</label><br>
	<input type="text" id="name" name="name"><br>
	
	<label for="email2">Email</label><br>
	<input type="text" id="email2" name="email2"><br>
	
	<label for="password">Password</label><br>
	<input type="text" id="password" name="password"><br>
	
	<label for="userType">User Type</label><br>
	<input type="text" id="userType" name="userType"><br>
	
	<input type="submit" value="Submit">
	<a href="adminMain.php">Go Back</a>
</form>