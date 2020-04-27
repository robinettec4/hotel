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

function createDb($data){
	$settings=[
		'host'=>'localhost',
		'db'=>'roomdb',
		'user'=>'root',
		'pass'=>''
	];
				
	$opt=[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];

	$pdo= new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4', $settings['user'], $settings['pass'], $opt);

	if(isset($data['streetName'])){
        $query='INSERT INTO hotel (name, address, email, picture) VALUES (?, ?, ?, ?)';
        $q=$pdo->prepare($query);
        $q->execute([$data['name'], $data['address'], $data['email'], $data['picture']]);
	}
	
}

function modify($data, $table){
	$settings=[
		'host'=>'localhost',
		'db'=>'roomdb',
		'user'=>'root',
		'pass'=>''
	];
				
	$opt=[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];

	$pdo= new PDO('mysql:host='.$settings['host'].';dbname='.$settings['db'].';charset=utf8mb4', $settings['user'], $settings['pass'], $opt);

	if(isset($data['edit'])){
		if(strcmp($data['drop'],"password")==0){
			$data['edit'] = trim($data['edit']);
			$data['edit']= password_hash($data['edit'], PASSWORD_DEFAULT);
		}
		
		$query='UPDATE '.$table.' SET '.$data['drop'].'="'.$data['edit'].'" WHERE id = "'.$data['id'].'"';
		$q=$pdo->prepare($query);
		$q->execute();
		echo 'information successfully edited';
	}
}

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
	
	public function isAdmin(){
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
		$user=$_SESSION['email'];
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
	
	public function isReservee($data){
		//connect to database
	
		//check if customerID in reservation is == to customer ID (primary key)
	}
	
	

	
	public function isLogged(){
		return isset($_SESSION['email']{0});
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
		echo $this->email;
		echo $this->pwd;
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
        $q=$db->prepare($query);
        $q->execute([$this->email]);

        if($q->rowCount()>0){
            $pwdArr=$q->fetch();
            $pwdDB=$pwdArr['password'];
            if(!password_verify($this->pwd, $pwdDB)){
                echo 'Password does not match!';
				die();
            }
            else{
                $_SESSION['email'] = $this->email;
				$query='SELECT name FROM customer WHERE email=?';
				$q=$db->prepare($query);
				$q->execute([$_SESSION['email']]);
				$nameArr=$q->fetch();
				$_SESSION['name']=$nameArr['name'];
                echo 'You have sucessfully signed in to your account. <a href="index.php">Welcome!</a>';
				die();
            }  
        }
        echo 'The credentials entered are not registered, you may need to <a href="signup.php">Sign Up</a>';
	}
	
	public function signout(){
		header('location: index.php');
		session_destroy();
	}
	
	public function reserve($data){
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
		
		//check if room is free during date
		
		$query='SELECT ID FROM room WHERE hotelID = ?';
		$q=$db->prepare($query);
		$q->execute([$data['hotelID']]);
		
		//get entries of all rooms in hotel
		while($room=$q->fetch()){
			//find day start
			$queryDayB='SELECT dayStart FROM reservation WHERE roomID = ?';
			//find day end
			$queryDayE='SELECT dayEnd FROM reservation WHERE roomID = ?';
			
			$qdb=$db->prepare($queryDayB);
			$qdb->execute([$room['id']]);
			$dayStart=$qdb->fetch();
			$dayStart=$qdbF['dayStart'];
			
			$qde=$db->prepare($queryDayE);
			$qde->execute([$room['id']]);
			$qdeF=$qde->fetch();
			$dayEnd=$qdeF['dayEnd'];
			
			//check if either start or end are between the start and end of an existing reservation for each room
			while($dayStart=$qdb->fetch() && $dayEnd=$qde->fetch()){
				$query='SELECT * FROM reservation WHERE  roomID = ? AND ? BETWEEN ? AND ?';
				$query2='SELECT * FROM reservation WHERE  roomID = ? AND ? BETWEEN ? AND ?';
				
				$qf=$db->prepare($query);
				$qf2=$db->prepare($query2);
				
				$qf->execute([$room['id'], $data['dayStart'], $dayStart, $dayEnd]);
				$qf2->execute([$room['id'], $data['dayEnd'], $dayStart, $dayEnd]);
				if($qf->rowCount()>0 && $qf2->rowCount()>0){
					//create reservation
					$query = 'INSERT INTO reservation (roomID, customerID, numberOfGuests, dayStart, dayEnd, creditCardID) VALUES (?, ?, ?, ?, ?, ?)';
					$qi=$db->prepare($query);
					$qi->execute([$room['id'], $this->id, $data['guests'], $data['dayStart'], $data['dayEnd'], $data['creditCardID']]);
					echo 'Reservation created!';
					die();
				}
			}
		}
		echo 'There are no available rooms in this hotel for those dates';
		die();
	}

}