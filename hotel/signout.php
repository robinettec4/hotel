<?php
session_start();
require_once('functions.php');

if (isset($_SESSION['email'])) {
	$user= new Customer($_SESSION['name'], $_SESSION['email']);
}
else{
	$user = new Customer();
}


$user->signout();
?>