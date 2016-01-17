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

setlocale(LC_ALL, 'de_DE@euro');

function getNameOfPhDe($number) {
    $func_sel_query="Select * from `phds` WHERE `id` = '".$number."';";
    $func_result = mysql_query($func_sel_query);
    $func_row = mysql_fetch_assoc($func_result);
    return $func_row['name'];
}

function getEmailOfPhDe($number) {
    $func2_sel_query="Select * from `phds` WHERE `id` = '".$number."';";
    $func2_result = mysql_query($func2_sel_query);
    $func2_row = mysql_fetch_assoc($func2_result);
    return $func2_row['email'];
}

function sendMail($matrikelnummer,$exam) {
    $query = "SELECT * FROM students WHERE matrikelnummer = $matrikelnummer and linked_exam = '$exam'";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    $query2 = "SELECT * FROM exams WHERE short = '$exam'";
    $result2 = mysql_query($query2);
    $row2 = mysql_fetch_assoc($result2);

    $email_resp = getEmailOfPhDe($row2['responsible_person']);
    $name_resp = getNameOfPhDe($row2['responsible_person']);

    $to      = $row['name'].' <'.$row['email'].'>';
    $subject = 'Smart Insight: Anmeldung zur Prüfungseinsicht erfolgreich!';
    $message = '<html>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<style>

    body {
        font-family: Arial, Sans-Serif;
        background-color:gainsboro;
    }
    h1 {
        font-size:50px;
        color:white;
    }

    @media only screen and (max-width: 500px) {
        h1 {
            font-size: 45px;
        }
    }

    @media only screen and (max-width: 470px) {
        h1 {
            font-size: 35px;
        }
    }

    h1 img {
        vertical-align:middle;
        margin:25px;
        height: 100px;
    }

    #head {
       background: linear-gradient(270deg, #00c9ff, #0091ff);box-shadow: 0px 0px 2px 0px rgba(71, 71, 71, 1);
    }

    #wrapper{
        max-width:500px;
        margin-left:auto;
        margin-right:auto;
    }

    footer{
        color:darkgray;
        font-size:12px;
        text-align:center;
        padding: 20px;
    }

    article {
        padding:20px;
        font-size:14px;
        background-color:white;
        box-shadow: 0px 0px 2px 0px rgba(71, 71, 71, 1);
        color:#444;
    }
    #info{
        font-size: 12px;
    }
    table{
        margin:auto;
        margin-top:20px;
        margin-bottom: 30px;
        font-size: 14px;
        width:90%;
    }
    tr{
     line-height: 150%;
    }
    td {
        width:100%
    }
    .left {
        font-weight: bold;
        text-align: right;
        padding-right: 20px;
        width:50%;
    }
    #android {
        height:auto;
        width:35%;
        float:left;
        margin-left:6%;
        margin-top:10px;
    }
    #ios {
        margin-top: 7px;
        height:auto;
        margin-left:20%;
        width:33%;
        margin-right:6%;
    }
    #info_box{
        margin:30px;
        padding:20px;
        background-color: lightgrey;
    }
    #warn {
        float:left;
        height:60px;;
        line-height: 60px;
        padding-right:20px;
    }
    #mail {
        vertical-align:middle;
    }
    a{
        color:blue;
    }
</style>
<body>
    <div id="wrapper">
        <div id="head">
            <h1><img src="http://marcengelmann.com/smart/images/512.png">Smart Insight</h1></div>
        <article>Hallo '.$row['name'].',
            <br/>
            <br/>Smart Insight informiert Sie hiermit über die erfolgreiche Registrierung mit der Matrikelnummer <i>'.$matrikelnummer.'</i> zu folgender Prüfung:
            <table>
                <tbody>
                    <tr>
                        <td class="left">Prüfung</td><td>'.$row2['name'].'</td>
                    </tr>
                    <tr>
                        <td class="left">Datum</td><td>'.date('j.n.Y, H:i',strtotime($row2['date'])).'</td>
                    </tr>
                    <tr>
                        <td class="left">Raum</td><td>'.$row2['room'].'</td>
                    </tr>
                    <tr>
                        <td class="left">Ansprechpartner</td><td><a href="mailto:'.$email_resp.'">'.$name_resp.'</a> <i id="mail" class="material-icons">mail_outline</i></td>
                    </tr>
                </tbody>
            </table>
            Freundliche Grüße
            <br/> Das Smart Insight Team
            <div id="info_box"><p><i id="warn" class="material-icons">warning</i>Um Smart Insight in der Prüfungseinsicht zu verwenden, ist es erforderlich, sich die entsprechende App vorab auf das Smartphone installiert zu haben.<br/></p><img id="android" src="http://marcengelmann.com/smart/images/de-play-badge.png"><img id="ios" src="http://marcengelmann.com/smart/images/badge_appstore_de.png"></div>
            <br/><br/><br/>
            <i id="info">Dies ist eine automatisch generierte Email des Smart Insight Webdienstes. Bitte antworten Sie nicht auf diese Email. Kontaktieren Sie bei Bedarf den Ansprechpartner.</i>
            </article>
        <footer>© Smart Insight 2016 </footer>
    </div>
</body>
</html>';
    $headers = 'From: Smart Insight <smartinsight@ftm.mw.tum.de>' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    mail($to, $subject, $message, $headers);
}



?>

