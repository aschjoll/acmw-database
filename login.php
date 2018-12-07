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
       	<!-- Compiled and minified CSS -->
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
       	<title>Login to the ACM-W Website</title>
</head>
<body id="LoginForm">
       <div class="container">
         <div class="row valign-wrapper">
           <div class="col s6 offset-s3 valign">
             <div class="card deep-purple lighten-2 white-text">
	       <div class="container">
                 <div class="card-content center-align">
           	  <span class="card-title white-text">Login</span>
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
                  <br><button type="submit" class="btn orange lighten-2" name="login">Login</button><br>
		  <p>Not yet a member? <a href="register.php">Sign up</a></p><br>
		</form>
		</div>
		</div>
	      </div>
	    </div>
          </div>
</body>
</html>
