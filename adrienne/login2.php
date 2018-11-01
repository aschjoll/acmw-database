<?php

session_start();

$username = "";
$pass    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('127.0.0.1', 'root', 'WECjk876g11!', 'acmwDB');

if (isset($_POST['login'])) {

  $user = $_POST['username'];
  $pass = $_POST['pass']);

  if (empty($user)) { 
    array_push($errors, "Username is required"); 
  }
  if (empty($pass)) { 
    array_push($errors, "Password is required"); 
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: welcome.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>

<html>
<head>
<title>Registration system PHP and MySQL</title>
</head>
<body>
<div class="header">
<h2>Login</h2>
</div>
 
<form method="post" action="login.php">

<div class="input-group">
	<label>Username</label>
	<input type="text" name="user" >
</div>
<div class="input-group">
	<label>Password</label>
	<input type="password" name="pass">
</div>
<div class="input-group">
	<button type="submit" class="btn" name="login">Login</button>
</div>
<?php
foreach ($errors ad $error){
echo $error."\n\n\n";
?>
<p>
	Not yet a member? <a href="register2.php">Sign up</a>
  	</p>
  </form>
</body>
</html>

<style>
{
  margin: 0px;
  padding: 0px;
}
body {
  font-size: 120%;
  background: #F8F8FF;
}

.header {
  width: 30%;
  margin: 50px auto 0px;
  color: white;
  background: #5F9EA0;
  text-align: center;
  border: 1px solid #B0C4DE;
  border-bottom: none;
  border-radius: 10px 10px 0px 0px;
  padding: 20px;
}
form, .content {
  width: 30%;
  margin: 0px auto;
  padding: 20px;
  border: 1px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}
.input-group {
  margin: 10px 0px 10px 0px;
}
.input-group label {
  display: block;
  text-align: left;
  margin: 3px;
}
.input-group input {
  height: 30px;
  width: 93%;
  padding: 5px 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid gray;
}
.btn {
  padding: 10px;
  font-size: 15px;
  color: white;
  background: #5F9EA0;
  border: none;
  border-radius: 5px;
}
.error {
  width: 92%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #a94442; 
  color: #a94442; 
  background: #f2dede; 
  border-radius: 5px; 
  text-align: left;
}
.success {
  color: #3c763d; 
  background: #dff0d8; 
  border: 1px solid #3c763d;
  margin-bottom: 20px;
}
</style>
