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

	$resultHotel=$db->query('SELECT * FROM hotel WHERE ID = '.$_GET['id']);
	$recordHotel=$resultHotel->fetch();
	$resultRoom=$db->query('SELECT * FROM room WHERE hotelID = '.$_GET['id']);
	$recordRoom=$resultRoom->fetch();


	if(!isset($_GET['id'])){
		echo 'Please enter the id of a member or visit the <a href="index.php">index page</a>.';
		die();
	}
	
	$_POST['hotelID'] = $_GET['id'];

	if(isset($_POST['start'])){
		$result=$user->reserve($_POST);
		echo $result;
	}
?>
<!doctype html>
<html lang="en">
	<head>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<title><?= $recordHotel['name']?></title>
	</head>
	<body>
		<div class="card" style="width: 1270px; margin: auto;">
			<img src="../lib/picture/<?=$recordHotel['picture'] ?>">
			<div class="card-body">
				<h5 class="card-title"><?= $recordHotel['name']?></h5>
				<p class="card-text"><?= $recordHotel['description'] ?></p>
				
				<form action="reserve.php?id=<?= $_GET['id'] ?>" method="post">
					<h2>Enter Reservation Information</h2>
					<div class="form-group">
						<label>Visit Start</label>
						<input type="date" class="form-control" name="start" id="start" value="<?=CURR_TIME?>" min="<?=CURR_TIME?>">
					</div>
					<div class="form-group">
						<label>Visit End</label>
						<input type="date" class="form-control" name="end" id="end" value="<?=CURR_TIME?>" min="<?=CURR_TIME?>">
					</div>
					<div class="form-group">
						<label>Credit Card</label>
						<select id="creditCardID" name="creditCardID">
							<?php 
								$query='SELECT * FROM creditcard WHERE customerID = ?';
								$q=$db->prepare($query);
								$q->execute([$user->getID()]);
								while($card=$q->fetch()){
									echo '<option value="'.$card['ID'].'">'.$card['cardNumber'].'</option>';
								}
							?>
						</select><br>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<a href="../index.php" class="btn btn-primary">Go Back</a>
				</form>
			</div>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>