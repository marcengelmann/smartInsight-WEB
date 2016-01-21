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

$query1 ="CREATE TABLE IF NOT EXISTS `exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `short` varchar(3) COLLATE latin1_german2_ci NOT NULL,
  `date` date NOT NULL,
  `password` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `number_of_students` int(3) NOT NULL,
  `mean_grade` varchar(5) COLLATE latin1_german2_ci NOT NULL DEFAULT '1,000',
  `room` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `responsible_person` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=10 ;";

$query2 = "CREATE TABLE IF NOT EXISTS `phds` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_login` datetime NOT NULL,
  `deviceID` varchar(200) NOT NULL,
  `deviceID_registration_date` datetime NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;";

$query3 ="CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linked_subtask` int(11) NOT NULL,
  `linked_task` int(11) NOT NULL,
  `linked_exam` varchar(3) COLLATE latin1_german2_ci NOT NULL,
  `linked_phd` int(11) NOT NULL,
  `linked_student` int(12) NOT NULL,
  `submission_date` datetime NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `type_of_question` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  `status_changed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=346 ;";

$query4 ="CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `matrikelnummer` int(20) NOT NULL,
  `linked_exam` varchar(3) COLLATE latin1_german2_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `seat_number` int(2) NOT NULL,
  `latest_login` datetime NOT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=38 ;";

$query5 = "CREATE TABLE IF NOT EXISTS `subtask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `letter` varchar(1) COLLATE latin1_german2_ci NOT NULL,
  `linked_task` int(11) NOT NULL,
  `linked_exam` varchar(3) COLLATE latin1_german2_ci NOT NULL,
  `linked_phd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=29 ;";

$query8 ="CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
  `linked_exam` varchar(3) COLLATE latin1_german2_ci NOT NULL,
  `linked_phd` int(11) NOT NULL,
  `number` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=25 ;";

$query6 ="CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `trn_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `currently_online` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT=12;";

$query7 = "INSERT INTO users SET username = 'admin', password = '21232f297a57a5a743894a0e4a801fc3', email = 'admin@example.de', trn_date = now();";

mysql_query($query1);
mysql_query($query2);
mysql_query($query3);
mysql_query($query4);
mysql_query($query5);
mysql_query($query6);
mysql_query($query7);
mysql_query($query8);

?>


