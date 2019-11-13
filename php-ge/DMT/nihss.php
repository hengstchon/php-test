<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2011-04-28
//  NIHSS Funktionen - DMT und web
//  im web und dmt verwendet > wenn notwendig, case global
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand - lezter Arbeitstag in der Entwicklung: 2011-04-28
//	2011-10				- NIHSS Punkte auf einer Seite
//	2011-10-26			- function getDBContent in getDBContent umbenannt
//   					- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
//  ----------------------------------------------------------------------------
//NIHSS

// -----------------------------------------------------------------------------
// Buttons in liste der Patientennavigation --- Begin 
// -----------------------------------------------------------------------------
function addNIHSSForm($patientID,$patientRecordID) {
	global $case;
	if($case == 'dmt'){
		print "<form method='post' action='DMT.php' style='float:left;'>";
	}
	if($case == 'web'){
		print "<form method='post' action='verwaltung.php' style='float:left;'>";
	}
	print "<input type='hidden' name='x' value='3220' />";
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='Dokum. NIHSS Neu' class='buttonNew' />";
	print "</form>";
}

function editNIHSSForm($patientID, $pnID) {
	global $case;
	$patientRecordID	= getDBContent('patientNIHSS','patientRecordID','pnID',$pnID);
	$editStatus			= getDBContent('patientRecords','editStatus','patientRecordID',$patientRecordID);
	if ($editStatus == 't'){
		$buttonClass= 'buttonShow';
	} else {
		$buttonClass= 'buttonEdit';
	}
	if($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	print "<input type='hidden' name='x' value='3200' />"; 
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='pnID' value='$pnID' />";
	print "<input type='submit' value='NIHSS (id: $pnID)' class='$buttonClass' />";
	print "</form>";
	print "<div class='clear'></div>";
}	  

function showNIHSSForm($patientID, $pnID) {
	global $case;
	if($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	print "<input type='hidden' name='x' value='3215' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='pnID' value='$pnID' />";
	print "<input type='submit' value='>ANZEIGEN<' class='buttonShow' />";
	print "</form>";
	print "<div class='clear'></div>";
}	 

function printNIHSSForm($patientID, $pnID) {
	global $case;
	if($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	print "<input type='hidden' name='x' value='3216' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='pnID' value='$pnID' />";
	print "<input type='submit' value='>DRUCKEN<' class='buttonShow' />"; 
	print "</form>";
	print "<div class='clear'></div>";
}   

function savePatientNIHSS($patientID, $patientRecordID) { 
	global $case;
	$pnID = '';
	global $db_handle, $x;
	if (access()) {
		$timestampCreated	= date('Y-m-d H:i:s');
		if($case == 'dmt'){
			$arztID = getAdminID();
		}
		if($case == 'web'){
			$arztID	= $_SESSION['arztID'];
		}
		$where = 'pnID, arztID, patientID, patientRecordID, timeNIHSS';
		$value = "'NULL','$arztID','$patientID','$patientRecordID', '$timestampCreated'";	 
		$db_request = "INSERT INTO patientNIHSS (" . $where . ") VALUES (" . $value . ")";
		$query_handle = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$pnID = mysql_insert_id();
			setSavedOptionYes($x); 
			$anzahl	= getMaxEntries('docuNIHSS','nihssStepID');
			for ($i = 1; $i <= $anzahl; $i++){
				$where2 = 'pWertID, pnID, nihssStepID, pWert1, pWert2, pWert3, pWert4, pWert5';
				$value2 = "'NULL','$pnID','$i','99','99','99','99','99'";	 
				$db_request2 = "INSERT INTO patientNIHSSWerte (" . $where2 . ") VALUES (" . $value2 . ")";
				$query_handle2 = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != ""){
					$pWertID = mysql_insert_id();
				} else {
					print "<p class='errorMessage'>Konnte kein neuen Eintrag erzeugen [savePatientNIHSS() -> $pWertID]!</p>";
				}
			}
		} else {
			print "<p class='errorMessage'>Konnte kein neuen Eintrag in erzeugen [savePatientNIHSS($patientID, $patientRecordID)]!</p>";
		}
		return $pnID;
	} else { 
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientNIHSS($patientID, $patientRecordID)]!</p>";
	} 
}

function editPatientNIHSSWerte($pnID) {
	global $db_handle;
	global $case;
	$patientID	= getDBContent('patientNIHSS','patientID','pnID',$pnID); 
	$arztID		= getDBContent('patientNIHSS','arztID','pnID',$pnID);
	$arztInfos	= getArztInfos($arztID);
	$time		= getDBContent('patientNIHSS','timeNIHSS','pnID',$pnID);
	$time		= strtotime($time);
	$time		= date("d.m.Y. H:i", $time) . ' Uhr';
	print " <hr>NIHSS (id: $pnID) Arzt: $arztInfos, Datum: $time <hr>";
	$nr			= 1;
 	if (access()) {
		if($case == 'dmt'){
			print "<form method='post' action='DMT.php'>";
		}
		if($case == 'web'){
			print "<form method='post' action='verwaltung.php'>";
		}
		print "<input type='hidden' name='x' value='3235' />";
		print "<input type='hidden' name='pnID' value='$pnID' />";
		print "<input type='hidden' name='patientID' value='$patientID' />"; 
		$db_request1	 = "SELECT  nihssStepName, nihssStepText, cameraInfo, assistenzInfo, nihssStepID, posNIHSSoriginal FROM docuNIHSS ORDER by posTelekonsil  ";	  
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			for ($i1 = 0; $i1 < $rows1; $i1++){
				$data1		  = mysql_fetch_row($query_handle1); 
				$name			= $data1[0];   
				$text			= $data1[1];
				$camera			= $data1[2];
				$assitenz		= $data1[3];
				$nihssStepID	= $data1[4];
				$posNIHSSoriginal	= $data1[5];
				print "<div class='eName1'>";
				print "<h2>";
				if ($posNIHSSoriginal <> ''){
					print "$posNIHSSoriginal. ";
				}
				print "$name</h2>";
				if ($text <> ''){
					print "<div class='eText'>($text)</div>";
				}
				print "Kameraeinstellung: ";
				if ($camera == 'z'){
					print "Naheinstellung ";
				} 
				if ($camera == 'w'){
					print "&Uuml;bersicht ";
				} 
				if ($assitenz == 'j'){
					print ", Assitenz n&ouml;tig";
				} 
				print "</div>";
				print "<div class='clear'></div>";
				$db_request2	 = "SELECT eigenschaftID, eigenschaftName, eigenschaftText, bewertungsType, wert1, wert2 FROM docuNIHSSdetails  WHERE nihssStepID ='$nihssStepID'  ";	  
				$query_handle2   = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != ""){
					$rows2 = mysql_num_rows($query_handle2);
					print "<ul style='list-style-type:none;margin-left: -24px;'>";
					for ($i2 = 0; $i2 < $rows2; $i2++){
						$data2		  = mysql_fetch_row($query_handle2); 
						$eigenschaftID  = $data2[0];   
						$name			= $data2[1];   
						$text			= $data2[2];
						$type			= $data2[3];
						$wert1		= $data2[4]; 
						$wert2		= $data2[5]; 
							if (($type == 'b') And ($i2 == 0)){ 
								print "<div class='clear'></div>";
								print "<div style='margin:0 0 0 495px;font-weight:bold;'>rechts &nbsp; links</div>";
								print "<div class='clear'></div>";
							}
						print "<li>";
						print "<div class='col1a'>";
						print "<div class='eName2'>";
						print "$name "; 
						print "</div>";
						if ($text <> ''){
							print "<div class='eText'>($text)</div>";
						}
						print "</div>"; 
						$db_request3	 = "SELECT pWert1, pWert2, pWert3, pWert4, pWert5, pWertDescr FROM patientNIHSSWerte  WHERE pnID = '$pnID' AND nihssStepID = '$nihssStepID' ";	  
						$query_handle3   = mysql_query($db_request3, $db_handle);
						if ($query_handle3 != ""){
							$rows3 		= mysql_num_rows($query_handle3);
							if ($rows3 == 0){
								$eID1		= '';   
								$eID2		= '';   
								$eID3 		= '';
								$eID4		= '';
								$eID5		= '';
								$pWertDescr	= '';	
							} else { 
								$data3 		= mysql_fetch_row($query_handle3); 
								$eID1		= $data3[0];   
								$eID2		= $data3[1];   
								$eID3 		= $data3[2];
								$eID4		= $data3[3];
								$eID5		= $data3[4];
								$pWertDescr	= $data3[5];				
							}
						}
						print "<div class='col2a'>";
						if ($type == 'p'){ 
							print "<div class='eInput'>";
							if ($eigenschaftID == $eID1){
								print "<input type='radio' name='pWert1[$i1]' value='$eigenschaftID' checked /> "; 
							} else {
								print "<input type='radio' name='pWert1[$i1]' value='$eigenschaftID' /> "; 
							}
							print "$wert1";
							print "</div>";
						} 
						if ($type == 'b'){ 
							print "<div class='eInput'>";
							if ($eigenschaftID == $eID2){
								print "<input type='radio' name='pWert2[$i1]' value='$eigenschaftID' checked /> "; 
							} else {
								print "<input type='radio' name='pWert2[$i1]' value='$eigenschaftID' />   "; 
							}
							print "$wert1";
							print "</div>";
							print "<div class='eInput'>";
							if ($eigenschaftID == $eID3){
								print "<input type='radio' name='pWert3[$i1]' value='$eigenschaftID' checked /> "; 
							} else {
								print "<input type='radio' name='pWert3[$i1]' value='$eigenschaftID' /> "; 
							}
							print "$wert2";
							print "</div>";
						}
						if ($type == 'c'){ 
							print "<div class='eInput'>";
							if ($eigenschaftID == $eID5){
								print "<input type='checkbox' name='pWert5[$i1]' value='$eigenschaftID' checked />li ";
							} else {
								print "<input type='checkbox' name='pWert5[$i1]' value='$eigenschaftID' />li ";
							}
							print "<div class='eInput'>";
							if ($eigenschaftID == $eID4){
								print "<input type='checkbox' name='pWert4[$i1]' value='$eigenschaftID' checked />re ";
							} else {
								print "<input type='checkbox' name='pWert4[$i1]' value='$eigenschaftID' />re ";
							}
							print "</div>";
						}
						if ($type == 's'){ 
							print "<div class='eInput'>";
							print "<input type='text' name='pWertDescr[$i1]' value='$pWertDescr' />";
							print "</div>";
						}
						print "</div>"; 
						print "<div class='clear'></div>";
					} 
					print "</ul>";
				} else {
					print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editNIHSS($pnID) > query2]</p>";
				} 
				print "<div class='clear'></div>";
				$nr++;
			}
			print "<input type='submit' value='Speichern' class='buttonHome' />";
			print "</form>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editNIHSS($pnID) > query1]</p>";
		} 
		print "<hr>";
		print "Erkl&auml;rungen Kameraeinstellungen: &Uuml;bersicht = Kamera Zoom weit, Naheinstellung = Kamera Zoom nah";
		print "<hr>";
	} 
}

function savePatientNIHSSWerte($pnID,$pWerteArray) { 
	global $db_handle;
	if (access()) {
		foreach ($pWerteArray as $key => $werte){
			if ($werte <> ''){
				foreach ($werte as $step => $eigenschaftID){
							$nihssStepID 	= $step + 1 ;
							$db_request1	= "SELECT nihssStepName FROM docuNIHSS WHERE nihssStepID = '$nihssStepID'";	  
							$query_handle1  = mysql_query($db_request1, $db_handle);
							if ($query_handle1 != ""){
								$data1	 	= mysql_fetch_row($query_handle1); 
								$name			= $data1[0];  
								if ($eigenschaftID <> ''){
									if ($key <> 5){
										$db_request2	 = "SELECT eigenschaftName, eigenschaftText, bewertungsType FROM docuNIHSSdetails  WHERE eigenschaftID ='$eigenschaftID'  ";	  
										$query_handle2   = mysql_query($db_request2, $db_handle);
										if ($query_handle2 != ""){
											$data2		  = mysql_fetch_row($query_handle2); 
											$nameE		= $data2[0];   
											$textE		= $data2[1];
											$type			= $data2[2];
										} else {
											print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [savePatientNIHSSWerte($pnID,$pWerteArray) - query 2]</p>";
										} 
									}
									else {
									}
								}
							} else {
								print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [savePatientNIHSSWerte($pnID,$pWerteArray) - query 1]</p>";
							} 
					if ($key == 0){ 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert1', $eigenschaftID); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert2', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert3', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert4', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert5', 0); 
					}
					if ($key == 1){ 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert2',  $eigenschaftID); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert1', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert3', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert4', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert5', 0); 
					}
					if ($key == 2){ 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert3',  $eigenschaftID); 
						$db_request2	 = "SELECT pWert2 FROM `patientNIHSSWerte` WHERE pnID = '$pnID' AND nihssStepID = '$nihssStepID'";
						$query_handle2   = mysql_query($db_request2, $db_handle);
						if ($query_handle2 != ""){
							$pW2 = mysql_fetch_row($query_handle2);
						}
						 if ($pW2[0] == 99){ 
							saveNIHSSWert($pnID, $nihssStepID, 'pWert2', 0); 
						 } 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert1', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert4', 0); 
						 saveNIHSSWert($pnID, $nihssStepID, 'pWert5', 0); 
					}
					if ($key == 3){ 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert4',  $eigenschaftID); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert1', 0); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert2', 0); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert3', 0); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert5', 0); 
					}
					if ($key == 4){ 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert5',  $eigenschaftID); 
						$db_request3	 = "SELECT pWert4 FROM `patientNIHSSWerte` WHERE pnID = '$pnID' AND nihssStepID = '$nihssStepID'";
						$query_handle3   = mysql_query($db_request3, $db_handle);
						if ($query_handle3 != ""){
							$pW4 = mysql_fetch_row($query_handle3);
						}
						if ($pW4[0] == 99){ 
							saveNIHSSWert($pnID, $nihssStepID, 'pWert4', 0); 
						 } 						 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert1', 0); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert2', 0); 
						saveNIHSSWert($pnID, $nihssStepID, 'pWert3', 0); 
					}
					if ($key == 5){ 
						if ($eigenschaftID <> ''){
						 	saveNIHSSWert($pnID, $nihssStepID, 'pWertDescr', $eigenschaftID); 
						}
					}
				} 
			} 
		} 
	}	
}

function saveNIHSSWert($pnID, $nihssStepID, $column, $pWert) { 
	global $db_handle, $x;
	global $case;
 	if (access()) {
		$db_request1	 = "SELECT nihssStepID FROM `patientNIHSSWerte` WHERE pnID = '$pnID' AND nihssStepID = '$nihssStepID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 <> 0){ 
				$db_request = "UPDATE patientNIHSSWerte SET $column = '$pWert' WHERE pnID = '$pnID' AND nihssStepID = '$nihssStepID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte NIHSS $column nicht &auml;ndern [saveNIHSSWert($pnID, $nihssStepID, $column, $pWert)]!</p>";
				}
			}
		}		
	} else { 
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [ssaveNIHSSWert($pnID, $nihssStepID, $column, $pWert)]!</p>";
	} 
}

function showPatientNIHSSWerte($pnID) {
	global $db_handle;
	$printTotal = '';
	$arztID		= getDBContent('patientNIHSS','arztID','pnID',$pnID);
	$arztInfos	= getArztInfos($arztID);
	$time		= getDBContent('patientNIHSS','timeNIHSS','pnID',$pnID);
	$time		= strtotime($time);
	$time		= date("d.m.Y. H:i", $time) . ' Uhr';
	print "<h2>NIHSS-Durchf&uuml;hrender Arzt: $arztInfos, Datum: $time&nbsp;</h2>";
	if (access()) {
		print "<ol id='list1'>";
		$db_request	 = "SELECT nihssStepID, pWert1, pWert2, pWert3, pWert4, pWert5, pWertDescr FROM patientNIHSSWerte WHERE pnID = '$pnID' ORDER by nihssStepID"; 
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			if ($rows == 0){
			} else {
				for($i=0;$i<$rows;$i++){
					$data   = mysql_fetch_row($query_handle); 
					$nihssStepID	= $data[0];
					$eID1		= $data[1]; 
					$eID2		= $data[2];
					$eID3		= $data[3];
					$eID4		= $data[4];
					$eID5		= $data[5];
					$eIDArray		= array($eID1,$eID2,$eID3,$eID4,$eID5);
					$wertDescr	= $data[6];
					$db_request3	 = "SELECT nihssStepName, nihssStepText, cameraInfo, assistenzInfo, posNIHSSoriginal FROM docuNIHSS WHERE nihssStepID = '$nihssStepID' ";	  
					$query_handle3   = mysql_query($db_request3, $db_handle);
					if ($query_handle3 != ""){
						$data3	  	= mysql_fetch_row($query_handle3); 
						$name		= $data3[0];   
						$text		= $data3[1];
						$camera		= $data3[2];
						$assitenz	= $data3[3];
						$posNIHSSoriginal	= $data3[4];
						print "<li>";
						print "<b>";
						if ($posNIHSSoriginal <> ''){
							print "$posNIHSSoriginal. ";
						}
						print "$name</b> ";
						if ($text <> ''){
							print "($text)";
						}
						$remember = 0;
						foreach ($eIDArray as $key => $id){ 
							if ($remember <> 1){
								if (($id <> 0) AND ($id <> 99)){
									$db_request2	 = "SELECT eigenschaftName, eigenschaftText, bewertungsType FROM docuNIHSSdetails  WHERE eigenschaftID ='$id'  ";	  
									$query_handle2   = mysql_query($db_request2, $db_handle);
									if ($query_handle2 != ""){
										$data2		  = mysql_fetch_row($query_handle2); 
										$nameE		= $data2[0];   
										$textE		= $data2[1];
										$type			= $data2[2];
									} else {
										print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [showPatientNIHSSWerte($pnID) > detail, WHERE eigenschaftID ='$id']</p>";
									} 
									print "<div class='clear'></div>";
									print "<div style='width: 450px;float: left;'>";
									print "$nameE "; 
									if ($textE <> ''){
										print " ($textE)";
									}
									print "</div>"; 
									print "<div style='width:150px;float: left; text-align:center;'>";
									if ($eID1 <> 0){  
										$wert1 = getDBContent('docuNIHSSdetails','wert1','eigenschaftID',$id);
										if ($wert1 == 9){ 
											$wert1	= '9 -> 0';
										} 
										print "$wert1";
									} 
									if ($type == 'b'){
										if ($eID2 <> 0){  
											$wert2 = getDBContent('docuNIHSSdetails','wert1','eigenschaftID',$eID2);
											if ($wert2 == 9){ 
												$wert2	= '9 -> 0';
											} 
											print "rechts: $wert2";
										} 
										if (($eID2 <> 0) AND ($eID3 <> 0)){
											print " & ";
										}
										if ($eID3 <> 0){  
											$wert3 = getDBContent('docuNIHSSdetails','wert2','eigenschaftID',$eID3);
											if ($wert3 == 9){ 
												$wert3	= '9 -> 0';
											} 
											print "links: $wert3";
										} 
										$remember = 1;
									}
									if ($type == 'c'){
										if ($eID4 <> 0){ 
											$wert4	= 'rechts';
										} else {
											$wert4	= '';
										}
										if ($eID5 <> 0){ 
											$wert5	= 'links';
										} else {
											$wert5	= '';
										}
										print "$wert4 &nbsp; $wert5";
										$remember = 1;
									}
									if ($wertDescr <> ''){ 
										print "<br>";
										print "Erkl.: $wertDescr ";
									}
									print "</div>"; 
								}	 
							}	
						}
						if ($id == 99){
							print "<br><b style='color:#FF3300;'>Nicht bewertet</b>";
							print ""; 
						}
						print "</li>";
						print "<div class='clear'></div>";
					} 
				} 
			$total		=  getTotalNIHSSviaSUM($pnID);
			$printTotal = "<h1 style='border-top:1px solid #000;border-bottom:3px double #000;padding: 13px;'>GESAMT: $total</h1>";
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [showPatientNIHSSWerte($pnID) ]</p>";
		} 
	} 
	print "</ol>";
	print "$printTotal";
}
?>