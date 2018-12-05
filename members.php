<?php
include('config.php');
include('header.php');

session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}

$sql = "SELECT sid, fname, lname, email, gender, year, title, officerID, major FROM student natural join gender natural join year natural join officer natural join major";
$result = $conn->query($sql);

?>

<html>

<?php   
$allSIDs = array();
if ($result->num_rows > 0) {
        $i = 0;
        // output data of each row
        while($i < $result->num_rows) 
	{
		$row = mysqli_fetch_assoc($result);
		$sid = $row['sid'];
		$fname[$sid] = $row['fname'];
		$lname[$sid] = $row['lname'];
		$fullName = $fname[$sid].' '.$lname[$sid];
		$email[$sid] = $row['email'];
		$gender[$sid] = $row['gender'];
		$year[$sid] = $row['year'];
		$officerTitle[$sid] = $row['title'];
		$officerID[$sid] = $row['officerID'];
		$major[$sid] = $row['major'];
	
		array_push($allSIDs, $sid);
?>
		<div class="row">
		  <div class="col s12">
		    <div class="card-panel blue lighten-4">
		      <span class="blue-grey-text text-darken-3">
		        <h4><?php echo $fullName?></h4>
		        <div class="divider blue-grey darken-3"></div>
		          <h6><?php echo $major[$sid]?></h6>
			  <h6><?php echo $gender[$sid]?></h6>
			  <h6><?php echo $year[$sid]?></h6>
			  <?php if($officerID[$sid] != '6') {
			    		echo "<h6>".$officerTitle[$sid]."</h6>";
			   } ?>
			  <h6><?php echo $email[$sid]?></h6>
			</div>
		      </span>
		    </div>
	          </div>
<?php
		$i++;
	}
} else {
	echo "0 results";
}

include('footer.php');

$conn->close(); 
?>
