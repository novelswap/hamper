<?php
require('./../../includes/dbConnect.inc.php');
include('./../../includes/config.php');
require('./../../vendor/autoload.php');

$db = new MysqliDb($mysqli);

$email = $_POST['email'];
$password = $_POST['password'];

$response = array();

if (empty($email)) {
  $response['status'] = 'error';
  $response['message'] = 'Please enter your email address.';
}
else if (empty($password)) {
  $response['status'] = 'error';
  $response['message'] = 'Please enter your password.';
} else {
  $result = $db->where('email', "$email")->where('active', 1)->where('deleted', 0)->get('users', null, "userID, password");

  foreach($result as $row) {
    if (password_verify($password, $row['password'])) {
      $db->where('userID', $row['userID'])->update('users', array(
        'lastLogin' => date('Y-m-d H:i:s')
      ));

      session_start();
      $_SESSION['userID'] = $row['userID'];

      $response['status'] = 'success';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Your password is incorrect.';
    }
  }
}

echo json_encode($response);
?>