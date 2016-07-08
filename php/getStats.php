<?php

include("../php/vars.php");
open_db();
$news_id = $_REQUEST['news_id'];


$most_comm_res = mysqli_query($db,"select count(pct.comment_id) as comm_count,pt.id,pt.title from press_comment_tab as pct, press_tab as pt where pct.article_id = pt.id group by pct.article_id order by comm_count desc limit 0,3");


$most_read_res = mysqli_query($db,"select id,read_no,title from press_tab order by read_no desc limit 0,3");

$comm_count = mysqli_query($db,"select count(pct.comment_id) as comm_count from press_comment_tab as pct where pct.article_id = $news_id");
$comm_row = mysqli_fetch_array($comm_count,MYSQL_ASSOC);

$read_count = mysqli_query($db,"select read_no from press_tab where id = $news_id");
$read_row = mysqli_fetch_array($read_count,MYSQL_ASSOC);

close_db();



?>

<table style="font-size:xx-small" align="center">
	<tr>
    	<td>
        	<b>Comments Amount</b>
        </td>
        <td>
        	<?=$comm_row['comm_count']?>
        </td>
    </tr>
    <tr>
    	<td colspan="2" height="5">
        	&nbsp;
        </td>
    </tr>
    <tr>
    	<td>
        	<b>Read Amount</b>
        </td>
        <td>
        	<?=$read_row['read_no']?>
        </td>
    </tr>
</table>

<table style="font-size:xx-small" align="center">
	
</table>
<br><br>
<font size="1"><b>Global Stats</b></font>
<table align="center">
	<tr>
    	<td colspan="2" style="font-size:xx-small">
        	<b>Most Commented Articles</b>
        </td>
    </tr>
    <?php 
	while($most_comm_row = mysqli_fetch_array($most_comm_res,MYSQL_ASSOC))
	{
		?>
        <tr>
        	<td style="font-size:xx-small">
            	<?=stripslashes($most_comm_row['title'])?>
            </td>
            <td style="font-size:xx-small">
            	<?=$most_comm_row['comm_count']?>
            </td>
        </tr>
        <?php
	}
	?>
</table>
<br>
<table style="font-size:xx-small" align="center">
	<tr>
    	<td colspan="2" style="font-size:xx-small">
        	<b>Most Read Articles</b>
        </td>
    </tr>
    <?php 
	while($most_read_row = mysqli_fetch_array($most_read_res,MYSQL_ASSOC))
	{
		?>
        <tr>
        	<td style="font-size:xx-small">
            	<?=stripslashes($most_read_row['title'])?>
            </td>
            <td style="font-size:xx-small">
            	<?=$most_read_row['read_no']?>
            </td>
        </tr>
        <?php
	}
	?>
</table>