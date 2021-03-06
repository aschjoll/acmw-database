<?php
include('config.php');
include('header.php');

session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}

$isOfficer = false;
$officerQuery = "SELECT sid, username, officerid FROM student";
$result2 = mysqli_query($conn, $officerQuery);
if (!$result2)
{
	echo "ERROR".mysqli_error($conn);
}

$sql = "SELECT eventid, event, eventTime, description, locationid, buildingRoom, address FROM event natural join location";
$result = $conn->query($sql);

while ($studentResult = mysqli_fetch_assoc($result2)){
	if($studentResult['username'] == $_SESSION['username']){
		$sid = $studentResult['sid'];
		if($studentResult['officerid']!=6){
			$isOfficer=true;
		}
		break;
	}
}

?>

<html>

<?php   
	$allEventIds = array();
	if ($result->num_rows > 0) {
	$i = 0;
	// output data of each row
	while($i < $result->num_rows) {
		$row = mysqli_fetch_assoc($result);
		$eventid = $row['eventid'];
		$title[$eventid] = $row['event'];
		$dateTimeRaw[$eventid] = $row['eventTime'];
		$dateTime[$eventid] = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeRaw[$eventid]);
		$date[$eventid] = $dateTime[$eventid]->format('F jS Y');
		$time[$eventid] = $dateTime[$eventid]->format('g:i a');
		$formattedDateTime[$eventid] = $dateTime[$eventid]->format('F jS Y, g:i a');
		$description[$eventid] = $row['description'];
		$locationid[$eventid] = $row['locationid'];
		$locationB[$eventid] = $row['buildingRoom'];
		$locationA[$eventid] = $row['address'];
		if($row['buildingRoom']=="null"){
			$location[$eventid] = $row['address'];
		}
		else{
			$location[$eventid] = $row['buildingRoom'];
		}

		array_push($allEventIds, $eventid);
		
		$RSVPQuery2 = "select sid, RSVP from attends where eventid = $eventid and RSVP = true";
		$result3 = mysqli_query($conn, $RSVPQuery2);
		$RSVPCount = $result3->num_rows;
		
		while ($RSVPs = mysqli_fetch_assoc($result3))
		{
			if ($sid == $RSVPs['sid']){
				$RSVPEED[$eventid] = true;
				break;
			}
			else{
				$RSVPEED[$eventid] = false;
			}
		}
?>
		<div class="row">
		  <div class="col s12">
		    <div class="card-panel white">
		      <span class="blue-grey-text text-darken-3">
		        <h4><?php echo $title[$eventid]?></h4>
		        <div class="divider blue-grey darken-3"></div>
		          <h6><?php echo $formattedDateTime[$eventid];?></h6>
		  <h6><?php echo $location[$eventid];?></h6>
		  <h6><?php echo "RSVPs: ".$RSVPCount; ?></h6>
		  <blockquote><?php echo $description[$eventid];?></blockquote><br><br>
		          <?php 
				if ($isOfficer){
					echo "<a class=\"waves-effect waves-light btn-small modal-trigger blue-grey lighten-5 grey-text text-darken-1\" href=\"#edit$eventid\">Edit</a>";
		          		echo "<a class=\"waves-effect waves-light btn-small blue-grey lighten-5 grey-text text-darken-1\" href=\"events.php?delete=$eventid\">Delete</a>";
		          	}
				if (!$RSVPEED[$eventid]){
					echo "<a class=\"waves-effect waves-light btn-small blue-grey lighten-5 grey-text text-darken-1\" href=\"?RSVP=$eventid\">RSVP</a>";
				}
				else{
					echo "<a class=\"waves-effect waves-light btn-small blue-grey lighten-5 grey-text text-darken-1\" href=\"?UNRSVP=$eventid\">Un-RSVP</a>";
				}
			?>
			  <!-- Modal Structure -->
		          <div id="edit<?=$eventid?>" class="modal">
		            <div class="modal-content center-align">
		              <h4>Edit Event</h4>
		              <div class="row">
		                <form class="col s12" action="events.php" method="post">
	 	                  <div class="row">
		                    <div class="input-field col s12">
				      <input name="updateName" type="text" class="validate" value="<?=$title[$eventid]?>">
		                      <label for="name">Event Name</label>
		                    </div>
		                  </div>
		                  <div class="row">
		                    <div class="input-field col s12">
				      <input name="updateDate" type="text" class="datepicker" value="<?=htmlspecialchars($date[$eventid])?>">
		                      <label for="name">Event Date</label>
		                    </div>
		                  </div>
		                  <div class="row">
		                    <div class="input-field col s12">
		                      <input name="updateTime" type="text" class="timepicker" value="<?=$time[$eventid]?>">
				      <label for="name">Event Time</label>
		                    </div>
		                  </div>
			      <h6>*Please choose a building and room OR an address, but do not choose both.</h6><br>
				  <div class="input-field col s12">
        			    <select name="updateBuilding">
           			      <option value="" disabled selected>Choose Building and Room</option>
                		      <?php	
				        $brQuery = "select buildingRoom from location natural join event where eventid=$eventid";
                                        $brResult =  mysqli_query($conn, $brQuery);
                                        if($brs = mysqli_fetch_assoc($brResult)){
                                          $br = $brs['buildingRoom'];
                                        }
                		        $buildingQuery = "select buildingRoom from location";
                		        $buildingResult = mysqli_query($conn, $buildingQuery);
					$addQuery = "select address from location natural join event where eventid=$eventid";
                                        $addResult =  mysqli_query($conn, $addQuery);
                                        if($adds = mysqli_fetch_assoc($addResult)){
                                          $add = $adds['address'];
                                        }
                		        while($buildings = mysqli_fetch_assoc($buildingResult)){
					  if($br!="null" && $buildings["buildingRoom"] == $br){
					    	if($building["buildingRoom"]!="null"){
							echo "<option selected=\"selected\">".$buildings["buildingRoom"]."</option>";
				 	    	}
					}
					  else{
					    	if($building["buildingRoom"]!="null"){
                        	      	    		echo "<option>".$buildings["buildingRoom"]."</option>";
					    	}
					}
                		        }?>
         			    </select>
         			    <label>Building and Room</label>
      				  </div>
      				  <div class="input-field col s12">
        			    <select name="updateAddress">
           			      <option value="" disabled selected>Choose Address (Optional)</option>
                		      <?php
                		        $addressQuery = "select address from location";
                                        $addressResult = mysqli_query($conn, $addressQuery);
                                        while($addresses = mysqli_fetch_assoc($addressResult)){
						echo $addresses['address'];
					  if($add!="null" && $addresses["address"] == $add){
						if($adresses["address"]!="null"){
					    		echo "<option selected=\"selected\">".$addresses["address"]."</option>";
					  	}
					  }
					  else{
						 if($adresses['address']!="null"){
                                            		echo "<option>".$addresses["address"]."</option>";
						}  
					  }
                                      }?>
                                    </select>
                                    <label>Address</label>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s12">
                                      <textarea id="textarea2" name="updateDescription" class="materialize-textarea" data-length="120"><?=$description[$eventid]?></textarea>
                                      <label for="textarea2">Description</label>
                                    </div>
                                  </div>
		                  <button class="btn waves-effect waves-light blue-grey lighten-5 grey-text text-darken-1" type="submit" onclick='window.location.reload(true)' name="<?="update".$eventid?>">Update
		                  <i class="material-icons right"></i>
		                  </button>
		                </form>
		              </div>
		            </div>
			  </div>
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

for($j=1; $j<=max($allEventIds); $j++){
	$delete = $_GET['delete'];
	if(isset($delete) && $delete=="$j"){
		$eventidQuery = "select eventid from event where eventTime = '".$dateTimeRaw[$j]."'";
                $eventidResult = mysqli_query($conn, $eventidQuery);
		if($eventids = mysqli_fetch_assoc($eventidResult)){
			$eventid = $eventids['eventid'];
			$deleteQuery = "delete from event where eventid = $eventid";
			if(!mysqli_query($conn, $deleteQuery)){
				echo "ERROR".mysqli_error($conn);
			}
		}	
	}
        $RSVP = $_GET['RSVP'];
        if(isset($RSVP) && $RSVP=="$j"){
                $eventidQuery = "select eventid from event where eventTime = '".$dateTimeRaw[$j]."'";
		$eventidResult = mysqli_query($conn, $eventidQuery);
                if($eventids = mysqli_fetch_assoc($eventidResult))
		{
                        $eventid = $eventids['eventid'];
                        $attendsQuery = "select sid, eventid from attends";
			if(!$attendsResults = mysqli_query($conn, $attendsQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
			while ($attends = mysqli_fetch_assoc($attendsResults))
			{
				if ($attends['sid'] == $sid && $attends['eventid'] == $eventid)
				{
					$RSVPQuery = "update attends set RSVP = true where sid = $sid and eventid =  $eventid";
					break;
				}
				else{
					$RSVPQuery = "insert into attends (sid, eventid, RSVP, attend) values ($sid, $eventid, true, false)";
				}
			}
			
			if(!mysqli_query($conn, $RSVPQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
                }
		$RSVPEED[$eventid] = true;
		header("events.php");
        }
        $UNRSVP = $_GET['UNRSVP'];
        if(isset($UNRSVP) && $UNRSVP=="$j"){
                $eventidQuery = "select eventid from event where eventTime = '".$dateTimeRaw[$j]."'";
                $eventidResult = mysqli_query($conn, $eventidQuery);
                if($eventids = mysqli_fetch_assoc($eventidResult)){
                        $eventid = $eventids['eventid'];
                        $UNRSVPQuery = "update attends set RSVP = false where sid = $sid and eventid =  $eventid";
                        if(!mysqli_query($conn, $UNRSVPQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
                }
                $RSVPEED[$eventid] = false;
		header("events.php");
        }


	if(isset($_POST['update'.$j])){
			$updateQuery = "update event set";
			$updatedName = false;
			$updatedTime = false;
			$updatedLocation = false;
			if($_POST['updateName']!=$title[$j]) {
				$updatedName = true;
				$updateQuery = $updateQuery." event = '".$_POST['updateName']."'";
			}
			if($_POST['updateDate']!=$date[$j] || $_POST['updateTime']!=$time[$j]){
				$updatedTime = true;
				$dateTimeFormat = strtotime($_POST['updateDate']." ".$_POST['updateTime']);
        			$updateDateTime = date("Y-m-d H:i:s", $dateTimeFormat);
				if($updatedName){
					$updateQuery = $updateQuery.",";
				}
				$updateQuery = $updateQuery." eventTime = '".$updateDateTime."'";
			}
			if($_POST['updateBuilding']!=$locationB[$j] || $_POST['updateAddress']!=$locationA[$j]){
				$updatedLocation=true;
				if($updatedTime == true || $updatedName==true){
					 $updateQuery = $updateQuery.",";
				}
				if($_POST['building']!=$locationB[$j]){
					$newLocationQuery = "select locationid from location where buildingRoom = '".$_POST['updateBuilding']."'";
				}
				else if($_POST['address']!=$locationA[$j]){
					$newLocationQuery = "select locationid from location where address = '".$_POST['updateAddress']."'";
				}
				$newLocationIdResult = mysqli_query($conn, $newLocationQuery);
 		                if($newLocationIds = mysqli_fetch_assoc($newLocationIdResult)){
					$newLocationId = $newLocationIds['locationid'];
				}
				$updateQuery = $updateQuery." locationid = $newLocationId";
                        }
			if($_POST['updateDescription']!=$description[$j]){
				if($updatedLocation==true || $updatedTime==true || $updatedName==true){
					 $updateQuery = $updateQuery.",";
				}
				$updateQuery = $updateQuery." description = '".$_POST['updateDescription']."'";
			}
                        $updateQuery = $updateQuery." where eventid = $j";
                        if(!mysqli_query($conn, $updateQuery)){
                                echo "ERROR".mysqli_error($conn);
                        }
			header("events.php");
	}
	
}
?>
<div class="fixed-action-btn">
<?php if ($isOfficer)
{
	echo "<a class=\"btn-floating btn-large waves-effect waves-light modal-trigger blue-grey lighten-5\" href=\"#add\"><i class=\"material-icons grey-text text-darken-1t\">add</i></a><br>";
}
?>
</div>
<!-- Modal Structure -->
<div id="add" class="modal">
<div class="modal-content center-align">
<h4>Add Event</h4>
  <div class="row">
    <form class="col s12" action="events.php" method="post">
      <div class="row">
	<div class="input-field col s12">
          <input name="name" type="text" class="validate">
	  <label for="name">Event Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name="date" type="text" class="datepicker">
	  <label for="name">Event Date</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
	  <input name="time" type="text" class="timepicker">
	  <label for="name">Event Time</label>
        </div>
      </div>
      <h6>*Please choose a building and room OR an address, but do not choose both.</h6><br>
      <div class="input-field col s12">
        <select name="building">
           <option value="" disabled selected>Choose Building and Room</option>
		<?php
		$buildingQuery = "select buildingRoom from location";
                $buildingResult = mysqli_query($conn, $buildingQuery);
                while($buildings = mysqli_fetch_assoc($buildingResult)){
			if($buildings["buildingRoom"]!="null"){
				echo "<option>".$buildings["buildingRoom"]."</option>";
			}
                }?>
         </select>
         <label>Building and Room</label>
      </div>
      <div class="input-field col s12">
        <select name="address">
           <option value="" disabled selected>Choose Address (Optional)</option>
                <?php
                $addressQuery = "select address from location";
                $addressResult = mysqli_query($conn, $addressQuery);
                while($addresses = mysqli_fetch_assoc($addressResult)){
                        if($adresses["address"]!="null"){
				echo "<option>".$addresses["address"]."</option>";
			}
                }?>
         </select>
         <label>Address</label>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea id="textarea2" name="description" class="materialize-textarea" data-length="120"></textarea>
          <label for="textarea2">Description</label>
        </div>
      </div>
	<button class="modal-close btn waves-effect waves-light blue-grey lighten-5 grey-text text-darken-1" type="submit" name="add">Add
      <i class="material-icons right"></i>
    </form>
  </div>
</div>
</html>
<?php
include('footer.php');
  if(isset($_POST['add'])){
        $name = $_POST['name'];
        $dateTimeFormat = strtotime($_POST['date']." ".$_POST['time']);
        $dateTime = date("Y-m-d H:i:s", $dateTimeFormat);
        $buildingRoom= $_POST['building'];
        $address = $_POST['address'];
        $description = $_POST['description'];

        if(!empty($name) && !empty($dateTime) && !empty($description)){
                if(!empty($buildingRoom)){
		  $locationQuery = "select locationid from location where buildingRoom = '$buildingRoom'";
        	  $locationidResult = mysqli_query($conn, $locationQuery);
        	  if($locationids = mysqli_fetch_assoc($locationidResult)){
                    $locationid = $locationids["locationid"];
        	  }
                  $insertQuery = "insert into event(eventid, event, eventTime, description, sid, projectid, locationid) values (null, '$name', '$dateTime','$description', null, null, $locationid)";
		  mysqli_query($conn, $insertQuery);
                }
		else if(!empty($address)){
                  $locationQuery = "select locationid from location where address = '$address'";
                  $locationidResult = mysqli_query($conn, $locationidQuery);
                  while($locationids = mysqli_fetch_assoc($locationidResult)){
                    $locationid = $locationids["locationid"];
                  }
                  $insertQuery = "insert into event(eventid, event, eventTime, description, sid, projectid, locationid) values (null, '$name', '$dateTime','$description', null, null, $locationid)";
		  mysqli_query($conn, $insertQuery);
                }
                else{
                        $array_push($errors, "Must submit building and room OR address");
                }
        }
        else{
                $array_push($errors, "Missing a field");
        }
  } 

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

<?php $conn->close(); ?>
