<?php
$pageName = "Login";
?>

<!doctype html>
<html>
<head>
  <?php include('./../includes/resources/header.php'); ?>
</head>
<body>
  <form id="loginForm">
    <input type="text" class="email" name="email" />
    <input type="password" class="password" name="password" />
    <button type="submit">Login</button>
  </form>
  <div class="errorMessage"></div>
</body>
  <?php include('./../includes/resources/footer.php'); ?>
</html>