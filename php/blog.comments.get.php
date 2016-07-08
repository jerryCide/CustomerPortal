<?php 
			if(empty($_REQUEST['blog_id']))
			{
				die("No Blog ID");
				}
			include("vars.php");
			open_db();
			$blog_id = $_REQUEST['blog_id'];
			$c_res = mysqli_query($db,"SELECT * FROM blog_comment_tab WHERE blog_id = $blog_id");
			?>
            <table width="500">
            <?php 
			while($c_row = mysqli_fetch_array($c_res,MYSQL_ASSOC))
			{
			?>
            	<tr bgcolor="#DDDDDD">
                	<td rowspan="2" width="70">&nbsp;
                    </td>
                    <td style="font-size:9px" width="500"><?php  $c_user = getLDAPUser($c_row['owner']); ?><?=$c_row['comment']?><br><br>by: <?=$c_user['fullName']?>
                    </td>
                    <td width="16" valign="top">
                    	<img src="images/bubble_16.png">
                    </td>
                </tr>
                <tr bgcolor="#DDDDDD">
                	<td style="font-size:9px" height="1" align="right" colspan="2">
                    
                    
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
                	<td colspan="3" id="new_comment_<?=$row['blog_id']?>">
                    <?php if(mysqli_num_rows($c_res) > 0 ){ ?>
                    	<input type="text" id="new_comment" style="width:400px; color:#666;" value="Write A Comment..." onfocus="showAddComment(<?=$row['blog_id']?>,'<?="new_comment_".$row['blog_id']?>')"/>
                      <?php } ?>
                    </td>
                </tr>
                
            </table>
            
            <?php close_db(); ?>