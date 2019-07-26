<?php

//  ----------------------------------------------------------------------------
//  2011-02-24
//  html begin
//  ----------------------------------------------------------------------------
// Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-05-09
//  2011-10-26 			- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17			- neu header definition  // umstellung auf utf-8
//  2011-11-23			- neuer Server: WAMP > header, meta charset:  ISO-8859-1
//  ----------------------------------------------------------------------------











header('Content-Type: text/html; charset=UTF-8');
print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
print "<html xmlns='http://www.w3.org/1999/xhtml'>";
print "<head>";
print "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
print "<title>Telekonsil</title>";
print "<meta name='robots' content='noindex, nofollow, noarchive'>";
print "	<script type='text/javascript' src='ckeditor/ckeditor.js'></script>";
if ((($x == 3316) OR ($x == 3216)) OR (($x == 3416) OR ($x == 3416)) ){ 
	print "<link rel='stylesheet' href='css/print.css' type='text/css'>";
	print "<script type='text/javascript' language='JavaScript'>
	<!-- Begin

	function printPage() {
	window.print();
	}
	</script>";
	print "</head>";
	print "<body onLoad='printPage();'>";
} else {
	print "<link rel='stylesheet' href='css/all.css' type='text/css'>";
	print "<link rel='stylesheet' href='css/seite.css' type='text/css'>";
	print "<meta name='programming-copyright' content=''>";
	print "<script language=JavaScript SRC='js/scripte.js' type='text/javascript'></script>";
	if ($x == 3300){
		$tT_all = Therapytemplate::getAllEntries('y');
		$count =0;
		if (is_array($tT_all)){
			foreach($tT_all as $id=>$sub) 
			{
				if (!is_array($sub)) { $count++; }
				else { $count = ($count + rcount($sub)); }
			}
		}
		$i = 1;
		if ($count > 0){
			foreach ($tT_all as $id){
				$t = 'tTitle'.$i;
				echo"
				<script type='text/javascript'>

				function transferText$i(){
						var source = document.getElementById('$t');
						var sourceText = source.value;
						var target = document.getElementById('therapyDescr3');
						var targetText = target.value;
						target.value = targetText + ' ' + sourceText;
				}
				</script>";
				$i++;
			}
    	}
   }
   print "</head>";
	print "<body>"; 
}
print "<div id='outline'> ";
print "<div id='printGrafik'>";
print "<p align='center'><a href='verwaltung.php'>Home</a></p>";
print "<img src='imagesLayout/stenoLogo.gif'>";
print "</div>";
print "<div id='header'>";
print "<h1>$pageName</h1>";
print "</div>";
print "<div id='nav1'>";
print "</div>";
print "<div id='inhalt'>";
?>