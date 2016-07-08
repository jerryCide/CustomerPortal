<?php
include("vars.php");

@session_start();
$_SESSSION['last_check_blog'] = strtotime(date());

$blog_id = $_REQUEST['blog_id'];
open_db();
$blog_res = mysqli_query($db,"SELECT * FROM blog_tab WHERE blog_id = $blog_id");
$blog_row = mysqli_fetch_array($blog_res);
?>        
        
        <div class="media" id="new_blog_<?=$blog_row['blog_id']?>">
              <a class="pull-left" href="#" onclick="showIMForm('<?=$blog_row['blog_sender']?>'); return false;">
                <img src="php/findDefaultProfileImg.php?username=<?=$blog_row['blog_sender']?>&dim=70x70" width="70" class="img-circle img-responsive img-retina"/>
              </a>
              <div class="media-body">
                <h4 class="media-heading"><?=getUserFullName($blog_row['blog_sender'])?> wrote...</h4>
                <?=stripslashes($blog_row['blog'])?><br>
                <span style="font-size:9px; color:#666666"><?php 
			if(date("d") == date("d",strtotime($blog_row['blog_date'])) && date("m") == date("m",strtotime($blog_row['blog_date'])) && date("Y") == date("Y",strtotime($row['blog_date'])))
			{
				echo "Today ".date("g:i A",strtotime($blog_row['blog_date']));
			}
			else if((date("d") - 1) == date("d",strtotime($blog_row['blog_date']))  && date("m") == date("m",strtotime($blog_row['blog_date'])) && date("Y") == date("Y",strtotime($blog_row['blog_date'])))
			{
					echo "Yesterday ".date("g:i A",strtotime($blog_row['blog_date']));
			}
			else
			{
				echo date("l, M jS, Y g:i A",strtotime($blog_row['blog_date']));		
			}
			?></span>
            <hr>
                <!-- Nested media object -->
                
                <?php 
			
			//$blog_id = $blog_row['blog_id'];
			$c_res = mysqli_query($db,"SELECT * FROM blog_comment_tab WHERE blog_id = $blog_id");
			
			while($c_row = mysqli_fetch_array($c_res))
			{
			?>
                
                <div class="media" id="comment_<?=$c_row['comment_id']?>">
                  <a class="pull-left" href="#">
                  	<img src="php/findDefaultProfileImg.php?username=<?=$c_row['owner']?>&dim=50x50" width="50" class="media-object img-circle img-responsive img-retina"/>                    
                  </a>
                  <div class="media-body">
                    <b class="media-heading"><?=getUserFullName($c_row['owner'])?> wrote...</b><br>
                    <?=$c_row['comment']?><br>
                    <span style="font-size:9px; color:#666666"> <?php 
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
                <a href="#" class="btn btn-primary btn-xs" onclick="showAddComment(<?=$blog_id?>,'<?="new_comment_".$blog_id?>','<?=getCurrentUsername()?>'); return false;">Post Comment</a>
            <?php
            	if(getCurrentUsername() == strtolower($blog_row['blog_sender'])){ ?><a href="#" class="btn btn-default btn-xs" onclick="delBlog('<?=$blog_row['blog_id']?>'); return false;">Delete Blog</a><?php }
			
			?>
                <div id="new_comment_<?=$blog_row['blog_id']?>"></div>
                <!-- End Nested media object -->
              </div>
            </div>
        
        
        <?php
			close_db();	 

?>