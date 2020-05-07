<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//admin create hotel entry
	function createDb($data){
		require_once('settings.php');
		require_once(APP_ROUTE.'/functions.php');
		require_once(APP_ROUTE.'/Db.php');

		$db=Db::Connect(DB_SETTINGS);
		if(isset($data['address']) && isset($data['email']) && isset($data['name']) && isset($data['price'])){
			$query='INSERT INTO hotel (name, address, email, picture, price, description, size) VALUES (?, ?, ?, ?, ?, ?, ?)';
			$q=$db->prepare($query);
			$q->execute([$data['name'], $data['address'], $data['email'], $data['picture'], $data['price'], $data['description'], $data['size']]);
			return '<div class="alert alert-success" role="alert">The hotel entry has been created</div>';
		}
		return '<div class="alert alert-danger" role="alert">One or more required fields were left unfilled! Please try again</div>';
	}

	//admin create room entry
	function createRoom($data){
		require_once('settings.php');
		require_once(APP_ROUTE.'/functions.php');
		require_once(APP_ROUTE.'/Db.php');

		$db=Db::Connect(DB_SETTINGS);

		
		$query='SELECT * FROM hotel WHERE ID = ?';
		$q=$db->prepare($query);
		$q->execute([$data['hotelID']]);
		
		if($q->rowCount()>0){
			$query='INSERT INTO room (hotelID, roomNumber) VALUES (?, ?)';
			$q=$db->prepare($query);
			$q->execute([$data['hotelID'], $data['roomNumber']]);
			
			echo '<div class="alert alert-success" role="alert">The room entry has been created</div>';
			
			//update room count
			$query='SELECT * FROM room WHERE hotelID = ?';
			$q=$db->prepare($query);
			$q->execute([$data['hotelID']]);
			$roomCount=$q->rowCount();
			$query='UPDATE hotel SET availableRooms = ? WHERE ID = ?';
			$q=$db->prepare($query);
			$q->execute([$roomCount, $data['hotelID']]);
			
			return '<div class="alert alert-success" role="alert">The hotel room availability entry has been updated</div>';
		}
		else{
			return '<div class="alert alert-danger" role="alert">Hotel ID must match an existing Hotel</div>';
		}
	}

	//admin create user account
	function createUser($data){
		require_once('settings.php');
		require_once(APP_ROUTE.'/functions.php');
		require_once(APP_ROUTE.'/Db.php');

		$db=Db::Connect(DB_SETTINGS);

		if(isset($data['userType'])){
			if(!filter_var($data['email2'], FILTER_VALIDATE_EMAIL)) return "The email that you entered is not valid";
			$data['email2'] = strtolower($data['email2']);

			$data['password'] = trim($data['password']);
			if(strlen($data['password'])<8) return '<div class="alert alert-danger" role="alert">Password must be at least 8 characters long!</div>';

			$query='SELECT ID FROM customer WHERE email=?';
			$q=$db->prepare($query);
			$q->execute([$data['email2']]);

			if($q->rowCount()>0) return '<div class="alert alert-danger" role="alert">The email entered is already registered!</div>';

			$data['password']=password_hash($data['password'], PASSWORD_DEFAULT);

			$query='INSERT INTO customer (name, email, password, userType) VALUES (?, ?, ?, ?)';
			$q=$db->prepare($query);
			$q->execute([$data['name'], $data['email2'], $data['password'], $data['userType']]);

			return '<div class="alert alert-success" role="alert">User registered</div>';
		}
	}

	//admin modify existing table entries
	function modify($data, $table){
		require_once('settings.php');
		require_once(APP_ROUTE.'/functions.php');
		require_once(APP_ROUTE.'/Db.php');

		$db=Db::Connect(DB_SETTINGS);

		if(isset($data['edit'])){
			if(strcmp($data['drop'],"password")==0){
				$data['edit'] = trim($data['edit']);
				$data['edit']= password_hash($data['edit'], PASSWORD_DEFAULT);
			}
			
			$query='UPDATE '.$table.' SET '.$data['drop'].' = ? WHERE ID = ?';
			$q=$db->prepare($query);
			$q->execute([$data['edit'], $data['id']]);
			return '<div class="alert alert-success" role="alert">information successfully edited</div>';
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
		
		//get user id
		public function getID(){
			$db=Db::Connect(DB_SETTINGS);
			$query='SELECT ID FROM customer WHERE email = ?';
			$q=$db->prepare($query);
			$q->execute([$this->email]);
			$id=$q->fetch();
			return $id['ID'];
		}
		
		//get user name
		public function getName(){
			return $this->name;
		}
		
		//check if user is an admin
		public function isAdmin(){
			//connect to db
			require_once('settings.php');
			require_once(APP_ROUTE.'/functions.php');
			require_once(APP_ROUTE.'/Db.php');
		
			$db=Db::Connect(DB_SETTINGS);

			
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
		
		//check if logged in user is the one that created reservation
		public function isReservee($data){
			//check if customerID in reservation is == to customer ID (primary key)
			if($this->getID() != $data){
				return false;
			}
			return true;
		}
		
		//check if a user is logged in
		public function isLogged(){
			return isset($_SESSION['email']{0});
		}

		//create an account for the user
		public function signup(){
			//connect to db
			require_once('settings.php');
			require_once(APP_ROUTE.'/functions.php');
			require_once(APP_ROUTE.'/Db.php');
		
			$db=Db::Connect(DB_SETTINGS);
			
			//validate that the email is valid
			if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
				return '<div class="alert alert-danger" role="alert">The email that you entered is not valid</div>';
			}
			$this->email = strtolower($this->email);

			//check that password is at least 8 characters long
			$this->pwd = trim($this->pwd);
			if(strlen($this->pwd)<8){
				return '<div class="alert alert-danger" role="alert">Password must be at least 8 characters long!</div>';
			}
			
			//check that email is not already in use
			$query='SELECT id FROM customer WHERE email=?';
			$q=$db->prepare($query);
			$q->execute([$this->email]);
			if($q->rowCount()>0){
				return '<div class="alert alert-danger" role="alert">The email entered is already registered!</div>';
			}
			$this->pwd=password_hash($this->pwd, PASSWORD_DEFAULT);

			//put new user into db
			$query='INSERT INTO customer (name, email, password, userType) VALUES (?, ?, ?, ?)';
			$q=$db->prepare($query);
			$q->execute([$this->name, $this->email, $this->pwd, 0]);

			return '<div class="alert alert-success" role="alert">You have successfully registered now you can <a href="login.php">login!</a></div>';
		}

		//log user into their account
		public function login(){
			//connect to db
			require_once('settings.php');
			require_once(APP_ROUTE.'/functions.php');
			require_once(APP_ROUTE.'/Db.php');
		
			$db=Db::Connect(DB_SETTINGS);
			
			//check if email is even valid
			if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
				return '<div class="alert alert-danger" role="alert">The email that you entered is not valid</div>';
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
					return '<div class="alert alert-danger" role="alert">Password does not match!</div>';
				}
				else{
					$_SESSION['email'] = $this->email;
					$query='SELECT name FROM customer WHERE email=?';
					$q=$db->prepare($query);
					$q->execute([$_SESSION['email']]);
					$nameArr=$q->fetch();
					$_SESSION['name']=$nameArr['name'];
					return '<div class="alert alert-success" role="alert">You have succesfully signed in! <a href="../index.php">click here to return to main page</a></div>';
				}  
			}
			return '<div class="alert alert-danger" role="alert">The credentials entered are not registered, you may need to <a href="signup.php">Sign Up</a></div>';
		}
		
		//signout user from current account
		public function signout(){
			header('location: ../index.php');
			session_destroy();
		}

		//create a reservation for user
		public function reserve($data){

			if(!isset($data['creditCardID'])){
				return '<div class="alert alert-danger" role="alert">You must select a credit card to pay for this reservation. If have no cards to select from you can add one to your account <a href="account.php">here</a></div>';
			}
			if($data['end']<$data['start']){
				return '<div class="alert alert-danger" role="alert">THE END DATE IS BEFORE THE START DATE PLEASE TRY AGAIN</div>';
			}
			
			if($data['start'] < CURR_TIME){
				return '<div class="alert alert-danger" role="alert">YOUR DESIRED VISIT HAS ALREADY PASSED</div>';
			}
			
			//connect to db
			require_once('settings.php');
			require_once(APP_ROUTE.'/functions.php');
			require_once(APP_ROUTE.'/Db.php');
		
			$db=Db::Connect(DB_SETTINGS);
			
			//check if a room is free during date
			
			$query='SELECT * FROM room WHERE hotelID = ?';
			$q=$db->prepare($query);
			$q->execute([$data['hotelID']]);
			
			
			//get entries of all rooms in hotel
			while($room=$q->fetch()){
				$flag = 0;
				//find day start and day end
				$query='SELECT dayStart, dayEnd FROM reservation WHERE roomID = ?';

				$q2=$db->prepare($query);
				$q2->execute([$room['ID']]);

				//check if start is before and existing end
				while(!$flag && $day=$q2->fetch()){
					
					$query='SELECT * FROM reservation WHERE  roomID = ? AND (? <= ?)';
					$q3=$db->prepare($query);
					$q3->execute([$room['ID'], $data['start'], $day['dayEnd']]);
					
					//if start is before a reservation end, see if end is also after reservation beginning
					if ($q3->rowCount()>0){
						
						$query='SELECT * FROM reservation WHERE roomID = ? AND (? >= ?)';
						$q3=$db->prepare($query);	
						$q3->execute([$room['ID'], $data['end'], $day['dayStart']]);
				
						if ($q3->rowCount()>0){
							$flag = 1;
						}
					}
				}
				if(!$flag){
					//create reservation
					$query = 'INSERT INTO reservation (roomID, customerID, dayStart, dayEnd, creditCardID) VALUES (?, ?, ?, ?, ?)';
					$qi=$db->prepare($query);
					$qi->execute([$room['ID'], $this->getID(), $data['start'], $data['end'], $data['creditCardID']]);
					return '<div class="alert alert-success" role="alert">Reservation created for room '.$room['roomNumber'].'</div>';
					
				}
			}
			return '<div class="alert alert-danger" role="alert">There are no available rooms in this hotel for those dates</div>';
		}
		
		//user adds a credit card to their account
		public function addCC($data){
			if(!is_numeric($data['cvv']) OR strlen($data['cvv']) != 3){
				return '<div class="alert alert-danger" role="alert">Something is wrong with the cvv</div>';
			}
			
			if(!is_numeric($data['cardNumber']) OR strlen($data['cardNumber']) != 16){
				return '<div class="alert alert-danger role="alert">Something is wrong with the card number</div>';
			}
			
			$date=$data['year'].'-'.$data['month'].'-01';
			
			$db=Db::Connect(DB_SETTINGS);
			
			$query='INSERT INTO creditcard (customerID, cardNumber, cardExpiration, cardSecurityNumber, cardHolder) VALUES (?, ?, ?, ?, ?)';
			$q=$db->prepare($query);
			$q->execute([$this->getID(), $data['cardNumber'], $date, $data['cvv'], $data['name']]);
			return '<div class="alert alert-success" role="alert">Credit Card Record Added</div>';
		}
	}
