<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
	$info=$db->query('SELECT * FROM hotel');
	
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
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Non-Profit Connections</title>

		<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<!-- Custom styles for this template -->
		<link href="Styles/custom.css" rel="stylesheet">
	</head>

	<body>
		<main role="main" class="container">

			<div class="template">
				<?php
					while($row=$info->fetch()){
					echo '<div class="card" style="width: 20rem;">
						<div class="card-body">
							<h5 class="card-title">'.$row['name'].'</h5>
							<h6 class="card-subtitle mb-2 text-muted">Address: '.$row['address'].' <br>Email: '.$row['email'].'</h6>
							<p class="card-text">Rooms: '.$row['availableRooms'].'</p>
							<a href="deleteFinal.php?id='.$row['ID'].'" class="card-link">More Details</a>
						</div>
					</div>
					<hr>';
					}
				?>
			</div>
			<a href="adminMain.php" class="btn btn-primary">Go Back</a>

		</main><!-- /.container -->

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="../../assets/js/vendor/popper.min.js"></script>
		<script src="../../dist/js/bootstrap.min.js"></script>
	</body>
</html>