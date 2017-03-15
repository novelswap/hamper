<?php
// RENAME THIS FILE TO 'dbConnect.inc.php'
// CHANGE THE DETAILS BELOW


//Change these details to new database
//Include this on every php page where you need to get or insert summet in database
$host="XXX"; // Host name
$username="XXX"; // Mysql username
$password="XXX&"; // Mysql password
$db_name="XXX"; // Database name
$mysqli = new MySQLi($host, $username,$password, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>