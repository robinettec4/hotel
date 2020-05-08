<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');
	
	$db=Db::Connect(DB_SETTINGS);
	$query='SELECT * FROM room WHERE ID = ?';
	$info=$db->prepare($query);
	$info->execute([$_GET['id']]);
	$row=$info->fetch();
	
	$query='SELECT * FROM hotel WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$row['hotelID']]);
	$hotel=$q->fetch();
	
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


		<title>Room <?= $row['roomNumber']?></title>

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
					echo '<div>
						<h3>Room Number '.$row['roomNumber'].'</h3>
						<h5>Contact Information</h5>
						<p>Room ID '.$row['ID'].'<br>Hotel '.$hotel['name'].'<br>
					</div>
					<a href="deleteUserFinalApproach2.php?id='.$_GET['id'].'" type="button">Delete</button>';
				?>
			</div>
			<a href="deleteUser.php">Go Back</a>

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