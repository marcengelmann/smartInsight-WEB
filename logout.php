<?php
session_start();
$username = $_SESSION["username"];
if(session_destroy()){
    require("db.php");
    if(isset($username)) {
        $update = "UPDATE users SET currently_online = 0 WHERE username = '$username'";
        mysql_query($update);
    }
header("Location: login.php?from=logout");
echo("should have done something!");
exit(); }
?>
