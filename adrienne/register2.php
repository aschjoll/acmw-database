<?php

//inspired by http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
//css from https://bootsnipp.com/snippets/ZXz3x 

session_start();

$sid = "";
$user = "";
$email = "";
$errors = array(); 

$db = mysqli_connect('127.0.0.1', 'root', 'OPr5qR8HR', 'acmwDB');
if (isset($_POST['register'])) {
  $sid = (int)$_POST['sid'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $user = $_POST['user'];
  $email = $_POST['email'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  $gpa = (float)$_POST['gpa'];
  $gender = $_POST['gender'];
  $year = $_POST['year'];
  $race = $_POST['race'];
  $major = $_POST['major'];
  $hispanic = $_POST['hispanic'];

  if (empty($sid) || empty($fname) || empty($lname) || empty($user) || empty($email) || empty($pass1) || empty($pass2) || empty($gpa) || empty($gender) || empty($year) || empty($race) || empty($hispanic) || empty($major)) {
	array_push($errors, "All fields are required"); 
  }
  if ($pass1 != $pass2) {
	array_push($errors, "The two passwords do not match");
  }

  $student_check_query = "SELECT * FROM student WHERE username='$user' OR email='$email' OR sid='$sid' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $student = mysqli_fetch_assoc($result);
  
  if ($student) {
    if ($student['sid'] === $sid) {
      array_push($errors, "Student ID already exists");
    }
    else if ($student['username'] === $user) {
      array_push($errors, "Username already exists");
    }
    else if ($student['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) {
        if($hispanic == "Hispanic"){
                $hispanic=1;
        }
        else{
		$hispanic=0;
        }
	$genderidQuery = "select genderid from gender where gender='$gender'";
        $yearidQuery = "select yearid from year where year='$year'";
        $raceidQuery = "select raceid from race where race='$race' and hispanic=$hispanic";
        $majoridQuery = "select majorid from major where major='$major'";
        $genderidResult = mysqli_query($db, $genderidQuery);
        while($genderids = mysqli_fetch_assoc($genderidResult)){
                $genderid = $genderids["genderid"];
        }
        $yearidResult = mysqli_query($db, $yearidQuery);
        while($yearids = mysqli_fetch_assoc($yearidResult)){
              $yearid = $yearids["yearid"];
        }
        $raceidResult = mysqli_query($db, $raceidQuery);
        while($raceids = mysqli_fetch_assoc($raceidResult)){
                $raceid = $raceids["raceid"];
        }
        $majoridResult = mysqli_query($db, $majoridQuery);
        while($majorids = mysqli_fetch_assoc($majoridResult)){
                $majorid = $majorids["majorid"];
        }

  	$password = md5($pass1);

  	$query = "INSERT INTO student (sid, username, password, fname, lname, email, gpa, ismember, genderid, yearid, raceid, officerid, majorid)
  		VALUES($sid, '$user', '$pass1', '$fname', '$lname', '$email', $gpa, 0, $genderid, $yearid, $raceid, 6, $majorid)";
	echo $query;
  	mysqli_query($db, $query);

  	$_SESSION['username'] = $user;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: welcome.php');
  }
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

 	<title>Register for ACM-W website access</title>
</head>
<body id="LoginForm">
	<div class="container">
  	<h1 class="form-heading">Register</h2>
	<div class="login-form">
	<div class="main-div">
	<div class="panel">
	<h2>Register</h2>
	<p>Please enter your information</p>
	</div>
	<form id="Login" action="register3.php" method="post">
		<div class="form-group">
                <!--<br><label>SID<label>-->
                <input type="text" name="sid" class="form-control" placeholder="Student ID">
		</div>
		<div class="form-group">
                <!--<label>First Name</label>-->
                <input type="text" name="fname" class="form-control" placeholder="First Name">
		</div>
		<div class="form-group">
                <!--<label>Last Name<label>-->
                <input type="text" name="lname" class="form-control" placeholder="Last Name">
		</div>
		<div class="form-group"><div class="form-group">
                <!--<label>Email</label>-->
                <input type="text" name="email" class="form-control" placeholder="Email Address">
		</div>
		<div class="form-group">
                <!--<label>Username</label>-->
                 <input type="text" name="user" class="form-control" placeholder="Username">
		</div>
		<div class="form-group">
                <!--<label>Password</label>-->
                <input type="password" name="pass1" class="form-control" placeholder="Password">
		</div>
		<div class="form-group">
                <!--<label>Confirm password</label>-->
                <input type="password" name="pass2" class="form-control" placeholder="Confirm Password">
		</div>
		<div class="form-group">
                <!--<label>GPA</label>-->
		<input type="text" name="gpa" class="form-control" placeholder="GPA">
		</div>
		<?php
		//echo "Gender";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"gender\">";
        	$genderQuery="select gender from gender";
        	$genderResult = mysqli_query($db, $genderQuery);
        	while($genders = mysqli_fetch_assoc($genderResult)){
        	        echo "<option>".$genders["gender"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Year";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"year\">";
        	$yearQuery="select year from year";
        	$yearResult = mysqli_query($db, $yearQuery);
        	while($years = mysqli_fetch_assoc($yearResult)){
        	        echo "<option>".$years["year"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Race";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"race\">";
        	$raceQuery="select race from race where hispanic=0";
        	$raceResult = mysqli_query($db, $raceQuery);
        	while($races = mysqli_fetch_assoc($raceResult)){
        	        echo "<option>".$races["race"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Hispanic";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"hispanic\">";
        	echo "<option>Hispanic</option>";
        	echo "<option>Not Hispanic</option>";
        	echo "</select>";
		echo "</div>";
        	//echo "Major     ";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"major\">";
        	$majorQuery="select major from major";
        	$majorResult = mysqli_query($db, $majorQuery);
        	while($majors = mysqli_fetch_assoc($majorResult)){
                	echo "<option>".$majors["major"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
		foreach ($errors as $error){
			echo $error."\n";
		}
		echo "\n";
		?>
		<br><button type="submit" class="btn btn-primary" name="register">Register</button><br>
  		Already a member? <a href="login.php">Sign in</a>
</form>
</div>
<p class="botto-text"> Designed by Sunil Rajput</p>
</div></div></div>
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
