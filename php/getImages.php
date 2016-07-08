<?php
    $art_id = $_REQUEST['art_id'];
	include("vars.php");
	
	
	open_db();
	$p_res = mysqli_query($db,"SELECT * FROM news_img_tab WHERE owner_id = $art_id"); 
	$res_amt = mysqli_num_rows($p_res);

?>


<table width="100%">
<tr>
	<td>
    	<?php
	 echo "$res_amt Images Found<br>";
	 ?>
  <br>
  <a href="#" onClick="javascript:window.open('/php/imageUploader.php?table_name=news_img_tab&item_id=<?=$art_id?>','ImageUploader','location=1,status=1,scrollbars=1,menubar=1,width=600,height=600'); return false;"><img src="/images/site_icons/action_add.gif" border="0"><font size="-6">Add/Remove Photos</font></a>
  <br>
    </td>
</tr>
</table>
<table width="100%">
<?php
	 for($i=0,$j=0;$i<$res_amt;$i++,$j++)
	 { 
	  $pic_row = mysqli_fetch_array($p_res,MYSQL_ASSOC);
	  
	  if($j%2 == 0){ ?><tr><?php }
	  
	  ?>
	  <td bgcolor="#EEEEEE" width="80" style="border-style:solid;border-color:#CCCCCC;border-width:1px"><img src="../php/findImg.php?pic_size=160&table_name=news_img_tab&table_field=img_id&img_id=<?=$pic_row['img_id']?>&crop=1"><br><a href="#" onclick="requestDeleteImage(<?=$pic_row['img_id']?>); return false;"><img src="/images/site_icons/bin_closed.png" border="0" title="Delete"/></a>
	  <?php
	  
	  if($j%2 != 0){ ?></td></tr><?php }
	  else{ echo "<td>"; }
	  
	  }
  
   
	?>
    
    <tr>
    	<td>
        	
        </td>
    </tr>
  </table><br>
  <?php
	 echo "$res_amt Images Found<br>";
	 ?>
  <br>
  <a href="#" onClick="javascript:window.open('/php/imageUploader.php?table_name=news_img_tab&item_id=<?=$art_id?>','ImageUploader','location=1,status=1,scrollbars=1,menubar=1,width=600,height=600'); return false;"><img src="/images/site_icons/action_add.gif" border="0"><font size="-6">Add/Remove Photos</font></a>
  <br>
  
  <?php 
   
  
  close_db();
  
  ?>
  <!--<input type="text" />-->
  