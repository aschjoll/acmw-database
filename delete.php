<?php

function respond($data) {
  echo @json_encode($data);
  exit;
}

if (empty($_POST)) respond(array('error' => 'Invalid request')); 

$table_name = $_POST['table_name'];
$id = $_POST['id'];

$response = deleteRecord($table_name, $id);

if ($response == $what_you_expect_on_a_successful_delete) {
  // create a response message, in associative array form
  $message = array('success' => true);

  // add some other information to your message as needed
  $message['sideNote'] = 'I like waffles.';

  // respond with your message
  respond($message);
}

// if we got this far your delete failed
respond(array('error' => 'Request Failed'));

?>
