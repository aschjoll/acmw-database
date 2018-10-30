<?php

$servername = "localhost";
$dbname = "acmwDB";
$password = "yourpasswordgoeshere";

$mysqli = new mysqli('127.0.0.1', 'root', $password, $dbname);

function startHtml(){
	echo "<html>";
	echo "<title>ACM-W Sign In</title>";
	echo "<body>";
}

function endHTML(){
    echo "</body>";
    echo "</html>";
}

function displaySignUp(){
	startHtml();
	echo "<form action=\"signup.php\" method=\"post\">";
	echo "<br>SID";
	echo "<input type=\"text\" name=\"sid\"><br><br>";
	echo "First Name	";
	echo "<input type=\"text\" name=\"fname\"><br><br>";
	echo "	Last Name";
	echo "<input type=\"text\" name=\"lname\"><br><br>";
	echo "Email";
	echo "<input type=\"text\" name=\"email\"><br><br>";
	echo "Username";
	echo "<input type=\"text\" name=\"user\"><br><br>";
	echo "Password";
	echo "<input type=\"password\" name=\"pass\"><br><br>";
	echo "GPA";
	echo "<input type=\"text\" name=\"gpa\"><br><br>";
	echo "Gender";
	echo "<select name=\"gender\">";
	$genderQuery="select gender from gender";
	$genderResult = $GLOBALS['mysqli']->query($genderQuery);
	while($genders = $genderResult->fetch_assoc()){
		echo "<option>".$genders["gender"]."</option>";
	}
	echo "</select><br><br>";
	echo "Year	";
	echo "<select name=\"year\">";
	$yearQuery="select year from year";
	$yearResult = $GLOBALS['mysqli']->query($yearQuery);
	while($years = $yearResult->fetch_assoc()){
		echo "<option>".$years["year"]."</option>";
	}
	echo "</select><br><br>";
	echo "Race	";
	echo "<select name=\"race\">";
	$raceQuery="select race from race";
	$raceResult = $GLOBALS['mysqli']->query($raceQuery);
	while($races = $raceResult->fetch_assoc()){
		echo "<option>".$races["race"]."</option>";
	}
	echo "</select><br><br>";
	echo "Hispanic";
	echo "<select name=\"hispanic\">";
	echo "<option>Yes</option>";
	echo "<option>No</option>";
	echo "</select><br><br>";
	echo "Major	";
	echo "<select name=\"major\">";
	$majorQuery="select major from major";
	$majorResult = $GLOBALS['mysqli']->query($majorQuery);
	while($majors = $majorResult->fetch_assoc()){
		echo "<option>".$majors["major"]."</option>";
	}
	echo "</select></br><br>";
	echo "<input type=\"submit\" name=\"signup\" value=\"SIGN UP\">";	
	endHtml();
}

function insertNewUser($sid, $fname, $lname, $email, $user, $pass, $gpa, $gender, $year, $race, $hispanic, $major){
	$sid = (int)$sid;
	$gpa = (float)$gpa;
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

	$genderidResult = $GLOBALS['mysqli']->query($genderidQuery);
	while($genderids = $genderidResult->fetch_assoc()){
		$genderid = $genderids["genderid"];
	}
	$yearidResult = $GLOBALS['mysqli']->query($yearidQuery);
        while($yearids = $yearidResult->fetch_assoc()){
  	      $yearid = $yearids["yearid"];
	}
	$raceidResult = $GLOBALS['mysqli']->query($raceidQuery);
        while($raceids = $raceidResult->fetch_assoc()){
        	$raceid = $raceids["raceid"];
	}
	$majoridResult = $GLOBALS['mysqli']->query($majoridQuery);
        while($majorids = $majoridResult->fetch_assoc()){
        	$majorid = $majorids["majorid"];
	}
	$insertQuery="insert into student (sid, username, password, fname, lname, email, gpa, genderid, yearid, raceid, officerid, majorid) values ($sid, '$user', '$pass', '$fname', '$lname', '$email', $gpa, $genderid, $yearid, $raceid, 6, $majorid)";
	if(!$GlOBALS['mysqli']->query($insertQuery)){
		echo "Error: ".$GLOBALS['mysqli']->error."\n";
	}
	else{
		echo "You have successfully signed up! Please go login in!\n";
	}
}

$mysqli = new mysqli('127.0.0.1', 'root', $password, $dbname);
if ($mysqli->connect_errno) {
        echo "Could not connect to database \n";
        echo "Error: ". $mysqli->connect_error . "\n";
        exit;
}
else {
	displaySignUp();
	if(isset($_POST["signup"])){
		if(!empty($_POST["sid"]) && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["user"]) && !empty($_POST["pass"]) && !empty($_POST["gpa"]) && !empty($_POST["gender"]) && !empty($_POST["year"]) && !empty($_POST["race"]) && !empty($_POST["hispanic"]) && !empty($_POST["major"])){
			insertNewUser($_POST["sid"], $_POST["fname"], $_POST["lname"], $_POST["email"], $_POST["user"], $_POST["pass"], $_POST["gpa"], $_POST["gender"], $_POST["year"], $_POST["race"], isset($_POST["hispanic"]) && isset($_POST["major"]));
		}
		else{
			echo "All fields need to be filled out\n";
		}
	}	
}




?>
