<?php
session_start();
require_once('functions.php');

$settings=[
	'host'=>'localhost',
	'db'=>'roomdb',
	'user'=>'root',
	'pass'=>''
];

$opt=[
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES=>false,
];

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Basic Hotel Room Browser</title>
  </head>
  <body style="margin: 25px 25px; border: 3px;">
  <a href="signup.php" class="btn btn-primary">Click here to create an account!</a>
  <a style="position:absolute; top:25px; right:25px; text-align: right;" href="login.php" class="btn btn-primary">Click here to login to your account!</a>
  <div class="container">
    <h1>Basic Hotel Room Browser</h1>
	<?php
	$db = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4',$settings['user'],$settings['pass'], $opt);

	$result=$db->query('SELECT * FROM hotel');
	
	while($record=$result->fetch()){
		echo '<div class="media">
			<img src="'.$record['picture'].'" class="mr-3" alt="'.$record['name'].'" width="150">
			<div class="media-body">
				<h5 class="mt-0">'.$record['name'].'</h5>
				<a href="detail.php?id='.$record['ID'].'">Visit profile</a>
			</div>
		</div>';
		echo '<hr>';	
	}

	$db=null;
	
	if(is_logged()){
	?>
	
	<a href="create.php">Click here to reserve a room!</a>
	<?php } ?>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>