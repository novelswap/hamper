<?php
include('./../../includes/dbConnect.inc.php');
include('./../../includes/config.php');
require('./../../vendor/autoload.php');
use Mailgun\Mailgun;

$mg = new Mailgun($mailgun);
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

error_log($confirmPassword == $password);

if (empty($firstname)) {
  $response_array['message'] = 'Please enter your firstname.';
}
else if (empty($surname)) {
  $response_array['message'] = 'Please enter your surname.';
}
else if (empty($email)) {
  $response_array['message'] = 'Please enter your email.';
}
else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  $response_array['message'] = 'Please make sure that your email is valid.';
}
else if (empty($password)) {
  $response_array['message'] = 'Please enter a password.';
}
else if (empty($confirmPassword)) {
  $response_array['message'] = 'Please confirm your password.';
}
else if ($confirmPassword != $password) {
  $response_array['message'] = 'Please make sure that the passwords match.';
} else {
  $formError = false;
}

if ($formError === false) {
  // Validate the emails not been used
  $emailUsed = $db->where('email', "$email")->get('users', null, 'userID');

  // If a row with that email was found then return an error
  if ($db->count > 0) {
    $response_array['message'] = "This email has already been used. Click <a href='forgotten-password.php'>here</a> if you would like to reset your password.";
  }

  else {

    $options = [
      'cost' => 12
    ];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    $today = date('Y-m-d H:i:s');

    // Insert into the users table
    $userID = $db->insert('users', array(
      'firstname' => $firstname,
      'surname' => $surname,
      'email' => $email,
      'password' => $hashedPassword,
      'active' => 0,
      'deleted' => 0,
      'createdOn' => $today,
      'modifiedOn' => $today
    ));

    // Insert into the confirmation table

    $hash = bin2hex(random_bytes(32));

    $confirmationID = $db->insert('userConfirm', array(
      'userID' => $userID,
      'key' => $hash,
      'email' => $email,
      'datetime' => $today
    ));

    // Send email to the user
    $emailContent = "<p>Hello $firstname $surname,</p>";
    $emailContent .= "<p>Thank you for signing up to HH!</p>";
    $emailContent .= "<h4>To activate your account please <a href='https://hh.joshghent.com/dest/activate-account?email=$email&key=$hash'>click here</a></h4>";

    $confirmationEmail = $mg->sendMessage($domain, array(
      'from' => 'Confirm Registration <no-reply@hh.joshghent.com>',
      'to' => $email,
      'subject' => "Thanks for signing up $firstname!",
      'html' => $emailContent
    ));

    $response_array['status'] = 'success';
    $response_array['message'] = 'Thank you for registering. Please check your email to activate your account.';
  }
}



echo json_encode($response_array);
?>