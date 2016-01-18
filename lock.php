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

include('auth.php');
include('db.php');

$id = $_GET['id'];
$status = $_GET['status'];

if($status == 1) {
    $status = 0;
} else {
    $status = 1;
}

$query = "UPDATE exams SET locked = $status WHERE id = $id";
mysql_query($query);
header("Location: view.php?show=exam");
?>
