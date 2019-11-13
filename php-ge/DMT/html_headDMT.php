<?php

//  ----------------------------------------------------------------------------
//  2011-04-28
//  dmt html begin
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-05-09
//  2011-10-26 			- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17			- neu header definition  
//						  umstellung auf utf-8 inklusive dateieigenschaften
// 	2011-11-23			- neuer Server: WAMP > header, meta charset:  ISO-8859-1
//  2912-09-15 			- jquery for konsilschein templates
//  ----------------------------------------------------------------------------







header('Content-Type: text/html; charset=ISO-8859-1');

print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
print "<html xmlns='http://www.w3.org/1999/xhtml'>";
print "<head>";
print "<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1' />";
print "<title>$pageName</title>";
print "	<script type='text/javascript' src='../ckeditor/ckeditor.js'></script>";
		echo "
		";
if ((($x == 3316) OR ($x == 3216)) OR (($x == 3416) OR ($x == 3416)) ){ 
	print "<link rel='stylesheet' href='../css/print.css' type='text/css'>";
	print "<script type='text/javascript' language='JavaScript'>
	<!-- Begin

	function printPage() {
	window.print();
	}
	</script>";
	print "</head>";
	print "<body onLoad='printPage();'>";
} else {
	echo"
	<link rel='stylesheet' href='../css/all.css' type='text/css'>
	<link rel='stylesheet' href='../css/CMT.css' type='text/css'>
	<meta name='programming-copyright' content=''>
	<script language=JavaScript SRC='../js/scripte.js' type='text/javascript'></script>";
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
	echo"	
	</head>
	<body>
	";
}
?>