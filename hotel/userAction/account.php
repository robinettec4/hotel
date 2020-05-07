<?php
	session_start();
	require_once('../lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');

	$db=Db::Connect(DB_SETTINGS);

	if (isset($_SESSION['email'])) {
		$user = new Customer($_SESSION['name'], $_SESSION['email']);
	}
	else{
		$user = new Customer();
	}
	
	if(!$user->isLogged()){
		echo 'You may not access this page unless you are logged in <a href="../index.php">return to main page</a>';
		die();
	}
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$result=$user->addCC($_POST);
		echo $result;
	}
	
?>
<!doctype html>
<html lang="en">
	<head>
	  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<title>Your Account</title>
	</head>
	<body style="margin: 25px 25px; border: 3px;">
	<?php if(!$user->isLogged()){ ?>
		<a href="userAction/signup.php" class="btn btn-primary">Click here to create an account!</a>
		<a style="position:absolute; top:25px; right:25px; text-align: right;" href="userAction/login.php" class="btn btn-primary">Click here to login to your account!</a>
	<?php } 
	if($user->isLogged()){?>
		<a href="signout.php" class="btn btn-primary">Click here to logout of your account!</a>
		<?php if ($user->isAdmin()){ ?>
			<a style="position:absolute; top:25px; right:25px; text-align:right;" href="../Admin/adminMain.php" class="btn btn-primary">Click here to access the admin zone</a>
		<?php } 
	}?>
	<div class="container">
		<h1>Reservation Viewer For <?=$user->getName()?></h1>
		<?php
			$query = 'SELECT * FROM reservation WHERE customerID = ?';
			$q=$db->prepare($query);
			$q->execute([$user->getID()]);
				
			$query = 'SELECT * FROM room WHERE ID = ?';
			$q2=$db->prepare($query);
		
			while($record=$q->fetch()){
				$q2->execute([$record['roomID']]);
				$media=$q2->fetch();
				
				$query = 'SELECT * FROM hotel WHERE ID = ?';
				$q3=$db->prepare($query);
				$q3->execute([$media['hotelID']]);
				$hotel=$q3->fetch();
				
				echo '<div class="media">
					<img src="../lib/picture/'.$hotel['picture'].'" class="mr-3" alt="'.$hotel['picture'].'" width="150">
					<div class="media-body">
						<h5 class="mt-0">'.$hotel['name'].'</h5>
						<a href="reserveDetail.php?id='.$record['ID'].'">Details</a>
					</div>
				</div>';
				echo '<hr>';
			}

			$db=null;
		?>
		<form action="account.php" method="POST">
			<h2>Register new Credit Card</h2>
			<div class="form-group">
				<label for="name">Owner</label>
                <input type="text" class="form-control" name="name" id="name">
			</div>
			<div class="form-group">
				<label for="cardNumber">Card Number</label>
                <input type="text" class="form-control" name="cardNumber" id="cardNumber">
			</div>
			<div class="form-group">
				<label for="cvv">CVV</label>
                <input type="text" class="form-control" name="cvv" id="cvv">
			</div>
			<div class="form-group">
                <label>Expiration Date</label>
                <select name="month" id="month">
                    <option value="01">January</option>
                    <option value="02">February </option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select id="year" name="year">
                    <option value="2020"> 2020</option>
                    <option value="2021"> 2021</option>
                    <option value="2022"> 2022</option>
                    <option value="2023"> 2023</option>
                    <option value="2024"> 2024</option>
                    <option value="2025"> 2025</option>
                </select>
            </div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<br>
		<a href="../index.php" class="btn btn-primary">Go back</a>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>