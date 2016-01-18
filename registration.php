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
include('auth.php');
?>
<!DOCTYPE html>
    <html>
    <?php include("header.html"); ?>

        <body>
            <?php
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
        $username = $_POST['username'];
		$email = $_POST['email'];
        $password = $_POST['password'];
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);
		$email = stripslashes($email);
		$email = mysql_real_escape_string($email);
		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		$trn_date = date("Y-m-d H:i:s");
        $query = "INSERT into `users` (username, password, email, trn_date) VALUES ('$username', '".md5($password)."', '$email', '$trn_date')";
        $result = mysql_query($query);
        if($result){
            header("Location: view.php?show=admin");
            echo("should have done something!");
        }
    }else{
?>
                <div class="form">

                    <?php include("head_part.php"); ?>

                     <div class="whitebox dropshadow" style="background-color:orangered;color:white;margin-top:30px;">
                                <h6><b><i class="material-icons">warning</i> <br/>Achtung! Wollen Sie wirklich einen neuen Administrator erstellen? </b> <br/> Administratoren können andere Administratoren löschen und alle Elemente bearbeiten.</h6></div>

                     <div style="width:100%" class="demo-card-square mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-card--expand" style="background:url(images/exam.jpg) 100% no-repeat; background-size: cover;">
                                <h2 class="mdl-card__title-text">Administrator erstellen</h2>
                            </div>
                            <div class="mdl-card__supporting-text">

                    <form name="registration" action="" method="post">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input type="text" name="username" class="mdl-textfield__input" value="" pattern="">
                                        <label class=" mdl-textfield__label " for="username">
                                        Username
                                        </label>
                                        <span class="mdl-textfield__error"></span>
                        </div>

                         <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input type="text" name="email" class="mdl-textfield__input" value="" pattern="">
                                        <label class=" mdl-textfield__label " for="email">
                                        Emailadresse
                                        </label>
                                        <span class="mdl-textfield__error"></span>
                        </div>

                         <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input type="password" name="password" class="mdl-textfield__input" value="" pattern="">
                                        <label class=" mdl-textfield__label " for="password">
                                         Passwort
                                        </label>
                                        <span class="mdl-textfield__error"></span>
                        </div>

                        <div class="mdl-card__actions mdl-card--border">
                                <input style="opacity:0;" name="submit" type="submit" value="">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Registrieren</button>
                                </input>
                            </div>
                    </form>
                         </div>
                    </div>
                </div>
                <?php } ?>
        </body>

    </html>
