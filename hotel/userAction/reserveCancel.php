<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
	$query='SELECT * FROM reservation WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$_GET['id']]);
	$res=$q->fetch();
	
	if (isset($_SESSION['email'])) {
		$user= new Customer($_SESSION['name'], $_SESSION['email']);
	}
	else{
		$user = new Customer();
	}
	
	if(!($user->isReservee($res['customerID']))){
		echo 'You do not have privileges to delete this reservation on this account, click here to return to the <a href="../index.php">index page</a>';
		die();
	}
	
	$id=$_GET['id'];
	$query='DELETE FROM reservation WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	
?>
<a href="account.php">Reservation deleted, return to account page</a>