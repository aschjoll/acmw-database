<?php
        include('config.php');
	include('header.php');

        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT event, eventTime, description, locationid FROM event";
        $result = $conn->query($sql);
?>

<html>

<?php   if ($result->num_rows > 0) {
		$i = 0;
		// output data of each row
                while($i < $result->num_rows) {
			$row = mysqli_fetch_assoc($result);
			$title = $row['event'];
			$dateTime = $row['eventTime'];
			$dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
			$formattedDateTime = $dateTime->format('F jS Y, g:i a');
			$description = $row['description'];
			$locationid = $row['locationid'];
?>
  <div class="row">
    <div class="col s12">
      <div class="card-panel blue lighten-4">
        <span class="blue-grey-text text-darken-3">
	  <h4><?php echo $title?></h4>
	  <div class="divider blue-grey darken-3"></div>
	  <h6><?php echo $formattedDateTime?></h6>
	  <?php echo $description?><br><br>
	  <a class="waves-effect waves-light btn-small modal-trigger orange lighten-2" href="#edit">Edit</a>
          <a class="waves-effect waves-light btn-small orange lighten-2">Delete</a>
	    <!-- Modal Structure -->
            <div id="edit" class="modal">
              <div class="modal-content">
                <h4>Edit Event</h4>
                  <p>A bunch of text</p>
              </div>
              <div class="modal-footer">
               <a href="#!" class="modal-close waves-effect waves-green btn-flat">Yup</a>
              </div>
            </div>
        </span>
      </div>
    </div>
  </div>

<?php
			$i++;
		}
  	} else {
		echo "0 results";
  	}
?>

<a class="btn-floating btn-large waves-effect waves-light modal-trigger orange lighten-2" href="#add"><i class="material-icons">add</i></a>
 <!-- Modal Structure -->
 <div id="add" class="modal">
   <div class="modal-content">
     <h4>Add Event</h4>
     <p>A bunch of text</p>
   </div>
   <div class="modal-footer">
     <a href="#!" class="modal-close waves-effect waves-green btn-flat">Yup</a>
   </div>
 </div>

</html>

<?php
  include('footer.php'); 
?>

<script>
  jQuery(document).ready(function(){
    jQuery('.modal').modal();
  });
</script>

<?php $conn->close(); ?>
