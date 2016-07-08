<?php

include("vars.php");
open_db();

if(!isset($_REQUEST['page']))
{
	$page = 1;
}
else
{
	$page = $_REQUEST['page'];
}


$pg = $page - 1;
$npp = 3;
$end_n = $page * $npp;
$start_page = $end_n - $npp;

$news_res = mysqli_query($db,"select * from press_tab WHERE type = 'N' order by pub_date DESC limit $start_page,3");
$all_news_res = mysqli_query($db,"select id from press_tab");
$news_count = mysqli_num_rows($all_news_res);

$pages = floor($news_count/$npp);


if(($pages+1)%$npp!=0)
{
 $pages++;
}



?>

<table cellpadding="0" cellspacing="0" width="100%" id="news_main_table" background="images/grad_bg.gif" style="background-repeat:repeat-x; background-position:bottom;">
     
            
       <!---get articles--->
       
       <?php
       
	   while($news_row = mysqli_fetch_array($news_res,MYSQL_ASSOC))
	   {
	    $pic_res = mysqli_query($db,"select img_id from news_img_tab where owner_id=".$news_row['id']);
		$pic_row = mysqli_fetch_array($pic_res,MYSQL_ASSOC);
	   ?>
       
       <tr id="News Item"><!--news item-->
        <td height="10" class="newsData"> 
        
        <table width="100%" cellpadding="0" cellspacing="0" class="dot_bottom" title="<?=$news_row['title']?>" id="<?=$news_row['id']?>" align="center" onClick="gL('?disp_page=articles&news_id=<?=$news_row['id']?>&news_type=N')" style="cursor:pointer">
         <tr>
         	<td width="55" valign="top" align="center" rowspan="2">
            <img src="php/findImg.php?pic_size=200&table_name=news_img_tab&table_field=img_id&img_id=<?=$pic_row['img_id']?>&crop=1" width="55" border="0" class="newsImg">         
            </td>
            <td rowspan="2" width="80">&nbsp;
            </td>
            <td width="415"avatar_tab height="80" align="justify" valign="top" style="word-wrap:break-word;width:100%;left:0; font-size:9px"><b><font color="#CC6600"><?=ucwords(substr($news_row['title'],0,50))?></font></b><br><?=substr($news_row['body'],0,180)?></td>
         </tr>
         <tr>
          <td align="right" height="13"><a href="?disp_page=articles&news_id=<?=$news_row['id']?>&news_type=N"><img src="images/site_icons/more_34.gif" border="0"/></a></td>
         </tr>
        </table>
         
        </td>
       </tr>
       <!---end loop---->
       <?php } ?>
       
       
       
       
       
       <tr>
        <td valign="top" align="left" >
         <font size="-6"><b>Pages:</b></font> 
         <?php 
		 	for($i=0;$i < $pages;$i++)
		 	{
			 if(($i+1)==$page)
			 { 
			 	echo "<b><font color=\"#000000\" style=\"background-color:#ffffff\">[".($i+1)."]</font></b>";
			 }
			 else
			 {
		  ?>
         		<a href="javascript:requestNewsInfo(<?=($i+1)?>)" class="miniLink"><?=($i+1)?></a> 
         <?php 
		      }
		     } ?>
         
        </td>
       </tr>
      </table>
      
      <?php      
	  close_db();	  
	  ?>