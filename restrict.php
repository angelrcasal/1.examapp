<?php
	//we need functions for dealing with session
	require_once("group_work_masha_angel.php");

	
	//RESTRICTION - LOGGED IN
	if(!isset($_SESSION["user_id"])){
		//redirect not logged in user to login page
		header("Location: login.php");
	}
	
	//?logout is in the URL
	if(isset($_GET["logout"])){
		//delete the session
		session_destroy();
		
		header("Location: login.php");
	}
	
	//someone clicked the button "add"
	if(isset($_GET["add_new_interest"])){
		
		if(!empty($_GET["new_interest"])){
			
			saveInterest($_GET["new_interest"]);
			
		}else{
			echo "you left the interest field empty";
		}
		
	}
	
	//someone clicked the button "select"
	if(isset($_GET["select_interest1"])){
		
		if(!empty($_GET["user_interest1"])){
			
			saveUserInterest($_GET["user_interest"]);
			
		}else{
			echo "error";
		}
		
	}
	
	
?>
