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

/* Allgemeine Datenbankeinstellungen */

$database_name = '***';
$database_user = '***';
$database_password = '***';

/* Die Strings der Klausur */
$show_exams = "Klausuren anzeigen";
$add_exam = "Klausur hinzufügen";
$exam_keys = array("locked","name","short","date","password","mean_grade","number_of_students","room","responsible_person");
$exam_strings = array("","Name", "Kürzel", "Datum","Passwort","Note","Anzahl","Raum","Verantwortlicher");
$exam_keys_edit = array("name","short","date","password","mean_grade","room","responsible_person");
$exam_strings_edit = array("Name", "Kürzel", "Datum","Passwort","Note","Raum","Verantwortlicher");
$exam_db_name = "exams";
$exam_order_by = "date";
$exam_image_name = "exam.jpg";

/* Die Strings der Task */
$task_db_name = "task";
$task_keys = array("number","name","linked_exam","linked_phd");
$task_strings = array("Aufgabe","Name","Betreuer");
$task_keys_edit = array("number","name","linked_phd");
$task_strings_edit = array("Aufgabe","Name","Betreuer");


/* Die Strings der Sub-Task */
$subtask_db_name = "subtask";
$subtask_keys = array("letter","name","linked_phd");
$subtask_keys_edit = array("letter","name","linked_phd");
$subtask_strings_edit = array("Buchstabe","Name","Verknüpfter Prüfer");

/* Die Strings der Studenten */
$show_students = "Studenten anzeigen";
$add_student = "Student hinzufügen";
$student_keys = array("name","matrikelnummer","linked_exam","seat_number","registration_date","latest_login","email");
$student_strings = array("Name","Matrikelnummer","Prüfung","Platz","Registrierung","Letzter Login","Email");
$student_keys_edit = array("name","matrikelnummer","linked_exam","email");
$student_strings_edit = array("Name","Matrikelnummer","Verknüpfte Prüfung","Email");
$student_db_name = "students";
$student_order_by = "matrikelnummer";
$student_image_name = "student.jpg";

/* Die Strings der Doktoranden */
$show_phds = "Doktoranden anzeigen";
$add_phd = "Doktorand hinzufügen";
$phd_keys = array("name","email","last_login","password");
$phd_strings = array("Name","Email","Letzter Login","Passwort");
$phd_keys_edit = array("name","email","password");
$phd_strings_edit = array("Name","Email","Passwort");
$phd_db_name = "phds";
$phd_order_by = "id";
$phd_image_name = "doktorand.jpg";

/* Die Strings der Admins */
$show_admin = "Administratoren anzeigen";
$add_admin = "Administrator hinzufügen";
$admin_keys = array("currently_online","username","email","trn_date","last_login");
$admin_strings = array("aktiv","Username","Email","Registrierung","Letzter Login");
$admin_db_name = "users";
$admin_order_by = "name";
$admin_image_name = "admin.jpg";

/* Die Strings der Anfragen */
$show_request = "Anfragen anzeigen";
$add_request = "Student hinzufügen";
$request_keys = array("id","linked_task","linked_subtask","linked_exam","linked_phd","linked_student","start_time","end_time","submission_date");
$request_keys_edit = array("linked_subtask","linked_task","linked_phd","linked_student");
$request_strings = array("ID","Aufgabe","","Prüfung","Doktorand","Student","Start","Ende","Zeitstempel");
$request_db_name = "requests";
$request_order_by = "id";
$request_image_name = "request.jpg";

/* Die Strings des UI */
$show_all_entries_string = "Details anzeigen ❯";

$insert_value_headline = "Neuen Eintrag erstellen";
$edit_value_headline = "Eintrag bearbeiten";

$insert_submit_value = "Hinzufügen";
$edit_submit_value = "Ändern";

/* Sonstige Strings */
$english_months = array("January","February","March","May","June","July","October","December");
$deutsch_monate = array("Januar","Februar","März","Mai","Juni","Juli","Oktober","Dezember");
?>
