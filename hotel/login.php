<?php

/*
1. show signin form
2. when the user submits the data we:*/
function signin(){
	if(count($_POST>0)){
	//2.1 we check if the email is there and it's valid
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			return 'The email is invalid';
		}
		$_POST['email']=strtolower($_POST['email']);
	//2.2 we check if the password is there and it's valid	
		$_POST['password']=trim($_POST['password']);
		if(strlen($_POST['password'])<8){
			return 'The password is invalid';
		}
	//2.3 check if email is in database
		$h=fopen('accounts.csv','r');
		while(!feof($h)){
			$line=fgets($h);
			if(strstr($line,$_POST['email'])){
				//2.4 check if the password matches the password entered by the user: https://www.php.net/manual/en/function.password-verify.php	
				$split=explode('\n',$line);
				$hash=$split[1];
				if(password_verify($_POST['password'], $hash)){
					echo 'Congratulations';
					return '';
				}
				else{
					echo 'bad';
					return '';
				}
			}
		}
	//2.5 we congratulate the user on their life achievement
	}
	
}

?>
<form action="signin.php" method="POST">
	E-mail
	<input type="email" name="email" required /><br />
	Password
	<input type="password" name="password" required minlength="8" /><br />
	<button type="submit">Sign In</button>
</form>