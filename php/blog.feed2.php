<?php
include("vars.php");
$username = getCurrentUsername();

open_db();

if(!empty($_REQUEST['filter']))
{
	$friend = $_REQUEST['filter'];
	$res = mysqli_query($db,"SELECT * FROM blog_tab WHERE (blog_sender ='$friend' or blog_recv ='$friend') ORDER BY blog_date DESC LIMIT 0,15");
	if(mysqli_num_rows($res) == 0)
	{
		die("<center>No Blogs :(</center>");
	}
}
else
{
	$res = mysqli_query($db,"SELECT * FROM blog_tab WHERE (blog_recv ='' OR blog_recv LIKE '%$username%') ORDER BY blog_date DESC LIMIT 0,15");
}

$profile_res = mysqli_query($db,"SELECT * FROM profile_tab WHERE username = '$username'");
close_db();
$isProfileSet = false;

if(mysqli_num_rows($profile_res) > 0)
{
	$isProfileSet = true;
	$profile_row = mysqli_fetch_array($profile_res);
}

?>
<input type="hidden" id="last_refresh" value="<?=$today?>">
<div id="blog_temp_div" style="visibility:hidden;width:0px; height:0px;padding:0px;"></div>
<div id="blog_precheck_div" style="visibility:hidden;width:0px; height:0px;padding:0px;"></div>

    <div class="media" id="blog_new"></div>
    <div id="all_blogs_div">
    <?php
    while($row = mysqli_fetch_array($res))
	{
		?>
        
        <div class="media" id="blog_<?=$row['blog_id']?>" align="left">
              <a class="pull-left" href="#" onclick="showIMForm('<?=$row['blog_sender']?>'); return false;" name="blog_<?=$row['blog_id']?>">
                <img src="php/findDefaultProfileImg.php?username=<?=$row['blog_sender']?>&dim=70x70" width="70" class="img-circle img-responsive img-retina"/>
              </a>
              <div class="media-body">
                <h4 class="media-heading"><?=getUserFullName($row['blog_sender'])?> wrote...</h4>
                 
                <?=stripslashes($row['blog'])?><br>
                
                <span style="font-size:9px; color:#666666"><?php 
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
			?></span>
            <br><?php
            	if(getCurrentUsername() == strtolower($row['blog_sender'])){ ?><a href="#" class="btn btn-default btn-xs" onclick="delBlog('<?=$row['blog_id']?>'); return false;">Delete Blog</a><?php }
			
			?>
            <hr>
                <!-- Nested media object -->
                
           <?php 
			open_db();
			$blog_id = $row['blog_id'];
			$c_res = mysqli_query($db,"SELECT * FROM blog_comment_tab WHERE blog_id = $blog_id");
			
			while($c_row = mysqli_fetch_array($c_res,MYSQL_ASSOC))
			{
			?>              
                <div class="media" id="comment_<?=$c_row['comment_id']?>" data-toggle="collapse" align="left">
                  <a class="pull-left" href="#">
                  	<img src="php/findDefaultProfileImg.php?username=<?=$c_row['owner']?>&dim=50x50" width="50" class="media-object img-circle img-responsive img-retina"/>                    
                  </a>
                  <div class="media-body">
                    <b class="media-heading"><?=getUserFullName($c_row['owner'])?> wrote...</b><br>
                    <?=$c_row['comment']?><br>
                    <span style="font-size:9px; color:#666666"><?php 
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
			?></span>
                  </div>
                </div>
                <?php
			}
				?>
                <a href="#" class="btn btn-primary btn-xs" onclick="showAddComment(<?=$row['blog_id']?>,'<?="new_comment_".$row['blog_id']?>','<?=getCurrentUsername()?>'); return false;">Post Comment</a>
           
                <div id="new_comment_<?=$row['blog_id']?>"></div>
                <!-- End Nested media object -->
              </div>
            </div>
        
        
        <?php
			
		
	 } ?>
     
     </div>
