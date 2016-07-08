<?php
include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT count(incoming_id) as mail_count,recv FROM mail_corr_incoming GROUP BY recv ORDER BY mail_count DESC LIMIT 0,9");
close_db();
$total = 0;
$usernames = NULL;
$chd = "";
$values = NULL;

while($row = mysqli_fetch_array($res,MYSQL_ASSOC))
{
	$usernames [] = $row['recv'];
	$values[] = $row['mail_count'];
	
}

?>

<?php
 /*
     Example10 : A 3D exploded pie graph
 */

 // Standard inclusions   
 include("../../../pChart/pChart/pData.class");
 include("../../../pChart/pChart/pChart.class");

 // Dataset definition 
 $DataSet = new pData;
 $DataSet->AddPoint($values,"Serie1");
 $DataSet->AddPoint($usernames,"Serie2");
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(900,550);
 $Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);

 // Draw the pie chart
 $Test->setFontProperties("../../../pChart/Fonts/tahoma.ttf",8);
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,TRUE,TRUE,50,20,5);
 $Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 $Test->Render("example10.png");
 
 
?>

<table>
<tr>
	<td>
<img src="applications/service_ticket_admin/php/example10.png" width="500px" height="250"/>
</td>
</tr>
<tr>
	<td>
    	<table id="Table_01" height="40" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer; font-family:Geneva, Arial, Helvetica, sans-serif" onClick="findChart(); return false;">
	<tr>
		<td width="9" height="9" background="/images/button_01.jpg"></td>
		<td background="/images/button_02.jpg" height="9"></td>
		<td background="/images/button_03.jpg" width="9" height="9"></td>
	</tr>
	<tr>
		<td background="/images/button_04.jpg" width="9" height="22"></td>
		<td background="/images/button_05.jpg" height="22" valign="middle" align="center" style="font-weight:bold">Refresh&nbsp;Chart</td>
		<td background="/images/button_06.jpg" width="9" height="22"></td>
	</tr>
	<tr>
		<td background="/images/button_07.jpg" width="9" height="9"></td>
		<td background="/images/button_08.jpg" height="9"></td>
		<td background="/images/button_09.png" width="9" height="9"></td>
	</tr>
</table>
    </td>
</tr>
</table>