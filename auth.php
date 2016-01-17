<?php
ini_set('session.use_cookies', '1');
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
echo("should have done something!");
exit(); }
?>
