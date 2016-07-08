<?php

?>
<table>
	<tr>
    	<td>
        	<table id="Table_01" height="40" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer; font-family:Geneva, Arial, Helvetica, sans-serif" onClick="window.location='index.php?app=mailCor&page=reports'">
	<tr>
		<td width="9" height="9" background="/images/button_01.jpg"></td>
		<td background="/images/button_02.jpg" height="9"></td>
		<td background="/images/button_03.jpg" width="9" height="9"></td>
	</tr>
	<tr>
		<td background="/images/button_04.jpg" width="9" height="22"></td>
		<td background="/images/button_05.jpg" height="22" valign="middle" align="center" style="font-weight:bold">Back To Reports</td>
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
	<tr>
    	<td>
        	<select name="month_p" id="month_p" class="black">
    <? for($i = 0;$i< 12;$i++) 
	{?>
		<option value="<?=$i+1?>" <?php if(!$isSub){ if(date("m",mktime(0,0,0,($i+2),0,0))==date("m")){ echo "selected=\"selected\""; } }else{ if($master_start[1]==date("m",mktime(0,0,0,($i+2),0,0))){ echo "selected=\"selected\""; } } ?>>
			<?=date("F",mktime(0,0,0,($i+2),0,0))?> (<?=date("n",mktime(0,0,0,($i+2),0,0))?>)
        </option>
	<? } ?>
   </select>
   <select name="day_p" id="day_p">
    <? for($i = 0;$i< 31;$i++) 
	{
	 
	?>
		<option value="<?=($i+1)?>" <?php if(!$isSub){ if(($i+1)==date("j")){ echo "selected=\"selected\""; } }else{ if($master_start[2]==($i+1)){ echo "selected=\"selected\""; } } ?>><?=($i+1)?></option>
	<? } ?>
   </select>
   <select name="year_p" id="year_p">
    <?php 
	for($i = 0,$year = date('Y');$i< 10;$i++,$year--) 
	{
		?>
		<option value="<?=$year?>" <?php if(!$isSub){ if($year==date("Y")){ echo "selected=\"selected\""; } }else{ if($master_start[0]==$year){ echo "selected=\"selected\""; } } ?>><?=$year?></option>
	<?php 
	} ?>
   </select> 
        </td>
        <td>
        	<input type="button" value="SHOW REPORT" onClick="getReport()">
        </td>
    </tr>
</table>