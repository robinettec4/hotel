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
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$result=modify($_POST, 'hotel');
		echo $result;
	}
	
    if(!($user->isAdmin())){
		echo 'You do not have admin privileges on this account, click here to return to the <a href="../index.php">index page</a>';
		die();
	}
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
			<h1>Modify Existing Hotel Entry</h1>
			<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
				<div class="form-group">
					<label for="drop">Select Field to Edit</label>
					<select id="drop" name="drop" class="form-control">
						<option value = "name">Name</option>
						<option value = "address">Address</option>
						<option value = "email">Email</option>
						<option value = "picture">Picture Filename</option>
						<option value = "price">Price Per Night</option>
						<option value = "description">Description</option>
						<option value = "size">Guests Per Room</option>
					</select>
				</div>
				<div class="form-group">
					<label for="id">Enter ID of Entry to Edit</label>
					<input type="number" min="1" id="id" name="id" class="form-control">
				</div>
				<div class="form-group">
					<label for="edit">Information to Insert</label>
					<textarea id="edit" name="edit" rows="4" cols="65" class="form-control"></textarea>
				</div>
				<input type="submit" value="Submit" class="btn btn-primary"> <a href="adminMain.php" class="btn btn-primary">Go Back</a>
			</form>
		</div>
		
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>