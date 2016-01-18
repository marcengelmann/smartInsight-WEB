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

// Entspricht der Prüfungs-ID
$query_id = $_GET['id'];


$sql_name = $task_db_name;
$sub_sql_name = $subtask_db_name;
$types_array = $task_keys;
$strings_array = $task_strings;

$arrlength = count($types_array);
$arrlength2 = count($strings_array);
        ?>

        <body>
            <div class="form">

                <?php include("head_part.php"); ?>
                 <div style="background:url(images/exam.jpg) 0% 50% no-repeat;height:150px;width:auto;background-size:cover;" class="dropshadow">
                        <h2>Detailansicht Prüfung <?php echo getNameOfExam($query_id); ?></h2></div>

                <table width="100%" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                    <tbody>
                        <tr>
                            <?php
                            for($x = 0; $x < $arrlength2; $x++) {
                                echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"left\"><strong>".$task_strings[$x]."</strong></td>";
                            }
                            ?>
                                <td class="mdl-data-table__cell">
<i class="material-icons option-link" onclick="location.href='delete.php?id=all<?php echo ("&db_name=".$sql_name."&show=".$query_id); ?>';">delete</i> </td>

                        </tr>

                        <?php

$sel_query="Select * from `task` WHERE `linked_exam` = '".$query_id."' ORDER BY number;";
$result = mysql_query($sel_query);

while($row = mysql_fetch_assoc($result)) {

    echo ("<tr>");

    for($x = 0; $x < $arrlength; $x++) {
        $name = $types_array[$x];
        if($name != "linked_exam") {
        if($name == "linked_phd") {
            echo "<td class=\"mdl-data-table__cell--non-numeric\" align=\"left\">".getPhDValueByKey($row[$name],'name')."</td>";
        }else {
        echo "<td  class=\"mdl-data-table__cell--non-numeric\" align=\"left\">".$row[$name]."</td>";
        }
        }
    }
        ?>
                                        <td class="mdl-data-table__cell">

                                              <?php getMenu(("insert.php?show=subtask&linked_exam=".$query_id."&linked_task=".$row['id']),"neue Unteraufgabe",("insert.php?show=task&linked_exam=".$query_id."&edit=true&id=".$row['id']),("delete.php?id=".$row['id']."&db_name=".$sql_name."&show=".$query_id)); ?>
</td>
                            <?php $sub_query="Select * from `subtask` WHERE `linked_exam` = '".$query_id."' AND `linked_task` = '".$row['id']."' ORDER BY letter;";
    $sub_result = mysql_query($sub_query);

    while($sub_row = mysql_fetch_assoc($sub_result)) { ?>
      <tr>
                        <?php
                                   for($x = 0; $x < count($subtask_keys); $x++) {
                                       $sub_name = $subtask_keys[$x];
                                       if($sub_name == "linked_phd") { ?>
                                        <td class="mdl-data-table__cell--non-numeric">
                                                <?php echo getPhDValueByKey($sub_row[$sub_name],'name'); ?> </td>
                                    <?php }else { ?>
                                        <td class="mdl-data-table__cell--non-numeric">
                                                <?php echo $sub_row[$sub_name]; ?></td>
                                 <?php      }
                                   } ?>
                                        <td class="mdl-data-table__cell" >
                                              <?php getMenu(NULL,"",("insert.php?show=subtask&linked_exam=".$query_id."&linked_task=".$row['id']."&edit=true&id=".$sub_row['id']),("delete.php?id=".$row['id']."&db_name=".$sub_sql_name."&show=".$query_id)); ?>

          </td>
                                </tr>
                                <?php } ?>
                        <tr style="height:30px;"></tr>
                                    </tr>
                                    <?php } ?>
                    </tbody>
                </table>
  <?php include("footer.php"); ?>
            </div>
 <!-- Colored FAB button with ripple -->
                <button  onclick="location.href='insert.php?show=task&linked_exam=<?php echo $query_id; ?>';" class="add_button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">add</i>
                </button>
        </body>

    </html>
