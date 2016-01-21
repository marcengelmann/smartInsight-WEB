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
include('functions.php');

$date_string = "Y-m-d H:i:s";

$intent = $_GET['intent'];
$matrikelnummer = $_GET['matrikelnummer'];
$task_id = $_GET['task_id'];
$subtask_id = $_GET['subtask_id'];
$type_of_question = $_GET['type_of_question'];
$exam_name = $_GET['exam_name'];
$password = $_GET['pw'];
$request_id = $_GET['request_id'];
$seat = $_GET['seat'];

$deviceID  = $_GET['deviceID'];
$phd_id = $_GET['phd'];
$email = $_GET['email'];

if($subtask_id == null) {
    $phd = getValueForKey($task_db_name,"id",$task_id,"linked_phd");
} else {
    $phd = getValueForKey($subtask_db_name,"id",$subtask_id,"linked_phd");
}

header('Content-type:application/json');

//Wenn Passwort oder Prüfungsname nicht gesetzt sind, wird die Seite geschlossen.
if(!isset($exam_name)||!isset($password)) {
    exit();
}
//CHECK ob die mit dem Passwort verknüpfte Prüfung auch die geforderte Prüfung ist.
if(getExamByPassword($password)!=$exam_name) {
    echo(json_encode(array("result"=>"access_denied")));
    exit();
} else if($intent == "delete_request") {
    $query = "delete from requests WHERE id = ".$request_id;
    mysql_query($query);
    $settings = array("result"=>"true");
} else if($intent == "request_done") {
    $query = "UPDATE requests SET done = '1', status_changed = now() WHERE id = ".$request_id;
    mysql_query($query);
    $settings = array("result"=>"true");
} else if($intent == "userdata") {
    if(!empty($deviceID)&&!empty($email)&&!empty($phd_id)) {
        $query = "UPDATE phds SET deviceID = '$deviceID', deviceID_registration_date = now() WHERE id = $phd_id";
        mysql_query($query);
        $settings = array("result"=>"true");
    } else {
        $query = "UPDATE students SET seat_number = $seat WHERE matrikelnummer = $matrikelnummer";
        mysql_query($query);
        $settings = array("result"=>"true");
    }
}else if($intent == "request") {

    //CHECK ob nicht schon genau so eine Anfrage existiert.
    $check_query = "SELECT * FROM requests WHERE linked_student = $matrikelnummer AND linked_task = $task_id AND linked_subtask = $subtask_id";
    $check_result = mysql_query($check_query);

    if(mysql_num_rows($check_result) != 0) {
        echo(json_encode(array("result"=>"Es existiert bereits eine Anfrage für diese Aufgabe.")));
        exit();
    } else {
        $start_time = date($date_string, time());
        $end_time = date($date_string, time()+600);

//        echo "vor-start: ".$start_time."<br/>";
//        echo "vor-end: ".$end_time."<br/>";

        //CHECK ob nicht schon eine Anfrage geplant ist.

        $date_query = "SELECT * FROM requests WHERE linked_student = $matrikelnummer AND linked_exam = '$exam_name' ORDER BY end_time DESC";
        $date_query_reverse = "SELECT * FROM requests WHERE linked_student = $matrikelnummer AND linked_exam = '$exam_name' ORDER BY end_time ASC";

        $phd_query = "SELECT * FROM requests WHERE linked_phd = $phd AND linked_exam = '$exam_name' ORDER BY end_time DESC";
        $phd_query_reverse = "SELECT * FROM requests WHERE linked_phd = $phd AND linked_exam = '$exam_name' ORDER BY end_time ASC";

        $date_result = mysql_query($date_query);
        $date_result_reverse = mysql_query($date_query_reverse);

        $phd_result = mysql_query($phd_query);
        $phd_result_reverse = mysql_query($phd_query_reverse);

        //CHECK ob schon eine Anfrage existiert.
        if(mysql_num_rows($date_result) != 0) {

            $date_item = mysql_fetch_assoc($date_result);
            $date_item_time = date($date_string, strtotime($date_item['end_time']));

            //Prüfen ob, noch platz zwischen erstem und aktueller zeit ist.
            //DURCH ALLE DURCH LOOPEN, ob noch Platz ist


            //CHECK ob sich die Anfrage Zeit überschneiden würde.
            if(strtotime($date_item_time)>strtotime($start_time)) {
                $start_time = date($date_string, strtotime($date_item['end_time']));
                $end_time = date($date_string, strtotime($date_item['end_time'])+600);
            }
        }

        //CHECK ob es schon Anfragen für den PhD gibt.
        if(mysql_num_rows($phd_result) != 0) {

            $phd_date_item = mysql_fetch_assoc($phd_result);
            $phd_date_item_time = date($date_string, strtotime($phd_date_item['end_time']));

            if(strtotime($phd_date_item_time)>strtotime($start_time)) {
                $start_time = date($date_string, strtotime($phd_date_item['end_time']));
                $end_time = date($date_string, strtotime($phd_date_item['end_time'])+600);
            }
        } else {
            //5 Minuten Zeit bei der ersten Anfrage für den Prüfer, um in den Raum zu kommen.
            $enter_delay = 5; // in Minuten
            $start_time = date($date_string, strtotime($start_time)+60*$enter_delay);
            $end_time = date($date_string, strtotime($end_time)+60*$enter_delay);
        }

        //CHECK ob schon eine Anfrage existiert.
        if(mysql_num_rows($date_result_reverse) != 0) {

            $date_item_reverse = mysql_fetch_assoc($date_result_reverse);
            $date_item_time_reverse = date($date_string, strtotime($date_item_reverse['start_time']));
            $now = date($date_string, time());

            //CHECK ob vor der ersten Anfrage des Studenten noch Platz ist.
            if(abs(strtotime($date_item_time_reverse)-strtotime($now))>10*60) {
                $start_time = $now;
                $end_time = date($date_string, strtotime($now)+600);
            } else {
                //CHECK ob zwischen 2 Elementen noch Platz ist.
                $time = date($date_string, strtotime($now)+600);

                while($current_time_item = mysql_fetch_assoc($date_result_reverse)) {

                    $current_time_item_reverse_start = date($date_string, strtotime($current_time_item['start_time']));
                    $current_time_item_reverse_end = date($date_string, strtotime($current_time_item['end_time']));

                    if(abs(strtotime($current_time_item_reverse_start)-strtotime($time))>10*60) {
                        $start_time = date($date_string, strtotime($time));
                        $end_time = date($date_string, strtotime($time)+600);
                        break;
                    }
                    $time = $current_time_item_reverse_end;
                }
            }
        }

        $query= "insert into requests (`linked_subtask`,`linked_task`,`linked_exam`,`linked_phd`,`linked_student`,`submission_date`,`start_time`,`end_time`,`type_of_question`)    values('$subtask_id','$task_id','$exam_name','$phd','$matrikelnummer',now(),'$start_time','$end_time','$type_of_question')";
        $settings = array("result"=>"true");
        mysql_query($query);

        include('push.php');

        $res = launchPushService(getValueByKey($phd_db_name, "id", $phd,'deviceID'),"Neue Anfrage bei SmartInsight","Anfrage von ".getNameOfStudent($matrikelnummer,$exam_name)." betreffs $type_of_question!");
        echo $res;
    }
} else {
    $settings = array("result"=>"Ein unbekannter Fehler ist aufgetreten!");
}
echo(json_encode($settings));
?>
