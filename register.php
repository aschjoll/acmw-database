<?php

//inspired by http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
//css from https://bootsnipp.com/snippets/ZXz3x 
include('config.php');
session_start();

$sid = "";
$user = "";
$email = "";
$errors = array(); 

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
  $result = mysqli_query($conn, $user_check_query);
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
        $genderidResult = mysqli_query($conn, $genderidQuery);
        while($genderids = mysqli_fetch_assoc($genderidResult)){
                $genderid = $genderids["genderid"];
        }
        $yearidResult = mysqli_query($conn, $yearidQuery);
        while($yearids = mysqli_fetch_assoc($yearidResult)){
              $yearid = $yearids["yearid"];
        }
        $raceidResult = mysqli_query($conn, $raceidQuery);
        while($raceids = mysqli_fetch_assoc($raceidResult)){
                $raceid = $raceids["raceid"];
        }
        $majoridResult = mysqli_query($conn, $majoridQuery);
        while($majorids = mysqli_fetch_assoc($majoridResult)){
                $majorid = $majorids["majorid"];
        }

  	$password = md5($pass1);

  	$query = "INSERT INTO student (sid, username, password, fname, lname, email, gpa, ismember, genderid, yearid, raceid, officerid, majorid)
  		VALUES($sid, '$user', '$password', '$fname', '$lname', '$email', $gpa, 0, $genderid, $yearid, $raceid, 6, $majorid)";
	echo $query;
  	mysqli_query($conn, $query);

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
	<link rel="stylesheet" href="mainstyles.css" type="text/css">
 	<title>Register for ACM-W website Access</title>
</head>
<body id="LoginForm">
	<div class="container">
  	<h1 class="form-heading"></h1>
	<div class="login-form">
	<div class="main-div">
	<div class="panel">
	<h2>Register</h2>
	<p>Please enter your information</p>
	</div>
	<form id="Login" action="register.php" method="post">
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
        	$genderResult = mysqli_query($conn, $genderQuery);
        	while($genders = mysqli_fetch_assoc($genderResult)){
        	        echo "<option>".$genders["gender"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Year";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"year\">";
        	$yearQuery="select year from year";
        	$yearResult = mysqli_query($conn, $yearQuery);
        	while($years = mysqli_fetch_assoc($yearResult)){
        	        echo "<option>".$years["year"]."</option>";
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Race";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"race\">";
        	$raceQuery="select race from race where hispanic=0";
        	$raceResult = mysqli_query($conn, $raceQuery);
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
        	$majorResult = mysqli_query($conn, $majorQuery);
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
</div></div></div>
</body>
</html>
