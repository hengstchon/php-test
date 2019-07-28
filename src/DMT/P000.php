<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  Globale Funktionen
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-04-26
//  2011-10-10		 	- vergessene savePatientInfos function in case 1030 & 1035 integriert
//	2011-10				- NIHSS Punkte auf einer Seite
//	2011-10-26			- function getDBContent in getDBContent umbenannt
//   					- dateieigenschaften > php, western (ISO Latin1) & <?php
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
//  ----------------------------------------------------------------------------

// --- includes ----------------------------------------------------------------



include("frida.php");
include("functions.php");
include("P001.php");
include_once('templatesTherapy.php');
$x						= getSecurePOSTAndGETData('x');
$case	 				= getSecurePOSTAndGETData('case');
$rowHR					= "<tr><td colspan='3'><hr></td></tr>";
$indicationID 			= getSecurePOSTAndGETData('indicationID');
$indicationName			= getSecurePOSTAndGETData('indicationName');
$indicationCode			= getSecurePOSTAndGETData('indicationCode');
$indicationComment		= getSecurePOSTAndGETData('indicationComment');
$indication2ID 			= getSecurePOSTAndGETData('indication2ID');
$indication2Name		= getSecurePOSTAndGETData('indication2Name');
$indication2Code		= getSecurePOSTAndGETData('indication2Code');
$indication2Comment		= getSecurePOSTAndGETData('indication2Comment');
$indication2DID 		= getSecurePOSTAndGETData('indication2DID');
$indication2DName		= getSecurePOSTAndGETData('indication2DName');
$indication2DCode		= getSecurePOSTAndGETData('indication2DCode');
$conditionID 			= getSecurePOSTAndGETData('conditionID');
$conditionName			= getSecurePOSTAndGETData('conditionName');
$conditionText			= getPOSTAndGETData('conditionText');
$conditionComment		= getSecurePOSTAndGETData('conditionComment');
$symptomID 				= getSecurePOSTAndGETData('symptomID');
$symptomName			= getSecurePOSTAndGETData('symptomName');
$symptomText			= getPOSTAndGETData('symptomText');
$symptomComment			= getSecurePOSTAndGETData('symptomComment');
$therapyID 				= getSecurePOSTAndGETData('therapyID');
$therapyName			= getSecurePOSTAndGETData('therapyName');
$therapyText			= getPOSTAndGETData('therapyText');
$therapyComment			= getSecurePOSTAndGETData('therapyComment');
$arztID 				= getSecurePOSTAndGETData('arztID');
$arztGender				= getSecurePOSTAndGETData('arztGender');
$acadTitle 				= getSecurePOSTAndGETData('acadTitle');
$arztFirstName 			= getSecurePOSTAndGETData('arztFirstName');
$arztLastName			= getSecurePOSTAndGETData('arztLastName');
$arztPhone				= getSecurePOSTAndGETData('arztPhone');
$arztComment 			= getSecurePOSTAndGETData('arztComment');
$userID 				= getSecurePOSTAndGETData('userID');
$userLogin				= getSecurePOSTAndGETData('userLogin');
$userPW					= getSecurePOSTAndGETData('userPW');
$userEMail				= getSecurePOSTAndGETData('userEMail');
$requestInfos			= getSecurePOSTAndGETData('requestInfos');
$clinicID 				= getSecurePOSTAndGETData('clinicID');
$capitalLetter 			= getSecurePOSTAndGETData('capitalLetter');
$patientID 				= getSecurePOSTAndGETData('patientID');
$pFirstName				= getSecurePOSTAndGETData('pFirstName');
$pLastName				= getSecurePOSTAndGETData('pLastName');
$pBday					= getSecurePOSTAndGETData('pBday');
if ($pBday == ''){
		$pBdayDay		= getSecurePOSTAndGETData('pBdayDay');
		$pBdayMonth		= getSecurePOSTAndGETData('pBdayMonth');
		$pBdayYear		= getSecurePOSTAndGETData('pBdayYear');
		$pBday			= $pBdayYear . '-' . $pBdayMonth . '-' . $pBdayDay;
}
$pStreet				= getSecurePOSTAndGETData('pStreet');
$pZipCode				= getSecurePOSTAndGETData('pZipCode');
$pCity					= getSecurePOSTAndGETData('pCity');
$pPhone					= getSecurePOSTAndGETData('pPhone');
$pGender				= getSecurePOSTAndGETData('pGender');
$pDataArray				= array($patientID, $pFirstName, $pLastName, $pBday, $pStreet, $pZipCode, $pCity, $pPhone, $pGender);
$patientRecordID		= getSecurePOSTAndGETData('patientRecordID');
$timeSymptoms			= getSecurePOSTAndGETData('timeSymptoms');
if ($timeSymptoms == ''){
		$timeSymptomsDay	= getSecurePOSTAndGETData('timeSymptomsDay');
		$timeSymptomsMonth	= getSecurePOSTAndGETData('timeSymptomsMonth');
		$timeSymptomsYear	= getSecurePOSTAndGETData('timeSymptomsYear');
		$timeSymptomsHour	= getSecurePOSTAndGETData('timeSymptomsHour');
		$timeSymptomsMinutes= getSecurePOSTAndGETData('timeSymptomsMinutes');
	$timeSymptoms			= $timeSymptomsYear . "-" . $timeSymptomsMonth . "-" . $timeSymptomsDay . " " . $timeSymptomsHour . ":" . $timeSymptomsMinutes . ":00";
}
$symptomsText			= getSecurePOSTAndGETData('symptomsText');
$symptomsText2			= getSecurePOSTAndGETData('symptomsText2');
$timeSymptomsGesund		= getSecurePOSTAndGETData('timeSymptomsGesund');
if ($timeSymptomsGesund == ''){
		$timeGesundDay		= getSecurePOSTAndGETData('timeGesundDay');
		$timeGesundMonth	= getSecurePOSTAndGETData('timeGesundMonth');
		$timeGesundYear		= getSecurePOSTAndGETData('timeGesundYear');
		$timeGesundHour		= getSecurePOSTAndGETData('timeGesundHour');
		$timeGesundMinutes	= getSecurePOSTAndGETData('timeGesundMinutes');
	$timeSymptomsGesund		= $timeGesundYear . "-" . $timeGesundMonth . "-" . $timeGesundDay . " " . $timeGesundHour . ":" . $timeGesundMinutes . ":00";
}
$timeInitialContact		= getSecurePOSTAndGETData('timeInitialContact');
$timeHospital			= getSecurePOSTAndGETData('timeHospital');
if ($timeHospital == ''){
		$timeHospitalDay	= getSecurePOSTAndGETData('timeHospitalDay');
		$timeHospitalMonth	= getSecurePOSTAndGETData('timeHospitalMonth');
		$timeHospitalYear	= getSecurePOSTAndGETData('timeHospitalYear');
		$timeHospitalHour	= getSecurePOSTAndGETData('timeHospitalHour');
		$timeHospitalMinutes= getSecurePOSTAndGETData('timeHospitalMinutes');
	$timeHospital			= $timeHospitalYear . "-" . $timeHospitalMonth . "-" . $timeHospitalDay . " " . $timeHospitalHour . ":" . $timeHospitalMinutes . ":00";
}
$timeDiagnosis			= getSecurePOSTAndGETData('timeDiagnosis');
if ($timeDiagnosis == ''){
		$timeDiagnosisDay	= getSecurePOSTAndGETData('timeDiagnosisDay');
		$timeDiagnosisMonth	= getSecurePOSTAndGETData('timeDiagnosisMonth');
		$timeDiagnosisYear	= getSecurePOSTAndGETData('timeDiagnosisYear');
		$timeDiagnosisHour	= getSecurePOSTAndGETData('timeDiagnosisHour');
		$timeDiagnosisMinutes= getSecurePOSTAndGETData('timeDiagnosisMinutes');
	$timeDiagnosis			= $timeDiagnosisYear . "-" . $timeDiagnosisMonth . "-" . $timeDiagnosisDay . " " . $timeDiagnosisHour . ":" . $timeDiagnosisMinutes . ":00";
}
$diagnosisArztID		= getSecurePOSTAndGETData('diagnosisArztID');
$symptomDescr			= getPOSTAndGETData('symptomDescr');
$timeTreatment			= getSecurePOSTAndGETData('timeTreatment');
if ($timeTreatment == ''){
		$timeTreatmentDay	= getSecurePOSTAndGETData('timeTreatmentDay');
		$timeTreatmentMonth	= getSecurePOSTAndGETData('timeTreatmentMonth');
		$timeTreatmentYear	= getSecurePOSTAndGETData('timeTreatmentYear');
		$timeTreatmentHour	= getSecurePOSTAndGETData('timeTreatmentHour');
		$timeTreatmentMinutes= getSecurePOSTAndGETData('timeTreatmentMinutes');
	$timeTreatment			= $timeTreatmentYear . "-" . $timeTreatmentMonth . "-" . $timeTreatmentDay . " " . $timeTreatmentHour . ":" . $timeTreatmentMinutes . ":00";
}
$therapyArztID			= getSecurePOSTAndGETData('therapyArztID');
$konsilType				= getSecurePOSTAndGETData('konsilType');
$lyseOption				= getPOST_CheckedValue('lyseOption');
$visualData 			= getPOSTAndGETData('visualData');
if ($visualData <> ''){
	for ($i=0;$i<4;$i++){
		if (array_key_exists($i,$visualData)){
		} else {
			$visualData[$i]	= '';
		}
	}
	$visualData	= $visualData[0] . ',' . $visualData[1] . ',' . $visualData[2] . ',' . $visualData[3];
} else {
	$visualData	= ',,,';
}
$visualDataDescr 		= getSecurePOSTAndGETData('visualDataDescr');
$therapyDescr			= getPOSTAndGETData('therapyDescr');
$therapyDescr2			= getPOSTAndGETData('therapyDescr2');
$therapyDescr3			= getPOSTAndGETData('therapyDescr3');
$tT_array 				= getPOSTAndGETData('templatesTherapy');
$editStatus				= getPOSTAndGETData('editStatus');
$pDrugs					= getPOSTAndGETData('pDrugs');
$pConditions			= getPOSTAndGETData('pConditions');
$pGewicht				= getSecurePOSTAndGETData('pGewicht');
$pGroesse				= getSecurePOSTAndGETData('pGroesse');
$pGewicht				= str_replace(',','.',$pGewicht);
$pGroesse				= str_replace(',','.',$pGroesse);
$pRecordDataArray		= array($patientRecordID, $patientID, $symptomsText, $timeInitialContact, $timeHospital, $timeDiagnosis, $timeTreatment, $clinicID, $diagnosisArztID, $symptomDescr, $indicationID, $therapyArztID, $konsilType, $lyseOption, $visualData, $indication2ID,  $indication2DID, $therapyDescr, $therapyDescr2, $therapyDescr3, $editStatus, $pDrugs, $pConditions, $pGewicht, $pGroesse, $visualDataDescr, $timeSymptoms, $symptomsText2, $timeSymptomsGesund, $tT_array );
$pInfoIDs				= getPOSTAndGETData('pInfoIDs');
$pnID				= getSecurePOSTAndGETData('pnID');
$nihssStepID		= getSecurePOSTAndGETData('nihssStepID');
$posTelekonsil		= getSecurePOSTAndGETData('posTelekonsil');
$posNIHSSoriginal	= getSecurePOSTAndGETData('posNIHSSoriginal');
$nihssStepName		= getSecurePOSTAndGETData('nihssStepName');
$nihssStepText		= getSecurePOSTAndGETData('nihssStepText');
$cameraInfo			= getSecurePOSTAndGETData('cameraInfo');
$assistenzInfo		= getPOST_CheckedValue('assistenzInfo');
$pWerteID			= getPOSTAndGETData('pWerteID');
$pWert1				= getPOSTAndGETData('pWert1');
$pWert2				= getPOSTAndGETData('pWert2');
$pWert3				= getPOSTAndGETData('pWert3');
$pWert4				= getPOSTAndGETData('pWert4');
$pWert5				= getPOSTAndGETData('pWert5');
$pWertDescr			= getPOSTAndGETData('pWertDescr');
$pWerteArray		= array($pWert1, $pWert2, $pWert3, $pWert4, $pWert5, $pWertDescr);
$step				= getPOSTAndGETData('step');
$column				= getPOSTAndGETData('column');
$pWert				= getPOSTAndGETData('pWert');
$nihssTotal			= getPOSTAndGETData('nihssTotal');
$ptID				= getPOSTAndGETData('ptID');
$apaVoreinnahme		= getPOST_CheckedValue('apaVoreinnahme');
$apaVoreinnahme2	= getPOST_CheckedValue('apaVoreinnahme2');
$apaVoreinnahme3	= getPOST_CheckedValue('apaVoreinnahme3');
$mVoreinnahme		= getPOST_CheckedValue('mVoreinnahme');
$vorhofflimmern		= getPOST_CheckedValue('vorhofflimmern');
$diabetes			= getPOST_CheckedValue('diabetes');
$hypertonus			= getPOST_CheckedValue('hypertonus');
$vorSchlaganfall	= getPOST_CheckedValue('vorSchlaganfall');
$oberArztTime		= getPOSTAndGETData('oberArztTime');
if ($oberArztTime == ''){
		$oberArztTimeH		= getSecurePOSTAndGETData('oberArztTimeH');
		$oberArztTimeMin	= getSecurePOSTAndGETData('oberArztTimeMin');
	$oberArztTime			= $oberArztTimeH . ":" . $oberArztTimeMin . ":00";
}
$oberArztDescr		= getPOSTAndGETData('oberArztDescr');
$laborWerteTime		= getPOSTAndGETData('laborWerteTime');
if ($laborWerteTime == ''){
		$laborWerteTimeH	= getSecurePOSTAndGETData('laborWerteTimeH');
		$laborWerteTimeMin	= getSecurePOSTAndGETData('laborWerteTimeMin');
	$laborWerteTime			= $laborWerteTimeH . ":" . $laborWerteTimeMin . ":00";
}
$laborWert1			= getPOSTAndGETData('laborWert1');
$laborWert2			= getPOSTAndGETData('laborWert2');
$laborWert3			= getPOSTAndGETData('laborWert3');
$laborWert4			= getPOSTAndGETData('laborWert4');
$laborWert5			= getPOSTAndGETData('laborWert5');
$laborWert1				= str_replace(',','.',$laborWert1);
$laborWert2				= str_replace(',','.',$laborWert2);
$laborWert3				= str_replace(',','.',$laborWert3);
$laborWert4				= str_replace(',','.',$laborWert4);
$laborWert5				= str_replace(',','.',$laborWert5);
$bdSenkungOption	= getPOSTAndGETData('bdSenkungOption');
$lyseDecisionTime	= getPOSTAndGETData('lyseDecisionTime');
if ($lyseDecisionTime == ''){
		$lyseDecisionTimeH		= getSecurePOSTAndGETData('lyseDecisionTimeH');
		$lyseDecisionTimeMin	= getSecurePOSTAndGETData('lyseDecisionTimeMin');
	$lyseDecisionTime			= $lyseDecisionTimeH . ":" . $lyseDecisionTimeMin . ":00";
}
$lyseDecisionDescr1	= getPOSTAndGETData('lyseDecisionDescr1');
$lyseDecisionDescr2	= getPOSTAndGETData('lyseDecisionDescr2');
$dosisWert1			= getPOSTAndGETData('dosisWert1');
$dosisWert2			= getPOSTAndGETData('dosisWert2');
$dosisWert3			= getPOSTAndGETData('dosisWert3');
$dosisWert4			= getPOSTAndGETData('dosisWert4');
$timeLyseStart		= getPOSTAndGETData('timeLyseStart');
if ($timeLyseStart == ''){
		$timeLyseStartY		= getSecurePOSTAndGETData('timeLyseStartY');
		$timeLyseStartD		= getSecurePOSTAndGETData('timeLyseStartD');
		$timeLyseStartM		= getSecurePOSTAndGETData('timeLyseStartM');
		$timeLyseStartH		= getSecurePOSTAndGETData('timeLyseStartH');
		$timeLyseStartMin	= getSecurePOSTAndGETData('timeLyseStartMin');
	$timeLyseStart			= $timeLyseStartY . "-" . $timeLyseStartM . "-" . $timeLyseStartD . " " . $timeLyseStartH . ":" . $timeLyseStartMin . ":00";
}
$timeLyseEnd		= getPOSTAndGETData('timeLyseEnd');
if ($timeLyseEnd == ''){
		$timeLyseEndY		= getSecurePOSTAndGETData('timeLyseEndY');
		$timeLyseEndD		= getSecurePOSTAndGETData('timeLyseEndD');
		$timeLyseEndM		= getSecurePOSTAndGETData('timeLyseEndM');
		$timeLyseEndH		= getSecurePOSTAndGETData('timeLyseEndH');
		$timeLyseEndMin		= getSecurePOSTAndGETData('timeLyseEndMin');
	$timeLyseEnd			= $timeLyseEndY . "-" . $timeLyseEndM . "-" . $timeLyseEndD . " " . $timeLyseEndH . ":" . $timeLyseEndMin . ":00";
}
$rekonsilArztID		= getPOSTAndGETData('rekonsilArztID');
$nihssWert2448		= getPOSTAndGETData('nihssWert2448');
$complications		= getPOSTAndGETData('complications');
$nihssWert7days		= getPOSTAndGETData('nihssWert7days');
$ranking			= getPOSTAndGETData('ranking');
$entlassung 		= getPOSTAndGETData('entlassung');
if ($entlassung == ''){
		$entlassungY		= getSecurePOSTAndGETData('entlassungY');
		$entlassungD		= getSecurePOSTAndGETData('entlassungD');
		$entlassungM		= getSecurePOSTAndGETData('entlassungM');
		$entlassungH		= getSecurePOSTAndGETData('entlassungH');
		$entlassungMin		= getSecurePOSTAndGETData('entlassungMin');
	$entlassung				= $entlassungY . "-" . $entlassungM . "-" . $entlassungD . " " . $entlassungH . ":" . $entlassungMin . ":00";
}
$entlassungNach 		= getPOSTAndGETData('entlassungNach');
$timeCCTStart 		= getPOSTAndGETData('timeCCTStart');
if ($timeCCTStart == ''){
		$timeCCTStartH		= getSecurePOSTAndGETData('timeCCTStartH');
		$timeCCTStartMin	= getSecurePOSTAndGETData('timeCCTStartMin');
	$timeCCTStart			= $timeCCTStartH . ":" . $timeCCTStartMin . ":00";
}
$timeCCTEnd 		= '00:00:00';
$cctDescr1 			= getSecurePOSTAndGETData('cctDescr1');
$cctDescr2 			= getSecurePOSTAndGETData('cctDescr2');
$cctDescr3 			= getSecurePOSTAndGETData('cctDescr3');
$cctOption1 		= getPOST_CheckedValue('cctOption1');
$cctOption2 		= getPOST_CheckedValue('cctOption2');
$cctOption3 		= getPOST_CheckedValue('cctOption3');
$cctOption4 		= getPOST_CheckedValue('cctOption4');
$bdWert1Aufnahme 	= getPOSTAndGETData('bdWert1Aufnahme');
$bdWert2Aufnahme 	= getPOSTAndGETData('bdWert2Aufnahme');
$bdDescrAufnahme 	= getPOSTAndGETData('bdDescrAufnahme');
$bdWert1vorLyse 	= getPOSTAndGETData('bdWert1vorLyse');
$bdWert2vorLyse 	= getPOSTAndGETData('bdWert2vorLyse');
$bdDescrvorLyse 	= getPOSTAndGETData('bdDescrvorLyse');
$ptWerteArray		= array($patientID, $patientRecordID, $apaVoreinnahme, $mVoreinnahme, $vorhofflimmern, $diabetes, $hypertonus, $vorSchlaganfall, $oberArztTime, $oberArztDescr, $laborWerteTime, $laborWert1, $laborWert2, $laborWert3, $laborWert4, $laborWert5, $bdSenkungOption, $lyseDecisionTime, $lyseDecisionDescr1, $lyseDecisionDescr2, $dosisWert1, $dosisWert2, $dosisWert3, $dosisWert4, $timeLyseStart, $timeLyseEnd, $rekonsilArztID, $nihssWert2448, $complications, $nihssWert7days, $ranking, $entlassung, $entlassungNach, $timeCCTStart, $timeCCTEnd, $cctDescr1, $cctDescr2, $cctDescr3, $cctOption1, $cctOption2, $cctOption3, $cctOption4, $apaVoreinnahme2, $apaVoreinnahme3, $bdWert1Aufnahme, $bdWert2Aufnahme, $bdDescrAufnahme, $bdWert1vorLyse, $bdWert2vorLyse, $bdDescrvorLyse);

function access() {
	global $db_host, $db_name, $db_user, $db_pw, $db_handle;
	$db_handle = mysql_connect($db_host, $db_user, $db_pw) or die ("No connection to database host");
	if (mysql_select_db($db_name)) {
		return  true;
	} else {
		die ("Database not available");
		return  false;
	}
}

function getPOSTAndGETData($send) {
	if (isset($_POST[$send])) {
		$variable = $_POST[$send];
	} else {
		$variable = '';
	}
	if (isset($_GET[$send])) {
		$variable = $_GET[$send];
	}
	$variable	= str_replace('"', '&quot;', $variable);
	$variable	= str_replace('\'', '&apos;', $variable);
	return $variable;
}
function getSecurePOSTAndGETData($send) {
	$variable = '';
	if (isset($_POST[$send])) {
		$variable = strip_tags($_POST[$send]);
	} else {
		if (isset($_GET[$send])) {
			$variable   = strip_tags($_GET[$send]);
		}
	}
	$variable	= str_replace('"', '&quot;', $variable);
	$variable	= str_replace('\'', '&apos;', $variable);
	return $variable;
}

function getPOST_CheckedValue($send) {
	if (isset($_POST[$send])) {
		$variable = $_POST[$send];
	} else {
		$variable = 'n';
	}
	return $variable;
}

function nameExist($capitalLetter) {
	global $db_handle;
	$rows = 0;
	if (access()) {
		$db_request	 = "SELECT pLastName FROM patients WHERE pLastnamePy LIKE '$capitalLetter%'  ORDER by pLastName ASC";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
		}
	}
	return $rows;
}

function schreibweise($variable){
	$count = strlen($variable);
	$variable	= substr($variable, 0, 1) . substr($variable, 1, $count);
	$pos		= strpos(substr($variable, 1, $count), ' ');
	if ($pos > 0){
		$nameArray	= explode(' ', $variable);
		$countTeile	= count($nameArray);
		for ($i=0; $i<$countTeile;$i++){
			$countLen		= strlen($nameArray[$i]);
			$variable1[$i]	=  substr($nameArray[$i], 0,1) . substr($nameArray[$i], 1, $countLen);
		}
		$variable	= '';
		for ($j=0; $j<$countTeile;$j++){
			$variable	.= $variable1[$j] . ' ';
		}
	}
	$pos2		= strpos(substr($variable, 1, $count), '-');
	if ($pos2 > 0){
		$nameArray	= explode('-', $variable);
		$countTeile	= count($nameArray);
		for ($i=0; $i<$countTeile;$i++){
			$countLen		= strlen($nameArray[$i]);
			$variable1[$i]	=  substr($nameArray[$i], 0,1) . substr($nameArray[$i], 1, $countLen);
		}
		$variable	= '';
		for ($j=0; $j<$countTeile;$j++){
			if($j < $countTeile-1){
				$variable	.= $variable1[$j] . '-';
			} else {
				$variable	.= $variable1[$j];
			}
		}
	}
	return $variable;
}

function replaceSpecialCharacters($variable){
	$variable	= str_replace(' ','-',$variable);
	$variable	= str_replace('.','',$variable);
	$variable	= str_replace(',','',$variable);
	$variable	= str_replace('\'','',$variable);
	$variable	= str_replace('"','',$variable);
	$variable 	= str_replace('&', '-',$variable);
	$variable 	= str_replace('/', '-',$variable);
	$variable 	= str_replace('%', '-',$variable);
	$variable	= str_replace('ß','ss',$variable);
	$variable	= str_replace('ü','ue',$variable);
	$variable	= str_replace('ö','oe',$variable);
	$variable	= str_replace('ä','ae',$variable);
	$variable	= str_replace('Ü','Ue',$variable);
	$variable	= str_replace('Ö','Oe',$variable);
	$variable	= str_replace('Ä','Ae',$variable);
	$variable	= str_replace('ë','e',$variable);
	return $variable;
}

function getDBContent($table, $column, $IDcolumn, $ID) {
	global $db_handle;
	$value = '';
	if (access()) {
		$db_request	 = "SELECT $column FROM $table WHERE $IDcolumn = '$ID' ";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			   $data   = mysql_fetch_row($query_handle);
				$value  = $data[0];
		} else {
			print "<p class='errorMessage'>Kein Zugriff auf Tabelle! [getDBContent($table, $column, $IDcolumn, $ID)]</p>";
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank! [getDBContent($table, $column, $IDcolumn, $ID)]</p>";
	}
	return $value;
}

function getMaxEntries($table, $column) {
	global $db_handle;
	$rows = 0;
	if (access()) {
		$db_request	 = "SELECT $column FROM $table";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			return $rows;
		} else {
			print "<p class='errorMessage'>Kein Zugriff auf Datenbanktabelle '$table!' [getMaxEntries($table, $column)]</p>";
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank! [getMaxEntries($table, $column)]</p>";
	}
	return $rows;
}

function createYearFields($selectName, $selectedYear) {
	print "<select name='$selectName' style='float:left;margin-right: 5px;'>";
	if ($selectedYear <> ""){
		print "<option selected value='$selectedYear'>$selectedYear</option>";
	}
	$currentYear = date('Y') ;
	for ($i=0; $i < 4; $i++){
		$year = $currentYear - $i;
		if ($selectedYear <> $year){
			print "<option value='$year'>$year</option>";
		}
	}
	print "</select>";
}

function createMonthFields($selectName, $selectedMonth) {
	print "<select name='$selectName' style='float:left;;margin-right: 5px;'>";
	if ($selectedMonth == ""){
		$selectedMonth = date("m");
	}
	$smName = monthName($selectedMonth);
	print "<option selected value='$selectedMonth'>$smName</option>";
	for ($i = 1; $i <= 12; $i++) {
		$mName = monthName($i);
		if ($i < 10) {
			print "<option value='0$i'>$mName</option>";
		} else {
			print "<option value='$i'>$mName</option>";
		}
	}
	print "</select>";
}
function monthName($month) {
	$monthName = '';
	$monthNameArray = Array(1=>'一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
	if (($month >= 1) and ($month < 13)) {
		return $monthNameArray[$month*1];
	}
}

function createDayFields($selectName, $selectedDay) {
	print "<select name='$selectName' style='float:left;;margin-right: 5px;'>";
	if ($selectedDay == ""){
		$selectedDay = date('d');
	}
	print "<option selected value='$selectedDay'>$selectedDay</option>";
	for ($i = 1; $i <= 31; $i++) {
		if ($i < 10) {
			print "<option value='0$i'>0$i</option>";
		} else {
			print "<option value='$i'>$i</option>";
		}
	}
	print "</select>";
}

function createHoursFields($selectName, $selected) {
	print "<select name='$selectName' style='float:left;margin-right: 5px;'>";
	if ($selected == ""){
		$selected = date('H');
	}
	print "<option selected value='$selected'>$selected</option>";
	for ($i = 0; $i < 24; $i++) {
		if ($i < 10) {
			print "<option value='0$i'>0$i</option>";
		} else {
			print "<option value='$i'>$i</option>";
		}
	}
	print "</select>";
}

function createMinutesFields($selectName, $selected) {
	print "<select name='$selectName' style='float:left;'>";
	if ($selected == ""){
		$selected = date('i');
	}
	print "<option selected value='$selected'>$selected</option>";
	for ($i = 0; $i < 60; $i++) {
		if ($i < 10) {
			print "<option value='0$i'>0$i</option>";
		} else {
			print "<option value='$i'>$i</option>";
		}
	}
	print "</select>";
}

function sendEmailNewLogin($arztLastName, $userLogin, $userPW) {
	global $db_handle, $administrator,  $adminEMailAdresse;
	if (access()) {
		$timestamp	= date('d.m.y H:i');
		$message 		= "<html><head></head><body>";
		$message		.= "<p align='right'>Erlangen, den $timestamp</p>";
		$message		.= "<h1>Schlaganfall-Netzwerk mit Telemedizin in Nordbayern</h1>";
		$message		.= "<p>Im Folgenden finden Sie f&uuml;r $arztLastName die Zugangsdaten zum Konsilschein - Telekonsil:</b> <br>";
		$message		.= "Name: $userLogin <br>";
		$message		.= "PW: $userPW </p>";
		$message		.= "<p>Diese Daten k&ouml;nnen jederzeit nach dem Login unter >Eigenes Arzt-Profil< ge&auml;ndert werden. </p>";
		$message		.= "Automatisches Email aus dem PDVS<br>";
		$message		.= "Universit&auml;tsklinikum Erlangen";
		$message		.= "</body></html>";
		$headers		= 'MIME-Version: 1.0' . "\r\n";
		$headers		.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers		.= 'From: ' . $adminEMailAdresse . "\r\n";
		$subject		= 'Telekonsil - New Login - ' .  $arztLastName;
		if (@mail($adminEMailAdresse, $subject, $message, $headers) == true){
			print "<p class='erfolgsMessage'>Die Zugangsdaten wurden erfolgreich an den $administrator versandt!</p>";
			print "<p class='erfolgsMessage'>Bitte wenden Sie sich an ihn.</p>";
			print "<p class='erfolgsMessage'>Die Daten k&ouml;nnen jederzeit nach dem Login unter >Eigenes Arzt-Profil< ge&auml;ndert werden. </p>";
		} else {
		}
		userLogin('', '');
	}
}

function sendEmailLoginNotfall($requestInfos) {
	global $db_handle, $administrator,  $adminEMailAdresse;
	if (access()) {
		$timestamp	= date('d.m.y H:i');
		$info1	= $requestInfos[0];
		$info2	= $requestInfos[1];
		$info3	= $requestInfos[2];
		$message 		= "<html><head></head><body>";
		$message		.= "<p align='right'>Erlangen, den $timestamp</p>";
		$message		.= "<h1>Schlaganfall-Netzwerk mit Telemedizin in Nordbayern</h1>";
		$message		.= "<p>Es wurde der Login >Notfall< benutzt. <br>Request time: $info1 <br>IP: $info2 <br>User Agent: $info3</p>";
		$message		.= "Automatisches Email aus dem PDVS<br>";
		$message		.= "Universit&auml;tsklinikum Erlangen";
		$message		.= "</body></html>";
		$headers		= 'MIME-Version: 1.0' . "\r\n";
		$headers		.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers		.= 'From: ' . $adminEMailAdresse . "\r\n";
		if (@mail($adminEMailAdresse, 'Telekonsil - Noftall-Login benutzt ', $message, $headers) == true){
		} else {
		}
	}
}

function sendEmailAdmin($requestInfos) {
	global $db_handle, $administrator,  $adminEMailAdresse;
	if (access()) {
		$timestamp	= date('d.m.y H:i');
		$info1	= $requestInfos[0];
		$info2	= $requestInfos[1];
		$info3	= $requestInfos[2];
		$info4	= $requestInfos[3];
		$info5	= $requestInfos[4];
		$message = "
		<html>
		<head>
		</head>
		<body>
		";
		$message		.= "<p align='right'>Erlangen, den $timestamp</p>";
		$message		.= "<h1>Schlaganfall-Netzwerk mit Telemedizin in Nordbayern</h1>";
		$message		.= "<p>Anfrage an den Administrator von: $info4 <br>";
		$message		.= "Mitteilung: $info5";
		$message		.= "<br>";
		$message		.= "Request time: $info1 <br>IP: $info2 <br>User Agent: $info3</p>";
		$message		.= "Automatisches Email aus dem PDVS<br>";
		$message		.= "Universit&auml;tsklinikum Erlangen";
		$message		.= "</body></html>";
		$headers		= 'MIME-Version: 1.0' . "\r\n";
		$headers		.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers		.= 'From: ' . $adminEMailAdresse . "\r\n";
		if (@mail($adminEMailAdresse, 'Telekonsil - Frage zum PDVS ', $message, $headers) == true){
				print "<p class='erfolgsMessage'>Ihre Mitteilung: <br>'$info5'<br> wurde erfolgreich versandt!</p>";
		} else {
		}
	}
}

function getPW($userLogin) {
	global $db_handle;
	$pw = '0';
	if (access()) {
		$db_request	 = "SELECT userPW FROM logins WHERE userLogin ='$userLogin' Limit 1";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			if ($rows > 0) {
				$data	   = mysql_fetch_row($query_handle);
				$pw		 = $data[0];
			}
		} else {
			print "<p class='errorMessage'>Kein Zugriff m&ouml;glich! [getPW($userLogin)]</p>";
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank! [getPW($userLogin)]</p>";
	}
	return $pw;
}

function getUserID($userLogin) {
	global $db_handle;
	$userID = '0';
	if (access()) {
		$db_request	 = "SELECT userID FROM logins WHERE userLogin ='$userLogin' Limit 1";
		$query_handle   = mysql_query($db_request, $db_handle);
		if ($query_handle != ""){
			$rows = mysql_num_rows($query_handle);
			if ($rows > 0) {
				$data	   = mysql_fetch_row($query_handle);
				$userID	 = $data[0];
			}
		} else {
			print "<p class='errorMessage'>Kein Zugriff m&ouml;glich! [getUserID($userLogin)]</p>";
		}
	} else {
		print "<p class='errorMessage'>Kein Zugriff auf Datenbank! [getUserID($userLogin)]</p>";
	}
	return $userID;
}

function getArztInfos($arztID) {
	global $db_handle;
	if (access()) {
		$arztGender	 = getDBContent('aerzte','arztGender', 'arztID', $arztID);
		if($arztGender == 'w'){
			$arztGender = "女士";
		} else {
			$arztGender = "先生";
		}
		$titel = getDBContent('aerzte', 'acadTitle', 'arztID', $arztID);
		$vorname = getDBContent('aerzte', 'arztFirstName', 'arztID', $arztID);
		$name = getDBContent('aerzte', 'arztLastName', 'arztID', $arztID);
		$clinicID	= getDBContent('aerzte', 'clinicID', 'arztID', $arztID);
		$clinicName	= getDBContent('clinics', 'clinicName', 'clinicID', $clinicID);
		$clinicInitial = getDBContent('clinics', 'clinicInitial', 'clinicID', $clinicID);
		$tel = getDBContent('aerzte', 'arztPhone', 'arztID', $arztID);
		$arztInfos = $clinicName . ' - ' . $titel . ' ' . $vorname . ' ' . $name ;
		if ($tel <> ''){
			$arztInfos = $clinicName . ' - ' . $titel . ' ' . $vorname . ' ' . $name . ' - Tel.:  ' . $tel;
		}
		return $arztInfos;
	}
}

function getArztInfosShort($arztID) {
	global $db_handle;
	if (access()) {
		$arztGender	 = getDBContent('aerzte','arztGender', 'arztID', $arztID);
		if($arztGender == 'w'){
			$arztGender = "女士 ";
		} else {
			$arztGender = "先生  ";
		}
		$titel		  	= getDBContent('aerzte','acadTitle', 'arztID', $arztID);
		$vorname		= getDBContent('aerzte','arztFirstName', 'arztID', $arztID);
		$name		   	= getDBContent('aerzte','arztLastName', 'arztID', $arztID);
		$clinicID	   	= getDBContent('aerzte','clinicID', 'arztID', $arztID);
		$clinicName		= getDBContent('clinics','clinicName','clinicID',$clinicID);
		$clinicInitial	= getDBContent('clinics','clinicInitial','clinicID',$clinicID);
		$tel			= getDBContent('aerzte','arztPhone', 'arztID', $arztID);
		$arztInfos	  	=  $titel . ' ' . $vorname . ' ' . $name ;
		return $arztInfos;
	}
}

function getAdminID() {
	global $db_handle;
	$id = 0;
	if (access()) {
		$id  = getDBContent('aerzte','arztID', 'arztStatus', 'a');
		return $id;
	}
}
?>
