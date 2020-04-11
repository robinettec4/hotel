<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function is_logged(){
	if(!isset($_SESSION['username'])){
		return 0;
	}
	return 1;
}

function signup($data,$file){
	//check for database
	
	//check if user already exists
	
	//create account
}

function signin($data,$file){
	
	//check for database
	
	//check login info and login if correct
}

function signout(){
	header('location: index.php');
	session_destroy();
}