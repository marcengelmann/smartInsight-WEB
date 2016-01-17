<?php include("auth.php");
if(isset($_SESSION["username"])){
header("Location: dashboard.php");
echo("should have done something!");
exit(); }
?>
