
<?php
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
	echo "<form action=\"index2.php\" method=\"post\">";
	
	echo "<input type=\"submit\" name=\"register\" value=\"SIGN UP\">";	
	endHtml();
}

function insertUser(){

}



?>
