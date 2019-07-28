<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2011-02-24
//  Arztarbeitsplattform
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-04-26
//  2011-10-10		 	- vergessene savePatientInfos function in case 1030 & 1035 integriert
//	2011-10				- NIHSS Punkte auf einer Seite
//	2011-10-26			- function getDBContent in getDBContent umbenannt
//   					- dateieigenschaften > php, western (ISO Latin1) & <?php
//						- FCK > CKeditor iPad faehig
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
// 	2011-11-23			- neuer Server: WAMP > neusortierung, alt raus
// 	2012-03-02			- Druckbarkeit der Dokumente verbessert (case 3216,3316,3416)
//  ----------------------------------------------------------------------------

session_set_cookie_params(3600);// einstellen auf 3600 = 60 Minuten
session_start();
include_once("webfcts.php");
include_once("html_head.php");
if ($x == 10) {
	if ($userLogin <> ''){
		sendZugangsdatenEmail($userLogin);
	} else {
		userLogin('', '');
	}
} else {
	if ($x == 20) {
		if (($userEMail == 'neuerArztLogin') AND ($userLogin <> '')){
			$arztLastName	= $userLogin;
			$userLogin	= replaceSpecialCharacters($userLogin);
			$userPW		= $userLogin . date('Y');
			$userID = saveArztLoginWeb('', $userLogin, $userPW, '');
			$arztID = saveArztWeb('', '', '', '',  $arztLastName,'', '', $userID,'');
			sendEmailNewLogin($arztLastName, $userLogin, $userPW);
		} else {
			userLogin('', '');
		}
	} else {
		if (isset($_SESSION['userID']) == false) {
			if ((isset($userLogin) == false) OR ($userLogin == '')) {
				userLogin('', '');
			} else {
				if (((isset($userLogin) == true) AND ($userLogin <> '')) AND $x = 100){
				$pw = getPW($userLogin);
					if ($pw <>'0') {
						if ($pw == $userPW) {
							setSavedEmpty();
							$_SESSION['userID']	= getUserID($userLogin);
							$userID	= $_SESSION['userID'];
							$arztID	= getDBContent('aerzte', 'arztID', 'userID', $userID);
							$_SESSION['arztID'] 	= $arztID;
							$arztInfos				= getArztInfos($arztID);
							if ($userLogin == 'notfall'){
								$timestamp = $_SERVER['REQUEST_TIME'];
								$datum = date("d.m.Y",$timestamp);
								$uhrzeit = date("H:i:s",$timestamp);
								$requestTime	=  $datum . " - " . $uhrzeit . " Uhr";
								$requestInfos	= array($requestTime,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);
								 sendEmailLoginNotfall($requestInfos);
							}
						} else {
							print "<p class='errorMessage'>";
							print "Die von Ihnen eingegebene Benutzername und Passwort Kombination exitiert nicht (Login-Fehlermeldung: 1). ";
							print "Bitte wenden Sie sich direkt an $administrator.</p>";
							userLogin($userLogin, $userPW);
						}
					} else {
						print "<p class='errorMessage'>";
						print "Die von Ihnen eingegebene Benutzername und Passwort Kombination exitiert nicht (Login-Fehlermeldung: 2). ";
						print "Bitte wenden Sie sich direkt an $administrator.";
						print "</p>";
						userLogin($userLogin, $userPW);
					}
				}
			}
		}
	}
}
if (isset($_SESSION['userID']) == true) {
	$userID	= $_SESSION['userID'];
	if ($_SESSION['userID'] <>'') {
		if ($x == 200) {
			$_SESSION['userID'] = '';
			$_SESSION['arztID'] = '';
			session_unset();
			session_destroy();
			print "您已离开受保护的工作区。<br>";
			userLogin('', '');
		} else {
			$xWas = $_SESSION['xWas'];
			if ($xWas <> $x) {
				setSavedEmpty();
			} else {
			}
			$arztID					= $_SESSION['arztID'];
			$arztInfos				= getArztInfos($arztID);
			$arztName				= getDBContent('aerzte','arztLastName','arztID',$arztID);
			if ((($x == 3316) OR ($x == 3216)) OR (($x == 3416) OR ($x == 3416))){
				print "<div id='infoOben'>";
				print "日期: $datum, ";
				print "已登录: $arztInfos";
				print "</div>";
			} else {
				print "<div id='infoOben'>";
				print "<form method='post' action='verwaltung.php'>";
				print "<input type='hidden' name='x' value='200' />";
				print "<input type='submit' value='退出'  class='logout' />";
				print "</form>";
				print "日期: $datum, ";
				print "已登录: $arztInfos";
				print "</div>";
				navigation();
			}
			print "<div class='clear'></div>";
			$case	= 'web';
			if ($x == 100){
				if ($arztName == ''){
					print "<h1>Bitte Profil vervollst&auml;ndigen</h1>";
					editArztWeb();
				} else {
					print "<h1><img src='imagesLayout/blinkenRot.gif'> 未处理 - 诊断文件</h1>";
					listAllPatientsRecords('o') ;
				}
			}
			print "<div class='clear'></div>";
			if (($x >= 1000) and ($x < 9000)) {
				switch ($x) {
					case 1000:
						print "<h1>新患者</h1>";
						print "<fieldset>";
						print "<legend>创建新患者</legend>";
						print "<form method='post' action='verwaltung.php'>";
						print "<input type='hidden' name='x' value='1010' />";
						print "<p>输入患者的姓氏: <input type='text' name='pLastName' /></p>";
						print "<p><input type='submit' value='登记患者'  class='buttonHome' /></p>";
						print "</form>";
						print "</fieldset>";
						print "<hr size='1' noshade>";
						include_once("DMT/search.php");
						searchPatientMenu();
						print "<div class='clear'></div>";
					break;
					case 1010:
						$pLastName	= $pLastName;
						$exists = checkpLastNameExists($pLastName);
						if($exists  == 1){
							listPatients($pLastName);
						} else {
							$addOption	= $_SESSION['addOption'];
							if ($addOption == 0){
								$pDataArray	= array('', '', $pLastName, '', '', '', '', '', '', '', '', '', '');
								$patientID	= savePatient($pDataArray);
								print "<h1>患者资料 - 输入(编辑)</h1>";
								print "<form method='Post' action='verwaltung.php'>";
								print "<fieldset>";
								print "<input type='hidden' name='x' value='1030' />";
								editPatientAndDiagnose($patientID);
								print "<input type='submit' value=' >>> 诊断文件 保存 >>> ' class='buttonHome' />";
								print "</fieldset>";
								print "</form>";
							} else {
								print "<h1><img src='imagesLayout/blinkenRot.gif'> 未处理 - 诊断文件</h1>";
								listAllPatientsRecords('o') ;
							}
						}
					break;
					case 1015:
						$addOption	= $_SESSION['addOption'];
						if ($addOption == 0){
							$pDataArray	= array('', '', $pLastName, '', '', '', '', '', '', '', '', '', '');
							$patientID	= savePatient($pDataArray);
							print "<h1>患者资料 - 输入(编辑)</h1>";
							print "<form method='Post' action='verwaltung.php'>";
							print "<fieldset>";
							print "<input type='hidden' name='x' value='1030' />";
							editPatientAndDiagnose($patientID);
							print "<input type='submit' value=' >>> 诊断文件 保存 >>> ' class='buttonHome' />";
							print "</fieldset>";
							print "</form>";
						} else {
							print "<h1><img src='imagesLayout/blinkenRot.gif'> 未处理 - 诊断文件</h1>";
							listAllPatientsRecords('o') ;
						}
					break;
					case 1020:
						if ($patientID == ''){
							print "<h1>患者 - 调查</h1>";
							print "<p class='errorMessage'>Es wurde kein Patient ausgew&auml;hlt.</p>";
							listAllPatients($capitalLetter);
						} else {
							print "<h1>患者资料 - 输入(编辑)</h1>";
							print "<form method='Post' action='verwaltung.php'>";
							print "<fieldset>";
							print "<input type='hidden' name='x' value='1033' />";
							editPatient($patientID);
							print "<input type='submit' value=' >>>保存  >>> ' class='buttonHome' />";
							print "</fieldset>";
							print "</form>";
							navPatient($patientID);
						}
					break;
					case 1025:
						print "<h1>$diagnoseButton 输入</h1>";
						print "<fieldset>";
						showPatient($patientID);
						print "<form method='Post' action='verwaltung.php'>";
						print "<input type='hidden' name='x' value='1035' />";
						hiddenTherapyFields($patientRecordID);
						editPatientRecordDiagnose($patientRecordID);
						print "<input type='submit' value=' >>> 诊断文件 保存 >>> ' class='buttonHome' />";
						print "</fieldset>";
						print "</form>";
						navPatient($patientID);
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
						include_once("DMT/search.php");
						searchAll($search);
						addPatientForm('');
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
						print "<h1>患者 - 调查</h1>";
						listAllPatients($capitalLetter);
					break;
					case 3200:
						include_once("DMT/nihss.php");
						print "<fieldset>";
						showPatient($patientID);
						editPatientNIHSSWerte($pnID);
						print "</fieldset>";
						navPatient($patientID);
					break;
					case 3215:
						include_once("DMT/nihss.php");
						print "<fieldset>";
						showPatient($patientID);
						showPatientNIHSSWerte($pnID);
						print "</fieldset>";
						print "<div id='ks'>";
						print "<hr>";
						print "<h3>诊断文件的补充修改:</h3>";
						editNIHSSForm($patientID, $pnID) ;
						print "<hr></div><br />";
						navPatient($patientID);
					break;
					case 3216:
						include_once("DMT/nihss.php");
						showPatient($patientID);
						showPatientNIHSSWerte($pnID);
					break;
					case 3220:
						include_once("DMT/nihss.php");
						print "<fieldset>";
						showPatient($patientID);
						$addOption	= $_SESSION['addOption'];
						if ($addOption == 0){
							$pnID = savePatientNIHSS($patientID,$patientRecordID);
							editPatientNIHSSWerte($pnID);
						}
						print "</fieldset>";
						navPatient($patientID);
					break;
					case 3235:
						include_once("DMT/nihss.php");
						print "<fieldset>";
						showPatient($patientID);
						savePatientNIHSSWerte($pnID,$pWerteArray);
						showPatientNIHSSWerte($pnID);
						print "</fieldset>";
						print "<div id='ks'>";
						printNIHSSForm($patientID, $pnID) ;
						print "</div>";
						navPatient($patientID);
					break;
					case 3300:
						editPatientRecordTherapy($patientRecordID);
						print "<div id='ks'>";
						print "<hr>";
						print "<h3>诊断文件的补充修改:</h3>";
						editRecordForm($patientID, $patientRecordID);
						print "<hr></div><br />";
						navPatient($patientID);
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
						print "</fieldset>";
						print "<div id='ks'>";
						print "<hr>";
						print "<h3>诊断文件的补充修改:</h3>";
						editRecordForm($patientID, $patientRecordID);
						print "<hr></div><br />";
						navPatient($patientID);
					break;
					case 3316:
						showPatient($patientID);
						showPatientRecord($patientRecordID);
					break;
					case 3320:
						$addOption	= $_SESSION['addOption'];
						if ($addOption == 0){
							$patientRecordID = savePatientRecord($pRecordDataArray);
							print "<fieldset>";
							showPatient($patientID);
							print "<form method='Post' action='verwaltung.php'>";
							print "<input type='hidden' name='x' value='1035' />";
							hiddenTherapyFields($patientRecordID);
							editPatientRecordDiagnose($patientRecordID);
							print "<input type='submit' value=' >>> 诊断文件 保存 >>> ' class='buttonHome' />";
							print "</form>";
							print "</fieldset>";
						} else {
							print "<fieldset>";
							showPatient($patientID);
							listPatientRecords($patientID);
							print "</fieldset>";
						}
					break;
					case 3400:
						editPatientThrombolyseWeb($ptID);
						navPatient($patientID);
					break;
					case 3410:
						print "<h1>Thrombolyse Dokumentation</h1>";
						print "<fieldset>";
						showPatient($patientID);
						savePatientWeight($patientRecordID, $pGewicht, $pGroesse);
						saveTimeErstContact($patientRecordID, $timeInitialContact);
						savePatientThrombolyseWeb($ptID,$ptWerteArray);
						showPatientThrombolyseWerteWeb($ptID);
						print "</fieldset>";
						print "<div id='ks'>";
						print "<hr>";
						print "<h3>诊断文件的补充修改:</h3>";
						editThrombolyseForm($patientID, $ptID);
						print "<hr></div><br />";
						navPatient($patientID);
					break;
					case 3415:
						print "<h1>Thrombolyse Dokumentation</h1>";
						print "<fieldset>";
						showPatient($patientID);
						showPatientThrombolyseWerteWeb($ptID);
						print "</fieldset>";
						print "<div id='ks'>";
						print "<hr>";
						print "<h3>诊断文件的补充修改:</h3>";
						editThrombolyseForm($patientID, $ptID);
						print "<hr></div><br />";
						navPatient($patientID);
					break;
					case 3416:
						print "<h1>Thrombolyse Dokumentation</h1>";
						showPatient($patientID);
						showPatientThrombolyseWerteWeb($ptID);
					break;
					case 3420:
						$addOption	= $_SESSION['addOption'];
						if ($addOption == 0){
							$ptID = savePatientThrombolyseWeb('',$ptWerteArray);
							editPatientThrombolyseWeb($ptID);
						}
						navPatient($patientID);
					break;
					case 3999:
						print "<fieldset>";
						showPatient($patientID);
						print "<div class='clear'></div>";
						listPatientRecords($patientID);
						print "</fieldset>";
					break;
					case 4000:
						print "<h1>Eigenes Arzt-Profil</h1>";
						editArztWeb();
					break;
					case 4110:
						print "<div class='clear'></div>";
						saveArztLoginWeb($userID, $userLogin, $userPW, $userEMail);
						saveArztWeb($arztID, $arztGender, $acadTitle, $arztFirstName, $arztLastName, $arztPhone, $arztComment, $userID, $clinicID);
						showArztWeb();
					break;
					case 4200:
						print "<h1>Kontakt zum Administrator</h1>";
						print "<fieldset>";
						print "<form method='post' action='verwaltung.php'>";
						print "<p>Hier koennen Sie eine Nachricht an den Administrator $administrator senden.</p>";
						print "<input type='hidden' name='x' value='4210' />";
						print "Mitteilung: <textarea name='arztComment' cols='45' rows='5'></textarea>";
						print "<p>Absender: $arztInfos</p>";
						print "<input type='submit' value='Anfrage an den Administrator $administrator senden' class='buttonHome' />";
						print "</form>";
						print "</fieldset>";
						print "<div class='clear'></div>";
					break;
					case 4210:
						$timestamp = $_SERVER['REQUEST_TIME'];
						$datum = date("d.m.Y",$timestamp);
						$uhrzeit = date("H:i:s",$timestamp);
						$requestTime	=  $datum . " - " . $uhrzeit . " Uhr";
						$requestInfos	= array($requestTime,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'], $arztInfos, $arztComment);
						sendEmailAdmin($requestInfos);
					break;
				}
			}
		}
	}
	require("html_end.php");
} else {
	print "</div>";
	print "<div id='nav2'>";
	print "</div>";
	print "</div>";
	print "</body>";
	print "</html>";
}
?>
