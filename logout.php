<?php

/**
 * Smart Insight Version 1.0
 *
 * Das Tool Smart Insight dient der Erstellung und
 * Verwaltung von Prüfungseinsichten mithilfe einer
 * mobilen Applikation.
 *
 * @author      Marc Engelmann
 * @date        12.01.2016
 * @version     1.0
 *
 */

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
