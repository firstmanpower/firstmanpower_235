<?php
session_start();

$username = "";
$password = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', 'qmoiuuyunnumkkojnhy', 'fmp_pui');


if (isset($_POST['reg_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($errors, "0"); }
  if (empty($password_1)) { array_push($errors, "0" }
  if ($password_1 != $password_2) { array_push($errors, "0"); }

  $user_check_query = "SELECT * FROM user_ver2 WHERE NAME = '$username'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "0");
    }
  }

  if (count($errors) == 0) {
  	$password = md5($password_1);

  	$_query = "INSERT INTO user_ver2 (NAME, PASSWORD) 
  			  VALUES('$username', '$password')";
  	query($db, $_query);
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) { array_push($errors, "0"); }
  if (empty($password)) { array_push($errors, "0"); }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM user_ver2 WHERE NAME = '$username' AND PASSWORD = '$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>