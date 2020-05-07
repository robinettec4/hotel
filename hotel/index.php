<?php
	session_start();
	require_once('lib/settings.php');
	require_once(APP_ROUTE.'/functions.php');
	require_once(APP_ROUTE.'/Db.php');

	$db=Db::Connect(DB_SETTINGS);

	if (isset($_SESSION['email'])) {
		$user = new Customer($_SESSION['name'], $_SESSION['email']);
	}
	else{
		$user = new Customer();
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

		<title>Basic Hotel Room Browser</title>
			
		<script>
			$(document).ready(function(){
				$(".media").click(function(){
					$(this).hide();
				});
			});
		</script>
	</head>
	<body style="margin: 25px 25px; border: 3px;">
	<?php if(!$user->isLogged()){ ?>
		<a href="userAction/signup.php" class="btn btn-primary">Click here to create an account!</a>
		<a style="position:absolute; top:25px; right:25px; text-align: right;" href="userAction/login.php" class="btn btn-primary">Click here to login to your account!</a>
	<?php } 
	else{?>
		<a href="userAction/signout.php" class="btn btn-primary">Click here to logout of your account!</a>
		<?php if ($user->isAdmin()){ 
			echo '<a style="position:absolute; top:25px; right:800px; text-align:right;" href="Admin/adminMain.php" class="btn btn-primary">Click here to access the admin zone</a>';
		} 
		
		echo '<a href="userAction/account.php" class="btn btn-primary" style="position:absolute; top:25px; right:25px; text-align:right;">Check your account and reservations</a>';
		
	}?>
	<div class="container">
		<h1>Basic Hotel Room Browser</h1>
		<h2>click a tab to hide it</h2>
		<?php
			$result=$db->query('SELECT * FROM hotel');
				
			while($record=$result->fetch()){
				echo '<div class="media">
					<img src="lib/picture/'.$record['picture'].'" class="mr-3" alt="'.$record['name'].'" width="150">
					<div class="media-body">
						<h5 class="mt-0">'.$record['name'].'</h5>
						<a href="userAction/detail.php?id='.$record['ID'].'">Visit profile</a>
					</div>
				</div>';
				echo '<hr>';	
			}
			$db=null;
		?>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>