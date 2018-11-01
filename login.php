<?php

//inspired by http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
//css from https://bootsnipp.com/snippets/ZXz3x

session_start();

$username = "";
$password = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('127.0.0.1', 'root', 'WECjk876g11!', 'acmwDB');

if (isset($_POST['login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) { 
    array_push($errors, "Username is required"); 
  }
  if (empty($password)) { 
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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

        <title>Login to the ACM-W Website</title>
</head>
<body id="LoginForm">
        <div class="container">
        	<h1 class="form-heading"></h1>
        	<div class="login-form">
        		<div class="main-div">
        			<div class="panel">
        				<h2>Login</h2>
        				<p>Please enter your information</p>
        			</div>
        			<form id="Login" action="login.php" method="post">
                			<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="Username">
                			</div>
                			<div class="form-group">
                				<input type="password" name="password" class="form-control" placeholder="Password">
                			</div>
					<?php        
						foreach ($errors as $error){
                        				echo $error."\n";
                				}
                				echo "\n";
                			?>
                			<br><button type="submit" class="btn btn-primary" name="login">Login</button><br>
					<p>Not yet a member? <a href="register.php">Sign up</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

<style>
body#LoginForm{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

.form-heading { color:#fff; font-size:23px;}
.panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
.panel p { color:#777777; font-size:14px; margin-bottom:30px; line-height:24px;}
.login-form .form-control {
  background: #f7f7f7 none repeat scroll 0 0;
  border: 1px solid #d4d4d4;
  border-radius: 4px;
  font-size: 14px;
  height: 50px;
  line-height: 50px;
}
.main-div {
  background: #ffffff none repeat scroll 0 0;
  border-radius: 2px;
  margin: 10px auto 30px;
  max-width: 38%;
  padding: 50px 70px 70px 71px;
}

.login-form .form-group {
  margin-bottom:10px;
}
.login-form{ text-align:center;}
.forgot a {
  color: #777777;
  font-size: 14px;
  text-decoration: underline;
}
.login-form  .btn.btn-primary {
  background: #f0ad4e none repeat scroll 0 0;
  border-color: #f0ad4e;
  color: #ffffff;
  font-size: 14px;
  width: 100%;
  height: 50px;
  line-height: 50px;
  padding: 0;
}
.forgot {
  text-align: left; margin-bottom:30px;
}
.botto-text {
  color: #ffffff;
  font-size: 14px;
  margin: auto;
}
.login-form .btn.btn-primary.reset {
  background: #ff9900 none repeat scroll 0 0;
}
.back { text-align: left; margin-top:10px;}
.back a {color: #444444; font-size: 13px;text-decoration: none;}
</style>

