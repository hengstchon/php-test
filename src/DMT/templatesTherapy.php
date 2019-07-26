<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  Templates fuer die Beurteilung und Therapieempfehlung
//  ----------------------------------------------------------------------------
// 	Change history:
//  ----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
class Therapytemplate {
	private $tT_ID;
	private $tT_title;
	private $tT_text;
	private $tT_pos;
	private $tT_status;
	private $tTg_ID;
	
	public function setID($tT_ID){
		$this->tT_ID = $tT_ID;
	}

	public function getID(){
		return $this->tT_ID;
	}

	public function setTitle($tT_title){
		$this->tT_title = $tT_title;
	}

	public function getTitle(){
		return $this->tT_title;
	}

	public function setText($tT_text){
		$this->tT_text = $tT_text;
	}

	public function getText(){
		return $this->tT_text;
	}

	public function setPos($tT_pos){
		$this->tT_pos = $tT_pos;
	}

	public function getPos(){
		return $this->tT_pos;
	}

	public function setStatus($tT_status){
		$this->tT_status = $tT_status;
	}

	public function getStatus(){
		return $this->tT_status;
	}

	public function setID_tTg($tTg_ID){
		$this->tTg_ID = $tTg_ID;
	}

	public function getID_tTg(){
		return $this->tTg_ID;
	}

	public function getEntry($tT_ID){
		$entry = '';
		if (access()) {
			$db_request	= "Select * from `templatesTherapy` WHERE tT_ID = '$tT_ID'";						
			$query_handle   = mysql_query($db_request);
			if ($query_handle != ""){
				$rows	= mysql_num_rows($query_handle);
				if($rows > 0 ) {
					$entry	= mysql_fetch_object($query_handle,'self');
				}
			}
		}
		return $entry;
	}

	public function getAllEntries($tT_status){
		$entries = "";
		if (access()) {
			if ($tT_status == '')
			{
				$db_request	= "
				Select * 
				from `templatesTherapy` as tT 
				JOIN `tTGruppen` as tTg 
				ON tT.tTg_ID = tTg.tTg_ID
				ORDER BY tTg.tThG_ID, tTg_pos, tT_pos"; 
			} else {
				$db_request	= "
				Select * 
				from `templatesTherapy`  as tT
				JOIN `tTGruppen` as tTg 
				ON tT.tTg_ID = tTg.tTg_ID
				WHERE tT.tT_status = '$tT_status' 
				ORDER BY tTg.tThG_ID, tTg_pos, tT_pos"; 
			}
			$query_handle   = mysql_query($db_request);
			if ($query_handle != ""){
				while ($data = mysql_fetch_object($query_handle,'self')) {
					$entries[] = $data;
				}
			}
		}
		return $entries;
	}
}
?>