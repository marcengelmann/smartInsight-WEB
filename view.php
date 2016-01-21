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
include("auth.php");
?>
    <!DOCTYPE html>
    <html>


    <?php

include("header.html");
include("strings.php");
include("functions.php");
include("material.php");

$query = $_GET['show'];

switch ($query) {
    case "student":
        $headline = $show_students;
        $sql_name = $student_db_name;
        $types_array = $student_keys;
        $id = "name";
        $strings_array = $student_strings;
        $image_string = $student_image_name;
        break;
    case "request":
        $headline = $show_request;
        $sql_name = $request_db_name;
        $types_array = $request_keys;
        $id = "id";
        $strings_array = $request_strings;
        $image_string = $request_image_name;
        break;
    case "exam":
        $headline = $show_exams;
        $sql_name = $exam_db_name;
        $types_array = $exam_keys;
        $strings_array = $exam_strings;
        $image_string = $exam_image_name;
        $id = "date";
        break;
    case "phd":
        $headline = $show_phds;
        $sql_name = $phd_db_name;
        $types_array = $phd_keys;
        $strings_array = $phd_strings;
        $image_string = $phd_image_name;
        $id = "id";
        break;
    case "admin":
        $headline = $show_admin;
        $sql_name = $admin_db_name;
        $types_array = $admin_keys;
        $strings_array = $admin_strings;
        $image_string = $admin_image_name;
        $id = "id";
        break;
}

$arrlength = count($types_array);
$show_detail = NULL;

        ?>

        <body>

            <div class="form">

                <?php include("head_part.php"); ?>

                    <div style="background:url(images/<?php echo $image_string; ?>) 0% 50% no-repeat;height:150px;width:auto;background-size:cover;" class="dropshadow">
                        <h2><?php echo $headline ?></h2></div>

                    <table width="100%" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <tbody>
                            <tr>
                                <?php
                            for($x = 0; $x < $arrlength; $x++) {

                                if( $types_array[$x] != "linked_subtask") {
                                    echo "<td class=\"mdl-data-table__cell--non-numeric\"><strong>".$strings_array[$x]."</strong></td>";
                                }
                            }
                            if($query == "exam") {
                               echo("<td class=\"mdl-data-table__cell--non-numeric\"><strong>Fragen</strong></td>");
                            }
                             if($query == "student") {?>
                                <td><i class="material-icons option-link" onclick="location.href='delete.php?id=all&db_name=<?php echo $sql_name; ?>&show=<?php echo $query; ?>'">delete</i></td>
                            <?php } ?>
                            </tr>
                            <?php
$count=1;
$sel_query="Select * from " . $sql_name . " ORDER BY ".$id." ASC;";
$result = mysql_query($sel_query);
while($row = mysql_fetch_assoc($result)) { ?>
                                <tr>
                                    <?php
                                   for($x = 0; $x < $arrlength; $x++) {
                                       $name = $types_array[$x];
                                       if($name== "linked_phd") {
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".getValueByKey($phd_db_name, "id", $row[$name], "name")."</td>";
                                       }else if($name == "currently_online") {
                                            $online_string = "account_box";
                                            if($row[$name] == "0") {
                                                $online_string = "";
                                            }
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\"><i class=\"material-icons\">$online_string</i></td>";
                                       } else if($name == "locked") {
                                            $lock_string = "lock";
                                            if($row[$name] == "0") {
                                                $lock_string = "lock_open";
                                            }
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\"><i onclick=\"location.href='lock.php?status=$row[$name]&id=".$row['id']."';\" class=\"material-icons\">$lock_string</i></td>";
                                       }else if($name == "start_time" || $name == "end_time") {
                                            setlocale(LC_ALL, 'de_DE@euro');
                                            $h = strtotime($row[$name]);
                                            $hour_string = date('H:i:s',$h);
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".$hour_string."</td>";
                                       }else if($name == "submission_date") {
                                            setlocale(LC_ALL, 'de_DE@euro');
                                            $w = strtotime($row[$name]);
                                            $w_string = date('j.n.Y, H:i:s',$w);
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".$w_string."</td>";
                                       }else if($name == "password") {
                                           $pw = preg_replace('@.@','●',$row[$name]);
                                            echo "<td style='font-family:Monaco !important; font-size:12px !important;' class=\"mdl-data-table__cell--non-numeric\" align=\"center\" onmouseover=\"this.innerHTML='$row[$name]';\" onmouseout=\"this.innerHTML='$pw';\">$pw</td>";
                                       }else if($name == "registration_date" || $name == "latest_login" || $name == "last_login" || $name == "trn_date") {
                                            setlocale(LC_ALL, 'de_DE@euro');
                                            $p = strtotime($row[$name]);
                                            $p_string = date('j.n.Y, H:i',$p);
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".$p_string."</td>";
                                       }else if($name == "date") {
                                            setlocale(LC_ALL, 'de_DE@euro');
                                            $t = strtotime($row[$name]);
                                            $date_string = date('j. F Y',$t);
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".str_replace($english_months, $deutsch_monate, $date_string)."</td>";
                                       } else if($name== "linked_student") {
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".getNameOfStudent($row['linked_student'],$row['linked_exam'])."</td>";
                                       }else if($name== "responsible_person") {
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".getValueByKey($phd_db_name, "id",$row['responsible_person'],'name')."</td>";
                                       } else if($name== "linked_task") {
                                            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".getValueByKey($task_db_name, "id", $row[$name],"number").getValueByKey($subtask_db_name, "id", $row['linked_subtask'],"letter")."</td>";
                                       }else if($name== "linked_subtask") {
                                           //
                                       }else {
                                        echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"center\">".$row[$name]."</td>";
                                       }
                                    }
    if($query == "exam") {
        $show_detail = "details.php?id=".$row["short"]; ?>

                                    <td class="mdl-data-table__cell--non-numeric" align="center"><?php echo getSizeOfTaskTables($row["short"]); ?></td>
                                    <?php }  ?>
                                        <td class="mdl-data-table__cell" align="right">
                                        <?php if($query == "admin" || $query == "request") {
                                            echo getMenu(NULL,NULL,NULL,("delete.php?id=".$row['id']."&db_name=".$sql_name."&show=".$query));
                                            } else {
                                            echo getMenu($show_detail,"Details",("insert.php?show=".$query."&edit=true&id=".$row['id']),("delete.php?id=".$row['id']."&db_name=".$sql_name."&show=".$query)); } ?>

                        </td></tr>
                                <?php $count++; } ?>
                        </tbody>
                    </table>
                    <?php include("footer.php") ?>
            </div>
            <?php if($query == "admin") { ?>
                <!-- Colored FAB button with ripple -->
                <button  onclick="location.href='registration.php';" class="add_button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">add</i>
                </button>
           <?php } else if($query != "request" && $query != "student"){?>
                <!-- Colored FAB button with ripple -->
                <button  onclick="location.href='insert.php?show=<?php echo $query ?>';" class="add_button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">note_add</i>
                </button>
            <?php } ?>
        </body>

    </html>
