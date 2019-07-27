<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2011-02-24
//  Variablen Global
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-05-09
//  2011-10-26 			- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
//  ----------------------------------------------------------------------------









$adminEMailAdresse		= "hengstchon@gmail.com";
$administrator			= "Hr. Scibor";
$timestamp 				= $_SERVER['REQUEST_TIME'];
date_default_timezone_set("Europe/Berlin");
$datum 					= date("d.m.Y",$timestamp);
$uhrzeit 				= date("H:i",$timestamp);
$zeit   				= date('H:i');
$currentTime			= time();
$datumZeit				=  $datum . " - " . $uhrzeit . " Uhr";
$pageNameDMT			= "Telekonsil - Patienten-Dokument-Verwaltungssystem (PDVS)";
$pageName		    	= "诊断文件 - 远程诊断";
$versionsNr				= '04';
$author					= 'R. Handschu';
$datumFreigabeZEA		= '08.06.2010';
$datumFreigabeGNV		= '01.07.2010';
$datumFreigabePL		= '10.07.2010';
$gueltigkeit			= '31.10.2011';
$diagnoseButton			= '要求';
$therapyButton			= '诊断建议';
?>
