<?php
$pageName = "Sign Up";
?>

<!doctype html>
<html>
<head>
  <?php include('./../includes/resources/header.php'); ?>
</head>
<body>
  <div class="successMessage"></div>
  <form id="signupForm">
    <div class="form-group">
      <span>Firstname</span>
      <input type="text" class="firstname" name="firstname" />
    </div>

    <div class="form-group">
      <span>Surname</span>
      <input type="text" class="surname" name="surname" />
    </div>

    <div class="form-group">
      <span>Email</span>
      <input type="text" class="email" name="email" />
    </div>

    <div class="form-group">
      <span>Password</span>
      <input type="password" class="password" name="password" />

      <span>Confirm Password</span>
      <input type="password" class="confirmPassword" name="confirmPassword" />
    </div>

    <label>
      <input type="checkbox" name="notifications" selected/> I agree to occationally recieve marketing emails 
    </label>
    <button type="submit">Signup</button>
  </form>
  <div class="errorMessage"></div>
</body>
  <?php include('./../includes/resources/footer.php'); ?>
</html>