<?php
	session_start();
	$user = $_SESSION["user_id"];
	$username = $_SESSION["username"];
	$user_role = $_SESSION["user_role"];
	echo "Session is created.. <br><br>";
	echo "USER ID : ". $user .'<br>';
	echo "USER-NAME : " . $username .'<br>';
	echo "USER-ROLE : " . $user_role .'<br>';
?>