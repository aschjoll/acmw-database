<?php

//inspired by http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
//css from https://bootsnipp.com/snippets/ZXz3x

include ('config.php');

session_start();

$username = "";
$password = "";
$errors = array(); 

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
  	$results = mysqli_query($conn, $query);
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
	<link rel="stylesheet" href="mainstyles.css" type="text/css">
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
