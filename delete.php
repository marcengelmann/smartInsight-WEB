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

require('db.php');
include("auth.php"); //include auth.php file on all secure pages
include("strings.php");

$id_name = $_GET['id'];
$db_name = $_GET['db_name'];
$query_name = $_GET['show'];

//echo $id_name." ";
//echo $db_name." ";
//echo $query_name;


if($id_name == "all") {
    if($db_name == $task_db_name) {
        $query = "TRUNCATE `".$db_name."`";
        $result = mysql_query($query) or die ( mysql_error());
        header("Location: details.php?id=$query_name");
    } else if($db_name == $exam_db_name) {
        $query1 = "TRUNCATE `".$db_name."`";
        $result = mysql_query($query1) or die ( mysql_error());
        $query2 = "TRUNCATE `task`";
        $resul2 = mysql_query($query2) or die ( mysql_error());
        $query3 = "TRUNCATE `subtask`";
        $resul3 = mysql_query($query3) or die ( mysql_error());
        header("Location: view.php?show=$query_name");
    }else {
    $query = "TRUNCATE `".$db_name."`";
    $result = mysql_query($query) or die ( mysql_error());
    header("Location: view.php?show=$query_name");
    }
} else {
    if($db_name == $subtask_db_name) {
        $query = "DELETE FROM `subtask` WHERE id = $id_name;";
        $result = mysql_query($query) or die ( mysql_error());
        header("Location: details.php?id=$query_name");

    } else if($db_name == $task_db_name) {

        //Hier nicht nur die Aufgabe, sondern auch alle Unteraufgaben löschen.
        $query = "DELETE FROM `".$db_name."` WHERE id = '".$id_name."'";
        $result = mysql_query($query) or die ( mysql_error());
        $query2 = "DELETE FROM `subtask` WHERE linked_task = ".$id_name." AND linked_exam = '".$query_name."';";
        $result = mysql_query($query2) or die ( mysql_error());

        header("Location: details.php?id=$query_name");
    } else if($db_name == $exam_db_name) {

        //Beim Löschen einer Klausur werden alle Aufgaben und Unteraufgaben mitgelöscht.
        $query = "DELETE FROM `".$db_name."` WHERE id = ".$id_name;
        $result = mysql_query($query) or die ( mysql_error());
        $query2 = "DELETE FROM `task` WHERE linked_exam = '".$query_name."'";
        $result2 = mysql_query($query2) or die ( mysql_error());
        $query3 = "DELETE FROM `subtask` WHERE linked_exam = '".$query_name."'";
        $result3 = mysql_query($query3) or die ( mysql_error());

        header("Location: view.php?show=$query_name");
    }else {
        $query = "DELETE FROM `".$db_name."` WHERE id = ".$id_name;
        $result = mysql_query($query) or die ( mysql_error());
        header("Location: view.php?show=$query_name");
    }
}
?>
