<?php
        include('config.php');

        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT eventid, event, eventTime FROM event";
        $result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
                while($row = $result->fetch_assoc()) {
                        echo "id: " . $row["eventid"]. " - Event: " . $row["event"]. " - Time: " . $row["eventTime"]. "<br>";
                }
 	} else {
                echo "0 results";
        }

$conn->close(); 
?>
