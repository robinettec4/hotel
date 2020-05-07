<?php

	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
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
	
	$result=createUser($_POST);
	echo $result;

?>
<!doctype html>
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
		<div class="container">
		<h1>Create New User</h1>
			<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" id="name" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="email2">Email</label>
					<input type="text" id="email2" name="email2" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="text" id="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="userType">User Type</label>
					<input type="text" id="userType" name="userType" class="form-control">
				</div>
				<input type="submit" value="Submit" class="btn btn-primary">
				<a href="adminMain.php" class="btn btn-primary">Go Back</a>
			</form>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>