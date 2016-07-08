<table width="100%" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">

<tr>

<td>

<?php

if(empty($_REQUEST['serial']))
{
	die("Please Enter Serial to Search");
}

$serial = $_REQUEST['serial'];

@include("../../../php/vars.php");
$count = 0;
open_db();
$inventory_res = mysqli_query($db,"SELECT * FROM inventory_item_tab WHERE ((UPPER(serial_num) LIKE UPPER('$serial%')) OR (UPPER(series_code) LIKE UPPER('$serial%')))  AND item_type_id = 1");
close_db();


while($inventory_row = mysqli_fetch_array($inventory_res))
{
?>

<table style="border-bottom:1px #999999 dashed" cellpadding="0" cellspacing="0" width="100%" id="user_<?=$username?>" onmouseover="this.style.backgroundColor='#FF9900'" onmouseout="this.style.backgroundColor=''">
	<tr>
		<td style="cursor:pointer" height="50" background="/images/bgz/list_bg_50.jpg" onclick="insertInv_st(<?=$count?>); return false;">
          	<?=$inventory_row['descrp']?><br>
            <font color="#999999"><b>S/N:</b> <?=$inventory_row['serial_num']?></font><br>
            <font color="#999999"><b>S/C:</b> <?=$inventory_row['series_code']?></font>             
  		</td>
    </tr>
</table>
	<input type="hidden" value="<?=$inventory_row['serial_num']?>" id="serial_pick_<?=$count?>" />
    <input type="hidden" value="<?=$inventory_row['series_code']?>" id="mwh_serial_pick_<?=$count?>" />
    <input type="hidden" value="<?=$inventory_row['descrp']?>" id="desc_pick_<?=$count?>" />


    

</td>
</tr>
</table>

<?php
}

if(mysqli_num_rows($inventory_res) == 0)
{ ?>
	<table background="/images/bgz/list_bg_50.jpg" width="100%">
    	<tr>
        	<td>
            	<font color="#993300"><b>Sorry, Item Not in Inventory</b></font>
            </td>
        </tr>
    </table>
    <?php
}

?>