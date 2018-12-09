<?php
include('config.php');
include('header.php');

session_start();

$sql = "SELECT sid, fname, lname, email, gender, year, title, officerID, major FROM student natural join gender natural join year natural join officer natural join major ORDER BY officerID";
$result = $conn->query($sql); 

?>

<html>

<?php   
$allSIDs = array();
echo "POO";
if ($result->num_rows > 0) {
        $i = 0;
        // output data of each row
        while($i < $result->num_rows) 
	{
		$row = mysqli_fetch_assoc($result);
		$sid = $row['sid'];
		$researchQuery = "SELECT * FROM research WHERE sid = $sid";
		echo $researchQuery;
                if(!$researchResult = mysqli_query($conn, $researchQuery){
                        echo mysqli_error($conn);
                }
        	$companyQuery = "SELECT * FROM company WHERE sid = $sid";
		if(!$companyResult = mysqli_query($conn, $companyQuery){
			echo mysqli_error($conn);
		}
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
		    <div class="card-panel white">
		      <span class="blue-grey-text text-darken-3">
                          <h5>General Information</h5>

		        <h4><?php echo $fullName?></h4>
		        <div class="divider blue-grey darken-3"></div>
		          <h6><?php echo $major[$sid]?></h6>
			  <h6><?php echo $gender[$sid]?></h6>
			  <h6><?php echo $year[$sid]?></h6>
			  <?php if($officerID[$sid] != '6') {
			    		echo "<h6>".$officerTitle[$sid]."</h6>";
			   } ?>
			  <h6><?php echo $email[$sid]?></h6>
<?php
                while ($researchRow = mysqli_fetch_assoc($researchResult))
                {
                        $researchTopic = $researchRow['topic'];
                        $researchMent = $researchRow['professor'];
                        $researchDesc = $researchRow['description'];
                        echo "<br><div class=\"divider blue-grey darken-3\"></div>";
                        echo "<h5>Research"."<br>";
                        echo "<h6>Research Topic: ".$researchRow['topic']."</h6>";
                        echo "<h6>Research Mentor: ".$researchRow['professor']."</h6>";
                        echo "<h6>Description: ".$researchRow['description']."</h6>";

                while ($companyRow = mysqli_fetch_assoc($companyResult))
                {
                        $companyName = $companyRow['company'];
                        $companyPos = $companyRow['position'];
                        $companyDesc = $companyRow['description'];
                        echo "<br><div class=\"divider blue-grey darken-3\"></div>";
                        echo "<h5>Professional Experience"."<br>";
                        echo "<h6>Company: ".$companyRow['company']."</h6>";
                        echo "<h6>Position: ".$companyRow['position']."</h6>";
                        echo "<h6>Description: ".$companyRow['description']."</h6>";
                }?>
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
