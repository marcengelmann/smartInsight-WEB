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

$warning = false;
$logout = isset($_GET['from']) ? $_GET['from'] : '';

if (isset($_POST['username'])){
     $logout = "wrong";
     $username = $_POST['username'];
     $password = $_POST['password'];
     $username = stripslashes($username);
     $username = mysql_real_escape_string($username);
     $password = stripslashes($password);
     $password = mysql_real_escape_string($password);
     //Checking is user existing in the database or not
     $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
     $result = mysql_query($query) or die(mysql_error());
     $rows = mysql_num_rows($result);
     if($rows==1){
        $_SESSION['username'] = $username;
        $update = "UPDATE users SET last_login = now(), currently_online = 1 WHERE username = '$username'";
        mysql_query($update);
        header("Location: index.php");
        echo("should have done something!");
        exit();
     } else{
         $warning = true;
     }
}
?>
    <!DOCTYPE html>
    <html>

    <?php include("header.html"); ?>

        <body>
            <div class="form">
                <?php include("head_part.php"); ?>
                    <form action="" method="post" name="login">

                        <?php if($warning) { ?>
                            <div class="whitebox dropshadow" style="background-color:orangered;color:white;margin-top:30px;">
                                <h6><i class="material-icons">warning</i><br/>Der Benutzername oder das Passwort war falsch. Bitte versuchen Sie es erneut.</h6></div>
                            <?php } ?>

                                <?php if($logout == "logout") { ?>
                                    <div class="whitebox dropshadow" style="background-color:limegreen;color:white;margin-top:30px;">
                                        <h6><i class="material-icons">done</i><br/>Sie wurden erfolgreich ausgeloggt!</h6></div>
                                    <?php } ?>
                                        <div id="login_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                                            <div class="mdl-card__title mdl-card--expand" style="background:url(images/admin.jpg) 100% no-repeat; background-size: cover;">
                                                <h2 class="mdl-card__title-text">Administrator Login</h2>
                                            </div>
                                            <div class="mdl-card__supporting-text">

                                                <!-- Textfield with Floating Label -->
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <input name="username" class="mdl-textfield__input" type="text" id="username">
                                                    <label class="mdl-textfield__label" for="username">Benutzername</label>
                                                </div>

                                                <!-- Textfield with Floating Label -->
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <input name="password" class="mdl-textfield__input" type="password" id="password">
                                                    <label class="mdl-textfield__label" for="password">Passwort</label>
                                                </div>

                                            </div>
                                            <div class="mdl-card__actions mdl-card--border">
                                                <input style="opacity:0;" name="submit" type="submit" value="">
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Anmelden</button>
                                                </input>
                                            </div>
                                        </div>

                                        <div id="einsicht_tile" class="demo-card-square mdl-card mdl-shadow--2dp">
                                            <div class="mdl-card__title mdl-card--expand" style="background:url(images/student.jpg) 100% no-repeat; background-size: cover;">
                                                <h2 class="mdl-card__title-text">Anmeldung zur Einsicht</h2>
                                            </div>
                                            <div class="mdl-card__supporting-text">

                                                Liebe Studenten, fall Sie sich beim <b>Lehrstuhl für Fahrzeugtechnik</b> für eine Prüfungseinsicht anmelden wollen, so nutzen Sie bitte das Formular hinter dem Link. Alle Prüfungseinsichten werden zentral verwaltet und durch die App <b>SmartInsight</b> deutlich vereinfacht.

                                            </div>
                                            <div class="mdl-card__actions mdl-card--border">
                                                <a href="register.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                Zur Anmeldung
                            </a>
                                            </div>
                                        </div>
                    </form>
                    <?php include("footer.php") ?>
            </div>
        </body>

    </html>
