<?php
include('config.php');
include('header.php');

session_start();

if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}

$memberCountQuery = "select * from student";
$genderCountQuery = "select count(*) as num, gender from (student natural join gender) group by genderid";
$majorCountQuery = "select count(*) as num, major from (student natural join major) group by majorid";
$yearCountQuery = "select count(*) as num, year from (student natural join year) group by yearid";
$raceCountQuery = "select count(*) as num, race, hispanic from (student natural join race) group by raceid";

if(!$memberCountResult = mysqli_query($conn, $memberCountQuery)){
        echo "ERROR ".mysqli_error($conn);
}

echo "Number of members: ".$memberCountResult->num_rows."<br><br>";

if(!$genderCountResult = mysqli_query($conn, $genderCountQuery)){
        echo "ERROR ".mysqli_error($conn);
}

if(!$majorCountResult = mysqli_query($conn, $majorCountQuery)){
        echo "ERROR ".mysqli_error($conn);
}

if(!$yearCountResult = mysqli_query($conn, $yearCountQuery)){
	echo "ERROR ".mysqli_error($conn);
}

if(!$raceCountResult = mysqli_query($conn, $raceCountQuery)){
        echo "ERROR ".mysqli_error($conn);
}

while($genderCount = mysqli_fetch_assoc($genderCountResult)){
	if($genderCount['gender'] == "Female"){
		$femaleCount = $genderCount['num'];
	}
	else{
		$maleCount = $genderCount['num'];
	}
	$percentage = ($genderCount['num']/$memberCountResult->num_rows)*100;
        echo $genderCount['gender'].": ".$genderCount['num']."--------".$percentage."%<br>";
}
echo "<br>";
while($majorCount = mysqli_fetch_assoc($majorCountResult)){
	if($majorCount['major']=="Computer Science"){
		$csCount = $majorCount['num'];
	}
	if($majorCount['major']=="Information Communcation Technology"){
		$ictCount = $majorCount['num'];
	}
	$percentage = ($majorCount['num']/$memberCountResult->num_rows)*100;
        echo $majorCount['major'].": ".$majorCount['num']."--------".$percentage."%<br>";
}
echo "<br>";
while($yearCount = mysqli_fetch_assoc($yearCountResult)){
	if($yearCount['year'] == "Freshman"){
		$freshCount = $yearCount['num'];
	}
	if($yearCount['year'] == "Sophomore"){
		$sophCount = $yearCount['num'];
	}
	if($yearCount['year'] == "Junior"){
                $junCount = $yearCount['num'];
        }
        if($yearCount['year'] == "Senior"){
                $senCount = $yearCount['num'];
        }
	$percentage = ($yearCount['num']/$memberCountResult->num_rows)*100;
	echo $yearCount['year'].": ".$yearCount['num']."--------".$percentage."%<br>";
}
echo "<br>";

while($raceCount = mysqli_fetch_assoc($raceCountResult)){
	if($raceCount['hispanic']==0){
		$hispanic="(Not Hispanic)";
	}
	else{
		$hispanic="(Hispanic)";
	}
	$percentage = ($raceCount['num']/$memberCountResult->num_rows)*100;
	echo $raceCount['race']." ".$hispanic.": ".$raceCount['num']."--------".$percentage."%<br>";
}
echo "<br>";
include('footer.php');

?>

