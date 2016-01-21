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

if(isset($_SESSION["username"])){
    header("Location: index.php");
    echo("should have done something!");
    exit();
}

require('db.php');
ini_set('session.use_cookies', '1');
// If form submitted, insert values into the database

include('functions.php');
include('email.php');

$errors = array();

$name = isset($_POST['name']) ? $_POST['name'] : NULL;
$matrikel = isset($_POST['matrikelnummer']) ? $_POST['matrikelnummer'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$exam = isset($_POST['options']) ? $_POST['options'] : NULL;


$first_boot = true;

if(isset($_GET['first_boot'])) {
    $first_boot = false;
}

$success = null;

if (empty($name)) {
    array_push($errors,"Bitte einen Namen eingeben!");
}

if (empty($email)) {
    array_push($errors,"Bitte eine Emailadresse eingeben!");
}

if (empty($matrikel)) {
    array_push($errors,"Bitte eine Matrikelnummer eingeben!");
}

if (empty($errors)){

     //Checking is user existing in the database or not
     $query = "SELECT * FROM students WHERE matrikelnummer = $matrikel and linked_exam='$exam'";
     $result = mysql_query($query) or die(mysql_error());
     $rows = mysql_num_rows($result);
     if($rows!=0){
        array_push($errors,"Kombination aus Prüfung und Matrikelnummer existiert bereits!");
         $success = NULL;
     } else{

         sendMail($matrikel,$exam);
//            array_push($errors,"Emailadresse scheint ungültig zu sein!");
//            $success = NULL;
//        } else {
        $ins_query="insert into `students`(`name`,`matrikelnummer`,`linked_exam`,`email`,`registration_date`)values('$name','$matrikel','$exam','$email',now())";
        mysql_query($ins_query) or die(mysql_error());

        $success = $name.", Sie wurden erfolgreich zur Einsicht für die Prüfung ".getValueByKey($exam_db_name, "short", $exam, "name")." angemeldet.";
        $numbOfStudCount_query = "SELECT * FROM students WHERE linked_exam = '$exam'";
        $numbResult = mysql_query($numbOfStudCount_query);
        $numbOfStud = mysql_num_rows($numbResult);

        $update_counter_query = "UPDATE exams SET number_of_students = $numbOfStud WHERE short = '$exam'";
        mysql_query($update_counter_query);
       //  }
     }
}
?>
    <!DOCTYPE html>
    <html>

    <?php include("header.html"); ?>

        <body>
            <div class="form">
                <?php include("head_part.php"); ?>
                    <form action="?first_boot=false" method="post" name="login">

                        <?php if(count($errors)>0 && !$first_boot) { ?>
                            <div class="whitebox dropshadow" style="background-color:orangered;color:white;margin-top:30px;">
                                <h6><i class="material-icons">warning</i><br/>
                                    <?php foreach($errors as $issue) {
                                              echo $issue."<br/>";
                                          }
                                    ?></h6>
                        </div>
                            <?php } ?>

                                <?php if(isset($success)) { ?>
                                    <div class="whitebox dropshadow" style="background-color:limegreen;color:white;margin-top:30px;">
                                        <h6><i class="material-icons">done</i><br/><?php echo $success; ?></h6></div>
                                    <?php } ?>


                                        <div id="register_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                                            <div class="mdl-card__title mdl-card--expand" style="background:url(images/exam.jpg) 100% no-repeat; background-size: cover;">
                                                <h2 class="mdl-card__title-text">Anmeldung zur Einsicht</h2>
                                            </div>
                                            <div class="mdl-card__supporting-text">
                                                Liebe Studenten, bitte melden Sie sich nun über das folgende Formular an. Für jede Prüfung muss eine separate Anmeldung erfolgen. <br/>

                                                <!-- Textfield with Floating Label -->
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <input pattern="[A-Z,a-z, ]*" name="name" class="mdl-textfield__input" type="text" id="name" value="">
                                                    <label class="mdl-textfield__label" for="name">Name</label>
                                                    <span class="mdl-textfield__error">Bitte nur Buchstaben eingeben!</span>
                                                </div>

                                                <!-- Textfield with Floating Label -->
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <input pattern="[0-9]{8,12}" name="matrikelnummer" class="mdl-textfield__input" type="text" id="matrikelnummer" value="">
                                                    <label class="mdl-textfield__label" for="matrikelnummer">Matrikelnummer</label>
                                                    <span class="mdl-textfield__error">Bitte eine 8 - 12 stellige Matrikelnummer eingeben!</span>
                                                </div>

                                                 <!-- Textfield with Floating Label -->
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" class="mdl-textfield__input" type="text" id="email" value="">
                                                    <label class="mdl-textfield__label" for="email">Emailadresse</label><span class="mdl-textfield__error">Bitte eine gültige Emailadresse eingeben!</span>
                                                </div>
                                                  <select name="options">
                                                <?php
    $sel_query="Select * from exams ORDER BY id ASC;";
    $result = mysql_query($sel_query);
    while($row = mysql_fetch_assoc($result)) {
        echo "<option value=\"".$row['short']."\">".$row['name']."</option>";
    }
    ?>
                                            </select>
                                                <br/>
                                            </div>
                                            <div class="mdl-card__actions mdl-card--border">
                                                <input style="opacity:0;" name="submit" type="submit" value="">
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Zur Einsicht anmelden</button>
                                                </input>
                                            </div>
                                        </div>
                    </form>
                    <?php include("footer.php") ?>
            </div>
        </body>

    </html>
