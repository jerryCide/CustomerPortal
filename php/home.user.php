<script>
var blogIntervalID;
</script>
<?php
@session_start();
unset($_SESSION['app_name']);
//@session_start();
//$session_user = unserialize($_SESSION['USER']); 

$username = getCurrentUsername();
//echo getCurrentUsername();

if(!getCurrentUsername())
{
	?>
    <script>
	window.location='?disp_page=home';
	</script>
    <?php	
}


open_db();
$profile_res = mysqli_query($db,"SELECT * FROM profile_tab WHERE username = '$username'");
close_db();

$dept_row = mysqli_fetch_array($dept_res);
@session_start();

if(mysqli_num_rows($profile_res) == 0 && isset($_SESSION['USER']))
{
	
?>
<script>
	document.location = '?disp_page=profile.edit';
</script>
<?php
}
?>


<?php


@session_start();
if(!getCurrentUsername())
{			
	//die("There was a Fatal Error: Contact The Administrator"); 
	?>
    <script>
		//alert('nosession')
		//window.location='?disp_page=home&redir=nosession';
	</script>
    <?php
}


if(!empty($_REQUEST['friend']))
{
 $friend = $_REQUEST['friend'];
}

?>

<input type="hidden" value="" id="filter_feed">
<table class="table table-responsive" background="images/bgz/general.jpg" style="background-repeat:repeat-x;">
	<tr>
    	<td colspan="3">
			<table width="100%">
            	<tr>
                	<td width="70%">            			
                    </td>
                    <td id="new_friend_disp" align="right">&nbsp;</td>
              <td align="right" id="msg_disp">&nbsp;</td>
                    
           	  </tr>
          	</table>
          </td>
    </tr>
    
    <tr>
    	<td width="250px" valign="top">
        	
        <!-----  Side Portion  ----->
        	<table width="100%">
            	<tr>
                	<td height="150px" align="center">
                    	
                        
                                	<div class="col-md-12">
                                	<a href="?disp_page=profile.edit" style="color:#FFFFFF; color:#FFFFFF; font-weight:bold" class="shadow-text"><img src="php/findDefaultProfileImg.php?username=<?=$username?>&dim=250x250" style="border: 1px #000 solid" class="img-circle img-responsive img-retina"/></a></div><p>&nbsp;</p>
                               
                    	<table width="100%">
                        	
                            <tr>
                            	<td align="left">
                                <div class="col-md-12">
                                <input type="text" id="username_input_search" class="form-control" placeholder="Search Co-Workers..."/>
                                </div>
                                
                                </td>
                            </tr>
                            
                            <tr>
                            	<td>
                            		<div id="userListDiv" style="position:absolute; width:220px;visibility:hidden; overflow:auto; overflow-x:hidden; border:1px #999999 solid"></div>                   </td>
                            </tr>
                        </table>
                    
                    </td>
                </tr>
                <tr>
                	<td align="center">
                    	<p>&nbsp;</p>
                    	<div id="onlineDiv" class="fade in"><b>Loading User List...</b></div>
                        <div id="onlineListDiv" class="fade in"></div>
                    	<input type="hidden" id="online_list_current">
                        <input type="hidden" id="online_count_current">
                        
                        
                    </td>
                </tr>
            </table>
        
        </td>
    	<td valign="top">
        	<table>
            	<tr>
                	<td valign="top" style="background-color:transparent">
                    
        	
        	<table class="table" style="background-color:transparent">
            	<tr>
                	<td colspan="3" align="right" height="50px">&nbsp;
                    	
                    </td>
                </tr>
                <tr>
                	<td colspan="3" width="550px" align="center">
                    <table>
                    	<tr>
                        	<td align="center" valign="top">
                            <table class="table table-condensed" style="border-top:none; background-color:transparent">
                            	<tr>
                                	<td>
                    	<textarea id="user_status" placeholder="BLOG IT...."  class="form-control" style="min-height:100px"></textarea>
                        </td>
                        </tr>
                        <tr>
                        	<td>
                            <div style="width:550px;">
                        	<div style="float:left">
                           		<a href="#" class="btn btn-danger btn-lg" onClick="showPopup3('applications/service_ticket/php/service_ticket.mini.php','username=<?=$session_user->username?>&include=1','document.getElementById(\'problem\').focus();'); return false;"><span class="glyphicon glyphicon-flash"></span> ICT Help Desk</a>
                            <button class="btn btn-success btn-lg" onClick="showPopup3('php/download_editor.php','username=<?=$session_user->username?>&include=1',''); return false;"><span class="glyphicon glyphicon-cloud-upload"></span> Upload File</button>
                            
                    	
                        </div>
                        <div style="float:right;">
                        <button class="btn btn-primary btn-large" onclick="addBlog('user_status','')"><i class="glyphicon glyphicon-bell"></i> Share</button>
                    	
                    	</div>
                        </div>
                            </td>
                        </tr>
                        </table>
</td>
</tr>
</table>
                    </td>
                </tr>
                <tr>
                	<td style="font-size:9px; font-weight:bold;">
                    </td>
                </tr>
        	 </table>
             
                            
                            <div id="blog_feed"></div>
             </td>
             <td valign="top" width="250px" style="vertical-align:top">
             	<table class="table" style="background-color:transparent">
             		
                	<tr>
                		<td valign="top">
                    		
                            
  								<li  class="list-group-item list-group-item-default" style="background-color:#930; color:#FFF"><b>Apps</b></li>
    

 	<?php 
	open_db();
	$username = $session_user->username;
$app_res = mysqli_query($db,"SELECT * FROM app_tab `AT` LEFT JOIN app_permission_tab APT ON `AT`.app_id = APT.app_id WHERE (APT.app_user_id = '$username' OR `AT`.app_isPrivate = 0) GROUP BY `AT`.app_name");
close_db();
	$isAppExists = false;
	while($app_row = mysqli_fetch_array($app_res,MYSQL_ASSOC))
	{
		$isAppExists = true;
	 ?>
     
     <a href="?app=<?=$app_row['app_dir']?>" class="list-group-item <?=!$app_row['app_isonline']?"disabled":""?>" <?php if(!$app_row['app_isonline']){ ?>onclick='return false;'<?php } ?>>
    <b class="list-group-item-heading" style="color:#999"><span class="glyphicon glyphicon-cog"></span> <?=$app_row['app_name']?></b>
    <span class="list-group-item-text" id="app_notification_<?=$app_row['app_id']?>"><?=!$app_row['app_isonline']?"This app is disabled by administrator":""?></span>
  </a>
    <?php } 
	
	if(!$isAppExists)
	{
	?>
    	<a href="#" class="list-group-item" onclick="return false;">
    <h4 class="list-group-item-heading">No Applications Added</h4>
    <span class="list-group-item-text">You do not have any permissions to use any apps, contact administrator</span>
  </a>
    <?php
	}
	?>

</div>
<br>
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
    	<td>
        <div id="downloadListDiv" style="visibility:hidden; height:0px; width:0px"></div>
        <div id="downloadDisplayDiv"><b>Loading Downloads...</b></div>
        <input type="hidden" id="download_list_current">
        
        </td>
    </tr>
</table>

                        
                    </td>
                </tr>
             </table>
                    
             </td>
             </tr>
             </table>
             
             
      </td>
    </tr>
</table>

        

        <script>
	 	//requestNewsInfo(1);
     
			//var int = self.setInterval("getNewMail()",5000);
			var int = self.setInterval("getOnlineUsers()",5000);
			var int = self.setInterval("getDownloadsList()",5000);
			var int = self.setInterval("getBlogs()",1000);
						
			//blogIntervalID = self.setInterval("checkBlog()",15000);
			getOnlineUsers();
			checkBlog();
			getDownloadsList();
			getBlogs(); //pre check for blogs
		</script>
