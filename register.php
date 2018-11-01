<?php
ini_set('display_error', 1);

error_reporting(E_ALL);

session_start();

// initializing variables
$sid = "";
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('127.0.0.1', 'root', 'WECjk876g11!', 'acmwDB');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $sid = mysqli_real_escape_string($db, $_POST['sid']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($sid)) {array_push($errors, "SID is required"); }
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $student_check_query = "SELECT * FROM student WHERE username='$username' OR email='$email' OR sid='$sid' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $student = mysqli_fetch_assoc($result);
  
  if ($student) {//if student exists
    if ($student['username'] === $username) {
      array_push($errors, "Username already exists");
    }
    if ($student['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO student (sid, username, password, fname, lname, email, gpa, ismember, genderid, yearid, raceid, officerid, majorid)
  		VALUES('$sid', '$username', '$password', 'yo', 'momma', 'email', 4.0, 0, 1, 1, 1, 6, 1)";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: register.php');
  }
}
?>

<html>
<head>
 	<title>Register for ACM-W website access</title>
</head>
<body>
  	<div class="header">
  		<h2>Register</h2>
  	</div>
	
  	<form method="post" action="register.php">
  		<?php include('errors.php'); ?>
  	<div class="input-group">
                <label>SID</label>
                <input type="text" name="sid" value="<?php echo $sid; ?>">
        </div>
	<div class="input-group">
  	  	<label>Username</label>
  	  	<input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  	<label>Email</label>
	  	<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
  		<label>Confirm password</label>
  		<input type="password" name="password_2">
	</div>
<!--	<div class="input-group">
		<label>First Name</label>
		<input type="text" name "fname" value="<?php echo $fname; ?>">
	</div>
	<div class="input-group">
                <label>Last Name</label>
                <input type="text" name "lname" value="<?php echo $lname; ?>">
        </div>-->
	<div class="input-group">
  		<button type="submit" class="btn" name="reg_user">Register</button>
	</div>
	<p>
  		Already a member? <a href="login.php">Sign in</a>
</head>
<body>
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
