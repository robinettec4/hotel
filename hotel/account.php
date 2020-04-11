<?php
	session_start();
	require_once('functions.php');
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
?>

<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Private area</title>
  </head>
  <body>
  <div class="container">
    <h1>Private area</h1>
	<p class="lead">The content of this area should be visible only to users who logged in.</p>
	<p>All users should be able to access the <a href="index.php">public area</a>.</p>
	<h4>Be careful</h4>
	<?php
	if(!is_logged()){
		?>
	<p class="lead">The following buttons should be visible in the public area</p>
	<p><a href="signup.php" class="btn btn-primary">Register an account</a> <a href="login.php" class="btn btn-primary">Access your account</a></p>
	<?php }?>
	<p class="lead">The following button should be visible in the private and public areas, instead, but only if the user is logged in</p>
	<p><a href="signout.php" class="btn btn-primary">Sign out your account</a></p>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>