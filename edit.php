<?php
require('db.php');
include("auth.php"); //include auth.php file on all secure pages

$status = "";
$query = $_GET['show'];
$id = $_GET['id'];
$headline = "";
$headline = "";
$sql_name = "";

include("strings.php");
include("functions.php");

$types_array = array();

switch ($query) {
    case "student":
        $headline = $show_students;
        $sql_name = $student_db_name;
        $types_array = $student_keys_edit;
        break;
    case "exam":
        $headline = $show_exams;
        $sql_name = $exam_db_name;
        $types_array = $exam_keys_edit;
        break;
    case "phd":
        $headline = $show_phds;
        $sql_name = $phd_db_name;
        $types_array = $phd_keys_edit;
        break;
    case "task":
        $sql_name = $task_db_name;
        $types_array = $task_keys_edit;
        break;
}

$arrlength = count($types_array);

//if(!isset($_POST['new'])) {
//$error = true;
//echo("error!");
//}

if(isset($_POST['new']) && $_POST['new']==1 )
{
    $ins_query;

    switch ($query) {
    case "student":
            $name =$_REQUEST['name'];
            $matrikelnummer = $_REQUEST['matrikelnummer'];
            $linked_exam = $_REQUEST['options'];
            $ins_query="insert into ".$sql_name."(`name`,`matrikelnummer`,`linked_exam`)values('$name','$matrikelnummer','$linked_exam')";
        break;
    case "exam":
            $name = $_REQUEST['name'];
            $short = $_REQUEST['short'];
            $date = $_REQUEST['date'];
            $ins_query="insert into ".$sql_name."(`name`,`short`,`date`)values('$name','$short','$date')";
        break;
    case "task":
            $name = $_REQUEST['name'];
            $phd = $_REQUEST['options'];
            $exam_task = $_GET['linked_exam'];
            $ins_query="insert into ".$sql_name."(`name`,`linked_exam`,`linked_phd`)values('$name','$exam_task','$phd')";
        break;
    case "phd":
            $name =$_REQUEST['name'];
            $prename = $_REQUEST['prename'];
            $ins_query="insert into ".$sql_name."(`name`,`prename`)values('$name','$prename')";
        break;
}

mysql_query($ins_query) or die(mysql_error());
if($query == "task") {
  header("Location: details.php?id=".$exam_task);
echo("should have done something!");
exit();
} else {
header("Location: view.php?show=".$query);
echo("should have done something!");
exit();
}
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
                                <h2 class="mdl-card__title-text">Neuer Eintrag</h2>
                            </div>
                            <div class="mdl-card__supporting-text">

                                <input type="hidden" name="new" value="1" />
                                <?php
                            for($x = 0; $x < $arrlength; $x++) { ?>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input pattern="<?php
                                                                                                           $error_array = getPattern($types_array[$x]);
                                                                                                           echo($error_array[0]);?>" class="mdl-textfield__input" type="text" name="<?php echo($types_array[$x]); ?>">
                                        <label class=" mdl-textfield__label " for="<?php echo($types_array[$x]); ?>">
                                            <?php echo($types_array[$x]); echo $pre_single_result[$types_array[$x]]; ?>
                                        </label>
                                        <span class="mdl-textfield__error"><?php echo($error_array[1]); ?></span>
                                    </div>

                                    <?php   }
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

                                        <?php
}

                                  if($query == "task" ) { ?>
                                            <select name="options">
                                                <?php
    $sel_query="Select * from phds ORDER BY name ASC;";
    $result = mysql_query($sel_query);
    while($row = mysql_fetch_assoc($result)) {
        echo "<option value=\"".$row['id']."\">".$row['name'].", ".$row['prename']."</option>";
    $count++;
    }
    ?>
                                            </select>
                                        <?php
}?>
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
                                <input style="opacity:0;" name="submit" type="submit" value="">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Hinzufügen</button>
                                </input>
                            </div>
                        </div>
                    </form>
                    <?php include("footer.php");?>
            </div>
        </body>

    </html>
