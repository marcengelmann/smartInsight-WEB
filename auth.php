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

ini_set('session.use_cookies', '1');
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
echo("should have done something!");
exit(); }
?>
