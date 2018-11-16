<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'WECjk876g11!');
   define('DB_DATABASE', 'acmwDB');

   // attempt to connect
   $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

  // Check connection
  if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>
