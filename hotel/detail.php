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

$db = new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4',$settings['user'],$settings['pass'], $opt);

$resultHotel=$db->query('SELECT * FROM hotel WHERE ID = '.$_GET['id']);
$recordHotel=$resultHotel->fetch();
$resultRoom=$db->query('SELECT * FROM room WHERE hotelID = '.$_GET['id']);
$recordRoom=$resultRoom->fetch();


if(!isset($_GET['id'])){
	echo 'Please enter the id of a member or visit the <a href="index.php">index page</a>.';
	die();
}

$db = null;
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?= $recordHotel['name']?></title>
  </head>
  <body>
	  <div class="card" style="width: 1270px; margin: auto;">
		<img src="<?= $recordRoom['picture'] ?>">
		<div class="card-body">
			<h5 class="card-title"><?= $recordHotel['name']?></h5>
			<p class="card-text"><?= $recordRoom['description'] ?></p> 
			<a href="index.php" class="btn btn-primary">Go back</a>	<a href="reserve.php" class="btn btn-primary">Reserve</a>
		</div>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>