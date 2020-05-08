<?php

	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
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
<html lang="en">
	<title>Admin Page</title>


	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>

	<body>
		<div class="card" style="width: 1270px; margin: auto;">
			<h1>ADMIN ZONE</h1>
			<a href="create.php" class="btn btn-primary">Click here to create a new Hotel</a><br>
			<a href="delete.php" class="btn btn-primary">Click here to delete a Hotel</a><br>
			<a href="modify.php" class="btn btn-primary">Click here to modify an existing Hotel</a><br><br> 
			<a href="createRoom.php" class="btn btn-primary">Click here to create new Room</a><br>
			<a href="deleteRoom.php" class="btn btn-primary">Click here to delete a Room</a><br>
			<a href="modifyRoom.php" class="btn btn-primary">Click here to modify an existing Room</a><br><br>
			<a href="createUser.php" class="btn btn-primary">Click here to add a new user</a><br>
			<a href="deleteUser.php" class="btn btn-primary">Click here to delete a user</a><br>
			<a href="modifyUser.php" class="btn btn-primary">Click here to modify an existing user</a>
			<br>
			<br>
			<a href="../index.php" class="btn btn-primary">Go Back</a>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>