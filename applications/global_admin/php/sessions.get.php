<?php
include("../../../php/vars.php");
open_db();
$sessions_res = mysqli_query($db,"SELECT * FROM session_tab ORDER BY logon_time");
close_db();

$bgColor = "#cccccc";
?>
<h3>Number of Sessions: <?=mysqli_num_rows($sessions_res)?></h3>
<table width="100%" class="table-condensed table-responsive table-striped table-hover">
<tr>
	<td colspan="2">
    	
    </td>
    <td id="sessionStat" align="right" colspan="3">
    </td>
</tr>
<thead>
    	<td>
        	<b>Username</b>
        </td>
        <td> 
        	<b>IP Address</b>       
        </td>
        <td>
        	<b>Current Page</b>
        </td>
        <td>
        	<b>Logon Time</b>
        </td>
        <td>
        	<b>Hrs Logged On</b>
        </td>
    </thead>
<?php
while($sessions_row = mysqli_fetch_array($sessions_res,MYSQL_ASSOC))
{
?>
	<tr>
    	<td>
        	<?=$sessions_row['username']=="-"?"[NOT LOGGED IN]":$sessions_row['username']?>
        </td>
      <td align="left">
       	<?=$sessions_row['ip']?>
      </td>
      <td align="left">
       	<?=$sessions_row['page']?>
      </td>
      <td>
      	<?=date("H:i:s a d/m/Y",strtotime($sessions_row['logon_time']))?>
      </td>
      <td>
      	<?php 
		$date_diff_array = date_diff2(strtotime($sessions_row['logon_time']),strtotime($today));
		?>
      	<?=$date_diff_array['hour']."HR ".$date_diff_array['minute']." MIN"?>
        <a href="#" class="btn btn-default btn-xs" onclick="killSession('<?=$sessions_row['ip']?>','<?=$sessions_row['username']?>')"><span class="glyphicon glyphicon-remove"></span> Kick User</a>
      </td>
    </tr>
    <?php } ?>
    
</table>

