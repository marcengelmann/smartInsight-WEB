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

require("db.php");
include("functions.php");

$matrikelnummer = isset($_POST['matrikelnummer']) ? $_POST['matrikelnummer']  : null;
$password = isset($_POST['password']) ? $_POST['password']  : null;
$boolean = false;

$seat = isset($_POST['seat']) ? $_POST['seat']  : null;
$phd = isset($_POST['phd']) ? $_POST['phd']  : null;
$email_phd = isset($_POST['email']) ? $_POST['email']  : null;
$error = "access_denied";

if(isset($email_phd)&&$phd="yes") {

    //CHECK ob eine Prüfung zum Passwort existiert!
    $exam_name = getExamByPassword($password);
    if($exam_name!=null) {
        $boolean = true;
    }

    if($boolean) {
        //CHECK, ob der phd überhaupt vorhanden ist und mit einer Prüfung verknüpft ist!
        $query_check = "SELECT * from `phds` WHERE email = '$email_phd'";
        $result_check = mysql_query($query_check);

        if(mysql_num_rows($result_check) != 0 ) {

            $seat_query = "UPDATE phds SET last_login = now() WHERE email = '$email_phd'";
            mysql_query($seat_query);

            if(mysql_numrows($result_check)) {
                $post = mysql_fetch_assoc($result_check);
            }
            $post['password'] = $password;
            $post['exam'] = $exam_name;
            header('Content-type: application/json');
            echo json_encode($post);
            exit();
        }
    }
} else if(isset($matrikelnummer)) {

    //CHECK ob eine Prüfung zum Passwort existiert!
    $exam_name = getExamByPassword($password);
    if($exam_name!=null) {
        $boolean = true;
    }

    if(isExamLocked($exam_name)) {
        $boolean = false;
    }

    if($boolean) {
        //CHECK, ob die Matrikelnummer überhaupt vorhanden ist und mit einer Prüfung verknüpft ist!
        $query_check = "SELECT * from `students` WHERE matrikelnummer = ".$matrikelnummer." AND linked_exam = '".$exam_name."'";
        $result_check = mysql_query($query_check);
        if(mysql_num_rows($result_check) != 0 ) {

            $seat_query = "UPDATE students SET seat_number = ".$seat.", latest_login = now() WHERE matrikelnummer =".$matrikelnummer." AND  linked_exam = '$exam_name'";
            mysql_query($seat_query);

            if(mysql_numrows($result_check)) {
                $post = mysql_fetch_assoc($result_check);
            }
            $post['password'] = $password;
            $post['seat_number'] = $seat;
            header('Content-type: application/json');
            echo json_encode($post);
            exit();
        }
    }
}
echo $error;
exit();
?>
