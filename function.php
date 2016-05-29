<?php
	
	require_once("../../config.php");
	
	//start server session to store data
	//in every file you want to access session
	//you should require functions
	session_start();
	
	function login($user, $pass){
		
		//hash the password
		$pass = hash("sha512", $pass);
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		$stmt = $mysql->prepare("SELECT id, name FROM users WHERE username=? and password=?");
		
		echo $mysql->error;
		
		$stmt->bind_param("ss", $user, $pass);
		
		$stmt->bind_result($id, $name);
		
		$stmt->execute();
		
		//get the data
		if($stmt->fetch()){
			echo "user with id ".$id." logged in!";
			
			//create session variables 
			//redirect user
			$_SESSION["user_id"] = $id;
			$_SESSION["name"] = $name;
			$_SESSION["username"] = $user;
			
			header("Location: restrict.php");
			
			
		}else{
			// username was wrong or password was wrong or both
			echo $stmt->error;
			echo "wrong credentials";
		}
		
	}
	function signup($user, $pass, $name){
		
		//hash the password
		$pass = hash("sha512", $pass);
		
		
		// GLOBALS - access outside variable in function
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		$stmt = $mysql->prepare("INSERT INTO users (username, password, name) VALUES (?, ?, ?) ");
		
		echo $mysql->error;
		
		$stmt->bind_param("sss", $user, $pass, $name);
		
		if($stmt->execute()){
			echo "user saved successfully!";
		}else{
			echo $stmt->error;
		}
		
	}
	function saveInterest($interest){
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		$stmt = $mysql->prepare("INSERT INTO interests (name) VALUE (?)");
		
		echo $mysql->error;
		
		$stmt->bind_param("s", $interest1);
		
		if($stmt->execute()){
			echo "interest saved successfully!";
		}else{
			echo $stmt->error;
		}
		
	}
	
	
	function createInterestDropdown(){
		
		//query all interests
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		$stmt = $mysql->prepare("SELECT id, name FROM interests1 ORDER BY name ASC");
		
		echo $mysql->error;
		
		$stmt->bind_result($id, $name);
		
		$stmt->execute();
		
		
		//dropdown html
		$html = "<select name='users_interest'>";
		
		//for each interest
		while($stmt->fetch()){
			$html .= "<option value='".$id."'>".$name."</option>";
		}
		
		$html .= "</select>";
		
		echo $html;
	}
	
	
	function saveUserInterest($interest_id){
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		
		//if user already has the interest
		$stmt = $mysql->prepare("SELECT id FROM users_interests WHERE user_id = ? and interests1_id = ?");
		echo $mysql->error;
		$stmt->bind_param("ii", $_SESSION["user_id"], $interest_id);
		$stmt->execute();
		
		if($stmt->fetch()){
			// it existed
			echo "you already have this interest";
			return; //stop it there
		}
		$stmt->close();
		
		
		
		
		$stmt = $mysql->prepare("INSERT INTO users_interests (user_id, interests_id) VALUES (?, ?)");
		
		echo $mysql->error;
		
		//$_SESSION["user_id"] logged in user ID
		$stmt->bind_param("ii", $_SESSION["user_id"], $interest_id);
		
		if($stmt->execute()){
			echo "save successfully";
		}else{
			echo $stmt->error;
		}
		
	}
	
	
	function createUserInterestList(){
		
		
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_angcas");
		
		$stmt = $mysql->prepare("
			SELECT interests.name FROM users_interests
			INNER JOIN interests ON
			users_interests1.interests_id = interests.id
			WHERE users_interests.user_id = ?
		");
		
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($interest1);
		
		$stmt->execute();
		
		$html = "<ul>";
		
		//for each interest
		while($stmt->fetch()){
			$html .= "<li>".$interest1."</li>";
		}
		
		$html .= "</ul>";
		
		echo $html;
		
	}
	
	
	/*$name = "Romil";
	
	hello($name, "thursday", 7);
	hello("Toomas", "esmaspäev", 1);
	
	function hello($recieved_name, $day_of_the_week, $day){
		echo "hello ".$recieved_name."!";
		echo "<br>";
		echo "Today is ".$day_of_the_week." ".$day;
		echo "<br>";
	}*/
?>

