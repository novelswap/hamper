<?php
require('./../../includes/dbConnect.inc.php');
include('./../../includes/config.php');

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
  
}

// Insert into the users table
// Insert into the confirmation table

// Send email to the user
?>