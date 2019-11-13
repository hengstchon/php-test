<?php
print "</div>";
print "<div id='printGrafik'>";
print "</div>";
print "<div id='nav2'>";
print "</div>";
print "
<table cellspacing='3' id='dokuInfos'>
<tr valign='top'>
<th>Datum</th>
<th>Version</th>
<th>Autor</th>
<td>Freigegeben: ZEA am $datumFreigabeZEA &nbsp; GNV am $datumFreigabeGNV  &nbsp; Projektleiter am $datumFreigabePL </td>
</tr>
<tr>
<td>$datumFreigabeGNV</td>
<td align='center'>$versionsNr</td>
<td>$author</td>
<td>G&uuml;ltigkeit: Gesamtnetz bis $gueltigkeit</td>
</tr>
</table>
";
print "</div>";
print "</body>";
print "</html>";
?>