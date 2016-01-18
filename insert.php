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

$status = "";
$query = $_GET['show'];

$id = isset($_GET['id']) ? $_GET['id'] : '';

$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$edit = isset($_GET['edit']) ? $_GET['id'] : '';

$sql_name = "";

include("strings.php");
include("functions.php");

if($edit) {
    $headline = $edit_value_headline;
    $submit =  $edit_submit_value;
} else {
    $headline = $insert_value_headline;
    $submit = $insert_submit_value;
}

$types_array = array();

switch ($query) {
    case "student":
        $sql_name = $student_db_name;
        $types_array = $student_keys_edit;
        $strings_array = $student_strings_edit;
        break;
    case "exam":
        $sql_name = $exam_db_name;
        $types_array = $exam_keys_edit;
        $strings_array = $exam_strings_edit;
        break;
    case "subtask":
        $sql_name = $subtask_db_name;
        $types_array = $subtask_keys_edit;
        $strings_array = $subtask_strings_edit;
        break;
    case "phd":
        $sql_name = $phd_db_name;
        $types_array = $phd_keys_edit;
        $strings_array = $phd_strings_edit;
        break;
    case "task":
        $sql_name = $task_db_name;
        $types_array = $task_keys_edit;
        $strings_array = $task_strings_edit;
        break;
}

$arrlength = count($types_array);

if(isset($_POST['new']) && $_POST['new']==1 )
{
    $ins_query;

    switch ($query) {
    case "student":
            $name =$_REQUEST['name'];
            $matrikelnummer = $_REQUEST['matrikelnummer'];
            $linked_exam = $_REQUEST['options'];
            $email = $_REQUEST['email'];
            if($edit) {
            $ins_query = "UPDATE ".$sql_name." SET name = '".$name."', matrikelnummer = '".$matrikelnummer."', linked_exam = '$linked_exam', email = '$email' WHERE id = ".$id;
            } else {
            $ins_query="insert into ".$sql_name."(`name`,`matrikelnummer`,`linked_exam`,`email`,`registration_date`)values('$name','$matrikelnummer','$linked_exam','$email',now())";
            }
        break;
    case "exam":
            $name = $_REQUEST['name'];
            $short = $_REQUEST['short'];
            $date = $_REQUEST['date'];
            $password = $_REQUEST['password'];
            $grade = $_REQUEST['mean_grade'];
            $room = $_REQUEST['room'];
            $person = $_REQUEST['options'];
            if($edit) {
            $ins_query = "UPDATE $sql_name SET name = '$name', short = '$short', date = '$date', password = '$password', mean_grade = '$grade', room = '$room', responsible_person = '$person' WHERE id = ".$id;
            } else {
            $ins_query="insert into ".$sql_name."(`name`,`short`,`date`,`password`,`mean_grade`,`room`,`responsible_person`)values('$name','$short','$date','$password','$grade','$room','$responsible_person')";
            }
        break;
    case "task":
            $name = $_REQUEST['name'];
            $number = $_REQUEST['number'];
            $phd = $_REQUEST['options'];
            $exam_task = $_GET['linked_exam'];
            if($edit) {
            $ins_query = "UPDATE ".$sql_name." SET name = '".$name."', number = '".$number."', linked_phd = '".$phd."' WHERE id = ".$id;
            } else {
            $ins_query="insert into ".$sql_name."(`name`,`linked_exam`,`linked_phd`,`number`)values('$name','$exam_task','$phd','$number')";
            }
        break;
    case "subtask":
            $name = $_REQUEST['name'];
            $phd = $_REQUEST['options'];
            $letter = $_REQUEST['letter'];
            $task = $_GET['linked_task'];
            $exam_subtask = $_GET['linked_exam'];
            $exam_task = $exam_subtask;
            if($edit) {
            $ins_query = "UPDATE ".$sql_name." SET name = '$name', letter = '$letter', linked_phd = '$phd' WHERE id = ".$id;
            } else {
            $ins_query="insert into ".$sql_name."(`name`,`letter`,`linked_task`,`linked_exam`,`linked_phd`)values('$name','$letter','$task','$exam_subtask','$phd')";
             }
        break;
    case "phd":
            $name =$_REQUEST['name'];
            $email = $_REQUEST['email'];
            $pw = $_REQUEST['password'];
            if($edit) {
            $ins_query = "UPDATE $sql_name SET name = '$name', email = '$email', password = '$pw' WHERE id = ".$id;
            } else {
            $ins_query="insert into ".$sql_name."(`name`,`email`,`password`)values('$name','$email','$pw')";
            }
        break;
}

mysql_query($ins_query) or die(mysql_error());
if($query == "task" || $query == "subtask") {
  header("Location: details.php?id=".$exam_task);
echo("should have done something!");
exit();
} else {
header("Location: view.php?show=".$query);
echo("should have done something!");
exit();
}
}


$pre_query = "SELECT * FROM $sql_name WHERE id = $id";
$pre_result = mysql_query($pre_query);
if($pre_result) {
    $pre_single_result = mysql_fetch_assoc($pre_result);
}

?>

    <!DOCTYPE html>
    <html>

    <?php include("header.html"); ?>

        <body>
            <div class="form">
                <?php include("head_part.php"); ?>
                    <form name="form" method="post" action="">
                        <div style="width:100%" class="demo-card-square mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-card--expand" style="background:url(images/exam.jpg) 100% no-repeat; background-size: cover;">
                                <h2 class="mdl-card__title-text"><?php echo $headline; ?></h2>
                            </div>
                            <div class="mdl-card__supporting-text">

                                <input type="hidden" name="new" value="1" />
                                <?php

                            for($x = 0; $x < $arrlength; $x++) {
                                if($types_array[$x] != "linked_exam" && $types_array[$x] != "linked_phd" && $types_array[$x] != "id" && $types_array[$x] != "responsible_person") { ?>

                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input value="<?php echo $pre_single_result[$types_array[$x]]; ?>" pattern="<?php $error_array = getPattern($types_array[$x]);
                                                              echo($error_array[0]);?>" class="mdl-textfield__input" type="text" name="<?php echo($types_array[$x]); ?>">
                                        <label class=" mdl-textfield__label " for="<?php echo($types_array[$x]); ?>">
                                            <?php echo($strings_array[$x]); ?>
                                        </label>
                                        <span class="mdl-textfield__error"><?php echo($error_array[1]); ?></span>
                                    </div>

                                    <?php  } }
                                                                       if($query == "student" ) { ?>
                                            <select name="options">
                                                <?php
    $sel_query="Select * from exams ORDER BY id ASC;";
    $result = mysql_query($sel_query);
    while($row = mysql_fetch_assoc($result)) {
        echo "<option value=\"".$row['short']."\">".$row['name']."</option>";
    $count++;
    }
    ?>
                                            </select>

                                        <?php }

                                  if($query == "task" || $query == "subtask" || $query == "exam") { ?>
                                            <select name="options">
                                                <?php
    $sel_query="Select * from phds ORDER BY name ASC;";
    $result = mysql_query($sel_query);
    while($row = mysql_fetch_assoc($result)) {
        echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
    $count++;
    }
    ?>
                                            </select>
                                        <?php
                                  }  ?>
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
                                <input style="opacity:0;" name="submit" type="submit" value="">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"><?php echo $submit; ?></button>
                                </input>
                            </div>
                        </div>
                    </form>
                    <?php include("footer.php");?>
            </div>
        </body>

    </html>
