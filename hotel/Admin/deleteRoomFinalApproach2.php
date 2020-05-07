<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
	$info=$db->query('SELECT * FROM customer WHERE id='.$_GET['id']);
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
	
	//delete any reservations for the target user
	$query='DELETE FROM reservation WHERE roomID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	
	//delete entry
	$query='DELETE FROM room WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	
?>
<a href="adminMain.php">Entry deleted, return to main</a>