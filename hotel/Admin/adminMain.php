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
<!doctype html><!--no page formatting yet just functional-->
<title>Admin Page</title>

<head>
</head>

<body>
	<a href="create.php">Click here to create a new Hotel</a><br>
	<a href="delete.php">Click here to delete a Hotel</a><br>
	<a href="modify.php">Click here to modify an existing Hotel</a><br>
	<a href="createRoom.php">Click here to create new Room</a><br>
	<a href="deleteRoom.php">Click here to delete a Room</a><br>
	<a href="modifyRoom.php">Click here to modify an existing Room</a><br>
	<a href="createUser.php">Click here to add a new user</a><br>
	<a href="deleteUser.php">Click here to delete a user</a><br>
	<a href="modifyUser.php">Click here to modify an existing user</a>
</body>