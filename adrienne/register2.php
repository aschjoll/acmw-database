<?php
session_start();

$sid = "";
$username = "";
$email    = "";
$errors = array(); 

$db = mysqli_connect('127.0.0.1', 'root', 'youpasswordgoeshere', 'acmwDB');
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
  if($hispanic == "Yes"){
    $hispanic=true;
  }
  else{
    $hispanic=false;
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

  if (empty($sid) || empty($fname) || empty($lname) || empty($user) || empty($email) || empty($pass1) || empty($pass2) || empty($gpa) || empty($gender) || empty($year) || empty($race) || empty($hispanic) || empty($major)) {
	array_push($errors, "All fields are required"); 
  }
  if ($pass1 != $pass2) {
	echo $pass1;
	echo $pass2;
	array_push($errors, "The two passwords do not match");
  }

  $student_check_query = "SELECT * FROM student WHERE username='$user' OR email='$email' OR sid='$sid' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $student = mysqli_fetch_assoc($result);
  
  if ($student) {
    if ($student['sid'] === $sid) {
      array_push($errors, "Student ID already exists");
    }
    else if ($student['username'] === $username) {
      array_push($errors, "Username already exists");
    }
    else if ($student['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) {
  	$password = md5($pass1);

  	$query = "INSERT INTO student (sid, username, password, fname, lname, email, gpa, ismember, genderid, yearid, raceid, officerid, majorid)
  		VALUES('$sid', '$username', '$password', '$fname', '$lname', '$email', $gpa, 0, $genderid, $yearid, $raceid, 6, $majorid)";
	echo $query;
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: welcome.php');
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
	
	<form action="register2.php" method="post">
                <br><label>SID<label>
                <input type="text" name="sid"><br><br>
                <label>First Name</label>
                <input type="text" name="fname"><br><br>
                <label>Last Name<label>
                <input type="text" name="lname"><br><br>
                <label>Email</label>
                <input type="text" name="email"><br><br>
                <label>Username</label>
                 <input type="text" name="user"><br><br>
                <label>Password</label>
                <input type="password" name="pass1"><br><br>
                <label>Confirm password</label>
                <input type="password" name="pass2"><br><br>
                <label>GPA</label>
		<input type="text" name="gpa"><br><br>
		<?php
		echo "Gender";
        	echo "<select name=\"gender\">";
        	$genderQuery="select gender from gender";
        	$genderResult = mysqli_query($db, $genderQuery);
        	while($genders = mysqli_fetch_assoc($genderResult)){
        	        echo "<option>".$genders["gender"]."</option>";
        	}
        	echo "</select><br><br>";
        	echo "Year";
        	echo "<select name=\"year\">";
        	$yearQuery="select year from year";
        	$yearResult = mysqli_query($db, $yearQuery);
        	while($years = mysqli_fetch_assoc($yearResult)){
        	        echo "<option>".$years["year"]."</option>";
        	}
        	echo "</select><br><br>";
        	echo "Race";
        	echo "<select name=\"race\">";
        	$raceQuery="select race from race";
        	$raceResult = mysqli_query($db, $raceQuery);
        	while($races = mysqli_fetch_assoc($raceResult)){
        	        echo "<option>".$races["race"]."</option>";
        	}
        	echo "</select><br><br>";
        	echo "Hispanic";
        	echo "<select name=\"hispanic\">";
        	echo "<option>Yes</option>";
        	echo "<option>No</option>";
        	echo "</select><br><br>";
        	echo "Major     ";
        	echo "<select name=\"major\">";
        	$majorQuery="select major from major";
        	$majorResult = mysqli_query($db, $majorQuery);
        	while($majors = mysqli_fetch_assoc($majorResult)){
                	echo "<option>".$majors["major"]."</option>";
        	}
        	echo "</select></br><br>";
		foreach ($errors as $error){
			echo $error."\n";
		}
		?>
                <button type="submit" name="register">Register</button>
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

form, .content {
  width: 30%;
  margin: 0px auto;
  padding: 20px;
  border: 1px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}
</style>
