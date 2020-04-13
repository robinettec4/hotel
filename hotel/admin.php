<?php
session_start();
require_once('functions.php');

if(!is_admin()){
	echo 'You do not have admin privileges on this account, click here to return to the <a href="index.php">index page</a>.';
	die();
}

?>

admin zone