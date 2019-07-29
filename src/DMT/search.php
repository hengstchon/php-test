<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------
//
//  ----------------------------------------------------------------------------
//  2011-10-27
//  Patienten-Such-Funktionen - DMT und web
//  im web und dmt verwendet > wenn notwendig, case uebergeben
//  ----------------------------------------------------------------------------
// 	Change history:
//	Bisheriger Stand 	- lezter Arbeitstag in der Entwicklung: 2011-11-15
//	2011-11-17		  	- umstellung auf utf-8 inklusive dateieigenschaften
//  ----------------------------------------------------------------------------
// --- variables ---------------------------------------------------------------
// search zusammenstellen







$from		= getPOSTAndGETData('from');
$to			= getPOSTAndGETData('to');
if ($from == ''){
	$from = $to;
}
if ($to == ''){
	$to = $from;
}
$name		= getPOSTAndGETData('name');
$pBdayDayS	= getSecurePOSTAndGETData('pBdayDayS');
$pBdayMonthS= getSecurePOSTAndGETData('pBdayMonthS');
$pBdayYearS	= getSecurePOSTAndGETData('pBdayYearS');
$arzt		= getPOSTAndGETData('arzt');
$search		= array($from, $to, $name, $pBdayDayS, $pBdayMonthS, $pBdayYearS , $arzt) ;
$column		= getPOSTAndGETData('column');
$what		= getPOSTAndGETData('what');
if ($case == 'dmt'){
	print "<script type='text/javascript' src='calendar/CalendarControl.js'></script>";
	print "<link rel='stylesheet' href='calendar/CalendarControl.css' type='text/css'>";
}
if ($case == 'web'){
	print "<script type='text/javascript' src='DMT/calendar/CalendarControl.js'></script>";
	print "<link rel='stylesheet' href='DMT/calendar/CalendarControl.css' type='text/css'>";
}

function searchPatientMenu(){
	global $db_handle, $case;
	if ($case == 'dmt'){
		$form	= "<form method='post' action='DMT.php'>";
	}
	if ($case == 'web'){
		$form	= "<form method='post' action='verwaltung.php'>";
	}
	print "<a name='suchen'></a>";
	print "<fieldset style='margin:20px 0px 20px 0px;width:420px;float:left;'>";
	print "<legend>搜索</legend>";
	print "<div style='float:left;border: 1px dotted #999;margin: 3px 5px 0 0;padding: 3px;width:300px;'>";
	print $form;
	print "<input type='hidden' name='x' value='1100' />";
	print "<table cellpadding='0' cellspacing='1' border='0' width='100%'>";
	print "<tr><td><b>患者姓名:</b></td><td><input type='text' name='name' /></td></tr>";
    print "<tr><td colspan='2'><b>生日:</b> ";
	print "<select name='pBdayDayS'>";
	print "<option selected value=''>日</option>";
	for ($i = 1; $i <= 31; $i++) {
		if ($i < 10) {
			print "<option value='0$i'>0$i</option>";
		} else {
			print "<option value='$i'>$i</option>";
		}
	}
	print "</select>";
	print "<select name='pBdayMonthS'>";
	print "<option selected value=''>月</option>";
	for ($i = 1; $i <= 12; $i++) {
		$mName = monthName($i);
		if ($i < 10) {
			print "<option value='0$i'>$mName</option>";
		} else {
			print "<option value='$i'>$mName</option>";
		}
	}
	print "</select>";
	print "<select name='pBdayYearS'>";
	print "<option value=''>年</option>";
	$currentYear = date('Y') ;
	$startjahr	= $currentYear - 110 ;
	for ($i=0; $i < 110; $i++){
		$year = $startjahr + $i;
		print "<option value='$year'>$year</option>";
	}
	print "</select></td></tr>";
    print "<tr><td colspan='2'><hr></td></tr>";
    print "<tr><td colspan='2'><b>入院</b><br /> ";
	print "从: <input name='from' 	onfocus='showCalendarControl(this);' type='text' size='12' /> ";
	print "到: <input name='to' 	onfocus='showCalendarControl(this);' type='text' size='12' /></td></tr>";
    print "<tr><td colspan='2'><hr></td></tr>";
	print "<tr><td width='50%'><b>推荐人:</b></td><td>";
				print "<select name='arzt'>";
				print "<option value=''  selected>请选择</option>";
				$db_request2	 = "SELECT arztID, arztLastName FROM aerzte  ORDER BY arztLastName";
				$query_handle2   = mysql_query($db_request2, $db_handle);
				if ($query_handle2 != "") {
					$rows2 = mysql_num_rows($query_handle2);
					for ($i2 = 0; $i2 < $rows2; $i2++){
						$data2 = mysql_fetch_row($query_handle2);
						$id			= $data2[0];
						$arztLastName	= $data2[1];
						$info		= getArztInfosShort($id);
						print "<option value='$arztLastName'>$info</option>";
					}
				} else {
				}
				print "</select>";
	print "</td></tr>";
	print "</table>";
	print "<input type='submit' value='搜索'  style='width:100%;' class='buttonMini' />";
	print "</form>";
	print "</div>";
	print "<div style='float:left;border: 1px dotted #999;margin: 3px;padding: 5px 3px;'>";
	print "<b class='mini'>入院 </b><br /> ";
	searchYesterdayButton();
	searchTodayButton();
	print "</div>";
	print "</fieldset>";
	print "<div class='clear'></div>";
}

function searchYesterdayButton(){
	global $case;
	if ($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if ($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	$from	= date('Y.m.d', time()-(60*60*24));;
	print "<input type='hidden' name='x' value='1100' />";
	print "<input type='hidden' name='from' value='$from' />";
	print "<input type='submit' value='昨天'  class='buttonMini' style='width:80px;' />";
	print "</form>";
}

function searchTodayButton(){
	global $case;
	if ($case == 'dmt'){
		print "<form method='post' action='DMT.php'>";
	}
	if ($case == 'web'){
		print "<form method='post' action='verwaltung.php'>";
	}
	$from	= date("Y.m.d");
	print "<input type='hidden' name='x' value='1100' />";
	print "<input type='hidden' name='from' value='$from' />";
	print "<input type='submit' value='今天'  class='buttonMini' style='width:80px;'  />";
	print "</form>";
}

function searchAll($search) {
	global $db_handle;
	global $case;
	if (access()) {
		$patientIDs 	= array();
		$arztIDs		= array();
		$patientIDOld	= '';
		$pBdayDB		= $search[5] . '-' . $search[4] . '-' . $search[3];
		$pBdayT			= $search[3]. '. ' . monthName($search[4]) . ' ' . $search[5];
		print "<h3>搜索</h3>";
		if ((((((($search[0] <> '') OR ($search[1] <> '')) OR ($search[2] <> '')) OR ($search[3] <> '')) OR ($search[4] <> '')) OR ($search[5] <> '')) OR ($search[6] <> '')){
			print "<b style='float:left;margin-right: 25px;'>搜索条件:</b> ";
		}
		print "<ul>";
		if ($search[0] <> ''){
			print "<li style='float:left;margin-right: 25px;'>时间从 $search[0] 到 $search[1]</li>";
		}
		if ($search[2] <> ''){
			print "<li style='float:left;margin-right: 25px;'>患者姓名: $search[2]</li>";
		}
		if ((($search[3] <> '') AND ($search[4] <> '')) AND ($search[5] <> '')){
			$monat 	= monthName($search[4]);
			print "<li style='float:left;margin-right: 25px;'>Geburtstagdatum: $search[3]. $monat $search[5]</li>";
		} else {
			if ($search[3] <> ''){
				print "<li style='float:left;margin-right: 25px;'>Geburtstag-Tag: $search[3]</li>";
			}
			if ($search[4] <> ''){
				$monat 	= monthName($search[4]);
				print "<li style='float:left;margin-right: 25px;'>Geburtstag-Monat: $monat</li>";
			}
			if ($search[5] <> ''){
				print "<li style='float:left;margin-right: 25px;'>Geburtstag-Jahr: $search[5]</li>";
			}
		}
		if ($search[6] <> ''){
			print "<li style='float:left;margin-right: 25px;'>Arztname: $search[6]</li>";
		}
		print "</ul>";
		print "<div class='clear'></div>";
		if ($search[2] <> ''){
			if ((($search[3] <> '') AND ($search[4] <> '')) And ($search[5] <> '')){
				$db_request1	 = "SELECT * FROM patients WHERE pBday = '$pBdayDB' AND MATCH (pLastName) AGAINST ('$search[2]*' IN BOOLEAN MODE) OR pLastName LIKE '%$search[2]%' ORDER by pLastName, pBday";
			} else {
				$db_request1	 = "SELECT * FROM patients WHERE MATCH (pLastName) AGAINST ('$search[2]*' IN BOOLEAN MODE) OR pLastName LIKE '%$search[2]%' ORDER by pLastName, pBday";
			}
		} else {
			if ((($search[3] <> '') AND ($search[4] <> '')) And ($search[5] <> '')){
				$db_request1	 = "SELECT * FROM patients WHERE pBday = '$pBdayDB'  ORDER by pLastName, pBday";
			} else {
				$db_request1	 = "SELECT * FROM  patients ORDER by pLastName";
			}
		}
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1!= ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 > 0){
				for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1		  	= mysql_fetch_object($query_handle1);
					$patientID	  	= $data1 -> patientID;
					$patientIDs[$i1]= $patientID;
				}
			}
		}
		if ($search[6] <> ''){
			$db_request1	 = "SELECT * FROM aerzte WHERE arztLastName ='$search[6]'";
			$query_handle1   = mysql_query($db_request1, $db_handle);
			if ($query_handle1 != ""){
				$rows1 = mysql_num_rows($query_handle1);
				if ($rows1 > 0){
					for ($i1 = 0; $i1 < $rows1; $i1++){
						$data1		  	= mysql_fetch_object($query_handle1);
						$arztIDs[$i1]	= $data1 -> arztID;
					}
				} else {
					print "<p class='hint'>Kein Arzt mit diesem Namen auffindbar</p>";
				}
			} else {
				print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [searchAll - query_handle 1 - arzt > arztIDs]</p>";
			}
		}
		if ($search[0] <> ''){
			$from		= explode('.', $search[0]);
			$fromD		= $from[0];
			$fromM		= $from[1];
			$fromY		= $from[2];
			$from		= $fromY . '-' . $fromM . '-' . $fromD;
		} else {
			$from		= '';
		}
		if ($search[0] <> ''){
			$to			= explode('.', $search[1]);
			$toD		= $to[0];
			$toM		= $to[1];
			$toY		= $to[2];
			$to			= $toY . '-' . $toM . '-' . $toD ;
		} else {
			$to		= '';
		}
		print "<fieldset>";
		if (count($patientIDs) > 0) {
			print "<legend>选择患者：</legend>";
			if ($case == 'dmt'){
				print "<form method='post' action='DMT.php'>";
			}
			if ($case == 'web'){
				print "<form method='post' action='verwaltung.php'>";
			}
			print "<input type='hidden' name='x' value='1020' />";
			print "<ol style='line-height:190%;'>";
			foreach ($patientIDs as $key => $patientID){
				$print = false;
				$db_request1	= "SELECT * FROM patientRecords WHERE patientID = '$patientID' ";
				$query_handle1   = mysql_query($db_request1, $db_handle);
				if ($query_handle1 != ""){
					$rows1 = mysql_num_rows($query_handle1);
					if ($rows1 > 0){
						for ($i1 = 0; $i1 < $rows1; $i1++){
							$data1		  	= mysql_fetch_object($query_handle1);
							$patientRecordID= $data1 -> patientRecordID;
							$timeHospital	= $data1 -> timeHospital;
							$diagnosisArztID= $data1 -> diagnosisArztID;
							$timeHospital	= explode(' ', $timeHospital);
							$timeHospital	= $timeHospital[0];
							if (($from <> '')  AND (count($arztIDs) == 0)){
								if (($timeHospital >= $from) AND ($timeHospital <= $to)){
									$print = true;
								}
							} else {
								$print = true;
							}
							if ((count($arztIDs) > 0) AND ($from == '')) {
								foreach ($arztIDs as $key => $arztID){
									if ($diagnosisArztID == $arztID) {
										$print = true;
									} else {
										$print = false;
									}
								}
							}
							if ((count($arztIDs) > 0) AND ($from <> '')) {
								foreach ($arztIDs as $key => $arztID){
									if ($diagnosisArztID == $arztID) {
										if (($timeHospital >= $from) AND ($timeHospital <= $to)){
											$print = true;
										} else {
											$print = false;
										}
									} else {
										$print = false;
									}
								}
							}
							$print2 = false;
							if ($patientID <> $patientIDOld) {
								if ($print){
									$patientIDOld	= $patientID;
									$db_request3	 = "SELECT * FROM  patients  WHERE patientID = '$patientID'";
									$query_handle3   = mysql_query($db_request3, $db_handle);
									if ($query_handle3 != ""){
										$rows3 = mysql_num_rows($query_handle3);
										if ($rows3 > 0){
											$data3		  	= mysql_fetch_object($query_handle3);
											$patientID	  	= $data3 -> patientID;
											$pFirstName	 	= $data3 -> pFirstName;
											$pLastName	  	= $data3 -> pLastName;
											$pBday	 		= $data3 -> pBday;
											$pStreet		= $data3 -> pStreet;
											$pZipCode	 	= $data3 -> pZipCode;
											$pCity			= $data3 -> pCity;
											$pPhone 		= $data3 -> pPhone;
											$pGender	 	= $data3 -> pGender;
											if($pGender == 'w'){
												$pGender = "女士 ";
											} else {
												$pGender = "先生  ";
											}
											$pFirstName		= schreibweise($pFirstName);
											$pLastName		= schreibweise($pLastName);
											$pCity			= schreibweise($pCity);
											$pBday1			=	explode('-',$pBday);
											$pBdayYear		=	$pBday1[0];
											$pBdayMonth		=	$pBday1[1];
											$pBdayDay		=	$pBday1[2];
											$what2 = explode(' ',$search[2]);
											if (is_array($search[2])){
												foreach($what2 as $i => $what3){
													$pLastName      = str_ireplace($what3, "<b>" . substr($what3,0,1) . substr($what3, 1) . "</b>", $pLastName);
												}
											} else {
												$pLastName      = str_ireplace($search[2], "<b>" . substr($search[2],0,1) . substr($search[2], 1) . "</b>", $pLastName);
										   }
											$info = '';
											if ((($search[3] <> '') OR ($search[4] <> '')) OR ($search[5] <> '')){
												if ($pBdayDay	== $search[3]){
													$info	.= '日';
													$print2 = true;
													$pBdayDay	= '<b>' . $pBdayDay . '</b>';
												}
												if ($pBdayMonth	== $search[4]){
													if ($print2){
														$info	.= ' & Monat';
													} else {
														$info	.= '月';
													}
													$print2 = true;
													$pBdayMonth	= '<b>' . $pBdayMonth . '</b>';
												}
												if ($pBdayYear	== $search[5]){
													if ($print2){
														$info	.= ' & Jahr';
													} else {
														$info	.= '年';
													}
													$print2 = true;
													$pBdayYear	= '<b>' . $pBdayYear . '</b>';
												}
												$info	= " <span class='mini'>&Uuml;bereinstimmung:<b> " . $info . "</b></span>";
											} else {
												$print2 = true;
											}
											if ($print2){
												print "<li style='margin-bottom:5px;'>";
												print "<input type='radio' name='patientID' value='$patientID' /> ";
												print "$pGender $pLastName,  $pFirstName (出生日期: $pBdayDay.$pBdayMonth.$pBdayYear$info)";
												$db_request3	 = "SELECT  * FROM patientRecords WHERE patientID = '$patientID' ORDER by patientRecordID DESC";
												$query_handle3   = mysql_query($db_request3, $db_handle);
												if ($query_handle3 != ""){
													$rows3 = mysql_num_rows($query_handle3);
													for ($i3 = 0; $i3 < $rows3; $i3++){
														$data3		  = mysql_fetch_object($query_handle3);
														$patientRecordID= $data3 -> patientRecordID;
														$timeHospital	= $data3 -> timeHospital;
														$editStatus		= $data3 -> editStatus;
														$timeHospital	= strtotime($timeHospital);
														$timeHospital	= date("Y.m.d",$timeHospital) ;
														if ($editStatus == 'o'){
															$editStatus = "未处理";
														} else {
															$editStatus = "已处理";
														}
														print "<span class='mini'>";
														if( ($i3 <> 0) AND ($i3 < $rows3)){
															print " || ";
														} else {
														}
														print " $timeHospital";
														print " ($editStatus)";
														print "</span>";
													}
												}
												print "</li>";
											}
										}
									} else {
										print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [searchAll - query_handle 3 - patient data]</p>";
									}
								}
							}
						}
					}
				}
			}
			if ((($search[3] <> '') OR ($search[4] <> '')) OR ($search[5] <> '')){
				print "<hr>";
				print "<b>Patienten ohne Angabe des Geburtsdatums:</b>";
				searchPatientpBDayEmpty();
				print "<hr>";
			}
			print "</ol>";
			print "<input type='submit' value='选择选定的患者' class='buttonHome' />";
			print "</form>";
		} else {
			print "<h4>Keine Patienteneintr&auml;ge vorhanden</h4>";
		}
		print "</fieldset>";
	}
}

function searchPatientpBDayEmpty() {
	global $db_handle;
	if (access()) {
		$db_request1	 = "SELECT * FROM patients WHERE pBday = '0000-00-00'  ORDER by pLastName, pBDay";
		$query_handle1   = mysql_query($db_request1, $db_handle);
		if ($query_handle1 != ""){
			$rows1 = mysql_num_rows($query_handle1);
			if ($rows1 > 0){
				for ($i1 = 0; $i1 < $rows1; $i1++){
					$data1		  	= mysql_fetch_object($query_handle1);
					$patientID	  	= $data1 -> patientID;
					$pFirstName	 	= $data1 -> pFirstName;
					$pLastName	  	= $data1 -> pLastName;
					$pStreet		= $data1 -> pStreet;
					$pZipCode	 	= $data1 -> pZipCode;
					$pCity			= $data1 -> pCity;
					$pPhone 		= $data1 -> pPhone;
					$pGender	 	= $data1 -> pGender;
					if($pGender == 'w'){
						$pGender = "女士 ";
					} else {
						$pGender = "先生  ";
					}
					$pFirstName		= schreibweise($pFirstName);
					$pLastName		= schreibweise($pLastName);
					$pCity			= schreibweise($pCity);
					$pBdayDay	= '<b>00</b>';
					$pBdayMonth	= '<b>00</b>';
					$pBdayYear	= '<b>0000</b>';
					print "<li style='margin-bottom:5px;'>";
					print "<input type='radio' name='patientID' value='$patientID' /> ";
					print "$pGender $pLastName,  $pFirstName (出生日期: $pBdayDay.$pBdayMonth.$pBdayYear)";
					$db_request3	 = "SELECT  * FROM patientRecords WHERE patientID = '$patientID' ORDER by patientRecordID DESC";
					$query_handle3   = mysql_query($db_request3, $db_handle);
					if ($query_handle3 != ""){
						$rows3 = mysql_num_rows($query_handle3);
						for ($i3 = 0; $i3 < $rows3; $i3++){
							$data3		  = mysql_fetch_object($query_handle3);
							$patientRecordID= $data3 -> patientRecordID;
							$timeHospital	= $data3 -> timeHospital;
							$editStatus		= $data3 -> editStatus;
							$diagnosisArztID= $data3 -> diagnosisArztID;
							$therapyArztID  = $data3 -> therapyArztID;
							$diagnosisArzt	= getArztInfosShort($diagnosisArztID);
							$therapyArzt	= getArztInfosShort($therapyArztID);
							$timeHospital	= strtotime($timeHospital);
							$timeHospital	= date("Y.m.d",$timeHospital) ;
							if ($editStatus == 'o'){
								$editStatus = "未处理";
							} else {
								$editStatus = "已处理";
							}
							if( ($i3 <> 0) AND ($i3 < $rows3)){
								print " || ";
							} else {
							}
							print "<span class='mini'>";
							print "  $timeHospital";
							print " ($editStatus)";
							print "</span>";
						}
					}
					print "</li>";
				}
			}
		} else {
			print "<p class='errorMessage'>Datenbankabfrage nicht erfolgreich! [ searchPatientpBDayEmpty()]</p>";
		}
	}
}
?>
