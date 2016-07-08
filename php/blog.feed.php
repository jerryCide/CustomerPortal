<?php
include("vars.php");


session_start();
$session_user = unserialize($_SESSION['USER']);
$username = $session_user->username;
open_db();

if(!empty($_REQUEST['filter']))
{
	$friend = $_REQUEST['filter'];
	$res = mysqli_query($db,"SELECT * FROM blog_tab where (blog_sender ='$friend' or blog_recv ='$friend')  order by blog_date DESC limit 0,15");
	if(mysqli_num_rows($res) == 0)
	{
		die("<center>No Blogs :(</center>");
	}
}
else
{
	$res = mysqli_query($db,"SELECT * FROM blog_tab where (blog_recv ='' or blog_recv ='$username') order by blog_date DESC limit 0,15");
}

$profile_res = mysqli_query($db,"SELECT * FROM profile_tab WHERE username = '$username'");
close_db();
$isProfileSet = false;

if(mysqli_num_rows($profile_res) > 0)
{
	$isProfileSet = true;
	$profile_row = mysqli_fetch_array($profile_res,MYSQL_ASSOC);
}

?>
<input type="hidden" id="last_refresh" value="<?=$today?>">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td id="myBlog" bgcolor="#EEEEEE"></td>
    </tr>
    <?php
    while($row = mysqli_fetch_array($res,MYSQL_ASSOC))
	{
	?>
    <tr>
    	<td>
    		<table style="border-bottom:dotted; border-bottom-color:#CCC; border-bottom-width:1px;font-size:10px; background-repeat:repeat-x;" width="600px" border="0" <?php if($row['blog_type'] == "system"){ ?> bgcolor="#FFFFCC"<? } ?>>
    		<tr>
    			<td rowspan="4" height="70" width="70" title="" valign="top">
        			<img src="php/findDefaultProfileImg.php?username=<?=$row['blog_sender']?>&dim=70x70" width="70" class="profilePhoto"/>
        		</td>
    		</tr>
    		<tr>
    			<td style="word-wrap: break-word; font-size:14px" width="300px" align="left">
                	<?php $b_user = getLDAPUser($row['blog_sender']); ?><a href="#" onclick="showIMForm('<?=$b_user['username']?>'); return false;" style="font-weight:bold; color:#06F"><?=getUserFullName($row['blog_sender'])?getUserFullName($row['blog_sender']):"User Removed"?> </a> <b>wrote...</b>                  
                    
                    
                    <img src="<?=$row['blog_type'] == "system"?"images/site_icons/asterisk_orange.png":"images/site_icons/highlighter.png"?>">
                    <br>
        			 &raquo; <?=stripslashes($row['blog'])?>
        		</td>
    		</tr>
    		<tr>
    			<td style="font-size:9px" height="1">&nbsp;<a href="#" style="color:#00F" onclick="showAddComment(<?=$row['blog_id']?>,'<?="new_comment_".$row['blog_id']?>'); return false;">Comment</a>
            <?php
            	if(strtolower($session_user->username) == strtolower($row['blog_sender'])){ ?><a href="#" onclick="delBlog('<?=$row['blog_id']?>'); return false;" style="font-size:9px; color:#0000FF;">Delete</a><?php }
			
			?><br><i><span style="font-size:9px; color:#666666">
            
            <?php 
			if(date("d") == date("d",strtotime($row['blog_date'])) && date("m") == date("m",strtotime($row['blog_date'])) && date("Y") == date("Y",strtotime($row['blog_date'])))
			{
				echo "Today ".date("g:i A",strtotime($row['blog_date']));
			}
			else if((date("d") - 1) == date("d",strtotime($row['blog_date']))  && date("m") == date("m",strtotime($row['blog_date'])) && date("Y") == date("Y",strtotime($row['blog_date'])))
			{
					echo "Yesterday ".date("g:i A",strtotime($row['blog_date']));
			}
			else
			{
				echo date("l, M jS, Y g:i A",strtotime($row['blog_date']));		
			}
			?>
            
            </span></i>
            
        		</td>
    		</tr>
   		 	<tr>
    			<td id="comments_<?=$row['blog_id']?>">
        	<?php 
			open_db();
			$blog_id = $row['blog_id'];
			$c_res = mysqli_query($db,"SELECT * FROM blog_comment_tab WHERE blog_id = $blog_id");
			?>
            		<table width="400px" border="0" cellpadding="1" cellspacing="5">
            <?php 
			while($c_row = mysqli_fetch_array($c_res,MYSQL_ASSOC))
			{
			?>
            			<tr bgcolor="#eaf0ff">
                			<td rowspan="2" height="70" width="70" valign="top" style="width:70px"><img src="php/findDefaultProfileImg.php?username=<?=$c_row['owner']?>&dim=70x70" width="70" class="profilePhoto"/>
                   		  </td>
                    		<td width="600px" style="font-size:14px" align="left">
                            <?php  $c_user = getLDAPUser($c_row['owner']); ?>
							<div style="font-weight:bold"><?=$c_user['fullName']?></div>
							<?=$c_row['comment']?><br>
                    		</td>
                            <td width="23" valign="top">
                            	<img src="images/bubble_16.png">
                            </td>
                		</tr>
                		<tr bgcolor="#eaf0ff">
                        	
                			<td style="font-size:9px; font-style:italic;" height="1" align="right" colspan="2">
                    
                    	 <?php 
			if(date("d") == date("d",strtotime($c_row['comment_date'])) && date("m") == date("m",strtotime($c_row['comment_date'])) && date("Y") == date("Y",strtotime($c_row['comment_date'])))
			{
				echo "Today ".date("g:i A",strtotime($c_row['comment_date']));
			}
			else if((date("d") - 1) == date("d",strtotime($c_row['comment_date']))  && date("m") == date("m",strtotime($c_row['comment_date'])) && date("Y") == date("Y",strtotime($row['blog_date'])))
			{
					echo "Yesterday ".date("g:i A",strtotime($c_row['comment_date']));
			}
			else
			{
				echo date("l, M jS, Y g:i A",strtotime($c_row['comment_date']));		
			}
			?>
                    
                    	</td>
                	</tr>
                <?php } ?>
                	<tr>
                		<td colspan="3" id="new_comment_<?=$row['blog_id']?>" align="right">
                    <?php if(mysqli_num_rows($c_res) > 0 ){ ?>
                    	<input type="text" id="new_comment_<?=$row['blog_id']?>" style="width:520px; color:#666;" value="Write A Comment..." onclick="showAddComment(<?=$row['blog_id']?>,'<?="new_comment_".$row['blog_id']?>','<?=$row['blog_sender']?>')"/>
                      <?php } ?>
                    	</td>
                	</tr>
                </table>
        	</td>
    		</tr>
    </table>
    </td>
    </tr>
    <?php } ?>
</table>

<?php
$_SESSION['BLOG_REFRESH'] = $today;
?>