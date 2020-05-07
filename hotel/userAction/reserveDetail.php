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

	if(!isset($_GET['id'])){
		echo 'Please enter the id of a reservation or select one via the <a href="account.php">account page</a>.';
		die();
	}
	
	//get the information about the reservation
	$query='SELECT * FROM reservation WHERE ID = ?';
	$q=$db->prepare($query);
	$q->execute([$_GET['id']]);
	$res=$q->fetch();

	//make sure user is logged in
	if(!$user->isLogged()){
		echo 'You are not the customer associated with these reservations <a href="../index.php">click here to return to main page</a>';
		die();
	}

	//make sure signed in user is the one that created the reservation
	if(!$user->isReservee($res['customerID'])){
		echo 'You are not the customer associated with these reservations <a href="../index.php">click here to return to main page</a>';
		die();
	}
	
	//get the information about the room
	$query='SELECT * FROM room WHERE ID = ?';
	$q2=$db->prepare($query);
	$q2->execute([$res['roomID']]);
	$room=$q2->fetch();
	
	//get the information about the hotel
	$query='SELECT * FROM hotel WHERE ID = ?';
	$q3=$db->prepare($query);
	$q3->execute([$room['hotelID']]);
	$hotel=$q3->fetch();
	
	//find the price of the stay using days reserved * price of the hotel
	$interval = date_diff(date_create($res['dayStart']), date_create($res['dayEnd']));
	$days=$interval->format('%R%a');
	$price=($days*$hotel['price']);

	//get credit card number for the reservation 
	$query='SELECT cardNumber FROM creditcard WHERE ID = ?';
	$q4=$db->prepare($query);
	$q4->execute([$res['creditCardID']]);
	$card=$q4->fetch();
	
	$db = null;
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

		<title><?= $hotel['name']?> Reservation</title>
	</head>
	<body>
		<div class="card" style="width: 1270px; margin: auto;">
			<img src="../lib/picture/<?=$hotel['picture'] ?>">
			<div class="card-body">
				<h5 class="card-title"><?= $hotel['name']?></h5>
				<p class="card-text">Room <?= $room['roomNumber'] ?></p>
				<p class="card-text">From <?= $res['dayStart'] ?> to <?= $res['dayEnd'] ?></p>
				<p class="card-text">For $<?= $price ?>.00 on card number <?= $card['cardNumber'] ?></p>
				<p class="card-text"><?= $hotel['description'] ?></p>
				<a href="account.php" class="btn btn-primary">Go back</a> <?php echo '<a href="reserveCancel.php?id='.$_GET['id'].'" class="btn btn-primary">Cancel Reservation</a>';?>
			</div>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>