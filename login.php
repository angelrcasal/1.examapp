<?php
	require_once("function.php");
	
	//RESTRICTION - NOT LOGGED IN
	if(isset($_SESSION["user_id"])){
		//redirect user to restricted page
		header("Location: group_work_masha_angel.php");
	}
	
	//login button clicked
	if(isset($_POST["login"])){
		
		//login
		
		echo "logging in ...";
		
		//the username and password are not empty
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
			
			//save to db
			
			login($_POST["username"], $_POST["password"]);
			
		}else{
			
			echo "both fields are required!";
			
		}
		
	
	//signup button clicked
	}else if(isset($_POST["signup"])){
		
		//signup
		
		echo "signing up ...";
		
		//the username and password are not empty
		if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["name"])){
			
			//save to db
			
			signup($_POST["username"], $_POST["password"], $_POST["name"]);
			
		}else{
			
			echo "both fields are rquired!";
			
		}
		
		
	}
?>



<h1>Log in</h1>
<form method="POST">
	
	<input type="text" placeholder="username" name="username">
	<input type="password" placeholder="password" name="password">
	
	<input type="submit" name="login" value="Log in">
	
</form> 


<h1>Sign up</h1>
<form method="POST">
	
	<input type="text" placeholder="First and Last name" name="name">
	<input type="text" placeholder="username" name="username">
	<input type="password" placeholder="password" name="password">
	
	<input type="submit" name="signup" value="Sign up">
	
</form>

