<?php
include('./../includes/dbConnect.inc.php');
include('./../includes/config.php');
require('./../vendor/autoload.php');
use Mailgun\Mailgun;

$mg = new Mailgun($mailgun);
$db = new MysqliDb($mysqli);

$key = $_GET['key'];
$email = $_GET['email'];

$content = '';

if (!isset($_GET['key']) || !isset($_GET['email'])) {
  $content = 'There has been an error. Please try again.';
} else {
  $confirmation = $db->where('email', "$email")->where('`key`', "$key")->orderBy('id', 'desc')->get('userConfirm', 1, 'userID, datetime');

  foreach($confirmation as $user) {
    error_log(json_encode($user));
    $confirmationTimeout = new DateTime($user['datetime']);
    $confirmationTimeout->modify('+4 hours');
    $today = date('Y-m-d H:i:s');

    error_log($confirmationTimeout->format('Y-m-d H:i:s'));
    error_log($today);
    error_log($confirmationTimeout->format('Y-m-d H:i:s') <= $today);

    if ($confirmationTimeout->format('Y-m-d H:i:s') >= $today) {
      
      $users = $db->where('userID', $user['userID'])->get('users', 1, 'active');
      
      foreach($users as $record) {

        if ($record['active'] == 1) {
          $content = 'Your account is already activated!';
        } else {
          $db->where('userID', $user['userID'])->update('users', array(
            'active' => 1,
            'modifiedOn' => $today
          ));

          $content = 'Your account is now active. Rock on!';
        }
      }

      

    } else {
      $content = "We're sorry the link you have clicked has expired! We have just sent you another email!";

      $hash = bin2hex(random_bytes(32));

      $confirmationID = $db->insert('userConfirm', array(
        'userID' => $user['userID'],
        'key' => $hash,
        'email' => $email,
        'datetime' => $today
      ));

      // Send email to the user
      $emailContent = "<p>Hello,</p>";
      $emailContent .= "<p>Here is another email to confirm your account!</p>";
      $emailContent .= "<h4>To activate your account please <a href='https://hh.joshghent.com/dest/activate-account.php?email=$email&key=$hash'>click here</a></h4>";

      $confirmationEmail = $mg->sendMessage($domain, array(
        'from' => 'Confirm Registration <no-reply@hh.joshghent.com>',
        'to' => $email,
        'subject' => "Confirm Registration",
        'html' => $emailContent
      ));
    }
  }
}




?>

<html>
<head>
  <?php include('./../includes/resources/header.php'); ?>
</head>
<body>
  <h1><?php echo $content ?></h1>
</body>
  <?php include('./../includes/resources/footer.php'); ?>
</html>