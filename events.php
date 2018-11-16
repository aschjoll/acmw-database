<?php
        include('config.php');

        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT event, eventTime, description, locationid FROM event";
        $result = $conn->query($sql);
	//$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" href="mainstyles.css" type="text/css">
</head>
<body>
<div class="container">
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
	<?php echo $description?>
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
 <!-- Modal Trigger -->
<div class="fixed-action-btn">
  <a class="waves-effect waves-light btn-floating btn-large orange lighten-3  modal-trigger" href="#modal">+<a>
</div>

</div>
</body>
</html>

<?php $conn->close(); ?>

