<?php
require('./../../includes/dbConnect.inc.php');
include('./../../includes/config.php');

$email = $_POST['email'];
$password = $_POST['password'];

error_log(json_encode($_POST));

$response = array();

if (empty($email)) {
  $response['status'] = 'error';
  $response['message'] = 'Please enter your email address.';
}
else if (empty($password)) {
  $response['status'] = 'error';
  $response['message'] = 'Please enter your password.';
} else {
  $response['status'] = 'success';
  $response['message'] = 'Successfully signed in.';
}

echo json_encode($response);
?>