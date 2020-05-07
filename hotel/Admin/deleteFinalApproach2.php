<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
	$info=$db->query('SELECT * FROM hotel WHERE ID ='.$_GET['id']);
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
	
	//delete reservations for rooms in hotel
	$query='SELECT * FROM room WHERE hotelID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	while($room=$q->fetch()){
		$query='DELETE FROM reservation WHERE roomID = ?';
		$q2=$db->prepare($query);
		$q2->execute([$room['ID']]);
	}
	
	//delete rooms in hotel
	$query='DELETE FROM room WHERE hotelID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	
	//delete hotel
	$query='DELETE FROM hotel WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$id]);
	
?>
<a href="adminMain.php">Entry deleted, return to main</a>