<?php
include('config.php');
include('header.php');

session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}
$sessionUsername = $_SESSION['username'];
$sql = "SELECT sid, username, fname, lname, email, gender, year, title, officerID, major, race, hispanic FROM student natural join gender natural join year natural join officer natural join major natural join race WHERE username = \"$sessionUsername\"";
$result = $conn->query($sql);

?>

<html>

<?php   
if ($result->num_rows > 0) {
	$row = mysqli_fetch_assoc($result);
	$sid = $row['sid'];
	$fname = $row['fname'];
	$lname = $row['lname'];
	$fullName = $fname.' '.$lname;
	$email = $row['email'];
	$gender = $row['gender'];
	$year = $row['year'];
	$officerTitle = $row['title'];
	$officerID = $row['officerID'];
	$major = $row['major'];
	$race = $row['race'];
	$hispanic = $row['hispanic'];
	
	array_push($allSIDs, $sid);
?>
		<div class="row">
		  <div class="col s12">
		    <div class="card-panel blue lighten-4">
		      <span class="blue-grey-text text-darken-3">
		        <h4><?php echo $fullName?></h4>
		        <div class="divider blue-grey darken-3"></div>
		          <h6><?php echo $major?></h6>
			  <h6><?php echo $gender?></h6>
			  <h6><?php echo $year?></h6>
			  <?php if($officerID != '6') {
			    		echo "<h6>".$officerTitle."</h6>";
			   } ?>
			  <h6><?php echo $email?></h6>
			</div>
		      </span>
		     <a class = "waves-effect waves-light btn-small modal-trigger orange lighten-2" href="#edit" >Edit</a>
		     <a class = "waves-effect waves-light btn-small modal-trigger orange lighten-2" href="#research">Add Research</a>
		     <a class = "waves-effect waves-light btn-small modal-trigger orange lighten-2" href="#company" >Add Company</a>
		    
		 	<!-- Modal Structure Edit-->
                          <div id="edit" class="modal">
                            <div class="modal-content">
                              <h4>Edit Profile</h4>
                              <div class="row">
                                <form class="col s12" action="profile.php" method="post">
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateFname" type="text" class="validate" value="<?=$fname?>">
                                      <label for="fname">First Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateLname" type="text" class="validate" value="<?=$lname?>">
                                      <label for="lname">Last Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateEmail" type="text" class="validate" value="<?=$email?>">
                                      <label for="email">Email</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
					<?php
		//echo "Gender";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"updateGender\">";
        	$genderQuery="select gender from gender";
        	$genderResult = mysqli_query($conn, $genderQuery);
        	while($genders = mysqli_fetch_assoc($genderResult)){
			if($genders["gender"] == $gender){
				echo "<option selected=\"selected\">".$genders["gender"]."</option>";
			}
			else{
        	        	echo "<option>".$genders["gender"]."</option>";
			}
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Year";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"updateYear\">";
        	$yearQuery="select year from year";
        	$yearResult = mysqli_query($conn, $yearQuery);
        	while($years = mysqli_fetch_assoc($yearResult)){
                        if($years["year"] == $year){
                                echo "<option selected=\"selected\">".$years["year"]."</option>";
                        }
                        else{
                                echo "<option>".$years["year"]."</option>";
                        }
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Race";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"updateRace\">";
        	$raceQuery="select race from race where hispanic=0";
        	$raceResult = mysqli_query($conn, $raceQuery);
        	while($races = mysqli_fetch_assoc($raceResult)){
	                if($races["race"] == $race){
                                echo "<option selected=\"selected\">".$races["race"]."</option>";
                        }
                        else{
				echo "<option>".$races["race"]."</option>";
                        }
        	}
        	echo "</select>";
		echo "</div>";
        	//echo "Hispanic";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"updateHispanic\">";
		if($hispanic == true){
        		echo "<option selected=\"selected\">Hispanic</option>";
			echo "<option>Not Hispanic</option>";
		}
		else{
			echo "<option>Hispanic</option>";
			echo "<option selected=\"selected\">Not Hispanic</option>";
		}
        	echo "</select>";
		echo "</div>";
        	//echo "Major     ";
		echo "<div class=\"form-group\">";
        	echo "<select class=\"form-control\" name=\"updateMajor\">";
        	$majorQuery="select major from major";
        	$majorResult = mysqli_query($conn, $majorQuery);
        	while($majors = mysqli_fetch_assoc($majorResult)){
                        if($majors["major"] == $major){
				echo "<option selected=\"selected\">".$majors["major"]."</option>";
                        }
                        else{   
				echo "<option>".$majors["major"]."</option>";
                        }
        	}
		echo "</select>";
                echo "</div>";
		?>
                                    </div>
                                  </div>
                                  <button class="btn waves-effect waves-light" type="submit" name="update">Update
                                  <i class="material-icons right"></i>
                                  </button>
				</form>
			      </div>
			    </div>
			  </div>
			<!-- Modal Structure Research-->
                          <div id="research" class="modal">
                            <div class="modal-content">
                              <h4>Edit Profile</h4>
                              <div class="row">
                                <form class="col s12" action="profile.php" method="post">
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="topic" type="text" class="validate">
                                      <label for="topic">Topic</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="pname" type="text" class="validate">
                                      <label for="pname">Research Mentor</label>
                                    </div>
                                  </div>
                                  <div class="row">
        			    <div class="input-field col s6">
          			      <textarea id="textarea2" name="description" class="materialize-textarea" data-length="120"></textarea>
          			      <label for="textarea2">Description</label>
        			    </div>
      				  </div>
                                  <button class="btn waves-effect waves-light" type="submit" name="addResearch">Add Research
                                  <i class="material-icons right"></i>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        <!-- Modal Structure Company-->
                          <div id="company" class="modal">
                            <div class="modal-content">
                              <h4>Edit Profile</h4>
                              <div class="row">
                                <form class="col s12" action="profile.php" method="post">
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="cname" type="text" class="validate">
                                      <label for="topic">Company</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="position" type="text" class="validate">
                                      <label for="position">Position</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <textarea id="textarea3" name="description" class="materialize-textarea" data-length="120"></textarea>
                                      <label for="textarea3">Description</label>
                                    </div>
                                  </div>
                                  <button class="btn waves-effect waves-light" type="submit" name="addComp">Add Company
                                  <i class="material-icons right"></i>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>

		    </div>
	          </div>

<?php
} else {
        echo "0 results";
}
	if(isset($_POST['update'])){
			$updateQuery = "update student set";
			$updatedFname = false;
			$updatedLname = false;
			$updatedGender = false;
			$updatedYear = false;
			$updatedRace = false;
			$updatedHispanic = false;
			$updatedMajor = false;
			$updatedYear = false;
			$updatedEmail = false;
			if($_POST['updateFname']!=$fname) {
				$updatedFname = true;
				$updateQuery = $updateQuery." fname = '".$_POST['updateFname']."'";
			}
                        if($_POST['updateLname']!=$lname) {
                                if($updatedFname == true){
                                         $updateQuery = $updateQuery.",";
                                }
                                $updatedLame = true;
                                $updateQuery = $updateQuery." lname = '".$_POST['updateLname']."'";
                        }
                        if($_POST['updateGender']!=$gender) {
                                if($updatedFname == true || $updatedLname==true){
                                         $updateQuery = $updateQuery.",";
                                }
                                $updatedGender = true;
				$newGenderQuery = "select genderid from gender where gender = '".$_POST['updateGender']."'";
				echo $newGenderQuery;
				$newGenderIdResult = mysqli_query($conn, $newGenderQuery);
                                if($newGenderIds = mysqli_fetch_assoc($newGenderIdResult)){
                                        $newGenderId = $newGenderIds['genderid'];
                                }

                                $updateQuery = $updateQuery." genderid = $newGenderId";
                        }
                        if($_POST['updateRace']!=$race) {
                                if($updatedFname == true || $updatedLname==true || $updatedGender==true){
                                         $updateQuery = $updateQuery.",";
                                }
				if($_POST['updateHispanic']=="Hispanic"){
					$newHispanic = true;
				}
				else{
					$newHispanic = false;
				}
                                $updatedRace = true;
                                $newRaceQuery = "select raceid from race where race = '".$_POST['updateRace']."' and hispanic = $newHispanic";
                                $newRaceIdResult = mysqli_query($conn, $newRaceQuery);
                                if($newRaceIds = mysqli_fetch_assoc($newRaceIdResult)){
                                        $newRaceId = $newRaceIds['raceid'];
                                }

                                $updateQuery = $updateQuery." raceid = $newRaceId";
                        }
                        if($_POST['updateMajor']!=$major) {
                                if($updatedFname == true || $updatedLname==true || $updatedGender==true || $updatedRace==true){
                                         $updateQuery = $updateQuery.",";
                                }
				$updatedMajor = true;
                                $newMajorQuery = "select majorid from major where major = '".$_POST['updateMajor']."'";
                                $newMajorIdResult = mysqli_query($conn, $newMajorQuery);
                                if($newMajorIds = mysqli_fetch_assoc($newMajorIdResult)){
                                        $newMajorId = $newMajorIds['majorid'];
                                }

                                $updateQuery = $updateQuery." majorid = $newMajorId";
                        }
                        if($_POST['updateYear']!=$year) {
                                if($updatedFname == true || $updatedLname==true || $updatedGender==true || $updatedRace==true || $updatedMajor==true){
                                         $updateQuery = $updateQuery.",";
                                }
                                $updatedYear = true;
                                $newYearQuery = "select yearid from year where year = '".$_POST['updateYear']."'";
                                $newYearIdResult = mysqli_query($conn, $newYearQuery);
                                if($newYearIds = mysqli_fetch_assoc($newYearIdResult)){
                                        $newYearId = $newYearIds['yearid'];
                                }

                                $updateQuery = $updateQuery." yearid = $newYearId";
                        }
                        if($_POST['updateEmail']!=$email) {
                                if($updatedFname == true || $updatedLname==true || $updatedGender==true || $updatedRace==true || $updatedMajor==true || $updatedYear==true){
                                         $updateQuery = $updateQuery.",";
                                }
                                $updatedEmail = true;
                                $updateQuery = $updateQuery." email = '".$_POST['updateEmail']."'";
                        }
                        $updateQuery = $updateQuery." where sid = $sid";
			echo $updateQuery;
                        if(!mysqli_query($conn, $updateQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
			header("profile.php");
	}
        if(isset($_POST['addResearch']){
                $topic = $_POST['topic'];
                $pname = $_POST['pname'];
                $description = $_POST['description'];

                if(empty($topic) || empty($pname)){
                        echo "Topic and Research Mentor are required";
                }
		else{
			if(empty($description){
				$description = null;
			}
                       	$insertResearchQuery = "insert into research (sid, topic, professor, description) values ('".$topic."'".", '$pname', '$description')";
			if(!mysqli_query($conn, $insertResearchQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
		}
        }

        if(isset($_POST['addCompany']){
                $company = $_POST['cname'];
                $position = $_POST['position'];
                $description = $_POST['description'];

                if(empty($company) || empty($position)){
                        echo "Company and Position are required";
                }
                else{
                        if(empty($description){
                                $description = null;
                        }
                        $insertCompanyQuery = "insert into company (sid, company, position, description) values ('".$company."'".", '$position', '$description')";
                        if(!mysqli_query($conn, $insertCompanyQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
                }
        }

include('footer.php');

$conn->close();
?>

<style>
.datepicker-controls .select-month input {
width: 100%;
height: 75%
}
.modal { width: 60% !important ; height: 66% !important ; }
</style>

<script>
jQuery(document).ready(function(){
                jQuery('.modal').modal();
                });
$(document).ready(function(){
                $('.datepicker').datepicker();
                });

$(document).ready(function(){
                $('.timepicker').timepicker();
                });

$(document).ready(function() {
                $('input#input_text, textarea#textarea2').characterCounter();
                });
$(document).ready(function(){
  $('select').formSelect();
});
</script>

