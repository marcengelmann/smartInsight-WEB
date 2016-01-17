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

function getNameOfPhD($number) {
    $func_sel_query="Select * from `phds` WHERE `id` = '".$number."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['name'];
}

function getEmailOfPhD($number) {
    $func_sel_query="Select * from `phds` WHERE `id` = '".$number."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['email'];
}

function getDeviceIDOfPhD($id) {
    $func_sel_query="Select * from `phds` WHERE `id` = '$id';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['deviceID'];
}

function getNameOfStudent($matrikel,$exam) {
    $func_sel_query="Select * from `students` WHERE matrikelnummer = $matrikel AND linked_exam = '$exam'";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['name'];
}

function getPhDForSubtask($number) {
    $func_sel_query="Select * from `subtask` WHERE `id` = '".$number."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['linked_phd'];
}

function getSeatbyMatrikel($matrikel,$exam) {
    $func_sel_query="Select * from `students` WHERE matrikelnummer = $matrikel AND linked_exam = '$exam'";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['seat_number'];
}

function getPhDForTask($number) {
    $func_sel_query="Select * from `task` WHERE `id` = '".$number."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['linked_phd'];
}

function getNameOfExam($short) {
    $func_sel_query="Select * from `exams` WHERE `short` = '".$short."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['name'];
}

function isExamLocked($short) {
    $func_sel_query="Select * from `exams` WHERE `short` = '$short';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return  ($func_row['locked'] == 1);
}

function getNameOfTask($short) {
    $func_sel_query="Select * from `task` WHERE `id` = ".$short.";";
    $func_result = mysql_query($func_sel_query);
    while($func_row = mysql_fetch_assoc($func_result)) {
        $its_it = $func_row['number'];
    }
    return $its_it;
}

function getNameOfSubTask($short) {
    $func_sel_query="Select * from `subtask` WHERE `id` = ".$short.";";
    $func_result = mysql_query($func_sel_query);
    while($func_row = mysql_fetch_assoc($func_result)) {
        $its_it = $func_row['letter'];
    }
    return $its_it;
}

function getSizeOfTable($tablename) {
    $size_sel_query="Select * from `".$tablename."`;";
    $size_result = mysql_query($size_sel_query);
    $size = mysql_num_rows($size_result);
    return $size;
}

function getSizeOfTaskTables($exam_id) {

    include("strings.php");

    $task_sel_query="Select * from `".$task_db_name."` WHERE linked_exam = '".$exam_id."';";
    $task_result = mysql_query($task_sel_query);
    $task_size = mysql_num_rows($task_result);

    $subtask_sel_query="Select * from `".$subtask_db_name."` WHERE linked_exam = '".$exam_id."';";
    $subtask_result = mysql_query($subtask_sel_query);
    $subtask_size = mysql_num_rows($subtask_result);

    return "".$task_size." (".$subtask_size.")";
}

function getExamByPassword($password){
    $func_sel_query="Select * from `exams`;";
    $func_result = mysql_query($func_sel_query);
    while($func_row = mysql_fetch_assoc($func_result)) {
        if(md5($func_row['password']) == $password) {
            return $func_row['short'];
        }
    }
    return null;
}

function switchSingularPlurar($number,$singular,$plural) {
    echo($number." ");
    if($number == 1) {
        echo $singular;
    } else {
        echo $plural;
    }
}

function getPattern($name) {
    switch ($name) {
        case "matrikelnummer":
            $pattern = "[0-9]{8,12}";
            $error_message = "Bitte eine 8 - 12 stellige Zahl eingeben.";
            break;
        case "name":
            $pattern = "[A-Z,a-z, ,0-9]*";
            $error_message = "Bitte nur Buchstaben eingeben.";
            break;
        case "short":
            $pattern = "[A-Z,a-z]{3}";
            $error_message = "Bitte nur 3 Buchstaben eingeben.";
            break;
        case "date":
            $pattern = "(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))";
            $error_message = "Bitte Datum als YYYY-MM-DD eingeben.";
            break;
        case "email":
            $pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$";
            $error_message = "Bitte gültige Emailadresse eingeben.";
            break;
        default:
            $pattern = "[A-Z,a-z, ,0-9]*";
            $error_message = "Ungültige Eingabe";
            break;
    }
    return array($pattern,$error_message);
}
?>
