<?php
	session_start();
	$_SESSION['error'] = '';

	require (__DIR__.'/../connection.php');

	$username = $mysqli->real_escape_string($_POST['username']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$confirmPassword = $_POST['confirmPassword'];

	if($password == $confirmPassword) {

		$salted = "jhdf45fhuig8sdhzdhsuhaskjhs".$password."uyf83ona";
		$hashed = hash('sha512', $salted);

		$sql = "INSERT INTO users (username, email, password)" . "VALUES ('$username', '$email', '$hashed')";

		if ($mysqli->query($sql) == true) { 

			$sql = "SELECT id FROM users WHERE username = '$username' AND email = '$email' AND password = '$hashed'";
			$result = $mysqli->query($sql);
			$user = $result->fetch_assoc();
			$id = $user['id'];
			header("location: /users/show.php?id=" . $id);
		}
		else {
			$_SESSION['error'] = "Username already exists. Please use a different username or log in below.";
			header("location: /users/login.php");
		}	
	} else {
		$_SESSION['error'] = "Passwords do not match. Please try again.";
		header("location: /users/register.php");
	}
	
?>