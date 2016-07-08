


<center>
	  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="mediumtext" >
	  <tr>
	  <td>
       
		 <table width="100%" class="mediumtext">
         <tr> 
         	<td>
            <?php
			
			
	   if(!empty($_REQUEST['news_id']))
	   {	
	   		
		$news_id = $_REQUEST['news_id'];
		open_db();
		$result = mysqli_query($db,"select * from press_tab where id = $news_id");
		close_db();
		
		
		if($_SESSION['viewed_art'] != $news_id)
		{
 			$_SESSION['viewed_art'] = $news_id;
 
 			open_db();
 
 			$r = mysqli_query($db,"SELECT read_no FROM press_tab WHERE id = $news_id");
 			$rr = mysqli_fetch_array($r,MYSQL_ASSOC);
 			$read = ++$rr['read_no'];
 			mysqli_query($db,"UPDATE press_tab SET read_no = $read WHERE id = $news_id");
 
 			close_db();
		}
		
		
				
		while($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
		 
		 ?>
		 <h1 align="left"><a name='top' class="topLink"></a><?=ucwords(stripslashes($row['title']))?></h1><br>
		 <div align="left"><a href="#comments"><font size="-6" color="#666666"><b><?=getCommentCount("press_comment_tab",$news_id)?></b> Comment<?php if(getCommentCount("press_comment_tab",$news_id) > 1){ echo "s"; } ?> written below</font></a></div>
		 <?
		 open_db();
		 $pic_res = mysqli_query($db,"SELECT * FROM news_img_tab WHERE owner_id = ".$row['id']);
		 close_db();
		 $pic_row = mysqli_fetch_array($pic_res,MYSQL_ASSOC);
		 ?><table width="100%" class="mediumtext"><tr><td align="justify" title="You Can Comment on this Article Below"><?
		 if(mysqli_num_rows($pic_res) > 0)
		 {
		  ?>
		  <img src="php/findImg.php?pic_size=180&table_name=news_img_tab&table_field=img_id&img_id=<?=$pic_row['img_id']?>" align=left class="newsImg">
<?		 } 
			
		?>
			 
		 <?=stripslashes($row['body'])?><br><br><br> <!--article body-->
            </td>
         </tr>
		 <tr>
		  <td>
		 read <?=$row['read_no']?> times<br>
		 <font color=#666666 size="-6"><b>Date Submitted:</b> <?=getDateStr($row['pub_date'])?> <br><b>Author:</b> <?=stripslashes($row['author'])?><br></font>
		 </td>
		 
		 </tr>
         <tr>
          <td>
          	comments
           <!-------comments------>
           <table height="30" width="100%" bgcolor="#EEEEEE" style="background-position:center" title="Views expressed are NOT necessarily those of the Minsitry of Water and Housing" class="mediumtext">
		 <tr>
		  <td background="images/table_top.gif" style="background-position:center" class="dot_bottom">
		   <font size="1"><b>Comments Disclaimer :: Views expressed are NOT necessarily those of the Ministry of Water & Housing</b></font> 
		  </td>
		 </tr>
		 <tr>
		  <td class="dot_bottom">
		   <table id="comments" width="100%">
           
		   <?php
		  
		  include('comments.php');
		 
		 $comments = getCommentRange(0,5,$news_id);
		 $i=0;
		 foreach($comments as $value)
		 {
		  $da_arr = explode(" ",$value['date_posted']);
		  ?>
          <tr>
          	<td>
		   <img src="images/site_icons/user.gif" />&nbsp; <b>|</b> <b><font color=green><?=($value['author']!="")?ucfirst($value['author']):"Anonymous"?></font></b> :: <?=getDateStr($da_arr[0])?><br><?=stripslashes($value['comment'])?></td></tr>
		   <?
		 }
		 
		 ?>
		   
		   </table>
		  </td>
		 </tr>
		 <tr> 
		  <td>
		   <!--<center><font size="-4"><a href="javascript:MM_openBrWindow('php/comments_view.php?art_id=<?=$news_id?>','All Comments','height=480,width=640,resizable=no,scrollbars=yes')">View All Comments</a></font></center>-->
		   <? 
		   
		   if(getCommentCount("press_comment_tab",$news_id) > 5)
		      {  
			   ?>
			    <center><font size="-4"><a href="javascript:MM_openBrWindow('php/comments_view.php?art_id=<?=$news_id?>','All Comments','height=480,width=640,resizable=no,scrollbars=yes')">View All Comments</a></font></center>
			   <?
			  } ?>
		  </td>
		 </tr>
		 <tr>
		  <td colspan="100%" bgcolor="#CCCCCC">
		  
		  	<!----comments start----->
		 
		 
		 
	<center>
    <form name="commForm" enctype="multipart/form-data" method="post" action="index.php">
		 
		 <table name='commTable' class="mediumtext">
		 <tr>
		 <td>
         <input type="hidden" name="time" value="<?php echo time(); ?>">
		 <input type="hidden" name="disp_page" value="articles" />
		 <input type="hidden" name="news_id" value="<?=$news_id?>" />
		 <input type="hidden" name="news_type" value="<?=$news_type?>" />
		 <input type="hidden" name="edit" value="add" />
		  </td>
		 </tr>
		 
		 <tr>
		  <td>
		   <b>comment:</b><br>
		   <textarea id="comment" rows="4" cols="45" class="black" wrap="hard" onkeydown="limitText(this.form.comment,'countdown',400);" 
onkeyup="limitText(this.form.comm,'countdown',400);"><? if($failed){ echo stripslashes($_REQUEST['comm']); } ?></textarea>
		  </td>
		 </tr>
		 <tr>
		  <td>
		   <span id="countdown">400 Left</span>
		  </td>
		 </tr>
		 
		 <tr>
		  <td>
		   <input onclick="addArtComment(<?=$news_id?>)" type="button" value="comment" id="addComment" class="black"/>
		  </td>
		 </tr>
		 <tr>
         	<td id="msg">
            &nbsp;
            </td>
         </tr>
		 </table>
		 </form></center>
		 <!----Comment end--->
		  
		  </td>
		 </tr>
		 </table>
          </td>
         </tr>
		 </table>
		 <br><br>
		 
		 <a name="comments"></a>		 
		 
		 
		 
		 
		<table height="30" width="100%" bgcolor="#BBBBBB" style="background-position:center" title="Latest Entries :: Minstry of Water and Housing">
		 <tr>
		  <td background="images/table_top.gif" style="background-position:center">
		   <font size="-2"><b>Top Stories</b></font> 
		  </td>
		 </tr>
		 <tr>
		  <td>
		 
		 <!--all news display start--> 
		 <table cellpadding="0" cellspacing="0" height="2">
   	
	<?
			if(!empty($_REQUEST['news_type']))
			{
			 $news_type = $_REQUEST['news_type'];
			}
			else
			{
			 $news_type = 'N';
			}
			
		    $ncount = 0;
			$c = 0;
			open_db();
		    $result = mysqli_query($db,"SELECT * FROM press_tab WHERE type = '$news_type' order by pub_date DESC limit 0,4 ");
			close_db();
			
			while($row = mysqli_fetch_array($result,MYSQL_ASSOC))
			{
			 $ncount = $ncount + 1;
			 $art_id2 = $row['id'];
			 open_db();
		     $pic_res = mysqli_query($db,"SELECT * FROM news_img_tab WHERE owner_id = $art_id2");
			 close_db();
		     $pic_row = mysqli_fetch_array($pic_res,MYSQL_ASSOC);
		  ?>
		  
		  
		  <? if($c == 0 || $c == 2){ ?> <tr> <? } ?>
		   <td valign="top" align="center">
		    	<table cellpadding="0" cellspacing="0" width="285" class="grpOn" onmouseover="gOn('pic')" onmouseout="gOff('pic')" onclick="gL('index.php?disp_page=articles&news_id=<?=$row['id']?>&news_type=<?=$news_type?>&page=<?=$start_page?>')" title="<?=stripslashes($row['title'])?>" height="30">
		   <tr>
		    <td valign="top" width="75" rowspan="100%"><?php if(mysqli_num_rows($pic_res) > 0) { ?><img src="php/findImg.php?pic_size=150&table_name=news_img_tab&table_field=img_id&img_id=<?=$pic_row['img_id']?>&crop=1" width="75" border="0" class="newsImg"><?php } ?></td>
			<td width="2" rowspan="100%">&nbsp;
			 
			</td>
			<td valign="top">
			 <?php
		   $type1 = $row['type'];
		   ?>
		   
		   <font color="orange" face="Arial" size="-3"><b><?=substr(stripslashes($row['title']),0,30)?><? if(strlen($row['title']) > 30){ ?>...<? } ?></b></font><br>
<font size="-3" color="#ffffff" face="Arial"><?=wordwrap(trim(stripslashes(substr(strip_tags($row['body']),0,80))),50,"<br>",true)?></font> ...<br>&nbsp;<br>

		   </td>
           <td rowspan="100%" width="10">
            
           </td>
		   </tr>
		   
		   <tr>
		    <td colspan="100%" height="5" align="right" valign="top">
			<? 
			$darray = explode("-",$row['pub_date']);
			
			?><font color="#333333" size="-2"><i><?=date("F",mktime(0,0,0,$darray[1],$darray[2],$darray[0]))?> <?=date("j",mktime(0,0,0,$darray[1],$darray[2],$darray[0]))?>, <?=date("Y",mktime(0,0,0,$darray[1],$darray[2],$darray[0]))?></i></font>			
			</td>
		   </tr>
		</table>
		   </td>
           		  
		 <? if($c == 1 || $c == 4){ ?> </tr> <? } ?>
		  
		  <? $c = $c + 1; } ?>
	
  </table>
		  <!--all news display end--> 
		 
		  
		   
		 </td>
		 </tr>
		 </table>
		 
		 
		 <br>
		 <br> 
		 
</td></tr></table>	
		 
		 
		 
		   <br><br>
		 
		 <?
		}
	   }
	   else
	   {
	    echo "News Article Not Found, Please try again";
	   }
	  
	  ?></td>
	  </tr>
	  </table>
	  </center>
      
      
      <script type="text/JavaScript">
<!--
function displayimg(picid){
	window.open("php/view.php?picid="+picid, 'popup', 'height=480,width=640,resizable=no,scrollbars=yes');
	return false;
}
//-->

function limitText(limitField, divId, limitNum) 
{

 if (limitField.value.length > limitNum) 
 {
  limitField.value = limitField.value.substring(0, limitNum);
 } 
 else 
 {
  var notice_text = (limitNum - limitField.value.length)+" Left";
  
 
  
  if((limitNum - limitField.value.length) < (limitNum/2) && (limitNum - limitField.value.length) > (limitNum/4))
  {
   notice_text = "<b><font color=#FF9900>"+notice_text+"</font></b>";
  }
  else if((limitNum - limitField.value.length) <= (limitNum/4))
  {
  	notice_text = "<b><font color=red>"+notice_text+"</font></b>";
  }
  
  document.getElementById(divId).innerHTML = notice_text;
 }
}

</script>
	
