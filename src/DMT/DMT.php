<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  Database Management Tool Administrator
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2011-02-24
//  Verwaltungsmenu
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-04-26
//  2011-10-10		 	- vergessene savePatientInfos function in case 1030 & 1035 integriert 
//	2011-10				- NIHSS Punkte auf einer Seite
//	2011-10-26			- function getDBContent in getDBContent umbenannt
//   					- dateieigenschaften > php, western (ISO Latin1) & <?php
//						- FCK > CKeditor iPad faehig
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
// 	2011-11-23			- neuer Server: WAMP > neusortierung, alt raus,
//						- thrombolyse korrektur: edit > Speichern Erstkontakt (feld ins form)
//						- edit & show: telekonsil arzt = therapyarzt (nicht nihss)
//						- edit & show: vorgewaehlte aezte in select anzeigen
//  ----------------------------------------------------------------------------


include("P000.php");
include("../constant.php");
include("html_headDMT.php") ;
$x = getPOSTAndGETData('x');
if ($x == '' ) {
	$x = 1000;
}
$verwaltung[]	= array('vwName' => '&Auml;rzte', 		'vwCase' => '4000', 	'dbTabelle' => 'aerzte', 			'dbSpalte' => 'arztID' );
$verwaltung[]	= array('vwName' => 'Patienten', 		'vwCase' => '3000', 	'dbTabelle' => 'patients', 			'dbSpalte' => 'patientID' );
$verwaltung[]	= array('vwName' => 'Kliniken', 		'vwCase' => '5000', 	'dbTabelle' => 'clinics', 			'dbSpalte' => 'clinicID' );
if (($x >= 1000) and ($x < 9000)) {	 
	print "<div id='seitenTitle'>$pageNameDMT</div>";
	if ($x <> 1000){	
		print "<div id='nav'>";
			navDMT();
		print "</div>";
	}	
	$case	= 'dmt';
	switch ($x) {
		case 1000: 
			print "<div class='clear'></div>";
			print "<ol>";
			foreach ($verwaltung as $key => $row) {
				$vwName[$key]		= $row['vwName'];
				if(strlen($vwName[$key]) > 20){ 
					$buttonText			= $vwName[$key];
				} else {
					$buttonText			= $vwName[$key] . '-Verwaltung';
				}
				$vwCase[$key] 		= $row['vwCase'];
				$dbTabelle[$key] 	= $row['dbTabelle'];
				$dbSpalte[$key] 	= $row['dbSpalte'];
				$count2 = getMaxEntries($dbTabelle[$key], $dbSpalte[$key]);	
				print "<form method='post' action='DMT.php'class='form1'>";
				print "<h2><li>$vwName[$key]</li></h2>"; 		
				print "<input type='hidden' name='x' value='$vwCase[$key]' />";
				print "<input type='submit' value='$buttonText ($count2)' class='button' />";
				print "</form>";
			}
			print "</ol>";
			print "<div class='clear'></div>";
			print "<hr size=1 noshade>";
		break; 
		case 1010: 
			$pLastName	= $pLastName;
			$exists = pLastNameExist($pLastName);
			if($exists  == 1){
				listPatientsWeb($pLastName);
			} else {  
				$pDataArray	= array('', '', $pLastName, '', '', '', '', '', '', '', '', '', '');
				$patientID	= savePatient($pDataArray);
				print "<h1>患者资料 - 输入(编辑)</h1>";
				print "<form method='Post' action='DMT.php'>";
				print "<fieldset>";		
				print "<input type='hidden' name='x' value='1030' />";
				editPatientAndDiagnose($patientID);
				print "<input type='submit' value=' >>> 保存  >>> ' class='buttonHome' />";
				print "</fieldset>";				
				print "</form>";
			}
		break; 	
		case 1015: 
			$pDataArray	= array('', '', $pLastName, '', '', '', '', '', '', '', '', '', '');
			$patientID	= savePatient($pDataArray);
			print "<h1>患者资料 - 输入(编辑)</h1>";
			print "<form method='Post' action='DMT.php'>";
			print "<fieldset>";		
			print "<input type='hidden' name='x' value='1030' />";
			editPatientAndDiagnose($patientID);
			print "<input type='submit' value=' >>> 保存  >>> ' class='buttonHome' />";
			print "</fieldset>";			  
			print "</form>";
		break; 
		case 1020: 
			print "<h1>患者资料 - 输入(编辑)</h1>";
			print "<fieldset>";		
			print "<form method='Post' action='DMT.php'>";
			print "<input type='hidden' name='x' value='1033' />";
			editPatient($patientID);		
			print "<input type='submit' value=' >>>  Weiter >>> ' class='buttonHome' />";  
			print "</form>";
			listPatientRecords($patientID) ;
			print "</fieldset>";		
		break;	 
		case 1025: 
			print "<h1>$diagnoseButton 输入</h1>";
			print "<fieldset>"; 
			showPatient($patientID);
			print "<form method='Post' action='DMT.php'>";
			print "<input type='hidden' name='x' value='1035' />";
			hiddenTherapyFields($patientRecordID);
			editPatientRecordDiagnose($patientRecordID);	
			print "<input type='submit' value=' >>> Konislanforderung senden >>> ' class='buttonHome' />";  
			print "</form>";
			listPatientRecords($patientID) ;  
			print "</fieldset>";	  
		break;	 
		case 1030: 
			print "<fieldset>";
			savePatient($pDataArray);
			savePatientInfos($patientRecordID, $pInfoIDs);
			savePatientRecord($pRecordDataArray);
			showPatient($patientID);
			listPatientRecords($patientID);
			print "</fieldset>";	
		break;				
		case 1033: 
			print "<fieldset>";
			savePatient($pDataArray);
			showPatient($patientID);
			listPatientRecords($patientID);	
			print "</fieldset>";	
		break;	 
		case 1035: 
			print "<fieldset>";
			savePatientInfos($patientRecordID, $pInfoIDs);
			savePatientRecord($pRecordDataArray);
			showPatient($patientID);
			listPatientRecords($patientID);	
			print "</fieldset>";	
		break;	 
		case 1100: 
			include_once("search.php");
			searchAll($search);
			print "<div style='margin-left:11px;'>";
			addPatientForm(''); 
			print "</div>";
		break;
		case 1200: 
			deletePatientQuest($patientID);
		break;
		case 1210: 
			deletePatient($patientID);
			listAllPatients($capitalLetter);
		break;
			case 2000: 
				print "<h1><img src='imagesLayout/blinkenRot.gif'> 未处理 - 诊断文件</h1>";
				listAllPatientsRecords('o') ; 
			break; 
			case 2100: 
				print "<h1>已处理 - 诊断文件</h1>";
				listAllPatientsRecords('t') ; 
			break;		
			case 2200: 
				print "<h1>Konsilschein-&Uuml;bersicht</h1>";
				listAllPatientsRecords('') ; 
			break;				
		case 3000: 
			listAllPatients($capitalLetter);
		break;
		case 3200: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			editPatientNIHSSWerte($pnID);
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3215: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			showPatientNIHSSWerte($pnID);
			print "<div id='ks'>";
			print "<hr>";
			print "<h3>Nachtr&auml;gliches Bearbeiten der NIHSS-Dokumentation:</h3>";
			editNIHSSForm($patientID, $pnID) ;
			print "<hr>";
			print "</div><br />";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3216: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			showPatientNIHSSWerte($pnID);
			print "</fieldset>";
		break;
		case 3220: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			$pnID = savePatientNIHSS($patientID,$patientRecordID);
			editPatientNIHSSWerte($pnID);
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3230: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			savePatientNIHSSWerte($pnID,$pWerteArray);
			editPatientNIHSSWerte($pnID);
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3235: 
			include_once("nihss.php");
			print "<fieldset>";
			showPatient($patientID);
			savePatientNIHSSWerte($pnID,$pWerteArray);
			showPatientNIHSSWerte($pnID);
			print "<div id='ks'>";
			printNIHSSForm($patientID, $pnID) ;
			print "</div>";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3300: 
			editPatientRecordTherapy($patientRecordID);
			print "<fieldset>";
			print "<div id='ks'>";
			print "<hr>";
			print "<h3>Nachtr&auml;gliches Bearbeiten des Konsilscheins:</h3>";
			editRecordForm($patientID, $patientRecordID);
			print "<hr>";
			print "</div><br />";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3310: 
			if ($nihssTotal <> ''){
				savePatientNIHSSTotal($patientID, $patientRecordID, $nihssTotal) ;
			}
			savePatientRecord($pRecordDataArray);
			print "<fieldset>";
			showPatient($patientID);
			listPatientRecords($patientID);
			print "</fieldset>";
		break;
		case 3315: 
			print "<fieldset>";
			showPatient($patientID);
			print "<div class='clear'></div>";
			showPatientRecord($patientRecordID);
			print "</fieldset><br />";
			print "<fieldset>";
			print "<div id='ks'>";
			print "<hr>";
			print "<h3>Nachtr&auml;gliches Bearbeiten des Konsilscheins:</h3>";
			editRecordForm($patientID, $patientRecordID);
			print "<hr>";
			print "</div><br />";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3316: 
			print "<fieldset>";
			showPatient($patientID);
			showPatientRecord($patientRecordID);
			print "</fieldset>";
		break;
		case 3320: 
			$patientRecordID = savePatientRecord($pRecordDataArray);
			print "<fieldset>";
			showPatient($patientID);
			print "<form method='Post' action='DMT.php'>";
			print "<input type='hidden' name='x' value='1035' />";
			hiddenTherapyFields($patientRecordID);
			editPatientRecordDiagnose($patientRecordID);	
			print "<input type='submit' value=' >>> 保存  >>> ' class='buttonHome' />";
			print "</form>";
			print "</fieldset>";		
		break;
		case 3400: 
			editPatientThrombolyse($ptID);
			print "<br>";
			print "<fieldset>";
			listPatientRecords($patientID);	
			print "</fieldset>";
			print "<br><hr>";
		break;
		case 3410: 
			print "<h1>Thrombolyse Dokumentation</h1>";
			print "<fieldset>";
			showPatient($patientID);
			savePatientWeight($patientRecordID, $pGewicht, $pGroesse);
			saveTimeErstContact($patientRecordID, $timeInitialContact);
			savePatientThrombolyse($ptID,$ptWerteArray);
			showPatientThrombolyseWerte($ptID);
			print "<div id='ks'>";
			print "<hr>";
			print "<h3>Nachtr&auml;gliches Bearbeiten der Throbolyse-Dokumentation:</h3>";
			editThrombolyseForm($patientID, $ptID);
			print "<hr></div><br />";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3415: 
			print "<h1>Thrombolyse Dokumentation</h1>";
			print "<fieldset>";
			showPatient($patientID);
			showPatientThrombolyseWerte($ptID);
			print "<div id='ks'>";
			print "<hr>";
			print "<h3>Nachtr&auml;gliches Bearbeiten der Throbolyse-Dokumentation:</h3>";
			editThrombolyseForm($patientID, $ptID);
			print "<hr></div><br />";
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3416: 
			print "<fieldset>";
			showPatient($patientID);
			showPatientThrombolyseWerte($ptID);
			print "</fieldset>";
		break;
		case 3420: 
			print "<fieldset>";
			$ptID = savePatientThrombolyse('',$ptWerteArray);
			editPatientThrombolyse($ptID);
			listPatientRecords($patientID);	
			print "</fieldset>";
		break;
		case 3999: 
			print "<fieldset>";
			showPatient($patientID);
			listPatientRecords($patientID);
			print "</fieldset>";
		break;
		case 4000: 
			listAerzte();
		break;
		case 4100: 
			editArzt($arztID);
		break;
		case 4110: 
			saveArztLogin($userID, $userLogin, $userPW, $userEMail);
			saveArzt($arztID, $arztGender, $acadTitle, $arztFirstName, $arztLastName, $arztPhone, $arztComment, $userID, $clinicID);
			listAerzte();
		break;
		case 4120: 
			$userID = saveArztLogin('', '', '', '');  
			$arztID = saveArzt('', 'w', 'Dr. med.', '', '', '', '', $userID,''); 
			editArzt($arztID);
		break;
		case 4200: 
			deleteArztQuest($arztID);
		break;
		case 4210: 
			deleteArzt($arztID);
			listAerzte();
		break;
		case 5000: 
			listClinics();
		break;
	} 
	if ($x <> 1000) {
	   homeButton();	
   }
}	
print "</body></html>";

function navDMT() {
global $verwaltung;
print "<div  id='ks'>";
	foreach ($verwaltung as $key => $row) {		
		$vwName[$key]		= $row['vwName'];
		$vwCase[$key] 		= $row['vwCase'];
			print "<form method='post' action='DMT.php'>";
			print "<input type='hidden' name='x' value='$vwCase[$key]' />";
			print "<input type='submit' value='$vwName[$key]' />";
			print "</form>";
	}
print "</div>";
}

function homeButton() { 
print "<div  id='ks'>";
	print "<form method='post' action='DMT.php'>"; 
	print "<input type='hidden' name='x' value='1000' />";
	print "<input type='submit' value='Home Verwaltungstools' class='buttonHome' />";
	print "</form>"; 
print "</div>";
}

function listClinics() { 
	print "<h2>Liste der Kliniken</h2>";
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT clinicName, clinicInitial, clinicComment FROM clinics ORDER BY clinicType, clinicInitial"; 
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<ul style='line-height:200%;'>";
			for ($i = 0; $i < $rows; $i++){
				$no			 = $i+1;
				$data = mysql_fetch_row($query_handle); 
				$clinicName	 = $data[0];
				$clinicInitial   = $data[1];				
				$clinicComment	= $data[2];
				print "<li>";
				print "<b>$clinicName</b> ($clinicInitial) ";
				print "</li>";
			}
			print "</ul>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listClinics]</p>";
		} 
	} 
}

function listAerzte() {
	print "<h2>Liste der &Auml;rzte</h2>";
	print "<form method='post' action='DMT.php' class='padding'>";
	print "<input type='hidden' name='x' value='4120' />";
	print "<input type='submit' value='>Neuen Arzt hinzuf&uuml;gen<' class='bg3' />";
	print "</form>";
	global $db_handle;
	if (access()) {
		$db_request	 = "SELECT arztID, arztGender, acadTitle, arztFirstName, arztLastName, arztPhone, arztComment, userID, clinicID FROM aerzte ORDER BY clinicID, arztLastName, arztFirstName"; 
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			print "<table cellspacing='0' cellpadding='5' class='padding'>";
			print "<tr class='bg1'>";
			print "<td>#</td><td>Name, Klinik</td><td>Infos</td>";
			print "<td>Editieren</td><td>L&ouml;schen</td>";
			print "</tr>";
			for ($i = 0; $i < $rows; $i++){
				$no			 = $i+1;
				$data 			= mysql_fetch_row($query_handle); 
				$arztID	 	  	= $data[0];
				$arztGender   	= $data[1];				
				$acadTitle		= $data[2];
				$arztFirstName  = $data[3];
				$arztLastName 	= $data[4];
				$arztPhone		= $data[5];
				$arztComment  	= $data[6];
				$userID	  		= $data[7];	
				$clinicID		= $data[8];			
				if($arztGender == 'w'){
					$arztGender = "女士 ";
				} else {
					$arztGender = "先生  ";
				}
				$userLogin		= getDBContent('logins', 'userLogin', 'userID', $userID);
				$userPW			= getDBContent('logins', 'userPW', 'userID', $userID);				
				$userEMail		= getDBContent('logins', 'userEMail', 'userID', $userID);
				$clinicName		= getDBContent('clinics','clinicName','clinicID',$clinicID);
				$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);
				print "<tr>";
				print "<td class='borderUnten'><span class='mini'>$no</span></td>";
				print "<td class='borderUnten'>$arztGender $acadTitle $arztFirstName $arztLastName <br />$clinicName</td>";
				print "<td class='borderUnten'>";
				if ($arztPhone <> ''){
					print "Tel.: $arztPhone ";
				}
				if ($userEMail <> ''){
					print "Email: $userEMail ";
				}
				if ($arztComment <> ''){
					print "Kommentar: $arztComment";
				}
				print "</td>";
				print "<td class='borderUnten'> ";
				print "<form method='post' action='DMT.php'>";
				print "<input type='hidden' name='x' value='4100' />";
				print "<input type='hidden' name='arztID' value='$arztID' />";
				print "<input type='submit' value='Bearbeiten' class='buttonEdit' />";
				print "</form>";
				print "</td>";
				print "<td class='borderUnten'> ";
				print "<form method='post' action='DMT.php'>";
				print "<input type='hidden' name='x' value='4200' />";
				print "<input type='hidden' name='arztID' value='$arztID' />";
				print "<input type='submit' value='L&ouml;schen' class='buttonDelete' />";
				print "</form>";
				print "</td>";
				print "</tr>";
			}
			print "</table>";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [listAezrte]</p>";
		} 
	} 
}

function editArzt($arztID) {
	global $db_handle;
	print "<form method='Post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='4110' />";
	print "<input type='hidden' name='arztID' value='$arztID' />";
	print "<fieldset style='background-color: #fdf7e1;'>";
	print "<legend>Bearbeite Arzt</legend>";
	if (access()) {
		$db_request	 = "SELECT arztGender, acadTitle, arztFirstName, arztLastName, arztPhone, arztComment, userID, clinicID FROM aerzte Where arztID = '$arztID'"; 
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != "") {
			$rows = mysql_num_rows($query_handle);
			$data =		 mysql_fetch_row($query_handle); 
			$arztGender	 = $data[0];				
			$acadTitle	  = $data[1];
			$arztFirstName  = $data[2];
			$arztLastName   = $data[3];
			$arztPhone 		= $data[4];
			$arztComment	= $data[5];
			$userID			= $data[6];
			$clinicID		= $data[7];
			$userLogin		= getDBContent('logins', 'userLogin', 'userID', $userID);
			$userPW			= getDBContent('logins', 'userPW', 'userID', $userID);
			$userEMail			= getDBContent('logins', 'userEMail', 'userID', $userID);
			$clinicName		= getDBContent('clinics','clinicName','clinicID',$clinicID);
			$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);
 			print "<table cellspacing='0' cellpadding='5' width=100%'>";
			print "<tr>";
			print "<td>称呼:</td>";
			print "<td colspan='3'><select name='arztGender'>";
			if($arztGender == 'w'){
				$arztGenderText = "女士 ";
				print "<option value='$arztGender' selected>$arztGenderText</option>";
				print "<option value='m'>先生</option>";
			} else {
				$arztGenderText = "先生 ";
				print "<option value='$arztGender' selected>$arztGenderText</option>";
				print "<option value='w'>女士</option>";
			}
			print "</select>";
			print " &nbsp; Title:";
			print "<input type='text' name='acadTitle' value='$acadTitle' size='20' />";
			print "</td>";
			print "</tr>";
			print "<tr>";
			print "<td>名:</td>";
			print "<td><input type='text' name='arztFirstName' value='$arztFirstName' size='50' /></td>";
			print "<td>姓:</td>";
			print "<td><input type='text' name='arztLastName' value='$arztLastName' size='50' /></td>";
			print "</tr>";
 			print "<tr>";
			print "<td>Klinik:</td>";
			print "<td><select name='clinicID'>";
			if ($clinicID <> 0){
				print "<option value='$clinicID' selected>$clinicName ($clinicInitial) </option>";
			} else {
				print "<option>请选择</option>";
			}
			$db_request1	 = "SELECT clinicID, clinicName, clinicInitial FROM clinics  ORDER BY clinicType, clinicInitial"; 
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != "") {
				$rows1 = mysql_num_rows($query_handle1);
				for ($i = 0; $i < $rows1; $i++){
					$data1 = mysql_fetch_row($query_handle1); 
					$clinicID1		 = $data1[0];
					$clinicName2	 = $data1[1];
					$clinicInitial2  = $data1[2]; 
					if($clinicID1 <> $clinicID){
						print "<option value='$clinicID1'>";
						print "$clinicName2 ($clinicInitial2) ";
						print "</option>";
					}
				}
			} 
			print "</select></td>";
			print "</tr>";
			print "<tr>";
			print "<td>电话:</td>";
			print "<td><input type='text' name='arztPhone' value='$arztPhone' size='50' /></td>";
			print "<td>E-Mail:</td>";
			print "<td><input type='text' name='userEMail' value='$userEMail' size='50' />";
			print "<br>";
			print "Notwendig, um ggf. Passwort zuzusenden</td>";
			print "</tr>";
			print "<tr>";
			print "<td>Login-Name:</td>";
			print "<td><input type='text' name='userLogin' value='$userLogin' size='50' /></td>";
			print "<td>Passwort:</td>";
			print "<td><input type='text' name='userPW' value='$userPW' size='50' /></td>";
			print "</tr>";
			print "<tr>";
			print "<td>Kommentar:</td>";
			print "<td colspan='3'>";
			print "<textarea class='ckeditor' name='arztComment' rows='40' cols='40'>$arztComment</textarea>"; 
			print "</td>";
			print "</tr>";
			print "</table>";
			print "<input type='hidden' name='userID' value='$userID' />";
			print "<input type='submit' value='Daten speichern' class='button100' />";
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editArzt]</p>";
		} 
	} 
	print "</fieldset>";
	print "</form>";
}

function saveArztLogin($userID, $userLogin, $userPW, $userEMail) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT userID FROM logins WHERE userID = '$userID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows = mysql_num_rows($query_handle1);
			if ($rows > 0) {
				$loginCheck = true;
				$db_request2	 = "SELECT userID  FROM logins WHERE userLogin = '$userLogin'";
				$query_handle2   = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != ""){
					$rows2 = mysql_num_rows($query_handle2);
					if ($rows2 > 0) { 
						for ($i=0; $i<$rows2; $i++) {
							$data2	   = mysql_fetch_row($query_handle2); 
							$userID1	= $data2[0];
							if ($userID1 <> $userID) {   
								print "<p class='errorMessage'>登陆用户名已存在，保存失败</p>";
								$loginCheck = false;
							}
						} 
					}
				} else {
					print "<p class='errorMessage'>Keine Anfrage m&ouml;glich! [saveArztLogin > checkLoginName]</p>";
				} 
				if ($loginCheck == true){ 
					$db_request = "UPDATE logins SET userLogin = '$userLogin' WHERE userID = $userID";
					$query_handle = mysql_query($db_request, $db_handle);
					if ($query_handle != ""){
					} else {
						print "<p class='errorMessage'>Konnte Login Name nicht &auml;ndern!</p>";
					}
				}
				$db_request = "UPDATE logins SET userPW = '$userPW' WHERE userID = $userID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Passwort nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE logins SET userEMail = '$userEMail' WHERE userID = $userID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte E-Mail-Adresse nicht &auml;ndern!</p>";
				}	
			} else { 
				$where = 'userID, userLogin, userPW, userEMail';
				$value = "'NULL', '','',''";	 
				$db_request = "INSERT INTO logins (" . $where . ") VALUES (" . $value . ")";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
					$ID = mysql_insert_id();
				} else {
					print "<p class='errorMessage'>Konnte kein neuen Eintrag erzeugen [saveArztLogin]!</p>";
				}
				return $ID;
			}
		}	
	} else { 
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [saveArztLogin]!</p>";
	} 
}

function saveArzt($arztID, $arztGender, $acadTitle, $arztFirstName, $arztLastName, $arztPhone, $arztComment, $userID, $clinicID) {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT arztID FROM aerzte WHERE arztID = '$arztID'";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows = mysql_num_rows($query_handle1);
			if ($rows > 0) {
				$db_request = "UPDATE aerzte SET arztGender = '$arztGender' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Anrede nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE aerzte SET acadTitle = '$acadTitle' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte akad. Title nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE aerzte SET arztFirstName = '$arztFirstName' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Vorname nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE aerzte SET arztLastName = '$arztLastName' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Nachname nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE aerzte SET arztPhone = '$arztPhone' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Telefonnummer nicht &auml;ndern!</p>";
				}	
				$db_request = "UPDATE aerzte SET arztComment = '$arztComment' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Kommentar nicht &auml;ndern!</p>";
				}   
				$db_request = "UPDATE aerzte SET clinicID = '$clinicID' WHERE arztID = $arztID";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Kommentar nicht &auml;ndern!</p>";
				}	 
			} else { 
				$timestamp	= date('Y-m-d H:i:s'); 
				$where = 'arztID, arztTimestamp, arztGender, acadTitle, arztFirstName, arztLastName, arztPhone, arztComment, userID';
				$value = "'NULL', '$timestamp', '','','','','','','$userID'";	 
				$db_request = "INSERT INTO aerzte (" . $where . ") VALUES (" . $value . ")";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
					$ID = mysql_insert_id();
				} else {
					print "<p class='errorMessage'>Konnte kein neuen Texteintrag erzeugen [saveArzt]!</p>";
				}
				return $ID;
			}
		}	
	} else { 
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [saveArzt]!</p>";
	} 
}

function deleteArztQuest($arztID) {
	$vorname		= getDBContent('aerzte', 'arztFirstName', 'arztID', $arztID);
	$nachname		= getDBContent('aerzte', 'arztLastName', 'arztID', $arztID);
	print "<form method='post' action='DMT.php' style='float:left;'>";
	print "<fieldset>";
	print "<legend>L&ouml;schen</legend>";
	print "<p>L&ouml;sche Arzteintrag: $vorname $nachname</p>";
	print "<input type='hidden' name='x' value='4210' />";
	print "<input type='hidden' name='arztID' value='$arztID' />";
	print "<input type='submit' value='Ja, L&ouml;sche  $vorname $nachname'  />";
	print "</fieldset>";
	print "</form>";
	print "<div style='clear:left;'></div>";
}

function deleteArzt($arztID) {
	 global $db_handle;
	$userID		= getDBContent('aerzte', 'userID', 'arztID', $arztID);
	if (access()) {
		$db_request	 = "DELETE FROM logins WHERE userID = $userID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
		} else {
			print "<p class='errorMessage'>Konnte den UserLogin nicht in Datenbank l&ouml;schen! [deleteArzt($arztID)]</p>";
		} 
	} else { 
		print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [deleteArzt($arztID)]</p>";
	} 
 	if (access()) {
		$db_request	 = "DELETE FROM aerzte WHERE arztID = $arztID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
		} else {
			print "<p class='errorMessage'>Konnte den Arzteintrag nicht in Datenbank l&ouml;schen! [deleteArzt($arztID)]</p>";
		} 
	} else { 
		print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich - Arzteintrag - ! [deleteArzt($arztID)]</p>";
	} 
}

function deletePatientQuest($patientID) {
	$vname		= getDBContent('patients', 'pFirstName', 'patientID', $patientID);
	$nname		= getDBContent('patients', 'pLastName', 'patientID', $patientID);
	$capitalLetter	= substr($nname, 0,1);
	print "<form method='post' action='DMT.php' style='float:left;'>";
	print "<fieldset>";
	print "<legend>L&ouml;schen</legend>";
	print "<p>L&ouml;sche Patientendaten und all die damit verbundenen Dokumentationen von '$vname $nname'</p>";
	print "<input type='hidden' name='x' value='1210' />";
	print "<input type='hidden' name='capitalLetter' value='$capitalLetter' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='submit' value='Ja, L&ouml;sche  $vname $nname (id: $patientID)'  />";
	print "</fieldset>";
	print "</form>";
	print "<div style='clear:left;'></div>";
}

function deletePatient($patientID) {
	global $db_handle;
 	if (access()) {
		$db_request	 = "SELECT pnID FROM patientNIHSS WHERE patientID = $patientID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows		= mysql_num_rows($query_handle);
			if ($rows == 0){
			} else {
				for ($i=0;$i<$rows;$i++){
					$data	= mysql_fetch_row($query_handle);
					$ID[$i]	= $data[0];
				}
				if (count($ID) > 0){
					foreach($ID as $key => $id){
						$db_request	 = "DELETE FROM patientNIHSSWerte WHERE pnID = $id";
						$query_handle   = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte den NIHSS Werte $id nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
						} 
					}
				}
			}
		}
		$db_request	 = "DELETE FROM patientNIHSS WHERE patientID = $patientID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
		} else {
			print "<p class='errorMessage'>Konnte den NIHSS Eintrag nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
		} 
		$db_request	 = "SELECT patientRecordID FROM patientRecords WHERE patientID = $patientID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows		= mysql_num_rows($query_handle);
			if ($rows > 0){
				for ($i=0;$i<$rows;$i++){
					$data	= mysql_fetch_row($query_handle);
					$recordIDs[$i]	= $data[0];	
				}
				if (count($recordIDs) > 0){
					foreach($recordIDs as $key => $id){
						$db_request	 = "DELETE FROM patientInfos WHERE patientRecordID = $id";
						$query_handle   = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte den patientInfos nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
						} 
					}
					foreach($recordIDs as $key => $id){
						$db_request	 = "DELETE FROM patientRecords WHERE patientRecordID = $id";
						$query_handle   = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte den patientRecord nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
						} 
					}
				}
			}
		}
		$db_request	 = "SELECT ptID FROM patientThrombolyse WHERE patientID = $patientID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows		= mysql_num_rows($query_handle);
			if ($rows == 0){
			} else{
				for ($i=0;$i<$rows;$i++){
					$data	= mysql_fetch_row($query_handle);
					$ID[$i]	= $data[0];
				}
				if (count($ID) > 0){
					foreach($ID as $key => $id){
						$db_request	 = "DELETE FROM patientThrombolyse WHERE ptID = $id";
						$query_handle   = mysql_query($db_request, $db_handle);
						if ($query_handle != ""){
						} else {
							print "<p class='errorMessage'>Konnte den Thrombolyse $id nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
						} 
					}
				}
			} 
		}
		$db_request	 = "DELETE FROM patients WHERE patientID = $patientID";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
		} else {
			print "<p class='errorMessage'>Konnte den Patient nicht in Datenbank l&ouml;schen! [deletePatient($patientID)]</p>";
		} 
	} else { 
		print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [deletePatient($patientID)]</p>";
	} 
}

function addRecordForm($patientID) {
	print "<form method='post' action='DMT.php' >";
	print "<input type='hidden' name='x' value='3320' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='submit' value='新 诊断文件' class='buttonNew' />";
	print "</form>";
	print "<div class='clear'></div>";
}	  

function editRecordForm($patientID, $patientRecordID) { 
global  $db_handle, $diagnoseButton, $therapyButton;
	$editStatus	= getDBContent('patientRecords','editStatus','patientRecordID',$patientRecordID);
	if ($editStatus == 't'){
		$buttonClass= 'buttonShow';
	} else {
		$buttonClass= 'buttonEdit';
	}
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='1025' />";
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='$diagnoseButton' class='$buttonClass' />";
	print "</form>";
	print "<div class='clear'></div>";
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3300' />";
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='$therapyButton' class='$buttonClass' />";
	print "</form>";
	print "<div class='clear'></div>";
}	  

function showRecordForm($patientID, $patientRecordID) {
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3315' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='>显示<' class='buttonShow' />";
	print "</form>";
	print "<div class='clear'></div>";
}	 

function printRecordForm($patientID, $patientRecordID) {
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3316' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='>打印<' class='buttonShow' />";
	print "</form>";
	print "<div class='clear'></div>";
}   

function addThrombolyseForm($patientID,$patientRecordID) {
	print "<form method='post' action='DMT.php' style='float:left;'>";
	print "<input type='hidden' name='x' value='3420' />";
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
	print "<input type='submit' value='溶栓 新' class='buttonNew' />";
	print "</form>";
}

function editThrombolyseForm($patientID, $ptID) {
	$patientRecordID	= getDBContent('patientThrombolyse','patientRecordID','ptID',$ptID);
	$editStatus	= getDBContent('patientRecords','editStatus','patientRecordID',$patientRecordID);
	if ($editStatus == 't'){
		$buttonClass= 'buttonShow';
	} else {
		$buttonClass= 'buttonEdit';
	}
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3400' />";
	print "<input type='hidden' name='patientID' value='$patientID' />"; 
	print "<input type='hidden' name='ptID' value='$ptID' />";
	print "<input type='submit' value='Edit Thrombolyse ' class='$buttonClass' />";
	print "</form>";
	print "<div class='clear'></div>";
}	  

function showThrombolyseForm($patientID, $ptID) {
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3415' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='ptID' value='$ptID' />";
	print "<input type='submit' value='>显示<' class='buttonShow' />";
	print "</form>";
	print "<div class='clear'></div>";
}	 

function printThrombolyseForm($patientID, $ptID) {
	print "<form method='post' action='DMT.php'>";
	print "<input type='hidden' name='x' value='3416' />";
	print "<input type='hidden' name='patientID' value='$patientID' />";
	print "<input type='hidden' name='ptID' value='$ptID' />";
	print "<input type='submit' value='>打印<' class='buttonShow' />";
	print "</form>";
	print "<div class='clear'></div>";
}   

function editPatientThrombolyse($ptID) {
	global $db_handle, $rowHR, $diagnoseButton;
	print "<h1>Thrombolyse Dokumentation</h1>";
 	if (access()) {
		$db_request1	 = "SELECT arztID, patientID, patientRecordID, apaVoreinnahme, mVoreinnahme, vorhofflimmern, diabetes, hypertonus, vorSchlaganfall, oberArztTime, oberArztDescr, laborWerteTime, laborWert1, laborWert2, laborWert3, laborWert4, laborWert5, bdSenkungOption, lyseDecisionTime, lyseDecisionDescr1, lyseDecisionDescr2, dosisWert1, dosisWert2, dosisWert3, dosisWert4, timeLyseStart, timeLyseEnd, rekonsilArztID, nihssWert2448, complications, nihssWert7days, ranking, entlassung, timeCCTStart, timeCCTEnd, cctDescr1, cctDescr2, cctDescr3, cctOption1, cctOption2, cctOption3, cctOption4, entlassungNach, apaVoreinnahme2, apaVoreinnahme3, bdWert1Aufnahme, bdWert2Aufnahme, bdDescrAufnahme,  bdWert1vorLyse, bdWert2vorLyse, bdDescrvorLyse  FROM patientThrombolyse WHERE ptID = '$ptID'";	  
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
				print "<p>Keine Thrombolyse-Dokumentation vorhanden.</p>";
			} else {
				for ($i1 = 0; $i1 < $rows1; $i1++){ 
					$data   = mysql_fetch_row($query_handle1); 
					$tArztID			= $data[0]; 	
					$patientID			= $data[1];	
					$patientRecordID	= $data[2];		
					$apaVoreinnahme		= $data[3];
					$mVoreinnahme		= $data[4];
					$vorhofflimmern		= $data[5];		
					$diabetes			= $data[6];		
					$hypertonus			= $data[7];		
					$vorSchlaganfall	= $data[8];	
					$oberArztTime 		= $data[9];		
					$oberArztDescr 		= $data[10];	
					$laborWerteTime 	= $data[11];	
					$laborWert1 		= $data[12];	
					$laborWert2 		= $data[13];
					$laborWert3 		= $data[14];	
					$laborWert4 		= $data[15];
					$laborWert5 		= $data[16];		
					$bdSenkungOption 	= $data[17];	
					$lyseDecisionTime 	= $data[18];	
					$lyseDecisionDescr1 = $data[19];	
					$lyseDecisionDescr2 = $data[20];	
					$dosisWert1 		= $data[21];	
					$dosisWert2 		= $data[22];	
					$dosisWert3 		= $data[23];	
					$dosisWert4 		= $data[24];	
					$timeLyseStart 		= $data[25];	
					$timeLyseEnd 		= $data[26];	
					$rekonsilArztID 	= $data[27];	
					$nihssWert2448 		= $data[28];	
					$complications 		= $data[29];	
					$nihssWert7days 	= $data[30];	
					$ranking 			= $data[31];	
					$entlassung 		= $data[32];	
					$timeCCTStart 		= $data[33];
					$timeCCTEnd 		= $data[34];
					$cctDescr1 			= $data[35];
					$cctDescr2 			= $data[36];
					$cctDescr3 			= $data[37];
					$cctOption1 		= $data[38];
					$cctOption2 		= $data[39];
					$cctOption3 		= $data[40];
					$cctOption4 		= $data[41];
					$entlassungNach 	= $data[42];		
					$apaVoreinnahme2	= $data[43];	
					$apaVoreinnahme3	= $data[44];	
					$bdWert1Aufnahme	= $data[45]; 	
					$bdWert2Aufnahme	= $data[46];	
					$bdDescrAufnahme	= $data[47];
					$bdWert1vorLyse		= $data[48]; 	
					$bdWert2vorLyse		= $data[49];	
					$bdDescrvorLyse 	= $data[50];	
					$laborWert1		 		= str_replace('.',',',$laborWert1);
					$laborWert2				= str_replace('.',',',$laborWert2);
					$laborWert3		 		= str_replace('.',',',$laborWert3);
					$laborWert4		 		= str_replace('.',',',$laborWert4);
					$laborWert5				= str_replace('.',',',$laborWert5);
					$vname				= schreibweise(getDBContent('patients','pFirstName', 'patientID',$patientID));
					$nname				= schreibweise(getDBContent('patients','pLastName', 'patientID',$patientID));
					$bDay				= getDBContent('patients','pBday', 'patientID',$patientID);
					$timeSymptoms		= getDBContent('patientRecords','timeSymptoms', 'patientRecordID',$patientRecordID);				
					$timeInitialContact	= getDBContent('patientRecords','timeInitialContact', 'patientRecordID',$patientRecordID);			
					$timeHospital		= getDBContent('patientRecords','timeHospital', 'patientRecordID',$patientRecordID);	
					if ($timeSymptoms <> "0000-00-00 00:00:00") { 
						$timeSymptoms	= strtotime($timeSymptoms);
						$timeSymptoms 	= date('Y.m.d H:i', $timeSymptoms);
					} else {
						$timeSymptoms 	=  "nicht angegeben";
					}
					if ($timeHospital <> '0000-00-00 00:00:00') { 
						$timeHospital	= strtotime($timeHospital);
						$timeHospital 	= date('Y.m.d H:i', $timeHospital);
					} else {
						$timeHospital 	= "nicht angegeben";
					}		
					print "<fieldset>";
					showPatient($patientID);
					print "<table>";
					print "<tr>";
					print "<td width='330'>";
					print "<h4>症状的开始:</h4> ";
					print "</td><td>";
					print "$timeSymptoms ";
					print " -  <a href='DMT.php?x=1025&patientRecordID=$patientRecordID&patientID=$patientID'>&Auml;ndern</a>";
					print "</td>";				
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "<h4>入院 :</h4> ";
					print "</td><td>";
					print "$timeHospital";
					print "  - <a href='DMT.php?x=1025&patientRecordID=$patientRecordID&patientID=$patientID'>&Auml;ndern</a>";
					print "</td>";
					print "</tr>";
					print "</table>";
					print "<form method='Post' action='DMT.php'>";
					print "<input type='hidden' name='x' value='3410' />";
					print "<input type='hidden' name='ptID' value='$ptID' />";
					print "<input type='hidden' name='patientID' value='$patientID' />";
					print "<input type='hidden' name='patientRecordID' value='$patientRecordID' />";
					print "<table>";
					print "<tr>";
					print "<td>";
					print "<h4>Erstkontakt mit med. Personal:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "<input type='text' name='timeInitialContact' value='$timeInitialContact' size='50'  />"; 
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td colspan='3'>";
					print "<table style='width:100%;' cellspacing='0' cellpadding='1'>";
					print "<tr>";
					print "<td width='25%'>";
					print "Voreinnahme : ";
					print "</td>";
					print "<td colspan='3'>";
					print "ASS: ";
					if ($apaVoreinnahme == 'j'){
						print "<input type='checkbox' name='apaVoreinnahme' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='apaVoreinnahme' value='j' /> ja ";
					}
					print " &nbsp;  &nbsp; Plavix: ";
					if ($apaVoreinnahme2 == 'j'){
						print "<input type='checkbox' name='apaVoreinnahme2' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='apaVoreinnahme2' value='j' /> ja";
					}
					print " &nbsp;  &nbsp; Aggrenox: ";
					if ($apaVoreinnahme3 == 'j'){
						print "<input type='checkbox' name='apaVoreinnahme3' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='apaVoreinnahme3' value='j' /> ja";
					}
					print " &nbsp;  &nbsp; Marcumar: ";
					if ($mVoreinnahme == 'j'){
						print "<input type='checkbox' name='mVoreinnahme' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='mVoreinnahme' value='j' /> ja";
					}
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "Vorhofflimmern: ";
					if ($vorhofflimmern == 'j'){
						print "<input type='checkbox' name='vorhofflimmern' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='vorhofflimmern' value='j' /> ja";
					}
					print "</td>";
					print "<td>";
					print "Fr&uuml;herer Schlaganfall: ";
					if ($vorSchlaganfall == 'j'){
						print "<input type='checkbox' name='vorSchlaganfall' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='vorSchlaganfall' value='j' /> ja";
					}
					print "</td>";
					print "<td>";
					print "Diabetes: ";
					if ($diabetes == 'j'){
						print "<input type='checkbox' name='diabetes' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='diabetes' value='j' /> ja";
					}
					print "</td>";
					print "<td>";
					print "Hypertonus: ";
					if ($hypertonus == 'j'){
						print "<input type='checkbox' name='hypertonus' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='hypertonus' value='j' /> ja";
					}
					print "</td>";
					print "</tr>";
					print "</table>";
					print "</td>";
					print "</tr>";
									print "$rowHR"; 
					print "<tr>"; 
					print "<td>";
					print "Blutdruck vor Thrombolyse: ";
					print "</td>";
					print "<td>";
					print "<span  class='tRight'>";
					print "<input type='text' name='bdWert1Aufnahme'  value='$bdWert1Aufnahme' size='5' /> ";
					print "/ ";
					print "<input type='text' name='bdWert2Aufnahme' value='$bdWert2Aufnahme' size='5' /> "; 
					print " mmHg => ";
					print "</span></td>";
					print "<td>";
					print "<input type='text' name='bdDescrAufnahme' value='$bdDescrAufnahme' size='25' /> ";
					print "</td>";
					print "</tr>";
									print "$rowHR"; 
					$timeCCTStartArray  = explode(':',$timeCCTStart);
					$timeCCT1H			= $timeCCTStartArray[0]; 
					$timeCCT1Min		= $timeCCTStartArray[1];	
					print "<tr>";
					print "<td valign='top'>";
					print "<h4>Beginn CCT: </h4>";
					print "</td>";
					print "<td>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>时间: </div>";
					print "<div style='float:left;'> ";
					createHoursFields('timeCCTStartH', $timeCCT1H); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('timeCCTStartMin', $timeCCT1Min);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "<td>";
					print "Anmerk.: ";  
					print "<input type='text' name='cctDescr1' value='$cctDescr1' size='25' /> ";
					print "</td>";
					print "</tr>";
					$OATimeArray	= explode(':',$oberArztTime);
					$timeOAH		= $OATimeArray[0]; 
					$timeOAMin		= $OATimeArray[1];	
					print "<tr>";
					print "<td>";
					print "Ggfs. R&uuml;cksprache Oberarzt:";
					print "</td>";
					print "<td>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>时间: </div>";
					print "<div style='float:left;'> ";
					createHoursFields('oberArztTimeH', $timeOAH); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('oberArztTimeMin', $timeOAMin);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "<td>";
					print "Anmerk.:";  
					print "<input type='text' name='oberArztDescr' value='$oberArztDescr' size='25' /> ";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					$timeTherapy	= getDBContent('patientRecords','timeTreatment','patientRecordID',$patientRecordID);
					$timeTherapyA 	= strtotime($timeTherapy);
					$timeTherapy 	= date("Y.m.d. H:i", $timeTherapyA) . "Uhr";
					print "<tr>";
					print "<td valign='top'>";
					print "<h4>Beginn Telekonsil:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "$timeTherapy"; 
					print " - <a href='DMT.php?x=3300&patientRecordID=$patientRecordID'>&Auml;ndern</a>";
					print "<br />"; 
					$nArztID		= getDBContent('patientRecords','therapyArztID','patientRecordID', $patientRecordID);
					$nArztInfo		= getArztInfos($nArztID);
					print "Durchf&uuml;hrender Arzt: $nArztInfo"; 
					print "<h4 class='mini'>NIHSS - durchgef&uuml;hrte Dokumentation:</h4>";
					getNIHSSlist($patientRecordID); 
					print "<br />"; 
					print "<h4 class='mini'>NIHSS - Eingetragene Werte im Konsilschein:</h4>";
					getTotalNIHSSWerte($patientRecordID);
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					$laborWerteTimeA	= explode(':',$laborWerteTime);
					$timeLaborH			= $laborWerteTimeA[0]; 
					$timeLaborMin		= $laborWerteTimeA[1];	
					print "<tr>";
					print "<td >";
					print "<h4 style='float:left;margin:10px 5px 10px 0px;'>Laborwerte: </h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>时间: </div>";
					print "<div style='float:left;'> ";
					createHoursFields('laborWerteTimeH', $timeLaborH); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('laborWerteTimeMin', $timeLaborMin);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "</tr>";
					$laborWert1	= str_replace('.',',',$laborWert1);
					$laborWert2	= str_replace('.',',',$laborWert2);
					$laborWert3	= str_replace('.',',',$laborWert3);
					$laborWert4	= str_replace('.',',',$laborWert4);
					$laborWert5	= str_replace('.',',',$laborWert5);
					print "<tr>";
					print "<td colspan='3'>";
					print "Thrombozyten: <span  class='tRight'><input type='text' name='laborWert1' value='$laborWert1' />";
					print "Hb: <input type='text' name='laborWert2' value='$laborWert2' />";
					print "INR: <input type='text' name='laborWert3' value='$laborWert3' />";
					print "PTT: <input type='text' name='laborWert4' value='$laborWert4' />";
					print "BZ bei Aufnahme: <input type='text' name='laborWert5' value='$laborWert5' /> mg/dl</span>";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td>";
					print "Blutdruck vor Lyse: ";
					print "</td>";
					print "<td colspan='2'>";
					print "<span  class='tRight'>";
					print "<input type='text' name='bdWert1vorLyse'  value='$bdWert1vorLyse' size='5' /> ";
					print "/ ";
					print "<input type='text' name='bdWert2vorLyse' value='$bdWert2vorLyse' size='5' /> ";
					print "</span>";
					print "Blutdrucksenkung vor Lyse (im KH):";
					if ($bdSenkungOption == 'j'){
						print "<input type='checkbox' name='bdSenkungOption' value='j' checked /> ja";
					} else {
						print "<input type='checkbox' name='bdSenkungOption' value='j' /> ja";
					}
					print "</td>";
					print "</tr>";
					$lyseDecisionTimeArray	= explode(':',$lyseDecisionTime);
					$timeLDH		= $lyseDecisionTimeArray[0]; 
					$timeLDMin		= $lyseDecisionTimeArray[1];	
					print "<tr>";
					print "<td>";
					print "<h4>Entscheidung Lyse:</h4>";
					print "</td>";
					print "<td>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>时间: </div>";
					print "<div style='float:left;'> ";
					createHoursFields('lyseDecisionTimeH', $timeLDH); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('lyseDecisionTimeMin', $timeLDMin);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "<td>";
					print "Anmerk.:";  
					print "<input type='text' name='lyseDecisionDescr1' value='$lyseDecisionDescr1' size='25' /> ";
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "keine Lyse wegen: ";  
					print "</td>";
					print "<td colspan='2'>";
					print "<input type='text' name='lyseDecisionDescr2' value='$lyseDecisionDescr2' size='60' /> ";
					print "</td>";
					print "</tr>";
					$pGewicht	= getDBContent('patientRecords','pGewicht','patientRecordID',$patientRecordID);
					print "<tr>";
					print "<td colspan='3'>";
					print "<h4 style='font-size:110%;float: left;margin:10px 0px 0px 0px;'>Dosis rtPA: => K&ouml;rpergewicht: &nbsp; </h4> ";
					if ($pGewicht == 0){
						print " <input type='text' name='pGewicht' size='5' /> kg";
						print " x 0,9 => ... mg rtPA = ml-L&ouml;sung Gesamt,<br>";
						print "10% der Gesamtdosis als Bolus = ... ml; ";
						print "Rest (90%) &uuml;ber 1 Std. = ... ml = ml/h (Laufrate Perfusor)";
					} else {
						print " $pGewicht kg ";
						if ($pGewicht <= 100){
							$dosisWert1	= ($pGewicht * 0.9);
							$dosisWert1a	= str_replace('.',',',$dosisWert1);
						} else {							
							$dosisWert1a	= "90 mg";
						}
						print " => $dosisWert1a  mg rtPA = ml-L&ouml;sung Gesamt,";
						print "<input type='hidden' name='dosisWert1' value='$dosisWert1a' size='5' />";
						print "<br />";
						$dosisWert2	= $dosisWert1 / 10;
						$dosisWert2a	= str_replace('.',',',$dosisWert2);
						$dosisWert3	= $dosisWert1 - $dosisWert2;
						$dosisWert3a	= str_replace('.',',',$dosisWert3);
						print "10% der Gesamtdosis als Bolus = $dosisWert2a ml; ";
						print "Rest (90%) &uuml;ber 1 Std. = $dosisWert3a ml = ml/h (Laufrate Perfusor)";
					}
					print "</td>";
					print "</tr>";
					$timeLyseStart	= str_replace(' ','-',$timeLyseStart);
					$timeLyseStart	= str_replace(':','-',$timeLyseStart);
					$timeLyseStartArray	= explode('-',$timeLyseStart);
					$time1		= $timeLyseStartArray[0]; 
					$time2		= $timeLyseStartArray[1]; 
					$time3		= $timeLyseStartArray[2]; 
					$time4		= $timeLyseStartArray[3]; 
					$time5		= $timeLyseStartArray[4]; 
					$time6		= $timeLyseStartArray[5];	
					print "<tr>";
					print "<td>";
					print "<h4>Beginn Lyse:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
					print "<div style='float:left;margin:0px 35px 0px 0px;'>";
					createDayFields('timeLyseStartD', $time3); 
					createMonthFields('timeLyseStartM', $time2);
					createYearFields('timeLyseStartY', $time1);
					print "</div>";
					print "<div style='float:left;'> ";
					createHoursFields('timeLyseStartH', $time4); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('timeLyseStartMin', $time5);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "</tr>";
					$timeLyseEnd	= str_replace(' ','-',$timeLyseEnd);
					$timeLyseEnd	= str_replace(':','-',$timeLyseEnd);
					$timeLyseEndArray	= explode('-',$timeLyseEnd);
					$time1a		= $timeLyseEndArray[0]; 
					$time2a		= $timeLyseEndArray[1]; 
					$time3a		= $timeLyseEndArray[2]; 
					$time4a		= $timeLyseEndArray[3]; 
					$time5a		= $timeLyseEndArray[4]; 
					$time6a		= $timeLyseEndArray[5];	
					print "<tr>";
					print "<td>";
					print "<h4>Ende Lyse:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
					print "<div style='float:left;margin:0px 35px 0px 0px;'>";
					createDayFields('timeLyseEndD', $time3a); 
					createMonthFields('timeLyseEndM', $time2a);
					createYearFields('timeLyseEndY', $time1a);
					print "</div>";
					print "<div style='float:left;'> ";
					createHoursFields('timeLyseEndH', $time4a); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('timeLyseEndMin', $time5a);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "Durchf&uuml;hrender Arzt:";
					print "</td>";
					print "<td colspan='2'>";
					print "<select name='tArztID'>";
					if ($tArztID == '' ) {
						$infoA		= getArztInfos($arztID);
						print "<option value='$arztID'>$infoA</option>"; 
					} else {
						$infoA		= getArztInfos($tArztID);
						print "<option value='$tArztID'>$infoA</option>"; 
					}
					print "<option value=''>请选择</option>";
					$db_request3	 = "SELECT arztID, clinicID FROM aerzte ORDER BY arztLastName"; 
					$query_handle3   = mysql_query($db_request3, $db_handle);
					if ($query_handle3 != "") {
						$rows3 = mysql_num_rows($query_handle3);
						for ($i3 = 0; $i3 < $rows3; $i3++){
							$data3 = mysql_fetch_row($query_handle3); 
							$id			= $data3[0];
							$clinicID	= $data3[1];
							$info		= getArztInfosShort($id);
							$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);		
							$clinicType		= getDBContent('clinics','clinicType','clinicID',$clinicID);
							if ($clinicType == 'k'){
								print "<option value='$id'>";
								print "$clinicInitial - $info ";
								print "</option>";
							}
						}
					} 
					print "</select>";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td valign='top'>";
					print "Kontroll-CCT <br>24-48 Std. nach Lyse: ";
					print "</td>";
					print "<td valign='top'>";
					print "Einblutung: ";
					if ($cctOption1 <> ''){ 
						if ($cctOption1 =='j'){ 
							print "<input type='radio' name='cctOption1' value='j' checked /> ";
							print "asympt. &nbsp; ";
							print "<input type='radio' name='cctOption1' value='n' /> ";
							print "sympt. &nbsp; ";
						} else {
							print "<input type='radio' name='cctOption1' value='j' /> ";
							print "asympt. &nbsp; ";
							print "<input type='radio' name='cctOption1' value='n' checked /> ";
							print "sympt. ";
						}
					} else {
						print "<input type='radio' name='cctOption1' value='j' /> ";
						print "asympt. &nbsp; ";
						print "<input type='radio' name='cctOption1' value='n'  /> ";
						print "sympt. ";
					}
					print "</td>";
					print "<td valign='top'>";
					print "其他:";
					print "<input type='text' name='cctDescr2' value='$cctDescr2' size='15' /> ";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td>";
					print "NIHSS nach 24-48 Std. ";
					print "</td>";
					print "<td colspan='2'>";
					if ($nihssWert2448 <> 0){
						print "<input type='text' name='nihssWert2448' value='$nihssWert2448' size='5' />";
					} else {
						print "<input type='text' name='nihssWert2448' size='5' />"; 
					}
					print " &nbsp; Re-Konsil  durch: ";
					print "<select name='rekonsilArztID'>";
					if ($rekonsilArztID == '' ) {
					} else {
						$info2		= getArztInfos($rekonsilArztID);
						print "<option value='$rekonsilArztID'>$info2</option>"; 
					}
					print "<option value=''>Bitte w&auml;hlen</option>"; 
					$db_request3	 = "SELECT arztID, clinicID FROM aerzte ORDER BY arztLastName"; 
					$query_handle3   = mysql_query($db_request3, $db_handle);
					if ($query_handle3 != "") {
						$rows3 = mysql_num_rows($query_handle3);
						for ($i3 = 0; $i3 < $rows3; $i3++){
							$data3 = mysql_fetch_row($query_handle3); 
							$id			= $data3[0];
							$clinicID	= $data3[1];
							$info		= getArztInfosShort($id);
							$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);							
							print "<option value='$id'>";
							print "$clinicInitial - $info ";
							print "</option>";
						}
					} 
					print "</select>";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td valign='top'>";
					print "Sonstige Komplikationen:";
					print "</td>";
					print "<td colspan='2'>";
					print "<textarea cols='55' rows=5' name='complications'>$complications</textarea>";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<td>";
					print "Tag 7 / Entlassung:";
					print "</td>";
					print "<td colspan='2'>";
					if ($nihssWert7days <> 0){
						print "NIHSS: <input type='text' name='nihssWert7days' value='$nihssWert7days' size='5' />";
					} else {
						print "NIHSS: <input type='text' name='nihssWert7days' size='5' />";
					}
					print " &nbsp; Ranking-Score:";
					for ($i=1; $i<=6;$i++){
						if ($ranking == $i){
							print " <input type='radio' name='ranking' value='$i' checked /> $i";
						} else {
							print " <input type='radio' name='ranking' value='$i' /> $i";
						}
					}
					print "</td>";
					print "</tr>";
					$entlassung	= str_replace(' ','-',$entlassung);
					$entlassung	= str_replace(':','-',$entlassung);
					$entlassungArray	= explode('-',$entlassung);
					$time1b		= $entlassungArray[0]; 
					$time2b		= $entlassungArray[1]; 
					$time3b		= $entlassungArray[2]; 
					$time4b		= $entlassungArray[3]; 
					$time5b		= $entlassungArray[4]; 
					$time6b		= $entlassungArray[5];	
					print "<tr>";
					print "<td>";
					print "<h4>Entlassung am:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>日期:  </div>";
					print "<div style='float:left;margin:0px 35px 0px 0px;'>";
					createDayFields('entlassungD', $time3b); 
					createMonthFields('entlassungM', $time2b);
					createYearFields('entlassungY', $time1b);
					print "</div>";
					print "<div style='float:left;'> ";
					createHoursFields('entlassungH', $time4b); 
					print "</div>";
					print "<div style='float:left;margin:10px 5px 10px 0px;'>:</div>";
					print "<div style='float:left;'>";
					createMinutesFields('entlassungMin', $time5b);	  
					print "</div> ";
					print "<div style='float:left;margin:10px 0px 10px 0px;'>Uhr</div>";  
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "Entlassung nach:";
					print "</td>";
					print "<td colspan='2'>";
					print "<select name='entlassungNach'></div>";
					if ( $entlassungNach <> ''){
					print "<option value='$entlassungNach' selected>$entlassungNach</option>";
					}
					print "<option value=''>Bitte w&auml;hlen</option>";
					print "<option value='Reha'>Reha</option>";
					print "<option value='zuhause'>zuhause</option>";
					print "<option value='Pflege'>Pflege</option>";
					print "<option value='Tod'>Tod</option>";
					print "</select> "; 
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "</table>";
					print "<input type='submit' value='Weiter' class='buttonHome' />";
					print "</form>";
					print "</fieldset>";
				} 
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [editPatientThrombolyse($ptID) ]</p>";
		} 
	} 
}

function savePatientThrombolyse($ptID, $ptWerteArray) { 
	global $db_handle,  $x;
	if (access()) {
		$db_request1	 = "SELECT patientID FROM patientThrombolyse WHERE ptID = '$ptID' ";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){ 
$arztID = 0;
				$timeT	= date("Y-m-d H:i:s");
				$where = 'ptID, arztID, patientID, patientRecordID, timestampCreated';
				$value = "'NULL','$arztID','$ptWerteArray[0]','$ptWerteArray[1]','$timeT'";	 
				$db_request = "INSERT INTO patientThrombolyse (" . $where . ") VALUES (" . $value . ")";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
					$ID = mysql_insert_id();
				} else {
					print "<p class='errorMessage'>Konnte kein neuen Eintrag erzeugen [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				return $ID;
			} else { 
				$where2 = 'ptID, patientID, patientRecordID';
				$value2 = "'$ptID','$ptWerteArray[0]','$ptWerteArray[1]'";	 
				$db_request = "UPDATE patientThrombolyse SET apaVoreinnahme = '$ptWerteArray[2]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse apaVoreinnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}				
				$db_request = "UPDATE patientThrombolyse SET mVoreinnahme = '$ptWerteArray[3]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse mVoreinnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET vorhofflimmern = '$ptWerteArray[4]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Vorhof-Flimmern nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET diabetes = '$ptWerteArray[5]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Vorhofflimmern nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET hypertonus = '$ptWerteArray[6]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Hypertonus nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET vorSchlaganfall = '$ptWerteArray[7]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Frueherer Schlaganfall nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET oberArztTime = '$ptWerteArray[8]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Oberarzt-Zeit nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET oberArztDescr = '$ptWerteArray[9]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Oberarzt-Bemerkung nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWerteTime = '$ptWerteArray[10]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Zeit - Laborwerte nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWert1 = '$ptWerteArray[11]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse laborWert1 = Thrombozyten nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWert2 = '$ptWerteArray[12]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse laborWert2 = HB nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWert3 = '$ptWerteArray[13]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse laborWert3 = INR nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWert4 = '$ptWerteArray[14]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse laborWert4 = PTT nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET laborWert5 = '$ptWerteArray[15]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse laborWert5 = Option BZ bei Aufnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdSenkungOption = '$ptWerteArray[16]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Blutdrucksenkung (bdSenkung) bei Aufnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET lyseDecisionTime = '$ptWerteArray[17]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse lyseDecisionTime nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET lyseDecisionDescr1 = '$ptWerteArray[18]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse lyseDecision Descr. 1 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET lyseDecisionDescr2 = '$ptWerteArray[19]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse lyseDecision Descr. 2 (keine - wegen) nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET dosisWert1 = '$ptWerteArray[20]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse Dosiswert 1 (mg rtPa) nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET timeLyseStart = '$ptWerteArray[24]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Lyse starttime nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET timeLyseEnd = '$ptWerteArray[25]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Lyse endtime nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET rekonsilArztID = '$ptWerteArray[26]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - rekonsilArztID nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET nihssWert2448 = '$ptWerteArray[27]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - nihss2448 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET complications = '$ptWerteArray[28]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Komplikationen nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET nihssWert7days = '$ptWerteArray[29]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - nihssWert7days nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET ranking = '$ptWerteArray[30]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Ranking nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET entlassung = '$ptWerteArray[31]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Entlassung nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET entlassungNach = '$ptWerteArray[32]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - Entlassung nach ... nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET timeCCTStart = '$ptWerteArray[33]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - timeCCTStart nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET timeCCTEnd = '$ptWerteArray[34]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - timeCCTEnd nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctDescr1 = '$ptWerteArray[35]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctDescr1 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctDescr2 = '$ptWerteArray[36]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctDescr2 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctDescr3 = '$ptWerteArray[37]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctDescr3 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctOption1 = '$ptWerteArray[38]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctOption1 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctOption2 = '$ptWerteArray[39]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctOption2 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctOption3 = '$ptWerteArray[40]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctOption3 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET cctOption4 = '$ptWerteArray[41]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse - cctOption4 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET apaVoreinnahme2 = '$ptWerteArray[42]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse apaVoreinnahme2 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET apaVoreinnahme3 = '$ptWerteArray[43]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse apaVoreinnahme3 nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdWert1Aufnahme = '$ptWerteArray[44]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdWert1Aufnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdWert2Aufnahme = '$ptWerteArray[45]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdWert2Aufnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdDescrAufnahme = '$ptWerteArray[46]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdDescrAufnahme nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdWert1vorLyse = '$ptWerteArray[47]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdWert1vorLyse nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdWert2vorLyse = '$ptWerteArray[48]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdWert2vorLyse nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
				$db_request = "UPDATE patientThrombolyse SET bdDescrvorLyse = '$ptWerteArray[49]' WHERE ptID = '$ptID'";
				$query_handle = mysql_query($db_request, $db_handle);
				if ($query_handle != ""){
				} else {
					print "<p class='errorMessage'>Konnte Thrombolyse bdDescrvorLyse nicht &auml;ndern [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
				}
			}
		}		
	} else { 
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank [savePatientThrombolyseWeb($ptID,$ptWerteArray)]!</p>";
	} 
}

function showPatientThrombolyseWerte($ptID) {
	global $db_handle, $rowHR;
 	if (access()) {
		$db_request1	 = "SELECT arztID, patientID, patientRecordID, apaVoreinnahme, mVoreinnahme, vorhofflimmern, diabetes, hypertonus, vorSchlaganfall, oberArztTime, oberArztDescr, laborWerteTime, laborWert1, laborWert2, laborWert3, laborWert4, laborWert5, bdSenkungOption, lyseDecisionTime, lyseDecisionDescr1, lyseDecisionDescr2, dosisWert1, dosisWert2, dosisWert3, dosisWert4, timeLyseStart, timeLyseEnd, rekonsilArztID, nihssWert2448, complications, nihssWert7days, ranking, entlassung, timeCCTStart, timeCCTEnd, cctDescr1, cctDescr2, cctDescr3, cctOption1, cctOption2, cctOption3, cctOption4, entlassungNach, apaVoreinnahme2, apaVoreinnahme3, bdWert1Aufnahme, bdWert2Aufnahme, bdDescrAufnahme,  bdWert1vorLyse, bdWert2vorLyse, bdDescrvorLyse  FROM patientThrombolyse WHERE ptID = '$ptID'";	  
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 == 0){
				print "<p>Keine Thrombolyse-Dokumentation vorhanden.</p>";
			} else {
				for ($i1 = 0; $i1 < $rows1; $i1++){ 
					$data   = mysql_fetch_row($query_handle1); 
					$arztID				= $data[0]; 	
					$patientID			= $data[1];	
					$patientRecordID	= $data[2];		
					$apaVoreinnahme		= $data[3];
					$mVoreinnahme		= $data[4];
					$vorhofflimmern		= $data[5];		
					$diabetes			= $data[6];		
					$hypertonus			= $data[7];		
					$vorSchlaganfall	= $data[8];	
					$oberArztTime 		= $data[9];		
					$oberArztDescr 		= $data[10];	
					$laborWerteTime 	= $data[11];	
					$laborWert1 		= $data[12];	
					$laborWert2 		= $data[13];
					$laborWert3 		= $data[14];	
					$laborWert4 		= $data[15];
					$laborWert5 		= $data[16];		
					$bdSenkungOption 	= $data[17];	
					$lyseDecisionTime 	= $data[18];	
					$lyseDecisionDescr1 = $data[19];	
					$lyseDecisionDescr2 = $data[20];	
					$dosisWert1 		= $data[21];	
					$dosisWert2 		= $data[22];	
					$dosisWert3 		= $data[23];	
					$dosisWert4 		= $data[24];	
					$timeLyseStart 		= $data[25];	
					$timeLyseEnd 		= $data[26];	
					$rekonsilArztID 	= $data[27];	
					$nihssWert2448 		= $data[28];	
					$complications 		= $data[29];	
					$nihssWert7days 	= $data[30];	
					$ranking 			= $data[31];	
					$entlassung 		= $data[32];	
					$timeCCTStart 		= $data[33];
					$timeCCTEnd 		= $data[34];
					$cctDescr1 			= $data[35];
					$cctDescr2 			= $data[36];
					$cctDescr3 			= $data[37];
					$cctOption1 		= $data[38];
					$cctOption2 		= $data[39];
					$cctOption3 		= $data[40];
					$cctOption4 		= $data[41];
					$entlassungNach 	= $data[42];			
					$apaVoreinnahme2	= $data[43];	
					$apaVoreinnahme3	= $data[44];	
					$bdWert1Aufnahme	= $data[45]; 	
					$bdWert2Aufnahme	= $data[46];	
					$bdDescrAufnahme	= $data[47];
					$bdWert1vorLyse		= $data[48]; 	
					$bdWert2vorLyse	= $data[49];	
					$bdDescrvorLyse 	= $data[50];		
					$timeSymptoms		= getDBContent('patientRecords','timeSymptoms', 'patientRecordID',$patientRecordID);
					$timeInitialContact	= getDBContent('patientRecords','timeInitialContact', 'patientRecordID',$patientRecordID);
					$timeHospital		= getDBContent('patientRecords','timeHospital', 'patientRecordID',$patientRecordID);		
					if ($timeSymptoms <> "0000-00-00 00:00:00") { 
						$timeSymptoms	= strtotime($timeSymptoms);
						$timeSymptoms 	= date('Y.m.d H:i', $timeSymptoms);
					} else {
						$timeSymptoms 	=  "nicht angegeben";
					}
					if ($timeHospital <> '0000-00-00 00:00:00') { 
						$timeHospital	= strtotime($timeHospital);
						$timeHospital 	= date('Y.m.d H:i', $timeHospital);
					} else {
						$timeSymptoms 	= "nicht angegeben";
					}		
					print "<table style='width:100%;border:1px solid #999;padding: 5px;font-size: 120%;font-weight: bold;line-height: 220%;margin:0px 0px 20px 0px;'>";
					print "<tr>";
					print "<td width=350>";
					print "症状的开始: ";
					print "</td><td>";
					print "$timeSymptoms ";
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "入院 : ";
					print "</td><td>";
					print "$timeHospital";
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "Erstkontakt mit med. Personal: ";
					print "</td><td>";
					print "$timeInitialContact ";
					print "</td>";
					print "</tr>";
					print "</table>";
					print "<table style='width:100%;border:1px solid #999;padding: 5px;' cellspacing='5' cellpadding='0'>";
					print "<tr>";
					print "<td colspan='3'>";
					print "<table style='width:100%;' cellspacing='0' cellpadding='1'>";
					print "<tr>";
					print "<td width='25%'>";
					print "Voreinnahme : ";
					print "</td>";
					print "<td colspan='3'>";
					print "ASS: ";
					if ($apaVoreinnahme == 'j'){
						print " ja";
					} else {
						print "nein ";
					}
					print " &nbsp;  &nbsp; Plavix: ";
					if ($apaVoreinnahme2 == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print " &nbsp;  &nbsp; Aggrenox: ";
					if ($apaVoreinnahme3 == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print " &nbsp;  &nbsp; Marcumar: ";
					if ($mVoreinnahme == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "Vorhofflimmern: ";
					if ($vorhofflimmern == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print "</td>";
					print "<td>";
					print "Fr&uuml;herer Schlaganfall: ";
					if ($vorSchlaganfall == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print "</td>";
					print "<td>";
					print "Diabetes: ";
					if ($diabetes == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print "</td>";
					print "<td>";
					print "Hypertonus: ";
					if ($hypertonus == 'j'){
						print " ja";
					} else {
						print " nein";
					}
					print "</td>";
					print "</tr>";
					print "</table>";
					print "</td>";
					print "</tr>";
					print "$rowHR"; 
					print "<tr>";
					print "<td>";
					print "Blutdruck vor Thrombolyse: ";
					print "</td>";
					print "<td>";
					print "$bdWert1Aufnahme ";
					print "/ ";
					print " $bdWert2Aufnahme "; 
					print " mmHg => ";
					print "</td>";
					print "<td>";
					print "Anmerk.: ";  
					print "$bdDescrAufnahme";
					print "</td>";
					print "</tr>";
					print "$rowHR"; 
					$timeCCTStartArray  = explode(':',$timeCCTStart);
					$timeCCT1H			= $timeCCTStartArray[0]; 
					$timeCCT1Min		= $timeCCTStartArray[1];	
					print "<tr>";
					print "<td valign='top'>";
					print "<h4>Beginn CCT: </h4>";
					print "</td>";
					print "<td>$timeCCT1H:$timeCCT1Min Uhr</td>";
					print "<td>";
					print "Anmerk.: ";  
					print "$cctDescr1 ";
					print "</td>";
					print "</tr>";
					$OATimeArray	= explode(':',$oberArztTime);
					$timeOAH		= $OATimeArray[0]; 
					$timeOAMin		= $OATimeArray[1];	
					print "<tr>";
					print "<td>";
					print "Ggfs. R&uuml;cksprache Oberarzt:";
					print "</td>";
					print "<td>$timeOAH:$timeOAMin Uhr</td>";
					print "<td>";
					print "Anmerk.:";  
					print "$oberArztDescr";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					$timeTherapy	= getDBContent('patientRecords','timeTreatment','patientRecordID',$patientRecordID);
					$timeTherapyA 	= strtotime($timeTherapy);
					$timeTherapy 	= date("Y.m.d. H:i", $timeTherapyA);
					print "<tr>";
					print "<td valign='top'>";
					print "<h4>Beginn Telekonsil:</h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "$timeTherapy, ";  
					$nArztID		= getDBContent('patientRecords','therapyArztID','patientRecordID', $patientRecordID);
					$nArztInfo		= getArztInfos($nArztID);
					print "Durchf&uuml;hrender Arzt: $nArztInfo<br />"; 
					print "<h4 class='mini'>NIHSS - durchgef&uuml;hrte Dokumentation:</h4>";
					getNIHSSlist($patientRecordID); 
					print "<br />"; 
					print "<h4 class='mini'>NIHSS - Eingetragene Werte im Konsilschein:</h4>";
					getTotalNIHSSWerte($patientRecordID);
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					$laborWerteTimeA	= explode(':',$laborWerteTime);
					$timeLaborH			= $laborWerteTimeA[0]; 
					$timeLaborMin		= $laborWerteTimeA[1];	
					print "<tr>";
					print "<td>";
					print "<h4>Laborwerte: </h4>";
					print "</td>";
					print "<td colspan='2'>";
					print "$timeLaborH:$timeLaborMin Uhr";  
					print "</td>";
					print "</tr>";
					$laborWert1	= str_replace('.',',',$laborWert1);
					$laborWert2	= str_replace('.',',',$laborWert2);
					$laborWert3	= str_replace('.',',',$laborWert3);
					$laborWert4	= str_replace('.',',',$laborWert4);
					$laborWert5	= str_replace('.',',',$laborWert5);
					print "<tr>";
					print "<td colspan='3'>";
					print "Thrombozyten: $laborWert1 &nbsp; ";
					print "Hb: $laborWert2  &nbsp; ";
					print "INR: $laborWert3 &nbsp; ";
					print "PTT: $laborWert4 &nbsp; ";
					print "BZ bei Aufnahme: $laborWert5 mg/dl";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td>";
					print "Blutdruck vor Lyse: ";
					print "</td>";
					print "<td colspan='2'>";
					print "$bdWert1vorLyse";
					print "/ ";
					print "$bdWert2vorLyse &nbsp;  &nbsp; ";
					print "Blutdrucksenkung vor Lyse (im KH):";
					if ($bdSenkungOption == 'j'){
						print "ja";
					} else {
						print "nein";
					}
					print "</td>";
					print "</tr>";
					$lyseDecisionTimeArray	= explode(':',$lyseDecisionTime);
					$timeLDH		= $lyseDecisionTimeArray[0]; 
					$timeLDMin		= $lyseDecisionTimeArray[1];	
					print "<tr>";
					print "<td>";
					print "<h4>Entscheidung Lyse:</h4>";
					print "</td>";
					print "<td>";
					print "$timeLDH:$timeLDMin Uhr";  
					print "</td>";
					print "<td>";
					print "Anmerk.: ";  
					print " $lyseDecisionDescr1";
					print "</td>";
					print "</tr>";
					print "<tr>";
					print "<td>";
					print "keine Lyse wegen: ";  
					print "</td>";
					print "<td colspan='2'>";
					print "$lyseDecisionDescr2";
					print "</td>";
					print "</tr>";
					$pGewicht			= getDBContent('patientRecords','pGewicht','patientRecordID', $patientRecordID);
					print "<tr>";
					print "<td colspan='3'>$pGewicht";
					print "$patientID & $patientRecordID<hr>: ";
					print "<h4 style='font-size:110%;float: left;margin:10px 0px 0px 0px;'>Dosis rtPA: => K&ouml;rpergewicht: &nbsp; </h4> ";
					if ($pGewicht == 0){
						print " keine Gewichtsangabe vorhanden";
					} else {
						print " $pGewicht kg ";
						$dosisWert1	= ($pGewicht * 0.9);
						$dosisWert1a	= str_replace('.',',',$dosisWert1);
						print " => x 0,9 = $dosisWert1a  mg rtPA = ml-L&ouml;sung Gesamt,";
						print "$dosisWert1a";
						$dosisWert2	= $dosisWert1 / 10;
						$dosisWert2a	= str_replace('.',',',$dosisWert2);
						$dosisWert3	= $dosisWert1 - $dosisWert2;
						$dosisWert3a	= str_replace('.',',',$dosisWert3);
						print "<br />";
						print "10% der Gesamtdosis als Bolus = $dosisWert2a ml; ";
						print "Rest (90%) &uuml;ber 1 Std. = $dosisWert3a ml = ml/h (Laufrate Perfusor)";
					}
					print "</td>";
					print "</tr>";
					if (($timeLyseStart == '0000-00-00 00:00:00') AND  ($timeLyseEnd == '0000-00-00 00:00:00')){
					} else {
						$timeLS		= strtotime($timeLyseStart);
						$timeLS		= date("Y.m.d H:i",$timeLS);
						$timeLE		= strtotime($timeLyseEnd);
						$timeLE		= date("Y.m.d H:i",$timeLE);
						print "<tr>";
						print "<td>";
						print "<h4>Zeiten Lyse:</h4>";
						print "</td>";
						print "<td colspan='2'>";
						print "Beginn: $timeLS	End: $timeLE";  
						print "</td>";
						print "</tr>";
					$infoA		= getArztInfos($arztID);
					print "<tr>";
					print "<td>";
					print "Durchf&uuml;hrender Arzt:";
					print "</td>";
					print "<td colspan='2'>";
					print " $infoA ";
					print "</td>";
					print "</tr>";
					}
										print "$rowHR"; 
					print "<tr valign='top'>";
					print "<td>";
					print "Kontroll-CCT<br> 24-48 Std. nach Lyse: ";
					print "</td>";
					print "<td>";
					print "Einblutung: ";
					if ($cctOption1 <> ''){ 
						if ($cctOption1 =='j'){ 
							print "asympt. &nbsp; ";
						} 
						if ($cctOption1 =='n'){ 
							print "sympt. &nbsp; ";
						} 
					} 
					print "</td>";
					print "<td>";
					print "其他:";
					print "$cctDescr2";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					print "<tr>";
					print "<td >";
					print "NIHSS nach 24-48 Std. ";
					print "</td>";
					print "<td colspan='3'>";
					print "$nihssWert2448";
					$infoRA		= getArztInfos($rekonsilArztID);
					print " &nbsp; || &nbsp; Re-Konsil  durch: $infoRA";
					print "</td>";
					print "</tr>";
										print "$rowHR"; 
					if ($complications <> ''){
						print "<tr>";
						print "<td valign='top'>";
						print "Sonstige Komplikationen:";
						print "</td>";
						print "<td colspan='2'>";
						print "$complications";
						print "</td>";
						print "</tr>";
										print "$rowHR"; 
					}
					print "<tr>";
					print "<td>";
					print "Tag 7 / Entlassung:";
					print "</td>";
					print "<td colspan='2'>";
					print "NIHSS: $nihssWert7days";
					print " &nbsp; Ranking-Score:";
					print " $ranking ";
					$entlassung		= strtotime($entlassung);
					$entlassung		= date("Y.m.d H:i",$entlassung);
					print " &nbsp; || &nbsp; am: ";
					print "$entlassung nach: $entlassungNach"; 
					print "</td>";
					print "</tr>";
					print "</table>";
				} 
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [showPatientThrombolyseWerteWeb($ptID) ]</p>";
		} 
	} 
}
?>
