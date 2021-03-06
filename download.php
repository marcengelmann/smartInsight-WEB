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

error_reporting(E_ALL ^ E_DEPRECATED);

require('db.php');
require('strings.php');
include('functions.php');

$intent = isset($_GET['intent']) ? $_GET['intent']  : null;
$matrikelnummer = isset($_GET['matrikelnummer']) ? $_GET['matrikelnummer']  : null;
$exam_name =  isset($_GET['exam_name']) ? $_GET['exam_name']  : null;
$type =  isset($_GET['type']) ? $_GET['type']  : null;
$password =  isset($_GET['pw']) ? $_GET['pw']  : null;

$id_phd =  isset($_GET['phd']) ? $_GET['phd']  : null;
$email =  isset($_GET['email']) ? $_GET['email']  : null;

$phd_mode = false;

$posts = null;

//Wenn Passwort oder Prüfungsname nicht gesetzt sind, wird die Seite geschlossen.
if(!isset($exam_name)||!isset($password)) {
    exit();
}

if(!empty($email)&&!empty($id_phd)) {
    $phd_mode = true;
} else {
    $phd_mode = false;
}

//CHECK ob die mit dem Passwort verknüpfte Prüfung auch die geforderte Prüfung ist.
if(getExamByPassword($password)!=$exam_name) {
    exit();
}

if($type == "all") {
    $query = "SELECT * from ".$intent;
    $result = mysql_query($query);
    $val = 0;
    if(mysql_num_rows($result)) {
        while($post = mysql_fetch_assoc($result)) {
            $posts[$val] = $post;
            $val = $val+1;
        }
    }
} else if($intent == "request") {
    if($phd_mode) {
        $query = "SELECT * from `requests` WHERE linked_phd = $id_phd AND linked_exam = '$exam_name' AND DATE(start_time) = DATE(NOW()) ORDER BY start_time ASC";
    } else {
        $query = "SELECT * from `requests` WHERE linked_student = $matrikelnummer AND linked_exam = '$exam_name' AND DATE(start_time) = DATE(NOW()) ORDER BY start_time ASC";
    }
    $result = mysql_query($query);
    $val = 0;
    if(mysql_num_rows($result)) {
        while($post = mysql_fetch_assoc($result)) {

            $post['task_name'] = getValueByKey($task_db_name, "id", $post['linked_task'],"number");
            $post['subtask_name'] = getValueByKey($subtask_db_name, "id", $post['linked_subtask'],"letter");
            if($phd_mode) {
                $post['seat'] = getSeatbyMatrikel($post['linked_student'],$exam_name);
                $post['linked_student'] = getNameOfStudent($post['linked_student'],$exam_name);
            } else {
               $post['linked_phd'] = getValueByKey($phd_db_name, "id", $post['linked_phd'],'name');
            }
            if($post['subtask_name'] == null) {
                $post['subtask_name'] = "";
            }
            $posts[$val] = $post;
            $val = $val+1;
        }
    }
} else if($intent == "calendar" && $phd_mode == true) {
    if($phd_mode) {
        $query = "SELECT * from `exams`";
        $result = mysql_query($query);
        $val = 0;
        while($post = mysql_fetch_assoc($result)) {
            unset($post['password']); // Das Passwort wird nicht heruntergeladen!
            $post['date'] = date("d.m.Y", strtotime($post['date']));
            $post['responsible_person'] = getValueByKey($phd_db_name, "id", $post['responsible_person'],'name');
            $posts[$val] = $post;
            $val ++;
        }
    }
} else if($intent == "calendar") {
    $query = "SELECT * from `students` WHERE matrikelnummer = ".$matrikelnummer;
    $result = mysql_query($query);
    $val = 0;
    while($super_post = mysql_fetch_assoc($result)) {
        $query_2 = "SELECT * from `exams` WHERE short = '".$super_post['linked_exam']."'";
        $result_2 = mysql_query($query_2);
        $post = mysql_fetch_assoc($result_2);
        unset($post['password']); // Das Passwort wird nicht heruntergeladen!
        $post['date'] = date("d.m.Y", strtotime($post['date']));
        $post['responsible_person'] = getValueByKey($phd_db_name, "id", $post['responsible_person'],'name');
        $posts[$val] = $post;
        $val ++;
    }

} else if($intent == "exam") {
    $query = "SELECT * from `task` WHERE linked_exam = '".$exam_name."' ORDER BY number";
    $result = mysql_query($query);
    $val = 0;
    if(mysql_num_rows($result)) {
        while($post = mysql_fetch_assoc($result)) {

            $sub_query = "SELECT * from `subtask` WHERE linked_exam = '".$exam_name."' AND linked_task = '".$post['id']."' ORDER BY letter";
            $sub_result = mysql_query($sub_query);
            $sub_array = array();
            $sub_val = 0;
            if(mysql_num_rows($sub_result)) {
                while($sub_post = mysql_fetch_assoc($sub_result)) {
                    $sub_array[$sub_val] = $sub_post;
                    $sub_val = $sub_val + 1;
                }
            }
            $post['subtasks'] = $sub_array;
            $posts[$val] = $post;
            $val = $val+1;
        }
    }
}
else {
    echo "exit";
    exit();
}

header('Content-type: application/json');
echo json_encode(array('posts'=>$posts));
?>
