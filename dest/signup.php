<?php
$pageName = "Sign Up";
?>

<!doctype html>
<html>
<head>
  <?php include('./../includes/resources/header.php'); ?>
</head>
<body>
  <form id="signupForm">
    <input type="text" class="firstname" name="firstname" />
    <input type="text" class="surname" name="surname" />
    <input type="text" class="email" name="email" />
    <input type="password" class="password" name="password" />
    <input type="password" class="confirmPassword" name="confirmPassword" />
    <label>
      <input type="checkbox" name="notifications" selected/> I agree to occationally recieve marketing emails 
    </label>
    <button type="submit">Signup</button>
  </form>
  <div class="errorMessage"></div>
</body>
  <?php include('./../includes/resources/footer.php'); ?>
</html>