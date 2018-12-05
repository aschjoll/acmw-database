<?php
include('config.php');
include('header.php');

session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}
$sessionUsername = $_SESSION['username'];
$sql = "SELECT sid, username, fname, lname, email, gender, year, title, officerID, major FROM student natural join gender natural join year natural join officer natural join major WHERE username = \"$sessionUsername\"";
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
                                      <label for="name">First Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateLname" type="text" class="vslidate" value="<?=$lname?>">
                                      <label for="name">Last Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateMajor" type="text" class="validate" value="<?=$major?>">
                                      <label for="name">Major</label>
                                    </div>
                                  </div>
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
                                      <input name="updateFname" type="text" class="validate" value="<?=$fname?>">
                                      <label for="name">First Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateLname" type="text" class="vslidate" value="<?=$lname?>">
                                      <label for="name">Last Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateMajor" type="text" class="validate" value="<?=$major?>">
                                      <label for="name">Major</label>
                                    </div>
                                  </div>
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
                                      <input name="updateFname" type="text" class="validate" value="<?=$fname?>">
                                      <label for="name">First Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateLname" type="text" class="vslidate" value="<?=$lname?>">
                                      <label for="name">Last Name</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <input name="updateMajor" type="text" class="validate" value="<?=$major?>">
                                      <label for="name">Major</label>
                                    </div>
                                  </div>
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

