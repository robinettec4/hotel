<?php

	session_start();
	require_once('../lib/auth_lib.php');
	
	$user = new User();
    if(!($user->isAdmin('email'))){
		echo 'You do not have admin privileges on this account, click here to return to the <a href="../index.php">index page</a>';
		die();
	}
	

?>
<!doctype html><!--no page formatting yet just functional-->
<title>Admin Page</title>

<head>
</head>

<body>
	<a href="create.php">Click here to create a new non-profit</a><br>
	<a href="delete.php">Click here to delete a non-profit</a><br>
	<a href="modify.php">Click here to modify an existing non-profit</a><br>
	<a href="createUser.php">Click here to add a new user</a><br>
	<a href="deleteUser.php">Click here to delete a user</a><br>
	<a href="modifyUser.php">Click here to modify an existing user</a>
</body>