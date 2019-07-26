<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------
//  ----------------------------------------------------------------------------
//  2011-04-05
//  Globale Funktionen - DMT und web > wenn notwendig, case uebergeben
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-04-26
//  2011-10-10		 	- vergessene savePatientInfos function in case 1030 & 1035 integriert
//	2011-10				- NIHSS Punkte auf einer Seite
//	2011-10-26			- function getDBContent in getDBContent umbenannt
//   					- dateieigenschaften > php, western (ISO Latin1) & <?php
//						- FCK > CKeditor iPad faehig
//	2011-11-02			- fct. listAllPatients > radio instead checkbox (case = web) == nur einer auswaehlbar
// 	2011-11-07			- function addPatientForm ohne patientennamen test (dieser ueber suche moeglich)
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
// 	2011-11-23			- neuer Server: WAMP > neusortierung, alt raus,
//						- listAllPatients: nach Delete 1. Eintrag anzeigen, wenn keiner mehr mit selben Buchstaben
// 	2011-12-09			- showPatientRecord: lyseOption raus, Datum therapy formatiert (deutsch, ohne Sekunden)
// 	2011-12-21			- Fehlerbehebung: savePatientRecord . Art des Konsils, Wert von Video war b statt v
//  ----------------------------------------------------------------------------

function setSavedOptionYes($x){
	$_SESSION['addOption'] = 1;
	$_SESSION['xWas'] = $x;
}

function setSavedEmpty(){
	$_SESSION['addOption'] = 0;
	$_SESSION['xWas'] = "";
}

function listIndication() {
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT indicationID, indicationName, indicationCode, indicationComment FROM indication ORDER BY indicationName";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<table cellspacing='0' cellpadding='5'>";
			print "<tr class='bg1'>";
			print "<td>Name</td><td>Text</td><td>Kommentar</td>";
			print "</tr>";
			for ($i = 0; $i < $rows; $i++){
				$data = mysql_fetch_row($query_handle);
				$ID	 		= $data[0];
				$Name 		= $data[1];
				$Text			= $data[2];
				$Comment		= strip_tags($data[3]);
				print "<tr>";
				print "<td class='borderUnten'>$Name  &nbsp;</td>";
				print "<td class='borderUnten'>$Text  &nbsp;</td>";
				print "<td class='borderUnten'>$Comment &nbsp;</td>";
				print "</tr>";
			}
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listIndication]</p>";
		}
	}
}

function getIndicationSelectMenu($indicationID) {
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT indicationID, indicationName, indicationCode, indicationComment FROM indication ORDER BY indicationID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<select name='indicationID' >";
			if($indicationID == 0){
				print "<option value=''>请选择</option>";
			}
			for ($i = 0; $i < $rows; $i++){
				$data = mysql_fetch_row($query_handle);
				$ID	 		= $data[0];
				$Name 		= $data[1];
				$Text			= $data[2];
				if ($ID == $indicationID){
					print "<option value='$ID' selected>$Text: $Name</option>";
				} else {
					print "<option value='$ID'>$Text: $Name</option>";
				}
			}
			print "</select>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [getIndicationSelectMenu($indicationID)]</p>";
		}
	}
}

function listIndication2() {
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT indication2ID, indication2Name, indication2Code FROM indication2 ORDER BY indication2Code";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<table cellspacing='0' cellpadding='5'>";
			print "<tr class='bg1'>";
			print "<td>Name</td><td>Text</td><td>Kommentar</td>";
			print "</tr>";
			for ($i = 0; $i < $rows; $i++){
				$data = mysql_fetch_row($query_handle);
				$ID	 		= $data[0];
				$Name 		= $data[1];
				$Text			= $data[2];
				$Comment		= strip_tags($data[3]);
				print "<tr>";
				print "<td class='borderUnten'>$Name  &nbsp;</td>";
				print "<td class='borderUnten'>$Text  &nbsp;</td>";
				print "<td class='borderUnten'>$Comment &nbsp;</td>";
				print "</tr>";
			}
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listIndication2Web]</p>";
		}
	}
}

function getIndication2SelectMenu($indication2ID) {
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT indication2ID, indication2Name, indication2Code, indication2Comment FROM indication2 ORDER BY indication2ID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<select name='indication2ID'>";
			if($indication2ID == 0){
				print "<option value=''>请选择</option>";
			}
			for ($i = 0; $i < $rows; $i++){
				$data = mysql_fetch_row($query_handle);
				$ID	 		= $data[0];
				$Name 		= $data[1];
				$Text			= $data[2];
				if ($ID == $indication2ID){
					print "<option value='$ID' selected>$Text: $Name</option>";
				} else {
					print "<option value='$ID'>$Text: $Name</option>";
				}
			}
			print "</select>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [getIndication2SelectMenu($indication2ID)]</p>";
		}
	}
}

function getIndication2DetailSelectMenu($indication2DID) {
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT indication2DID, indication2DName, indication2DCode FROM indication2Detail ORDER BY indication2DID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<select name='indication2DID'>";
			if($indication2DID == 0){
				print "<option value=''>请选择</option>";
			}
			for ($i = 0; $i < $rows; $i++){
				$data = mysql_fetch_row($query_handle);
				$ID	 		= $data[0];
				$Name 		= $data[1];
				$Text			= $data[2];
				if ($ID == $indication2DID){
					print "<option value='$ID' selected>$Text: $Name</option>";
				} else {
					print "<option value='$ID'>$Text: $Name</option>";
				}
			}
			print "</select>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [getIndication2DetailSelectMenu($indication2DID)]</p>";
		}
	}
}

function patientsNavigation() {
	global $case;
	print "<div id='letterNavLayer'>";
	for ($i=65; $i <=90 ; $i++){
		$capitalLetter = chr($i);
		if (nameExist($capitalLetter) > 0) {
			if ($case == 'web'){
				print "<form method='post' action='verwaltung.php' class='capitalLetter' >";
				print "<input type='hidden' name='x' value='3000' />";
			}
			if ($case == 'dmt'){
				print "<form method='post' action='DMT.php' class='capitalLetter' >";
				print "<input type='hidden' name='x' value='3000' />";
			}
			print "<input type='hidden' name='capitalLetter' value='$capitalLetter' />";
			print "<input type='submit' value='$capitalLetter' class='capitalLetter' />";
			print "</form>";
		} else {
			print "<div  class='capitalLetter'>$capitalLetter</div>";
		}
	}
	print "</div>";
	print "<div class='clear'></div>";
}

function checkpLastNameExists($pLastName) {
	global $db_handle;
	$exists = 0;
	if (access()) {
		$pLastName		= mb_strtoupper($pLastName);
		$db_request1	= "SELECT patientID FROM patients WHERE pLastName = '$pLastName'";
		$query_handle1  = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows = mysql_num_rows($query_handle1);
			if ($rows > 0){
				$exists	= 1;
			}
		}
	}
	return $exists;
}

function listAllPatients($capitalLetter) {
	global $db_handle;
	global $case;
	$count = 0;
    $navStatus = 1;
	if (access()) {
    	if ($capitalLetter == ''){
    		$navStatus = 0;
			$capitalLetter='A';
			$db_request	 = "SELECT pLastName FROM patients ORDER by pLastName ASC";
			$query_handle   = mysql_query($db_request, $db_handle);
			if ($query_handle != ""){
				$rows = mysql_num_rows($query_handle);
				$data		  = mysql_fetch_row($query_handle);
				$capitalLetter = substr($data[0],0,1);
			}
		}
		$db_request1	 = "SELECT patientID, pFirstName, pLastName, pBday, pStreet, pZipCode, pCity, pPhone, pGender FROM patients  WHERE pLastname LIKE '$capitalLetter%'  ORDER by pLastName ASC";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
				$db_request	 = "SELECT pLastName FROM patients ORDER by pLastName ASC";
				$query_handle   = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
					$data		  	= mysql_fetch_row($query_handle);
					$capitalLetter 	= substr($data[0],0,1);
				}
				if ($capitalLetter <> ''){
					listAllPatients($capitalLetter);
				}  else {
					print "<p>Keine Patienten vorhanden</p>";
					addPatientForm('');
					print "<div class='clear'></div>";
				}
			} else {
				patientsNavigation();
				print "<fieldset>";
				print "<legend>现有患者, 按姓氏排序</legend>";
				if ($case == 'dmt'){
					print "<form method='post' action='DMT.php'>";
					print "<input type='hidden' name='x' value='1020' />";
					print "<table cellspacing='0' cellpadding='5' class='padding'>";
					print "<tr class='bg1'>";
					print "<td valign='top' class='mini' width='2%'>#</td>";
					print "<td valign='top' class='mini' width='28%'>Vorname Nachname (出生日期)";
					print "</td>";
					print "<td valign='top' colspan='2' class='mini' width='70%'>Bearbeiten Links</td>";
					print "</tr>";
				}
				if ($case == 'web'){
					print "<form method='post' action='verwaltung.php'>";
					print "<input type='hidden' name='x' value='1020' />";
					print "<ul style='line-height:220%;list-style-type:none;'>";
				}
			 	for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1		  = mysql_fetch_row($query_handle1);
					$patientID	  = $data1[0];
					$pFirstName	 = $data1[1];
					$pLastName	  = $data1[2];
					$pBday	 		= $data1[3];
					$pStreet		= $data1[4];
					$pZipCode	 	= $data1[5];
					$pCity		= $data1[6];
					$pPhone 		= $data1[7];
					$pGender	 	= $data1[8];
					if($pGender == 'w'){
						$pGender = "女士 ";
					} else {
						$pGender = "先生  ";
					}
					$pFirstName	= schreibweise($pFirstName);
					$pLastName	= schreibweise($pLastName);
					$pCity		= schreibweise($pCity);
					$pBday1			=	explode('-',$pBday);
					$pBdayYear		=	$pBday1[0];
					$pBdayMonth		=	$pBday1[1];
					$pBdayDay		=	$pBday1[2];
					$fallAktenAnz	= 0;
					$db_request	 = "SELECT patientRecordID FROM patientRecords WHERE patientID ='$patientID'";
					$query_handle   = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
						$fallAktenAnz = mysql_num_rows($query_handle);
					}
					$count++;
					if ($case == 'dmt'){
						print "<tr>";
						print "<td class='borderUnten'><span class='mini'>$count </span></td>";
						print "<td class='borderUnten' align='top'>";
						print "<b>$pLastName</b>, $pFirstName  (出生日期 $pBdayDay.$pBdayMonth.$pBdayYear, id: $patientID) <br>";
						if ($fallAktenAnz > 0 ){
							if ($fallAktenAnz == 1 ){
								print "$fallAktenAnz Konsilschein vorhanden";
							} else {
								print "$fallAktenAnz Konsilscheine vorhanden";
							}
						}
						print "</td>";
						print "<td class='borderUnten' colspan='2'> ";
						print "<form method='post' action='DMT.php' style='float:left;'>";
						print "<input type='hidden' name='x' value='1020' />";
						print "<input type='hidden' name='patientID' value='$patientID' />";
						print "<input type='submit' value='Alle Patientendaten' class='buttonEdit' />";
						print "</form>";
						print "<form method='post' action='DMT.php' style='float:left;'>";
						print "<input type='hidden' name='x' value='1200' />";
						print "<input type='hidden' name='patientID' value='$patientID' />";
						print "<input type='submit' value='Patient/-daten l&ouml;schen' class='buttonDelete' />";
						print "</form>";
						print "</td>";
						print "</tr>";
					}
					if ($case == 'web'){
						print "<li><input type='radio' name='patientID' value='$patientID' />";
						print " <b>$pLastName</b>, $pFirstName (出生日期: $pBdayDay.$pBdayMonth.$pBdayYear)</li>";
					}
				}
				if ($case == 'dmt'){
					print "</table>";
				}
				if ($case == 'web'){
					print "</ul>";
					print "<p><input type='submit' value='选择选定的患者' class='buttonHome' /></p>";
					print "</form>";
				}
				print "</fieldset>";
				print "<fieldset style='margin-top:30px;'>";
				addPatientForm('');
				print "</fieldset>";
				print "<hr>";
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [ listAllPatients($capitalLetter)]</p>";
		}
	}
}

function listPatients($pLastName) {
	global $db_handle;
	global $case, $x;
	$pLastName1	= schreibweise($pLastName);
	if (access()) {
		$db_request1	 = "SELECT patientID, pFirstName, pLastName, pBday, pStreet, pZipCode, pCity, pPhone, pGender FROM patients WHERE pLastName = '$pLastName1' ORDER by pLastName";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			print "<fieldset>";
			print "<legend>Vorhandenen Patieneneintrag mit dem Nachnamen '$pLastName1' ausw&auml;hlen</legend>";
			if ($case == 'dmt'){
				print "<form method='post' action='DMT.php'>";
			}
			if ($case == 'web'){
				print "<form method='post' action='verwaltung.php'>";
			}
			print "<input type='hidden' name='x' value='1020' />";
			$rows1 = mysql_num_rows($query_handle1);
			print "Es gibt bereits Patienten mit dem Nachnamen '$pLastName1'.";
			print "<ol style='line-height:190%;'>";
			for ($i1 = 0; $i1 < $rows1; $i1++){
				$data1		  = mysql_fetch_row($query_handle1);
				$patientID	  = $data1[0];
				$pFirstName	 = $data1[1];
				$pLastName	  = $data1[2];
				$pBday	 		= $data1[3];
				$pStreet		= $data1[4];
				$pZipCode	 	= $data1[5];
				$pCity		= $data1[6];
				$pPhone 		= $data1[7];
				$pGender	 	= $data1[8];
				if($pGender == 'w'){
					$pGender = "女士 ";
				} else {
					$pGender = "先生  ";
				}
				$pFirstName	= schreibweise($pFirstName);
				$pLastName	= schreibweise($pLastName);
				$pCity		= schreibweise($pCity);
					$pBday1			=	explode('-',$pBday);
					$pBdayYear		=	$pBday1[0];
					$pBdayMonth		=	$pBday1[1];
					$pBdayDay		=	$pBday1[2];
				print "<li><input type='radio' name='patientID' value='$patientID' />";
				print " $pLastName,  $pFirstName (出生日期: $pBdayDay.$pBdayMonth.$pBdayYear)</li>";
			}
			print "</ol>";
			print "<input type='submit' value='选择选定的患者' class='buttonHome' />";
			print "</form>";
			print "</fieldset>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listPatients($pLastName) ]</p>";
		}
		addPatientForm($pLastName1);
	}
}

function addPatientForm($pLastName) {
	global $case;
	print "<fieldset style='margin:20px 10px 20px 0px;width:220px;float:left;padding: 10px;'>";
	print "<legend>创建新病人:</legend>";
	if ($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if ($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	print "姓: <input type='text' name='pLastName' value='$pLastName' size='17' />";
	print "<input type='hidden' name='x' value='1015' />";
	print "<input type='submit' value='保存病人资料'  style='width:100%;' class='buttonMini' />";
	print "</form>";
	print "</fieldset>";
	include_once("search.php");
	$nr	= getMaxEntries('patients', 'patientID');
	if ($nr > 0 ){
		searchPatientMenu();
	}
}

function editPatient($patientID) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT pGender, pFirstName, pLastName, pStreet, pZipCode, pCity, pPhone, pBday FROM patients WHERE patientID = '$patientID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  	= mysql_fetch_row($query_handle1);
			$pGender	 	= $data1[0];
			$pFirstName	 	= $data1[1];
			$pLastName	  	= $data1[2];
			$pStreet	 	= $data1[3];
			$pZipCode		= $data1[4];
			$pCity	 		= $data1[5];
			$pPhone			= $data1[6];
			$pBday			= $data1[7];
			$pBday1			=	explode('-',$pBday);
			$pBdayYear		=	$pBday1[0];
			$pBdayMonth		=	$pBday1[1];
			$pBdayDay		=	$pBday1[2];
			$pFirstName		= schreibweise($pFirstName);
			$pLastName		= schreibweise($pLastName);
			$pCity			= schreibweise($pCity);
			if ($pLastName == ''){
				print "<legend>患者资料 - 输入 (id: $patientID)</legend>";
			} else {
				print "<legend>$pLastName, $pFirstName (出生日期 $pBdayDay.$pBdayMonth.$pBdayYear | id: $patientID)</legend>";
			}
			print "<input type='hidden' name='patientID' value='$patientID' />";
			print "<table cellspacing='0' cellpadding='0' style='margin: 5px 0px 0px 0px;line-height:200%;'>";
			print "<tr>";
			print "<td width='175'>称呼:</td>";
			print "<td>";
			if($pGender == 'w'){
				print "<input type='radio' name='pGender' value='w' checked> 女士 ";
				print "<input type='radio' name='pGender' value='m'> 先生 ";
			} else {
				print "<input type='radio' name='pGender' value='w'> 女士 ";
				print "<input type='radio' name='pGender' value='m' checked> 先生 ";
			}
			print "</td>";
			print "</tr>";
			print "<tr><td>名:</td><td> <input name='pFirstName' value='$pFirstName' /></td></tr>";
			print "<tr><td>姓:</td><td> <input name='pLastName' value='$pLastName' /></td></tr>";
			print "<tr><td>出生日期 日期 (TT.MM.JJJJ):</td><td>";
			if ($pBday == "0000-00-00"){
				print "<p style='float:left;margin:11px 5px;'>B请选择: </p>";
			}
			print "<select name='pBdayDay' style='float:left;margin-right: 5px;'>";
			if ($pBdayDay == "00"){
				print "<option selected value=''>天</option>";
			} else {
				print "<option selected value='$pBdayDay'>$pBdayDay</option>";
			}
			for ($i = 1; $i <= 31; $i++) {
				if ($i < 10) {
					print "<option value='0$i'>0$i</option>";
				} else {
					print "<option value='$i'>$i</option>";
				}
			}
			print "</select>";
			print "<select name='pBdayMonth' style='float:left;margin-right: 5px;'>";
			if ($pBdayMonth == "00"){
				print "<option selected value=''>月</option>";
			} else {
				$smName = monthName($pBdayMonth);
				print "<option selected value='$pBdayMonth'>$smName</option>";
			}
			for ($i = 1; $i <= 12; $i++) {
				$mName = monthName($i);
				if ($i < 10) {
					print "<option value='0$i'>$mName</option>";
				} else {
					print "<option value='$i'>$mName</option>";
				}
			}
			print "</select>";
			print "<select name='pBdayYear'>";
			if ($pBdayYear == '0000'){
				print "<option value=''>年</option>";
			}  else {
				print "<option selected value='$pBdayYear'>$pBdayYear</option>";
			}
			$currentYear = date('Y') ;
			$startjahr	= $currentYear - 110 ;
			for ($i=0; $i < 110; $i++){
				$year = $startjahr + $i;
				if ($pBdayYear <> $year){
					print "<option value='$year'>$year</option>";
				}
			}
			print "</select>";
			print "</td></tr>";
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editPatientWeb($patientID)]</p>";
		}
	}
}

function savePatient($pDataArray) {
	$patientID	= $pDataArray[0];
	global $db_handle;
	if (access()) {
		if ( $patientID <> ''){
			$db_request1	 = "SELECT patientID FROM patients WHERE patientID = '$pDataArray[0]'";
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != ""){
				$rows = mysql_num_rows($query_handle1);
				if ($rows > 0) {
					$data1 = mysql_fetch_row($query_handle1);
					$vname		= mb_strtoupper($pDataArray[1]);
					$count1		= strlen($vname);
					$vname		= str_replace(' ','', substr($vname, 0,1)) . substr($vname, 1, $count1);
					$db_request = "UPDATE patients SET pFirstName = '$vname' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Vorname nicht &auml;ndern!</p>";
					}
					$nname		= mb_strtoupper($pDataArray[2]);
					$count2		= strlen($nname);
					$nname		= str_replace(' ','', substr($nname, 0,1)) . substr($nname, 1, $count2);
					$db_request = "UPDATE patients SET pLastName = '$nname' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Nachname nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET pBday = '$pDataArray[3]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Geburtsdatum nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET pStreet = '$pDataArray[4]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Strasse nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET pZipCode = '$pDataArray[5]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte PLZ  nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET pCity = '$pDataArray[6]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Ort nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET pPhone = '$pDataArray[7]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Telefonnummer nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patients SET  pGender = '$pDataArray[8]' WHERE patientID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Anrede nicht &auml;ndern!</p>";
					}
				 }
			}
		} else {
			$nname		= mb_strtoupper($pDataArray[2]);
			$where = 'patientID, pLastName';
			$value = "'NULL','$nname'";
			$db_request = "INSERT INTO patients (" . $where . ") VALUES (" . $value . ")";
			$query_handle = mysql_query($db_request, $db_handle);
			if ($query_handle != ""){
				$patientID = mysql_insert_id();
			} else {
				print "<p class='errorMessage'>Konnte kein neuen Eintrag in patients erzeugen [savePatient($pDataArray)]!</p>";
			}
			return $patientID;
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatient($pDataArray)]!</p>";
	}
}

function showPatient($patientID) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT pGender, pFirstName, pLastName, pStreet, pZipCode, pCity, pPhone, pBday FROM patients WHERE patientID = '$patientID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  	= mysql_fetch_row($query_handle1);
			$pGender	 	= $data1[0];
			$pFirstName	 	= $data1[1];
			$pLastName	  	= $data1[2];
			$pStreet	 	= $data1[3];
			$pZipCode		= $data1[4];
			$pCity	 		= $data1[5];
			$pPhone			= $data1[6];
			$pBday			= $data1[7];
			if($pGender == 'w'){
				$pGenderText = "女士 ";
			} else {
				$pGenderText = "先生 ";
			}
			$pFirstName	= schreibweise($pFirstName);
			$pLastName	= schreibweise($pLastName);
			$pBday1			=	explode('-',$pBday);
			$pBdayYear		=	$pBday1[0];
			if ($pBday1[1] <> 00){
				$pBdayMonth		=	monthName($pBday1[1]);
			} else {
				$pBdayMonth		=	'';
			}
			$pBdayDay		=	$pBday1[2];
			print "<legend>$pLastName, $pFirstName (出生日期: $pBdayDay. $pBdayMonth $pBdayYear)</legend>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editPatient($patientID)]</p>";
		}
	}
}

function editPatientAndDiagnose($patientID) {
	global $case;
	editPatient($patientID);
	$pRecordDataArray	= array('', $patientID);
	$patientRecordID 	= savePatientRecord($pRecordDataArray);
	print "<br />";
	print "<hr>";
	editPatientRecordDiagnose($patientRecordID);
}

function listAllPatientsRecords($editStatus1) {
	global $db_handle;
	global $case;
 	if (access()) {
		$patientID1 = '';
		if ($editStatus1 == ''){
			$db_request1	 = "SELECT patientRecordID, patientID FROM patientRecords  ORDER by patientID DESC , timestampCreated DESC";
		} else {
			$db_request1	 = "SELECT patientRecordID, patientID FROM patientRecords  WHERE editStatus = '$editStatus1' ORDER by patientID DESC ,  timestampCreated DESC";
		}
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
				print "<p>Keine Eintr&auml;ge vorhanden.</p>";
				addPatientForm('');
				print "<div class='clear'></div>";
			} else {
				for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1	= mysql_fetch_row($query_handle1);
					$pRID 	= $data1[0];
					$pID 	= $data1[1];
					if ($pID <> $patientID1){
						$patientIDs[$i1] 	= $pID;
						$patientID1			= $pID;
					}
				}
				print "<p>按寄售日期排序 ";
				print " ";
				print "  </p>";
				foreach ($patientIDs as $key => $patientID){
					$vname		= schreibweise(getDBContent('patients','pFirstName', 'patientID',$patientID));
					$nname		= schreibweise(getDBContent('patients','pLastName', 'patientID',$patientID));
					$bDay		= getDBContent('patients','pBday', 'patientID',$patientID);
					if ($bDay <> "0000-00-00"){
						$bDay		= strtotime($bDay);
						$bDay		= date("d.m.Y",$bDay);
					}
					print "<fieldset>";
					print "<legend>$nname, $vname (出生日期 $bDay, id: $patientID)</legend>";
					listPatientRecords($patientID);
					print "</fieldset>";
				}
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listAllPatientRecords()]</p>";
		}
	}
	if ($rows1 > 0){
		include_once("search.php");
		searchPatientMenu();
		print "<div class='clear'></div>";
	}
}

function listPatientRecords($patientID) {
	global $db_handle;
	global $case,$x;
	print "<h2>病人浏览查询</h2>";
	if (access()) {
		if($case == 'dmt'){
			print "<form method='post' action='DMT.php'>";
		}
		if($case == 'web'){
			print "<form method='post' action='verwaltung.php'>";
		}
		print "<input type='hidden' name='x' value='1020' />";
		print "<input type='hidden' name='patientID' value='$patientID' />";
		print "<input type='submit' value='患者资料' class='buttonMini' />";
		print "</form>";
		print "<div id='rahmenGruppeAll'>";
		$db_request3	 = "SELECT  patientRecordID, timeHospital, editStatus, diagnosisArztID,therapyArztID FROM patientRecords WHERE patientID = '$patientID' ORDER by patientRecordID DESC";
		$query_handle3   = mysql_query($db_request3, $db_handle);
		if ($query_handle3 != ""){
			$rows3 = mysql_num_rows($query_handle3);
			for ($i3 = 0; $i3 < $rows3; $i3++){
				$data3		  = mysql_fetch_row($query_handle3);
				$patientRecordID= $data3[0];
				$time			= $data3[1];
				$editStatus		= $data3[2];
				$diagnosisArztID= $data3[3];
				$therapyArztID  = $data3[4];
				$diagnosisArzt		= getArztInfos($diagnosisArztID);
				$therapyArzt		= getArztInfos($therapyArztID);
				$time			= strtotime($time);
				$time	 		= date("d.m",$time) . '. (' . date("H:i",$time) . ' Uhr)';
				if ($i3 > 0){
					print "<hr>";
				}
				if ($editStatus == 'o'){
					print "<h3 class='mini'>";
					if ($case == 'web'){
						print "<img src='imagesLayout/blinkenRot.gif' style='float:left;margin:0px 3px 0px 0px;'>";
					}
					if ($case == 'dmt'){
						print "<img src='../imagesLayout/blinkenRot.gif' style='float:left;margin:0px 3px 0px 0px;'>";
					}
				} else {
					print "<h3 id='show' class='mini'>";
				}
				$nr = $rows3 - $i3;
				print "$nr. 文件 --- 入院 : $time </h3> ";
				print "<p class='mini'>请求的医生: $diagnosisArzt<br>";
				if ($therapyArztID <> 0){
					print "检查医生: $therapyArzt";
				}
				print "</p>";
				print "<div class='clear'></div>";
				print "<div class='gruppe'>";
				print "<h4 class='mini'>诊断文件 (ID: $patientRecordID)</h4>";
				getTotalNIHSSWerte($patientRecordID);
				if ($editStatus == 't') {
					showRecordForm($patientID, $patientRecordID);
					printRecordForm($patientID, $patientRecordID);
				} else {
					editRecordForm($patientID, $patientRecordID);
				}
				print "</div>";
				if ($case =='dmt'){
					include_once("nihss.php");
				}
				if ($case =='web'){
					include_once("DMT/nihss.php");
				}
				print "<div class='gruppe'>";
				print "<h4 class='mini'>NIHSS</h4>";
				getNIHSSlistPlusButtons($patientRecordID);
				print "<hr>";
				addNIHSSForm($patientID,$patientRecordID);
				print "</div>";
				print "<div class='gruppe'>";
				print "<h4 class='mini'>Thrombolyse</h4>";
				getLyselistPlusButtons($patientID, $patientRecordID) ;
				print "<hr>";
				addThrombolyseForm($patientID,$patientRecordID);
				print "</div>";
				print "<div class='clear'></div>";
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listPatientRecords($patientID)]</p>";
		}
		print "<hr>";
		addRecordForm($patientID);
		print "</div>";
	}
}

function hiddenDiagnosisFields($patientRecordID) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT  timestampCreated, patientID, symptomsText, timeInitialContact, timeHospital, timeDiagnosis, timeTreatment, clinicID, diagnosisArztID, symptomDescr, indicationID, pDrugs, pConditions, pGewicht, pGroesse, timeSymptoms, symptomsText2, timeSymptomsGesund FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  = mysql_fetch_row($query_handle1);
			$timestampCreated	= $data1[0];
			$patientID			= $data1[1];
			$symptomsText 	= $data1[2];
			$timeInitialContact = $data1[3];
			$timeHospital 	= $data1[4];
			$timeDiagnosis 	= $data1[5];
			$timeTreatment		= $data1[6];
			$clinicID	 		= $data1[7];
			$diagnosisArztID	= $data1[8];
			$symptomDescr 	= $data1[9];
			$indicationID		= $data1[10];
			$pDrugs 			= $data1[11];
			$pConditions		= $data1[12];
			$pGewicht			= $data1[13];
			$pGroesse			= $data1[14];
			$timeSymptoms 	= $data1[15];
			$symptomsText2 	= $data1[16];
			$timeSymptomsGesund = $data1[17];
			print "<input type='hidden' name='clinicID' 			value='$clinicID' />";
			print "<input type='hidden' name='diagnosisArztID' 		value='$diagnosisArztID' />";
			print "<input type='hidden' name='symptomsText' 		value='$symptomsText' />";
			print "<input type='hidden' name='timeInitialContact' 	value='$timeInitialContact' />";
			print "<input type='hidden' name='timeHospital' 		value='$timeHospital' />";
			print "<input type='hidden' name='timeDiagnosis' 		value='$timeDiagnosis' />";
			print "<input type='hidden' name='symptomDescr' 		value='$symptomDescr' />";
			print "<input type='hidden' name='indicationID' 		value='$indicationID' />";
			print "<input type='hidden' name='pDrugs' 				value='$pDrugs' />";
			print "<input type='hidden' name='pConditions' 			value='$pConditions' />";
			print "<input type='hidden' name='pGewicht'				value='$pGewicht' />";
			print "<input type='hidden' name='pGroesse' 			value='$pGroesse' />";
			print "<input type='hidden' name='timeSymptoms' 		value='$timeSymptoms' />";
			print "<input type='hidden' name='symptomsText2' 		value='$symptomsText2' />";
			print "<input type='hidden' name='timeSymptomsGesund' 	value='$timeSymptomsGesund' />";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich hiddenDiagnosisFields($patientRecordID)!</p>";
		}
	}
}

function hiddenTherapyFields($patientRecordID) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT  timeTreatment, therapyArztID, konsilType, lyseOption, visualData, indication2ID, indication2DID, therapyDescr1, therapyDescr2, therapyDescr3, editStatus, visualDataDescr FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  = mysql_fetch_row($query_handle1);
			$timeTreatment		= $data1[0];
			$therapyArztID	= $data1[1];
			$konsilType 		= $data1[2];
			$lyseOption			= $data1[3];
			$visualData			= $data1[4];
			$indication2ID		= $data1[5];
			$indication2DID		= $data1[6];
			$therapyDescr 	= $data1[7];
			$therapyDescr2		= $data1[8];
			$therapyDescr3		= $data1[9];
			$editStatus			= $data1[10];
			$visualDataDescr	= $data1[11];
			$visualData			= explode(',',$visualData);
			print "<input type='hidden' name='timeTreatment' 	value='$timeTreatment' />";
			print "<input type='hidden' name='therapyArztID' 	value='$therapyArztID' />";
			print "<input type='hidden' name='konsilType' 		value='$konsilType' />";
			print "<input type='hidden' name='lyseOption' 		value='$lyseOption' />";
			print "<input type='hidden' name='visualData[0]' 		value='$visualData[0]' />";
			print "<input type='hidden' name='visualData[1]' 		value='$visualData[1]' />";
			print "<input type='hidden' name='visualData[2]' 		value='$visualData[2]' />";
			print "<input type='hidden' name='visualData[3]' 		value='$visualData[3]' />";
			print "<input type='hidden' name='indication2ID' 	value='$indication2ID' />";
			print "<input type='hidden' name='indication2DID' 	value='$indication2DID' />";
			print "<input type='hidden' name='therapyDescr' 	value='$therapyDescr' />";
			print "<input type='hidden' name='therapyDescr2' 	value='$therapyDescr2' />";
			print "<input type='hidden' name='therapyDescr3' 	value='$therapyDescr3' />";
			print "<input type='hidden' name='editStatus' 		value='$editStatus' />";
			print "<input type='hidden' name='visualDataDescr' 	value='$visualDataDescr' />";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich hiddenTherapyFields($patientRecordID)!</p>";
		}
	}
}

function editPatientRecordDiagnose($patientRecordID) {
	global $db_handle, $diagnoseButton;
	global $case;
	if ($case == 'dmt'){
		$editorURL	= '../';
	}
	if ($case == 'web'){
		$arztID		= $_SESSION['arztID'];
		$editorURL	= '';
	}
	if (access()) {
		$db_request1	 = "SELECT  timestampCreated, patientID, symptomsText, timeInitialContact, timeHospital, timeDiagnosis, clinicID, diagnosisArztID, symptomDescr, indicationID, pDrugs, pConditions, pGewicht, pGroesse, timeSymptoms, symptomsText2, timeSymptomsGesund FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  = mysql_fetch_row($query_handle1);
			$timestampCreated	= $data1[0];
			$patientID			= $data1[1];
			$symptomsText 		= $data1[2];
			$timeInitialContact = $data1[3];
			$timeHospital 		= $data1[4];
			$timeDiagnosis 		= $data1[5];
			$clinicID	 		= $data1[6];
			$diagnosisArztID	= $data1[7];
			$symptomDescr 		= $data1[8];
			$indicationID		= $data1[9];
			$pDrugs 			= $data1[10];
			$pConditions		= $data1[11];
			$pGewicht			= $data1[12];
			$pGroesse			= $data1[13];
			$timeSymptoms		= $data1[14];
			$symptomsText2		= $data1[15];
			$timeSymptomsGesund = $data1[16];
			if ($clinicID == 0){
				$clinicID		= getDBContent('aerzte','clinicID','arztID',$diagnosisArztID);
			}
			$clinicName			= getDBContent('clinics','clinicName','clinicID',$clinicID);
			$clinicInitial		= getDBContent('clinics','clinicInitial','clinicID',$clinicID);
			$timeGesundArray	= str_replace(' ','-',$timeSymptomsGesund);
			$timeGesundArray	= explode('-',$timeGesundArray);
			$timeGesundY		= $timeGesundArray[0];
			$timeGesundM		= $timeGesundArray[1];
			$timeGesundD		= $timeGesundArray[2];
			$timeGesundRest		= explode(':',$timeGesundArray[3]);
			$timeGesundH		= $timeGesundRest[0];
			$timeGesundMin		= $timeGesundRest[1];
			$timeSymptomsArray  = str_replace(' ','-',$timeSymptoms);
			$timeSymptomsArray  = explode('-',$timeSymptomsArray);
			$timeSymptomsY		= $timeSymptomsArray[0];
			$timeSymptomsM		= $timeSymptomsArray[1];
			$timeSymptomsD		= $timeSymptomsArray[2];
			$timeSymptomsRest	= explode(':',$timeSymptomsArray[3]);
			$timeSymptomsH		= $timeSymptomsRest[0];
			$timeSymptomsMin	= $timeSymptomsRest[1];
			if ($timeHospital == '0000-00-00 00:00:00') {
				$timeHospital = date('Y-m-d H:i:s');
			}
			$timeHArray 	= str_replace(' ','-',$timeHospital);
			$timeHArray 	= explode('-',$timeHArray);
			$timeHY			= $timeHArray[0];
			$timeHM			= $timeHArray[1];
			$timeHD			= $timeHArray[2];
			$timeHRest		= explode(':',$timeHArray[3]);
			$timeHH			= $timeHRest[0];
			$timeHMin		= $timeHRest[1];
			if ($timeDiagnosis == '0000-00-00 00:00:00') {
				$timeDiagnosis = date('Y-m-d H:i:s');
			}
			$timeSArray 	= str_replace(' ','-',$timeDiagnosis);
			$timeSArray 	= explode('-',$timeSArray);
			$timeSY			= $timeSArray[0];
			$timeSM			= $timeSArray[1];
			$timeSD			= $timeSArray[2];
			$timeSRest		= explode(':',$timeSArray[3]);
			$timeSH			= $timeSRest[0];
			$timeSMin		= $timeSRest[1];
			print "<h3>$diagnoseButton</h3>";
			print "<input type='hidden' name='patientID' value='$patientID' />";
			print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
			hiddenTherapyFields($patientRecordID);
			print "<table cellspacing='0' cellpadding='0' style='margin: 5px 0px 0px 0px;'>";
			print "<tr>";
			print "<td width='175'>请求的医生: </td>";
			print "<td>";
			if ($case == 'dmt'){
				print "<select name='diagnosisArztID'>";
				if ($diagnosisArztID <> 0){
					$infoDA		= getArztInfos($diagnosisArztID);
					print "<option value='$diagnosisArztID' selected>$infoDA </option>";
				} else {
					print "<option  selected>请选择</option>";
				}
				$db_request2	 = "SELECT arztID, clinicID FROM aerzte  ORDER BY  arztLastName";
				$query_handle2   = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != "") {
					$rows2 = mysql_num_rows($query_handle2);
					for ($i2 = 0; $i2 < $rows2; $i2++){
						$data2 = mysql_fetch_row($query_handle2);
						$id			= $data2[0];
						$clinicID	= $data2[1];
						$clinicType	= getDBContent('clinics','clinicType','clinicID',$clinicID);
						$info		= getArztInfos($id);
						if ($id == $diagnosisArztID) {
						} else {
							if (($id <> $diagnosisArztID) AND ($clinicType == 'k')){
								print "<option value='$id'>";
								print "$info ";
								print "</option>";
							}
						}
					}
				}
				print "</select>";
			}
			if ($case == 'web'){
				if ($diagnosisArztID <> 0){
					$infoDA		= getArztInfos($diagnosisArztID);
					print "$infoDA<input type='hidden' name='diagnosisArztID' value='$diagnosisArztID' />";
				} else {
					$infoDA		= getArztInfos($arztID);
					print "$infoDA<input type='hidden' name='diagnosisArztID' value='$arztID' />";
				}
			}
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td>症状的开始:</td>";
			print "<td>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
			print "<div style='float:left;margin:0px 15px 0px 0px;'>";
			createDayFields('timeSymptomsDay', $timeSymptomsD);
			createMonthFields('timeSymptomsMonth', $timeSymptomsM);
			createYearFields('timeSymptomsYear', $timeSymptomsY);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>时间:</div>";
			print "<div style='float:left;background-color:#FF0000;'> ";
			createHoursFields('timeSymptomsHour', $timeSymptomsH);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
			print "<div style='float:left;background-color:#FF0000;'>";
			createMinutesFields('timeSymptomsMinutes', $timeSymptomsMin);
			print "</div> ";
			print "<div style='float:left;margin:10px 0px 10px 3px;'>Uhr</div>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td valign='top'>";
			print "</td>";
			print "<td>";
			if ($symptomsText2 == '4') {
				print "<input type='radio' name='symptomsText2' value='4' checked /> 已知 &nbsp;  ";
			} else {
				print "<input type='radio' name='symptomsText2' value='4' /> 已知 &nbsp;  ";
			}
			if ($symptomsText2 == '1'){
				print "<input type='radio' name='symptomsText2' value='1' checked /> 未知 &nbsp;  ";
			} else {
				print "<input type='radio' name='symptomsText2' value='1' /> 未知 &nbsp;  ";
			}
			if ($symptomsText2 == '2'){
				print "<input type='radio' name='symptomsText2' value='2' checked /> 在睡觉时 &nbsp;  ";
			} else {
				print "<input type='radio' name='symptomsText2' value='2' /> 在睡觉时 &nbsp;  ";
			}
			if ($symptomsText2 == '3'){
				print "<input type='radio' name='symptomsText2' value='3' checked /> 其他 &nbsp;  ";
			} else {
				print "<input type='radio' name='symptomsText2' value='3' /> 其他 &nbsp;  ";
			}
			print "<input type='text' name='symptomsText' value='$symptomsText' size='50' />";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td>最后一次看到病人没有症状 :</td>";
			print "<td>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
			print "<div style='float:left;margin:0px 15px 0px 0px;'>";
			createDayFields('timeGesundDay', $timeGesundD);
			createMonthFields('timeGesundMonth', $timeGesundM);
			createYearFields('timeGesundYear', $timeGesundY);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>时间:</div>";
			print "<div style='float:left;background-color:#999966;'> ";
			createHoursFields('timeGesundHour', $timeGesundH);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
			print "<div style='float:left;background-color:#999966;'>";
			createMinutesFields('timeGesundMinutes', $timeGesundMin);
			print "</div> ";
			print "<div style='float:left;margin:10px 0px 10px 3px;'>Uhr</div>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td colspan='2'>";
			print "<hr>";
			print "</td>";
			print "</tr>";
			if ($case == 'dmt'){
				print "<tr>";
				print "<td>";
				print "Erstkontakt mit med. Personal:";
				print "</td>";
				print "<td>";
				print "<input type='text' name='timeInitialContact' value='$timeInitialContact' size='50'  />";
				print "</td>";
				print "</tr>";
			}
			print "<tr>";
			print "<td>入院 :</td>";
			print "<td>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
			print "<div style='float:left;margin:0px 15px 0px 0px;'>";
			createDayFields('timeHospitalDay', $timeHD);
			createMonthFields('timeHospitalMonth', $timeHM);
			createYearFields('timeHospitalYear', $timeHY);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>时间:</div>";
			print "<div style='float:left;background-color:#FF9900;'> ";
			createHoursFields('timeHospitalHour', $timeHH);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
			print "<div style='float:left;background-color:#FF9900;'>";
			createMinutesFields('timeHospitalMinutes', $timeHMin);
			print "</div> ";
			print "<div style='float:left;margin:10px 0px 10px 3px;'>Uhr</div>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td colspan='2'>";
			print "<hr>";
			print "</td>";
			print "</tr>";
			if ($case == 'dmt'){
				print "<tr>";
				print "<td >$diagnoseButton: <br> nirgends sichtbar</td>";
				print "<td>";
				print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
				print "<div style='float:left;margin:0px 15px 0px 0px;'>";
				createDayFields('timeDiagnosisDay', $timeSD);
				createMonthFields('timeDiagnosisMonth', $timeSM);
				createYearFields('timeDiagnosisYear', $timeSY);
				print "</div>";
				print "<div style='float:left;margin:10px 5px 10px 0px;'>时间:</div>";
				print "<div style='float:left;background-color:blue;'> ";
				createHoursFields('timeDiagnosisHour', $timeSH);
				print "</div>";
				print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
				print "<div style='float:left;background-color:blue;'>";
				createMinutesFields('timeDiagnosisMinutes', $timeSMin);
				print "</div> ";
				print "<div style='float:left;margin:10px 0px 10px 3px;'>Uhr</div>";
				print "</td>";
				print "</tr>";
				print "<tr>";
				print "<td colspan='2'>";
				print "<hr>";
				print "</td>";
				print "</tr>";
			}
			if ($case == 'web'){
				print "<input type='hidden' name='timeDiagnosis' value='$timeDiagnosis' />";
			}
			print "<tr>";
			print "<td valign='top'>当前病历: </td><td>";
			print "<textarea class='ckeditor' name='symptomDescr' rows='8' cols='40'>$symptomDescr</textarea>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td colspan='2'>";
			print "<hr>";
			print "</td>";
			print "</tr>";
			print "<tr><td>药物:</td><td>";
			print "<textarea rows='2' cols='30' name='pDrugs' style='margin: 0px 0px 10px 0px;'>$pDrugs</textarea>";
			print "<br />";
			$db_request3	 = "SELECT  medicationID, medicationName FROM infoMedication ";
			$query_handle3   = mysql_query($db_request3, $db_handle);
			if ($query_handle3 != ""){
				$rows3 = mysql_num_rows($query_handle3);
				if ($rows3 == 0){
				} else {
					for ($i3 = 0; $i3 < $rows3; $i3++){
						$data3	  = mysql_fetch_row($query_handle3);
						$idM			= $data3[0];
						$nameM		= $data3[1];
						$okayM		= 0;
						$db_request4	 = "SELECT  pInfoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoID = '$idM' AND infoType = 'm' ";
						$query_handle4   = mysql_query($db_request4, $db_handle);
						if ($query_handle4 != ""){
							$rows4 = mysql_num_rows($query_handle4);
							if ($rows4 > 0){
								$okayM		= 1;
							}
						}
						if ($okayM == 1){
							print "<input type='checkbox' name='pInfoIDs[$i3]' value='$idM' checked /> ";
						} else {
							print "<input type='checkbox' name='pInfoIDs[$i3]' value='$idM' /> ";
						}
						print "$nameM ";
					}
				}
			}
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td colspan='2'>";
			print "<hr>";
			print "</td>";
			print "</tr>";
			print "<tr><td>已知疾病/<br>风险因素:</td><td>";
			print "<textarea rows='2' cols='30' name='pConditions'>$pConditions</textarea>";
			print "<br />";
			$db_request5	 = "SELECT conditionID, conditionName FROM infoConditions ";
			$query_handle5   = mysql_query($db_request5, $db_handle);
			if ($query_handle5 != ""){
				$rows5 = mysql_num_rows($query_handle5);
				if ($rows5 == 0){
				} else {
					$count	= getMaxEntries('infoMedication','medicationID')  ;
					for ($i5 = 0; $i5 < $rows5; $i5++){
						$data5		  = mysql_fetch_row($query_handle5);
						$id			= $data5[0];
						$name		= $data5[1];
						$okayC		= 0;
						$db_request6	 = "SELECT  pInfoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoID = '$id' AND infoType = 'c'";
						$query_handle6   = mysql_query($db_request6, $db_handle);
						if ($query_handle6 != ""){
							$rows6 = mysql_num_rows($query_handle6);
							if ($rows6 > 0){
								$okayC		= 1;
							}
						}
						if ($okayC == 1){
							print "<input type='checkbox' name='pInfoIDs[$count]' value='$id' checked /> ";
						} else {
							print "<input type='checkbox' name='pInfoIDs[$count]' value='$id' /> ";
						}
						print "$name ";
						$count++;
					}
				}
			}
			print "</td></tr>";
			print "<tr>";
			print "<td colspan='2'> 适应症编码:";
			getIndicationSelectMenu($indicationID);
			print "</td>";
			print "</tr>";
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich [ editPatientRecordDiagnose($patientRecordID) ]!</p>";
		}
	}
}

function editPatientRecordTherapy($patientRecordID) {
	global $db_handle, $currentTime, $diagnoseButton, $therapyButton;
	global $case;
	print "<h1>$therapyButton 输入</h1>";
	if (access()) {
		if ($case== 'web'){
			$arztID	= $_SESSION['arztID'];
		}
		$db_request1	 = "SELECT  timeTreatment, therapyArztID, konsilType, lyseOption, visualData, indication2ID, indication2DID, therapyDescr1, therapyDescr2, therapyDescr3, editStatus, patientID, visualDataDescr  FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  = mysql_fetch_row($query_handle1);
			$timeTreatment		= $data1[0];
			$therapyArztID		= $data1[1];
			$konsilType 		= $data1[2];
			$lyseOption			= $data1[3];
			$visualData			= $data1[4];
			$indication2ID		= $data1[5];
			$indication2DID		= $data1[6];
			$therapyDescr 		= $data1[7];
			$therapyDescr2		= $data1[8];
			$therapyDescr3		= $data1[9];
			$editStatus			= $data1[10];
			$patientID			= $data1[11];
			$visualDataDescr 	= $data1[12];
			$vname				= schreibweise(getDBContent('patients','pFirstName', 'patientID',$patientID));
			$nname				= schreibweise(getDBContent('patients','pLastName', 'patientID',$patientID));
			$visualData	= explode(',',$visualData);
			if ($timeTreatment == '0000-00-00 00:00:00') {
				$timeTreatment = date('Y-m-d H:i:s');
			}
			$timeTArray 	= str_replace(' ','-',$timeTreatment);
			$timeTArray 	= explode('-',$timeTArray);
			$timeTY			= $timeTArray[0];
			$timeTM			= $timeTArray[1];
			$timeTD			= $timeTArray[2];
			$timeTRest		= explode(':',$timeTArray[3]);
			$timeTH			= $timeTRest[0];
			$timeTMin		= $timeTRest[1];
			print "<fieldset>";
			showPatient($patientID);
			print "<div class='clear'></div>";
			print "<h3 id='show'>$diagnoseButton</h3>";
			showPatientRecordDiagnose($patientRecordID, $case);
			print "<h3>$therapyButton</h3>";
			if ($case== 'dmt'){
				print "<form method='Post' action='DMT.php'>";
				$editorURL = "../";
			}
			if ($case== 'web'){
				print "<form method='Post' action='verwaltung.php'>";
				$editorURL = "";
			}
			print "<input type='hidden' name='x' value='3310' />";
			print "<input type='hidden' name='patientID' value='$patientID' />";
			print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
			hiddenDiagnosisFields($patientRecordID);
			print "<table cellspacing='0' cellpadding='0' style='margin: 5px 0px 0px 0px;line-height:200%;'>";
			print "<tr><td  width='175'>$therapyButton 医生: </td>";
			print "<td>";
			if ($case == 'dmt'){
				print "<select name='therapyArztID'>";
				if ($therapyArztID <> 0){
					$infoDA		= getArztInfos($therapyArztID);
					print "<option value='$therapyArztID' selected>$infoDA </option>";
				} else {
					print "<option  selected>请选择</option>";
				}
				$db_request2	 = "SELECT arztID, clinicID FROM aerzte  ORDER BY  arztLastName";
				$query_handle2   = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != "") {
					$rows2 = mysql_num_rows($query_handle2);
					for ($i2 = 0; $i2 < $rows2; $i2++){
						$data2 = mysql_fetch_row($query_handle2);
						$id			= $data2[0];
						$clinicID	= $data2[1];
						$clinicType	= getDBContent('clinics','clinicType','clinicID',$clinicID);
						$info		= getArztInfos($id);
						if ($id == $therapyArztID) {
						} else {
							if (($id <> $therapyArztID) AND ($clinicType == 'z')){
								print "<option value='$id'>";
								print "$info ";
								print "</option>";
							}
						}
					}
				}
				print "</select>";
			}
			if ($case == 'web'){
				if ($therapyArztID <> 0){
					$infoDA		= getArztInfos($therapyArztID);
					print "$infoDA<input type='hidden' name='therapyArztID' value='$therapyArztID' />";
				} else {
					$infoDA		= getArztInfos($arztID);
					print "$infoDA<input type='hidden' name='therapyArztID' value='$arztID' />";
				}
			}
			print "</td></tr>";
			print "<tr>";
			print "<td >检查:</td>";
			print "<td>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
			print "<div style='float:left;margin:0px 35px 0px 0px;'>";
			createDayFields('timeTreatmentDay', $timeTD);
			createMonthFields('timeTreatmentMonth', $timeTM);
			createYearFields('timeTreatmentYear', $timeTY);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px'>时间:</div>";
			print "<div style='float:left;background-color:#FF0000;'> ";
			createHoursFields('timeTreatmentHour', $timeTH);
			print "</div>";
			print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
			print "<div style='float:left;background-color:#FF0000;'>";
			createMinutesFields('timeTreatmentMinutes', $timeTMin);
			print "</div> ";
			print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td>诊断类型:</td>";
			print "<td>";
			if ($konsilType == ''){
				print "<input type='radio' name='konsilType' value='t'> 电话 &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='b'> 影像和电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='v'> 视频检查 ";
			}
			if ($konsilType == 't'){
				print "<input type='radio' name='konsilType' value='t' checked> 电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='b'> 影像和电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='v'> 视频检查";
			}
			if ($konsilType == 'b'){
				print "<input type='radio' name='konsilType' value='t'> 电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='b' checked> 影像和电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='v'> 视频检查";
			}
			if ($konsilType == 'v'){
				print "<input type='radio' name='konsilType' value='t'> 电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='b'> 影像和电话  &nbsp; &nbsp; &nbsp; &nbsp; ";
				print "<input type='radio' name='konsilType' value='v' checked> 视频检查";
			}
			print "</td>";
			print "</tr>";
			print "<tr><td valign='top'>临床​实验:</td><td>";
			print "<textarea class='ckeditor' name='therapyDescr' rows='8' cols='40'>$therapyDescr</textarea>";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td valign='top' class='borderUnten'>NIHSS:";
			print "</td>";
			print "<td class='borderUnten'>";
			getTotalNIHSSWerte($patientRecordID);
			print "<br>输入其他NIHSS值: <input type='text' name='nihssTotal' size='3' /><br>";
			getNIHSSlist($patientRecordID);
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td>影像类型:</td>";
			print "<td>";
			if ($visualData[0] == 'on'){
				print "<input type='checkbox' name='visualData[0]' checked> CT &nbsp; &nbsp; &nbsp; &nbsp; ";
			} else {
				print "<input type='checkbox' name='visualData[0]'> CT &nbsp; &nbsp; &nbsp; &nbsp; ";
			}
			if ($visualData[1] == 'on'){
				print "<input type='checkbox' name='visualData[1]' checked> MRT &nbsp; &nbsp; &nbsp; &nbsp; ";
			} else {
				print "<input type='checkbox' name='visualData[1]'> MRT &nbsp; &nbsp; &nbsp; &nbsp; ";
			}
			if ($visualData[3] == 'on'){
				print "<input type='checkbox' name='visualData[3]' checked> Angio";
			} else {
				print "<input type='checkbox' name='visualData[3]'> Angio";
			}
			print " &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; ";
			if ($visualData[2] == 'on'){
				print "<input type='checkbox' name='visualData[2]' checked> 视频检查 &nbsp; &nbsp; &nbsp; &nbsp; ";
			} else {
				print "<input type='checkbox' name='visualData[2]'> 视频检查 &nbsp; &nbsp; &nbsp; &nbsp; ";
			}
			print "</td>";
			print "</tr>";
			print "<tr><td valign='top'><b>Bildbewertung:</b></td><td>";
			print "<textarea class='ckeditor' name='visualDataDescr' rows='6' cols='40'>$visualDataDescr</textarea>";
			print "</td>";
			print "</tr>";
			print "<tr><td valign='top'><b>疑似诊断:</b></td><td>";
			print "<textarea class='ckeditor' name='therapyDescr2' rows='6' cols='40'>$therapyDescr2</textarea>";
			print "</td>";
			print "</tr>";
			$hint1 = 'Leitlinien zur Beurteilung und Therapieempfehlungen finden Sie unter diesem Textfeld.';
			$hint2 = 'Hinweis: Mit einem Klick auf die Texte werden diese zum Textfeld der Beurteilung und Therapieempfehlungen hinzugef&uuml;gt. Allerdings m&uussen diese erst gespeichert werden, bevor alle Texte wirklich gesichert sind.';
			$hint3 = 'Speichern nicht vergessen.';
			print "<tr><td valign='top'><p title='$hint1'>
			<b>评估和治疗建议:</b>
			<br />
			Leitlinien siehe unten
			<br />
			(Speichern nicht vergessen)</p>
			</td><td>";
			print "<textarea name='therapyDescr3' id='therapyDescr3' rows='12' cols='80' title='$hint3'>$therapyDescr3</textarea>";
			print "</td>";
			print "</tr>";
			print "<tr><td valign='top' title='$hint2'>Leitlinien &uuml;bertragen:
			</td><td title='$hint2'>";
			$tT_all = Therapytemplate::getAllEntries('y');
			foreach($tT_all as $key => $tT){
				$tT_ID = $tT->getID();
				$tT_title = $tT->getTitle();
				$tT_text  = $tT->getText();
				$tT_ausgabeButton = $tT_title . ' (' . substr($tT_text,0,25) . ' ...) ';
				$i = $key +1;
				print "<input type='hidden' id='tTitle$i' value='<p>$tT_title: $tT_text </p> ' title='$tT_title: $tT_text' style='border:0;' />
						<input type='button' onclick='transferText$i();' title='$tT_title: $tT_text' value='$tT_ausgabeButton' />";
			}
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td><b>诊断代码:</b>";
			print "</td>";
			print "<td>";
			getIndication2SelectMenu($indication2ID);
			getIndication2DetailSelectMenu($indication2DID);
			print "</td>";
			print "</tr>";
			print "</table>";
			print "<h3>STATUS</h3>";
			print "<p>";
			print "<input type='radio' name='editStatus' value='o'> 未处理 （未处理的咨询案例）<br>";
			print "<input type='radio' name='editStatus' value='t' checked> 已处理（已经处理完毕）<br>";
			print "<input type='submit' value='评估和治疗建议 保存' class='buttonHome' />";
			print "</form>";
			print "</fieldset>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich editPatientRecordTherapyWeb($patientRecordID)!</p>";
		}
	}
}

function savePatientRecord($pDataArray) {
	global $db_handle;
	global $case;
	$patientRecordID = $pDataArray[0];
	$patientID = $pDataArray[1];
	if (access()) {
		if ($patientRecordID <> ''){
			$db_request1	 = "SELECT patientRecordID FROM patientRecords WHERE patientRecordID = '$pDataArray[0]'";
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != ""){
				$rows = mysql_num_rows($query_handle1);
				if ($rows > 0) {
					$data1 = mysql_fetch_row($query_handle1);
					$db_request = "UPDATE patientRecords SET symptomsText = '$pDataArray[2]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Beginn der Symptome - Text nicht &auml;ndern!</p>";
					}
					if ($pDataArray[3] <> ''){
						$db_request = "UPDATE patientRecords SET timeInitialContact = '$pDataArray[3]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
						$query_handle = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte Zeit (Med. Erstkontakt) nicht &auml;ndern!</p>";
						}
					}
					$db_request = "UPDATE patientRecords SET timeHospital = '$pDataArray[4]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Zeit (Klinikaufnahme) nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET timeDiagnosis = '$pDataArray[5]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Zeit (Diagnose) nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET timeTreatment = '$pDataArray[6]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Zeit [timeTreatment] nicht &auml;ndern!</p>";
					}
					if ($pDataArray[7] == ''){
						$pDataArray[7]	= getDBContent('aerzte','clinicID','arztID',$pDataArray[8]);
					}
					$db_request = "UPDATE patientRecords SET clinicID = '$pDataArray[7]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Klinik nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET diagnosisArztID = '$pDataArray[8]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Diagnose-Arzt nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET symptomDescr = '$pDataArray[9]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Diagnose nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET indicationID = '$pDataArray[10]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Verdachtsdiagnose nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET  pDrugs = '$pDataArray[21]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Medikamente nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET pConditions = '$pDataArray[22]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Voererkrankungen nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET timeSymptoms = '$pDataArray[26]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte timeSymptoms nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET symptomsText2 = '$pDataArray[27]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte symptomsText2 (radio box) nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET timeSymptomsGesund = '$pDataArray[28]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Zeit 'Zuletzt gesund gesehen' nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET  therapyArztID = '$pDataArray[11]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Therapie-Arzt nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET konsilType = '$pDataArray[12]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Art des Konsils nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET lyseOption = '$pDataArray[13]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Lyse Option nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET visualData = '$pDataArray[14]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte CT, MRT, Video Angio - Optionen nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET visualDataDescr = '$pDataArray[25]' WHERE patientRecordID = '$pDataArray[0]' LIMIT 1";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Bildgebungsbeschreibung nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET indication2ID = '$pDataArray[15]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Verdachtsdiagnose 2 nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET indication2DID = '$pDataArray[16]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Verdachtsdiagnose - Lokalit&auml;t nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET  therapyDescr1 = '$pDataArray[17]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Befund nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET therapyDescr2 = '$pDataArray[18]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Verdachtsdiagnose nicht &auml;ndern!</p>";
					}
					$db_request = "UPDATE patientRecords SET therapyDescr3 = '$pDataArray[19]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Therapie-Empfehlungen nicht &auml;ndern!</p>";
					}
					updateTherapyEmpfehlung($patientRecordID,$pDataArray[29]);
					$db_request = "UPDATE patientRecords SET editStatus = '$pDataArray[20]' WHERE patientRecordID = '$pDataArray[0]'";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Status nicht &auml;ndern!</p>";
					}
				}
			}
		} else {
			$timestampCreated	= date('Y-m-d H:i:s');
			if ($case == 'dmt'){
				$arztID	= getAdminID();
			}
			if ($case == 'web'){
				$arztID	= $_SESSION['arztID'];
			}
			$where = 'patientRecordID, timestampCreated, patientID, diagnosisArztID, konsilType, lyseOption, visualData, editStatus';
			$value = "'NULL', '$timestampCreated','$patientID','$arztID','','n', ',,,','o'";
			$db_request = "INSERT INTO patientRecords (" . $where . ") VALUES (" . $value . ")";
			$query_handle = mysql_query($db_request, $db_handle);
			if ($query_handle != ""){
				$ID = mysql_insert_id();
			} else {
				print "<p class='errorMessage'>Konnte kein neuen Eintrag in patientRecords erzeugen [savePatientRecords($pDataArray)]!</p>";
			}
			return $ID;
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientRecords($pDataArray)]!</p>";
	}
}

 function updateTherapyEmpfehlung($patientRecordID,$tT_array){
		$error = "";
		$count = 0;
		$tT_Text_vorher 	= getDBContent('patientRecords', 'therapyDescr3', 'patientRecordID', $patientRecordID);
		$tT_Text_danach 	= $tT_Text_vorher;
		if (is_array($tT_array)){
			foreach($tT_array as $id=>$sub)
			{
				if (!is_array($sub)) { $count++; }
				else { $count = ($count + rcount($sub)); }
			}
		}
		if ($count > 0 ){
			foreach ($tT_array as $tT_ID){
				$tT = new Therapytemplate;
				$tT->setID($tT_ID);
				$tT_entry = $tT->getEntry($tT_ID);
				$tT_title = $tT_entry->getTitle();
				$tT_text  = $tT_entry->getText();
				$text2 = $tT_title . ' (' . $tT_text . ') ';
				$tT_Text_danach .=  $text2 ;
			}
		}
		if (access()){
			$db_request	= "SELECT * FROM `patientRecords` WHERE patientRecordID = '$patientRecordID'";
			$query_handle   = mysql_query($db_request);
			if ($query_handle != ""){
				$rows	= mysql_num_rows($query_handle);
				if ($rows > 0){
					$data	= mysql_fetch_array($query_handle);
					$db_request	= "UPDATE `patientRecords` SET  therapyDescr3 = '$tT_Text_danach' WHERE patientRecordID = '$patientRecordID'";
					$query_handle   = mysql_query($db_request);
					if ($query_handle != ""){
					} else {
						$error = "therapyDescr3";
					}
					if ($error != 0){
						echo "<h1>File:" . __file__ . "<br />";

						echo "Function: " . __function__ ;
						echo " in line: " . __line__ ;
						echo "</h1>";
						echo "Fehler '$error'";
					}
				}
			}
		}
	}

function showPatientRecord($patientRecordID){
	global $db_handle, $diagnoseButton, $therapyButton;
	global $case;
	if (access()) {
		$db_request1	 = "SELECT  timestampCreated, patientID, timeTreatment, therapyArztID, konsilType, lyseOption, visualData, indication2ID, indication2DID, therapyDescr1, therapyDescr2, therapyDescr3, editStatus, visualDataDescr FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  		= mysql_fetch_row($query_handle1);
			$timestampCreated	= $data1[0];
			$patientID			= $data1[1];
			$timeTreatment		= $data1[2];
			$therapyArztID		= $data1[3];
			$konsilType 		= $data1[4];
			$lyseOption			= $data1[5];
			$visualData			= $data1[6];
			$indication2ID		= $data1[7];
			$indication2DID		= $data1[8];
			$therapyDescr 		= $data1[9];
			$therapyDescr2		= $data1[10];
			$therapyDescr3		= $data1[11];
			$editStatus			= $data1[12];
			$visualDataDescr	= $data1[13];
			$visualData	= explode(',',$visualData);
			print "<div id='ks'>";
			print "<h2>诊断文件  (ID: $patientRecordID)</h2>";
			if ($editStatus == "o"){
				print "<h3>";
				print "  - Status: ";
				print "  <img src='imagesLayout/blinkenRot.gif'> 未处理 ";
			} else {
				print "<h3 id='show'>";
				print "  - Status: ";
				print " 已处理";
			}
			print "</h3>";
			print "</div>";
			print "<h2>$diagnoseButton</h2>";
			showPatientRecordDiagnose($patientRecordID, $case);
			print "<h2>$therapyButton</h2>";
			if ($therapyArztID == 0){
				print "<p>Noch keine Empfehlungen vorhanden.</p>";
			} else {
				$infoDA2		= getArztInfos($therapyArztID);
				print "<table cellspacing='0' cellpadding='0' style='margin: 5px 0px 0px 0px;line-height:200%;width:100%;'>";
				print "<tr>";
				print "<td width='175'>检查医生:</td>";
				print "<td>$infoDA2</td>";
				print "</tr>";
				$timeTreatment		= strtotime($timeTreatment);
				$timeTreatment	 	= date("d.m.y",$timeTreatment) . '. ' . date("H:i",$timeTreatment) . ' Uhr';
				print "<tr>";
				print "<td>检查:</td>";
				print "<td>$timeTreatment</td>";
				print "</tr>";
				$konsilTypeText = '';
				if ($konsilType == 't'){
					$konsilTypeText	= "电话";
				}
				if ($konsilType == 'b'){
					$konsilTypeText	= "电话 & Bild";
				}
				if ($konsilType == 'v'){
					$konsilTypeText	= "视频检查";
				}
				$controll1 = 0;
				if ($visualData[0] == 'on'){
					$ctOptionText	= "CT: Ja, ";
				} else {
					$ctOptionText	= "";
				}
				if ($visualData[1] == 'on'){
					$mrtOptionText	= "MRT: Ja, ";
				} else {
					$mrtOptionText	= "";
				}
				if ($visualData[2] == 'on'){
					$videoOptionText	= "视频检查: Ja, ";
				} else {
					$videoOptionText	= "";
				}
				if ($visualData[3] == 'on'){
					$angioOptionText	= "Angio: Ja";
				} else {
					$angioOptionText	= "";
				}
				$controll2 = 0;
				if (((($ctOptionText <> '') OR ($mrtOptionText <> '')) OR ($videoOptionText <> '')) OR ($angioOptionText <> '')){
					$controll2 = 1;
				}
				if (($controll1 == 1) OR ($controll2 == 1)){
					print "<tr>";
					print "<td>Weiteres:</td>";
					print "<td>";
					if ($konsilTypeText <> ''){
						echo "诊断类型:  $konsilTypeText, ";
					}
					if ($controll2 == 1){
						print "影像类型: $ctOptionText $mrtOptionText $videoOptionText $angioOptionText";
					}
					print "</td>";
					print "</tr>";
				}
				if ($visualDataDescr <> ''){
					print "<tr>";
					print "<td valign='top' class='borderUnten'>Bildbewertung: </td>";
					print "<td valign='top' class='borderUnten'>$visualDataDescr</td>";
					print "</tr>";
				}
				if ($therapyDescr <> ''){
					print "<tr>";
					print "<td valign='top' class='borderUnten'>临床​实验: </td>";
					print "<td valign='top' class='borderUnten'>$therapyDescr</td>";
					print "</tr>";
				}
				print "<tr>";
				print "<td valign='top' class='borderUnten'>NIHSS:";
				print "</td>";
				print "<td class='borderUnten'>";
				getTotalNIHSSWerte($patientRecordID);
				getNIHSSlist($patientRecordID);
				print "</td>";
				print "</tr>";
				if ($therapyDescr2 <> ''){
					print "<tr>";
					print "<td valign='top' class='borderUnten'>疑似诊断: </td>";
					print "<td valign='top' class='borderUnten'>$therapyDescr2</td>";
					print "</tr>";
				}
				if ($therapyDescr3 <> ''){
					print "<tr>";
					print "<td valign='top' class='borderUnten'>评估和治疗建议: </td>";
					print "<td valign='top' class='borderUnten'>$therapyDescr3</td>";
					print "</tr>";
				}
				$indication2			= getDBContent('indication2','indication2Name', 'indication2ID',$indication2ID);
				$indication2Code		= getDBContent('indication2','indication2Code', 'indication2ID',$indication2ID);
				$indication2D			= getDBContent('indication2Detail','indication2DName', 'indication2DID',$indication2DID);
				$indication2DCode		= getDBContent('indication2Detail','indication2DCode', 'indication2DID',$indication2DID);
				print "<tr>";
				print "<td>";
				print "<div id='ks'>";
				print "诊断代码:";
				print "</div>";
				print " </td>";
				print "<td>";
				print "<div id='ks'>";
				print "($indication2Code)	$indication2 - Lokalit&auml;t: ($indication2DCode)	$indication2D";
				print "</div>";
				print "</td>";
				print "</tr>";
				print "</table>";
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich showPatientRecord($patientRecordID)!</p>";
		}
	}
}

function showPatientRecordDiagnose($patientRecordID, $case){
	global $db_handle, $diagnoseButton, $therapyButton;
	if (access()) {
		$db_request1	 = "SELECT  timestampCreated, patientID, symptomsText, timeInitialContact, timeHospital, timeDiagnosis, clinicID, diagnosisArztID, symptomDescr, indicationID, pDrugs, pConditions, pGewicht, pGroesse, timeSymptoms, symptomsText2, timeSymptomsGesund FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1				= mysql_fetch_row($query_handle1);
			$timestampCreated	= $data1[0];
			$patientID			= $data1[1];
			$symptomsText 		= $data1[2];
			$timeInitialContact = $data1[3];
			$timeHospital 		= $data1[4];
			$timeDiagnosis 		= $data1[5];
			$clinicID	 		= $data1[6];
			$diagnosisArztID	= $data1[7];
			$symptomDescr 		= $data1[8];
			$indicationID		= $data1[9];
			$pDrugs 			= $data1[10];
			$pConditions		= $data1[11];
			$pGewicht			= $data1[12];
			$pGroesse			= $data1[13];
			$timeSymptoms		= $data1[14];
			$symptomsText2		= $data1[15];
			$timeSymptomsGesund = $data1[16];
			$timeInitialContact	= strtotime($timeInitialContact);
			$timeInitialContact	= date("d.m.y",$timeInitialContact) . '. ' . date("H:i",$timeInitialContact) . ' Uhr';
			$timeHospital		= strtotime($timeHospital);
			$timeHospital	 	= date("d.m.y",$timeHospital) . '. ' . date("H:i",$timeHospital) . ' Uhr';
			$timeDiagnosis		= strtotime($timeDiagnosis);
			$timeDiagnosis	 	= date("d.m.y",$timeDiagnosis) . '. ' . date("H:i",$timeDiagnosis) . ' Uhr';
			if ($timeSymptoms == '0000-00-00 00:00:00') {
				$timeSymptoms 		= '没有迹象' ;
			} else {
				$timeSymptoms		= strtotime($timeSymptoms);
				$timeSymptoms	 	= date("d.m.y",$timeSymptoms) . '. ' . date("H:i",$timeSymptoms) . ' Uhr';
			}
			if ($timeSymptomsGesund == '0000-00-00 00:00:00') {
				$timeSymptomsGesund		= '没有迹象' ;
			} else {
				$timeSymptomsGesund		= strtotime($timeSymptomsGesund);
				$timeSymptomsGesund	 	= date("d.m.y",$timeSymptomsGesund) . '. ' . date("H:i",$timeSymptomsGesund) . ' Uhr';
			}
			$clinicName		= getDBContent('clinics','clinicName','clinicID',$clinicID);
			$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);
			$infoDA			= getArztInfosShort($diagnosisArztID);
			print "<table cellspacing='0' cellpadding='0' style='margin: 5px 0px 0px 0px;line-height:200%;width:100%;'>";
			print "<tr>";
			print "<td width='175'><b>请求的医院:</b></td>";
			print "<td>$clinicName ($clinicInitial) - 医生: $infoDA";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td valign='top'>时间规定:</td>";
			print "<td>";
			print "<b>症状的开始:</b> ";
			print "$timeSymptoms ";
			if ($symptomsText2 == 1){
				print " (未知) ";
			}
			if ($symptomsText2 == 2){
				print " (在睡觉时) ";
			}
			if ($symptomsText2 == 3){
				print " (其他) ";
			}
			if ($symptomsText <> ''){
				print " $symptomsText";
			}
			print "<br />";
			print "<b>最后一次看到病人没有症状:</b> $timeSymptomsGesund";
			print "<br />";
			print "<b>入院 :</b> $timeHospital ";
			print "<br />";
			print "</td>";
			print "</tr>";
			if ($symptomDescr <> ''){
				print "<tr>";
				print "<td valign='top'>当前病历: </td>";
				print "<td>$symptomDescr</td>";
				print "</tr>";
			}
			$indication			= getDBContent('indication','indicationName', 'indicationID',$indicationID);
			$indicationCode		= getDBContent('indication','indicationCode', 'indicationID',$indicationID);
			if ($indication <> '') {
				print "<tr>";
				print "<td>适应症编码:</td>";
				print "<td>";
				print "($indicationCode) $indication";
				print "</td>";
				print "</tr>";
			}
			$db_request	 = "SELECT infoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoType = 'm'";
			$query_handle   = mysql_query($db_request, $db_handle);
			if ($query_handle != ""){
				$medicationRows = mysql_num_rows($query_handle);
			}
			$db_request	 = "SELECT infoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoType = 'c'";
			$query_handle   = mysql_query($db_request, $db_handle);
			if ($query_handle != ""){
				$conditionRows = mysql_num_rows($query_handle);
			}
			if ((((($pDrugs == '')) AND ($pConditions == '')) AND ($medicationRows == 0))  AND ($conditionRows == 0)) {
			} else {
				print "<tr>";
				print "<td valign='top'>";
				print "Weiteres:";
				print "</td>";
				print "<td>";
				if (($pDrugs <> '') OR ($medicationRows > 0)){
					print "<b药物: </b> ";
				}
				if ($pDrugs <> ''){
					print "$pDrugs, ";
				}
				$db_request4	 = "SELECT  infoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoType = 'm' ";
				$query_handle4   = mysql_query($db_request4, $db_handle);
				if ($query_handle4 != ""){
					$rows4 = mysql_num_rows($query_handle4);
					if ($rows4 > 0){
						for ($i = 0; $i < $rows4; $i++){
							$data	= mysql_fetch_row($query_handle4);
							$idM	= $data[0];
							$nameM	= getDBContent('infoMedication','medicationName', 'medicationID', $idM);
							print "$nameM, ";
						}
					}
				}
				if (($pConditions <> '') OR ($conditionRows > 0)){
					print "<b>已知疾病: </b> ";
				}
				if ($pConditions <> ''){
					print " $pConditions, ";
				}
				$db_request4	 = "SELECT  infoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoType = 'c' ";
				$query_handle4   = mysql_query($db_request4, $db_handle);
				if ($query_handle4 != ""){
					$rows4 = mysql_num_rows($query_handle4);
					if ($rows4 > 0){
						for ($i = 0; $i < $rows4; $i++){
							$data	= mysql_fetch_row($query_handle4);
							$idC	= $data[0];
							$nameC	= getDBContent('infoConditions','conditionName', 'conditionID', $idC);
							print "$nameC, ";
						}
					}
				}
				print "</td>";
				print "</tr>";
			}
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich showPatientRecordDiagnose($patientRecordID, $case)!</p>";
		}
	}
}

function savePatientInfos($patientRecordID, $pInfoIDs) {
	global $db_handle;
	if (access()) {
		$countM	 	= getMaxEntries('infoMedication','medicationID');
		$countC		= getMaxEntries('infoConditions', 'conditionID');
		$countAll	= $countM + $countC;
		$db_request	 = "DELETE FROM patientInfos WHERE patientRecordID = $patientRecordID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
		} else {
			print "<p class='errorMessage'>Konnte  nicht  l&ouml;schen! [delete in savePatientInfos]</p>";
		}
		if ($pInfoIDs <> ''){
			foreach ($pInfoIDs as $typeNummer => $id){
			if ((0 <= $typeNummer) AND ($typeNummer < $countM)){
				$type 	= 'm';
			} else {
				$type 	= 'c';
			}
			$db_request1	 = "SELECT pInfoID FROM patientInfos WHERE patientRecordID = '$patientRecordID' AND infoID = '$id' AND infoType = '$type'";
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != ""){
				$rows1 = mysql_num_rows($query_handle1);
				if ($rows1 > 0) {
				} else {
					$where = 'pInfoID, patientRecordID, infoID, infoType';
					$value = "'NULL', '$patientRecordID','$id','$type'";
					$db_request = "INSERT INTO patientInfos (" . $where . ") VALUES (" . $value . ")";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
						$ID = mysql_insert_id();
					} else {
						print "<p class='errorMessage'>Konnte kein neuen Eintrag in patientInfos erzeugen [savePatientInfos()]!</p>";
					}
				}
			}
		}
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientInfos($patientRecordID, $pInfoIDs)]!</p>";
	}
}

function getNIHSSlist($patientRecordID) {
	global $db_handle;
	if (access()) {
	$db_request1	 = "SELECT  pnID, timeNIHSS, arztID  FROM patientNIHSS WHERE patientRecordID = '$patientRecordID'  AND nihssTotal = '0' ORDER by pnID DESC";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
			} else {
				print "<span class='mini'>NIHSS Dokumentationen:</span>";
				for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1		  = mysql_fetch_row($query_handle1);
					$pnID			= $data1[0];
					$timeNIHSS		= $data1[1];
					$nArztID		= $data1[2];
					$nArzt			= getArztInfosShort($nArztID);
					$timeNIHSS		= strtotime($timeNIHSS);
					$timeNIHSS 		= date("d.m.Y",$timeNIHSS) . ' (' . date("H:i",$timeNIHSS) . ' Uhr)';
					$nihssTotal		=  getTotalNIHSSviaSUM($pnID);
					print "<li style='list-style-type: none;' class='mini'>Wert: <b>$nihssTotal</b>, $timeNIHSS</li>";
				}
			}
		}
	}
}

function getNIHSSlistPlusButtons($patientRecordID) {
	global $db_handle;
	global $case;
	if (access()) {
		$db_request1	 = "SELECT  pnID, timeNIHSS, arztID, patientID  FROM patientNIHSS WHERE patientRecordID = '$patientRecordID'  AND nihssTotal = '0' ORDER by pnID DESC";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
			} else {
				for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1		  = mysql_fetch_row($query_handle1);
					$pnID			= $data1[0];
					$timeNIHSS		= $data1[1];
					$nArztID		= $data1[2];
					$patientID		= $data1[3];
					$nArzt			= getArztInfosShort($nArztID);
					$timeNIHSS		= strtotime($timeNIHSS);
					$timeNIHSS 		= date("d.m.",$timeNIHSS) . ' (' . date("H:i",$timeNIHSS) . ' Uhr)';
					$nihssTotal		=  getTotalNIHSSviaSUM($pnID);
					if ($case =='dmt'){
						include_once("nihss.php");
					}
					if ($case =='web'){
						include_once("DMT/nihss.php");
					}
					print "<li style='list-style-type: none;' class='mini'>Dok.-Wert: <b>$nihssTotal</b>, $timeNIHSS</li>";
					$editStatus		= getDBContent('patientRecords','editStatus','patientRecordID',$patientRecordID);
					if ($editStatus == 't'){
						showNIHSSForm($patientID, $pnID);
						printNIHSSForm($patientID, $pnID);
					} else {
						editNIHSSForm($patientID, $pnID);
					}
					if ($i1 < $rows1 - 1){
						print "<hr>";
					}
				}
			}
		}
	}
}

function getTotalNIHSSviaSUM($pnID) {
	global $db_handle;
	$total 			= 0;
	$totalAlt 		= 0;
	$pkt1 			= 0;
	$pkt2 			= 0;
	$pkt3 			= 0;
	$db_request1	 = "SELECT pWert1, pWert2, pWert3  FROM patientNIHSSWerte WHERE pnID = '$pnID' ORDER by nihssStepID";
	$query_handle1   = mysql_query($db_request1, $db_handle);
	if ($query_handle1 != ""){
		$rows1 = mysql_num_rows($query_handle1);
		if ($rows1 == 0){
		} else {
			for ($i1 = 0; $i1 < $rows1; $i1++){
				$data1	  = mysql_fetch_row($query_handle1);
				$pWert1		= $data1[0];
				$pWert2	= $data1[1];
				$pWert3	= $data1[2];
				if (($pWert1 == 0) OR ($pWert1 == 99)){
					$pkt1 			= 0;
				} else {
					$db_request2	= "SELECT wert1 FROM docuNIHSSdetails  WHERE eigenschaftID ='$pWert1'  ";
					$query_handle2  = mysql_query($db_request2, $db_handle);
					if ($query_handle2 != ""){
						$data2		= mysql_fetch_row($query_handle2);
						$pkt1	= $data2[0];
						if ($pkt1 == 9){
							$pkt1	= 0;
						}
					}
				}
				if (($pWert2 == 0) OR ($pWert2 == 99)){
					$pkt2 			= 0;
				} else {
					$db_request2	= "SELECT wert1 FROM docuNIHSSdetails  WHERE eigenschaftID ='$pWert2'  ";
					$query_handle2  = mysql_query($db_request2, $db_handle);
					if ($query_handle2 != ""){
						$data2		= mysql_fetch_row($query_handle2);
						$pkt2		= $data2[0];
						if ($pkt2 == 9){
							$pkt2	= 0;
						}
					}
				}
				if (($pWert3 == 0) OR ($pWert3 == 99)){
					$pkt3 			= 0;
				} else {
					$db_request2	= "SELECT wert2 FROM docuNIHSSdetails  WHERE eigenschaftID ='$pWert3'  ";
					$query_handle2  = mysql_query($db_request2, $db_handle);
					if ($query_handle2 != ""){
						$data2		= mysql_fetch_row($query_handle2);
						$pkt3		= $data2[0];
						if ($pkt3 == 9){
							$pkt3	= 0;
						}
					}
				}
				$total		= $totalAlt + $pkt1 + $pkt2 + $pkt3;
				$totalAlt	= $total;
			}
		}
	} else {
		print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [getTotalNIHSSviaSUM($pnID)]</p>";
	}
	return $total;
}

function getTotalNIHSSWerte($patientRecordID) {
	global $db_handle;
	$counter = 0;
	if (access()) {
		$db_request2	 = "SELECT  *  FROM patientNIHSS WHERE patientRecordID = '$patientRecordID' AND nihssTotal <> '0' ORDER by pnID DESC";
		$query_handle2   = mysql_query($db_request2, $db_handle);
		if ($query_handle2 != ""){
			$rows2 = mysql_num_rows($query_handle2);
			if ($rows2 == 0){
			} else {
				for ($i2 = 0; $i2 < $rows2; $i2++){
					$data2		  = mysql_fetch_object($query_handle2);
					$pnID			= $data2 -> pnID;
					$nihssTotal	 	= $data2 -> nihssTotal;
					if ($nihssTotal > 0) {
						$counter++;
						print "<li style='list-style-type:none;float: left;margin: 0 8px 0 0;' class='mini'>$counter. NIHSS: <b>$nihssTotal</b></li>";
					}
				}
				print "<div class='clear'></div>";
			}
		}
	}
}

function savePatientNIHSSTotal($patientID, $patientRecordID, $nihssTotal) {
	global $db_handle, $case;
	if (access()) {
		$timeNIHSS	= date('Y-m-d H:i:s');
		if($case == 'dmt'){
			$arztID = getAdminID();
		}
		if($case == 'web'){
			$arztID	= $_SESSION['arztID'];
		}
		$where = 'pnID, arztID, patientID, patientRecordID, timeNIHSS, nihssTotal';
		$value = "'NULL','$arztID','$patientID','$patientRecordID','$timeNIHSS','$nihssTotal'";
		$db_request = "INSERT INTO patientNIHSS (" . $where . ") VALUES (" . $value . ")";
		$query_handle = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$ID = mysql_insert_id();
		} else {
			print "<p class='errorMessage'>Konnte kein neuen Eintrag in patients erzeugen [savePatientNIHSSTotal($patientID, $patientRecordID, $nihssTotal) ]!</p>";
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientNIHSSTotal($patientID, $patientRecordID, $nihssTotal) ]!</p>";
	}
}

function saveTimeErstContact($patientRecordID, $timeInitialContact) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT patientID FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows = mysql_num_rows($query_handle1);
			if ($rows > 0) {
				$data1 = mysql_fetch_row($query_handle1);
				$db_request = "UPDATE patientRecords SET timeInitialContact = '$timeInitialContact' WHERE patientRecordID = '$patientRecordID' LIMIT 1";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Zeit (Med. Erstkontakt) nicht &auml;ndern!</p>";
				}
			}
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [saveTimeErstContact($patientRecordID, $timeInitialContact)]!</p>";
	}
}

function getLyselistPlusButtons($patientID, $patientRecordID) {
	global $db_handle, $x;
	if (access()) {
		$db_request	 = "SELECT  ptID, timestampCreated, arztID  FROM patientThrombolyse WHERE patientID = '$patientID' AND patientRecordID = '$patientRecordID' ORDER by ptID DESC";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			if ($rows == 0){
			} else {
				for ($i = 0; $i < $rows; $i++){
					$data		  = mysql_fetch_row($query_handle);
					$ptID			= $data[0];
					$time			= $data[1];
					$tArztID		= $data[2];
					$time			= strtotime($time);
					$time 			= date("d.m.",$time) . ' (' . date("H:i",$time) . ' Uhr)';
					$tArzt			= getArztInfosShort($tArztID);
					if ($i > 0){
						print "<hr>";
					}
					print "<li style='list-style-type: none;' class='mini'>$time</li> ";
					$editStatus		= getDBContent('patientRecords','editStatus','patientRecordID',$patientRecordID);
					if ($editStatus == 't') {
						showThrombolyseForm($patientID, $ptID);
						printThrombolyseForm($patientID, $ptID);
					} else {
						editThrombolyseForm($patientID, $ptID);
					}
				}
			}
		}
	}
}

function editPatientWeight($patientRecordID){
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT   pGewicht, pGroesse FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$data1		  = mysql_fetch_row($query_handle1);
			$pGewicht			= $data1[0];
			$pGroesse			= $data1[1];
			print "<p>Gewicht in Kilogramm: <input name='pGewicht' value='$pGewicht' size='6' /> kg </p>";
			print "<p>Gr&ouml;&szlig;e in Zentimeter: <input name='pGroesse' value='$pGroesse' size='6' /> cm </p>";
		}
	}
}

function savePatientWeight($patientRecordID, $pGewicht, $pGroesse) {
	global $db_handle;
	if (access()) {
		if ($patientRecordID <> ''){
			$db_request1	 = "SELECT patientRecordID FROM patientRecords WHERE patientRecordID = '$patientRecordID'";
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != ""){
				$rows = mysql_num_rows($query_handle1);
				if ($rows > 0) {
					if($pGewicht <> ''){
						$db_request = "UPDATE patientRecords SET  pGewicht = '$pGewicht' WHERE patientRecordID = '$patientRecordID'";
						$query_handle = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte Gewicht nicht &auml;ndern!</p>";
						}
					}
					if($pGroesse <> ''){
						$db_request = "UPDATE patientRecords SET pGroesse = '$pGroesse' WHERE patientRecordID = '$patientRecordID' LIMIT 1";
						$query_handle = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte Gr&ouml;&szlig;e nicht &auml;ndern!</p>";
						}
					}
				}
			}
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientWeight($pDataArray, $pGewicht, $pGroesse)]!</p>";
	}
}
?>
