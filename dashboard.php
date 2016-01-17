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
?>
    <!DOCTYPE html>
    <html>

    <?php
include("header.html");
include("strings.php");
include("functions.php");
?>

        <body>
            <div class="form">

                <?php
include("head_part.php");
?>

                    <div id="phd_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-card--expand" style="background:url(images/<?php echo $phd_image_name; ?>) 100% no-repeat; background-size: cover;">
                            <h2 class="mdl-card__title-text"><?php switchSingularPlurar(getSizeOfTable($phd_db_name),"Dokrorand","Doktoranden"); ?></h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            Die Doktoranden sind die Betreuer von Aufgaben in einer Prüfung. Die Liste der Doktoranden ist unabhängig von Prüfungen.
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="view.php?show=phd" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                <?php echo $show_all_entries_string ?>
                            </a>
                        </div>
                    </div>

                    <div id="exam_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-card--expand" style="background:url(images/<?php echo $exam_image_name; ?>) 100% no-repeat;  background-size: cover;">
                            <h2 class="mdl-card__title-text"><?php switchSingularPlurar(getSizeOfTable("exams"),"Prüfung","Prüfungen"); ?></h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            Die Prüfungen beinhalten alle zur Einsicht zur Verfügung stehenden Prüfungen mit jeweils verknüpften Aufgaben, Unteraufgaben und den zugehörigen Betreuern.
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="view.php?show=exam" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                <?php echo $show_all_entries_string ?>
                            </a>
                        </div>
                    </div>

                    <div id="student_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-card--expand" style="background:url(images/<?php echo $student_image_name; ?>) 50% no-repeat;  background-size: cover;">
                            <h2 class="mdl-card__title-text"><?php switchSingularPlurar(getSizeOfTable("students"),"Student","Studenten"); ?></h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            Hier sind alle Studenten verzeichnet, die sich für eine Prüfungseinsicht angemeldet haben.
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="view.php?show=student" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                <?php echo $show_all_entries_string ?>
                            </a>
                        </div>
                    </div>

                    <div id="stats_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-card--expand" style="background:url(images/<?php echo $request_image_name; ?>) 50% no-repeat;  background-size: cover;">
                            <h2 class="mdl-card__title-text">Aktuelle Anfragen</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            Hier werden alle aktuellen Anfragen von Studenten and Doktoranden zu bestimmten Aufgaben einer Prüfung aufgelistet und optimal verteilt.
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="view.php?show=request" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                <?php echo $show_all_entries_string ?>
                            </a>
                        </div>
                    </div>

                <div id="admin_dash_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-card--expand" style="background:url(images/<?php echo $admin_image_name; ?>) 50% no-repeat;  background-size: cover;">
                            <h2 class="mdl-card__title-text">Administratoren</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            Hier sind alle Administratoren aufgelistet, die online die Oberfläche benutzen können. Es können auch neue hinzugefügt werden.
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="view.php?show=admin" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                <?php echo $show_all_entries_string ?>
                            </a>
                        </div>
                    </div>
                    <?php include("footer.php") ?>
            </div>

        </body>

    </html>
