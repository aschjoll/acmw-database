<?php
include('config.php');
include('header.php');

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT eventid, event, eventTime, description, locationid, buildingRoom, address FROM event natural join location";
$result = $conn->query($sql);
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
		if($row['buildingRoom']==null){
			$location[$eventid] = $row['address'];
		}
		else{
			$location[$eventid] = $row['buildingRoom'];
		}

		array_push($allEventIds, $eventid);

?>
		<div class="row">
		  <div class="col s12">
		    <div class="card-panel blue lighten-4">
		      <span class="blue-grey-text text-darken-3">
		        <h4><?php echo $title[$eventid]?></h4>
		        <div class="divider blue-grey darken-3"></div>
		          <h6><?php echo $formattedDateTime[$eventid]?></h6>
			  <h6><?php echo $location[$eventid]?></h6>
		          <?php echo $description[$eventid]?><br><br>
		          <a class="waves-effect waves-light btn-small modal-trigger orange lighten-2" href="#edit<?=$eventid?>">Edit</a>
		          <a class="waves-effect waves-light btn-small orange lighten-2" href="?delete=<?=$eventid?>">Delete</a>
		          <!-- Modal Structure -->
		          <div id="edit<?=$eventid?>" class="modal">
		            <div class="modal-content">
		              <h4>Edit Event</h4>
		              <div class="row">
		                <form class="col s12" action="events.php" method="post">
	 	                  <div class="row">
		                    <div class="input-field col s6">
	 	                      <!--<input id="name" type="text" class="validate" value=<?//=$title[$eventid]?>">-->
				      <input name="updateName" type="text" class="validate" value="<?=$title[$eventid]?>">
		                      <label for="name">Event Name</label>
		                    </div>
		                  </div>
		                  <div class="row">
		                    <div class="input-field col s6">
		                      <!--<input type="text" class="datepicker" value="<?//=htmlspecialchars($date[$eventid])?>">-->
				      <input name="updateDate" type="text" class="datepicker" value="<?=htmlspecialchars($date[$eventid])?>">
		                      <label for="name">Event Date</label>
		                    </div>
		                  </div>
		                  <div class="row">
		                    <div class="input-field col s6">
		                      <!--<input type="text" class="timepicker" value="<?//=$time[$eventid]?>">-->
		                      <input name="updateTime" type="text" class="timepicker" value="<?=$time[$eventid]?>">
				      <label for="name">Event Time</label>
		                    </div>
		                  </div>
				  <div class="input-field col s6">
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
					    echo "<option selected=\"selected\">".$buildings["buildingRoom"]."</option>";
				 	  }
					  else{
                        	      	    echo "<option>".$buildings["buildingRoom"]."</option>";
					  }
                		        }?>
         			    </select>
         			    <label>Building and Room</label>
      				  </div>
      				  <div class="input-field col s6">
        			    <select name="updateAddress">
           			      <option value="" disabled selected>Choose Address (Optional)</option>
                		      <?php
                		        $addressQuery = "select address from location";
                                        $addressResult = mysqli_query($conn, $addressQuery);
                                        while($addresses = mysqli_fetch_assoc($addressResult)){
					  if($add!="null" && $addresses["address"] == $add){
					    echo "<option selected=\"selected\">".$addresses["address"]."</option>";
					  }
					  else{
                                            echo "<option>".$addresses["address"]."</option>";
					  }
                                      }?>
                                    </select>
                                    <label>Address</label>
                                  </div>
                                  <div class="row">
                                    <div class="input-field col s6">
                                      <textarea id="textarea2" name="updateDescription" class="materialize-textarea" data-length="120"><?=$description[$eventid]?></textarea>
                                      <label for="textarea2">Description</label>
                                    </div>
                                  </div>
		                  <button class="btn waves-effect waves-light" type="submit" name="<?="update".$eventid?>">Update
		                  <i class="material-icons right"></i>
		                  </button>
		                </form>
		              </div>
		            </div>
		            <!--<div class="modal-footer">
		            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Yup</a>
	 	            </div>-->
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

	if(isset($_POST['update'.$j])){
			$updateQuery = "update event set";
			$updatedName = false;
			$updatedTime = false;
			$updatedLocation = false;
			if($_POST['updateName']!=$title[$j]){
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
	}
	
}
		
		

?>

<a class="btn-floating btn-large waves-effect waves-light modal-trigger orange lighten-2" href="#add"><i class="material-icons">add</i></a>
<!-- Modal Structure -->
<div id="add" class="modal">
<div class="modal-content">
<h4>Add Event</h4>
  <div class="row">
    <form class="col s12" action="events.php" method="post">
      <div class="row">
	<div class="input-field col s6">
          <input name="name" type="text" class="validate">
	  <label for="name">Event Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input name="date" type="text" class="datepicker">
	  <label for="name">Event Date</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
	  <input name="time" type="text" class="timepicker">
	  <label for="name">Event Time</label>
        </div>
      </div>
      <div class="input-field col s6">
        <select name="building">
           <option value="" disabled selected>Choose Building and Room</option>
		<?php
		$buildingQuery = "select buildingRoom from location";
                $buildingResult = mysqli_query($conn, $buildingQuery);
                while($buildings = mysqli_fetch_assoc($buildingResult)){
			echo "<option>".$buildings["buildingRoom"]."</option>";
                }?>
         </select>
         <label>Building and Room</label>
      </div>
      <div class="input-field col s6">
        <select name="address">
           <option value="" disabled selected>Choose Address (Optional)</option>
                <?php
                $addressQuery = "select address from location";
                $addressResult = mysqli_query($conn, $addressQuery);
                while($addresses = mysqli_fetch_assoc($addressResult)){
                        echo "<option>".$addresses["address"]."</option>";
                }?>
         </select>
         <label>Address</label>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <textarea id="textarea2" name="description" class="materialize-textarea" data-length="120"></textarea>
          <label for="textarea2">Description</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="add">Add
      <i class="material-icons right"></i>
    </form>
  </div>

</div>
<!-- <div class="modal-footer">
<a href="#!" class="modal-close waves-effect waves-green btn-flat">Yup</a>
</div>-->
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
