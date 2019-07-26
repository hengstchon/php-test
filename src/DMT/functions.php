<?php
//  ----------------------------------------------------------------------------
//  Patienten-Daten-Verwaltungssystem == PDVS
//  ----------------------------------------------------------------------------

//  ----------------------------------------------------------------------------
//  2012-09-15
//  Global genutzte Funktionen
//  ----------------------------------------------------------------------------
//  ----------------------------------------------------------------------------


function vardumpPre($var)  { 
// formatierte Ausgabe von Variablen for debug
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	echo "<hr>";
}

function cl($data)
{
    if (is_array($data) || is_object($data))
    {
        echo("<script>console.log('".json_encode($data)."');</script>");
    }
    else
    {
        echo("<script>console.log('".$data."');</script>");
    }
}

?>
