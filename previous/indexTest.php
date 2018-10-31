<?php

$servername = "localhost";
$dbname = "acmwDB";
$password = "WECjk876g11!";

function startHtml(){
	echo "<html>";
	echo "<title>ACM-W Sign In</title>";
	echo "<body>";
}

function endHTML(){
    echo "</body>";
    echo "</html>";
}

function displaySignIn(){
	startHtml();
	echo "<form action=\"index.php\" method=\"post\">";
	echo "username:<br>";
	echo "<input type=\"text\" name=\"user\"><br><br>";
	echo "password:<br>";
        echo "<input type=\"password\" name=\"password\"><br><br>";
	echo "<input type=\"submit\" name=\"login\" value=\"LOGIN\"><br>";
	echo "</form>";

	echo "<form action=\"indexTest.php\" method=\"post\">";
	echo "<input type=\"submit\" name=\"signup\" value=\"SIGN UP\">";
	echo "</form>";
	endHtml();
}

function displaySignUp(){
	startHtml();
	echo "<form action=\"index.php\" method=\"post\">";
	
	echo "<input type=\"submit\" name=\"register\" value=\"SIGN UP\">";	
	endHtml();
}

function checkLogin(){
	if(isset($_POST["user"]) && isset($_POST["password"])){
			$user = $_POST["user"];
			$pass = $_POST["password"];
			$userQuery = "select password from student where username = $user;";
			if(!$userQueryResult = $mysqli->query($userQuery)){
				echo "Error: ".$mysqli->error."\n";
				exit;
			}
			else if($userQueryResult->num_rows===0){
				echo "That username does not exist\n";
			}
			else{
				$correctPass = $userQueryResult->fetch_assoc();
				if($correctPass["password"]==$pass){
					echo "You have successfully logged in\n";
				}
				else{
					echo "Incorrect password\n";
				}
			}	
		}
	}


$mysqli = new mysqli('127.0.0.1', 'root', $password, $dbname);
if ($mysqli->connect_errno) {
        echo "Could not connect to database \n";
        echo "Error: ". $mysqli->connect_error . "\n";
        exit;
}
else {
	displaySignIn();
	if(isset($_POST["login"])){
		checkLogin();
	}
	else if(isset($_POST["signup"])){
		displaySignUp();
	}
	else if(isset($_POST["register"])){
		insertNewUser();
	}
		
}

