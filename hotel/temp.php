<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class Customer{
	private $name;
	private $email;
	private $pwd;
	private $userType;
	
	public function __construct($name=null, $email=null, $pwd=null){
		$this->email=$email;
		$this->pwd=$pwd;
		$this->name=$name;
	}
	
	public function isAdmin($data){
		//connect to db
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

		
		//get usertype related to email
		$user=$_SESSION[$data];
		$query='SELECT userType FROM customer WHERE email = ?';
		$q=$db->prepare($query);
		$q->execute([$user]);
		$result=$q->fetch();
		
		//if userType is 1 then it's an admin (default user is 0)
		if($result['userType'] == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	/* not implemented yet
	public function isSuperAdmin($data){
		
	}
	*/
	
	public function isLogged($data){
		return isset($_SESSION[$data]{0});
	}
	
	public function signup(){
		//connect to db
		
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
		
		//validate that the email is valid
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			echo "The email that you entered is not valid";
			die();
		}
        $this->email = strtolower($this->email);

		//check that password is at least 8 characters long
        $this->pwd = trim($this->pwd);
        if(strlen($this->pwd)<8){
			echo 'Password must be at least 8 characters long!';
			die();
		}
		
		//check that email is not already in use
        $query='SELECT id FROM customer WHERE email=?';
        $q=$db->prepare($query);
        $q->execute([$this->email]);
        if($q->rowCount()>0){
			echo 'The email entered is already registered!';
			die();
		}
        $this->pwd=password_hash($this->pwd, PASSWORD_DEFAULT);

		//put new user into db
        $query='INSERT INTO customer (name, email, password, userType) VALUES (?, ?, ?, ?)';
        $q=$db->prepare($query);
        $q->execute([$this->name, $this->email, $this->pwd, 0]);

        echo 'You have successfully registered now you can <a href="login.php">login!</a>';
		return '';
	}
	
	public function login(){
		//connect to db
		
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
		
		//check if email is even valid
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			echo "The email that you entered is not valid";
			die();
		}
        $this->email = strtolower($this->email);

        $this->pwd = trim($this->pwd);
        
        $query='SELECT password FROM customer WHERE email=?';
        $q=$pdo->prepare($query);
        $q->execute([$this->email]);

        if($q->rowCount()>0){
            $pwdArr=$q->fetch();
            $pwdDB=$pwdArr['password'];
            if(!password_verify($this->pwd, $pwdDB)){
                echo 'Password does not match!';
            }
            else{
                $_SESSION['email'] = $this->email;
                echo 'You have sucessfully signed in to your account. <a href="index.php">Welcome!</a>';
            }  
        }
        echo 'The credentials entered are not registered, you may need to <a href="../UserManagment/Signup.php">Sign Up</a>';
	}
	
	public function signout($data){
		header('location: index.php');
		session_destroy();
	}
}