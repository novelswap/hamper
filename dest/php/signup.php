<?php
include('./../../includes/dbConnect.inc.php');
include('./../../includes/config.php');
require('./../../vendor/joshcam/mysqli-database-class/MysqliDb.php');

$db = new MysqliDb($mysqli);

// POST VARIABLES
$firstname = $_POST['firstname'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$notifications = $_POST['notifications'];

$response_array = array();
$response_array['status'] = 'error';
$response_array['message'] = '';

$formError = true;

// Validation
// 1. Verify all inputs are filled in
// 2. Verify passwords are the same
// 3. Verify email is valid
// 4. Verify the email has not been used

if (empty($firstname)) {
  $response_array['message'] = 'Please enter your firstname.';
}
else if (empty($surname)) {
  $response_array['message'] = 'Please enter your surname.';
}
else if (empty($email)) {
  $response_array['message'] = 'Please enter your email.';
}
else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $response_array['message'] = 'Please make sure that your email is valid.';
}
else if (empty($password)) {
  $response_array['message'] = 'Please enter a password.';
}
else if (empty($confirmPassword)) {
  $response_array['message'] = 'Please confirm your password.';
}
else if ($confirmPassword === $password) {
  $response_array['message'] = 'Please make sure that the passwords match.';
} else {
  $formError = false;
}

if ($formError === false) {
  // Validate the emails not been used
  $emailUsed = $db->where('email', "$email")->get('users', null, 'userID');

  if ($db->count > 0) {
    $response_array['message'] = "This email has already been used. Click <a href='forgotten-password.php'>here</a> if you would like to reset your password.";
  }
} else {
  $formError = false;
}

if ($formError === )

// Insert into the users table

// Insert into the confirmation table
// Send email to the user

echo json_encode($response_array);
?>