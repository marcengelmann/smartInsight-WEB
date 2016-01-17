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

require('strings.php');

$connection = mysql_connect('localhost',$database_name, $database_password);
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db($database_name);
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>
