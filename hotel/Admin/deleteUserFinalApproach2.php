<?php
	session_start();
	include_once('../functions.php');

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
	//connecting to database
	$pdo = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4',
	$settings['user'],$settings['password'],$opt);
	$info=$pdo->query('SELECT * FROM customer WHERE id='.$_GET['id']);
	$row=$info->fetch();
	
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
	
	$id=$_GET['id'];
	$pdo = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4', $settings['user'],$settings['password'],$opt);
	$query='DELETE FROM customer WHERE id = "'.$id.'"';
	$q=$pdo->query($query);
	
?>
<a href="adminMain.php">Entry deleted, return to main</a>