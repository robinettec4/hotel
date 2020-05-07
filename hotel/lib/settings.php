<?php

	define('DB_SETTINGS',[
		'host'=>'localhost',
		'db'=>'roomdb',
		'user'=>'root',
		'pass'=>''
	]);

	define('APP_ROUTE', __DIR__);
	define('APP_FOLDER', '');
	
	//change the following line to change the time zone of the server
	date_default_timezone_set('America/New_York');
	
	$currentTime = date('Y-m-d');
	define('CURR_TIME', $currentTime);
