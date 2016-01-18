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


function getMenu($additional_link,$additional_link_name, $edit, $delete) {

    //Random ist hier nötig, um jedem Menü ein eindeutiges Ausklappmenü zuzuweisen.
    $random = rand(1,10000);

?>

<i id="menu_<?php echo $random ?>" class="material-icons option-link">expand_more</i>
<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu_<?php echo $random ?>">
    <?php if($additional_link != NULL) { ?>
    <li onclick="location.href='<?php echo $additional_link ?>';" class="mdl-menu__item"><?php echo $additional_link_name ?></li>
    <?php }  if($edit != NULL) { ?>
    <li onclick="location.href='<?php echo $edit ?>';" class="mdl-menu__item">bearbeiten</li>
    <?php } ?>
    <li onclick="location.href='<?php echo $delete ?>';" class="mdl-menu__item">löschen</li>
</ul>

<?php }  ?>
