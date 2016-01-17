<?php
ini_set('session.use_cookies', '1');
session_start();
//print_r($_SESSION);
//echo($_SESSION['username']);
//echo($_SESSION["username"]);
//echo("HÄÄÄ!=!=!=!");
if(!isset($_SESSION["username"])){
header("Location: login.php");
echo("should have done something!");
exit(); }
?>
