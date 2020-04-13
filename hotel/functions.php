<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

function is_logged(){
	if(!isset($_SESSION['username'])){
		return 0;
	}
	return 1;
}

function signup($data){
	//check if user already exists
	if(!empty($_POST)) {
		$record=$GLOBALS['db']->query('SELECT * FROM customer WHERE email = "'.$data['email'].'"');
		$result=$record->fetch();
		if (empty($result)) {
			//create account
			$GLOBALS['db']->query('INSERT INTO customer (name, email, password) VALUES ("'.$data['name'].'","'.$data['email'].'","'.$data['password'].'")');
		}
		else {
			echo 'That email is already registered!';
		}
	}
}

function signin($data){
	//check login info and login if correct
	if(!empty($_POST)) {
		$record=$GLOBALS['db']->query('SELECT * FROM customer WHERE email = "'.$data['email'].'"');
		$result=$record->fetch();
		if(!empty($result)) {
			if($result['password']==$data['password']) {
				echo "Congratulations, you are logged in as ".$result['name']."\n";
				echo 'Click here to return to <a href="index.php">index</a>';
				$_SESSION['username']=$data['email'];
				return'';
			}
		}
	}
}

function signout(){
	header('location: index.php');
	session_destroy();
}

function is_admin(){
	if(is_logged()){
		$record=$GLOBALS['db']->query('SELECT * FROM customer WHERE email= "'.$_SESSION['username'].'"');
		$result=$record->fetch();
		$id=$result['ID'];
		$record2=$GLOBALS['db']->query('SELECT * FROM admin WHERE  customerID='.$id);
		$result2=$record2->fetch();
		if (empty($result2)){
			return 0;
		}
		else {
			return 1;
		}
	}
}