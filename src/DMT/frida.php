<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2011-02-24
//  DB Login
//  ----------------------------------------------------------------------------
//  2011-10-26 			- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
//  ----------------------------------------------------------------------------






if ($_SERVER['SERVER_NAME'] == "localhost") { //use localhost
	$db_host			= 'db';
	$db_name			= 'cn';
	$db_user			= 'root';
	$db_pw				= 'root';
} else  {
	$db_host			= 'localhost';
	$db_name			= 'fo';
	$db_user			= 'root';
	$db_pw				= 'root';
}
?>
