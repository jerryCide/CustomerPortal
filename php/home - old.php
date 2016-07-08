<?php
//phpinfo();

@session_start();

unset($_SESSION['app_name']);
$ip_address = $_SERVER['REMOTE_ADDR'];

if(getCurrentUsername())
{
	open_db();
	@mysqli_query($db,"UPDATE profile_tab SET last_login='$today' where username = '".getCurrentUsername()."'");
	close_db();
	
	?>
    <script>
		window.location='?disp_page=home.user';
	</script>
    <?php
}

 $session_user = @unserialize($_SESSION['USER']);  
 
 ?>

<div class="container" style="padding:0px; background-image:url(images/bgz/front_page2.jpg);background-repeat:no-repeat; background-position:0px -100px;">
<div class="jumbotron">
  <h1><?=$main_title?></h1>
  <p>Welcome to <?=$main_title?>. Use this portal to send messages, files and even memos to your fellow co-workers. Before using most of the services being offered you must login (look at username and password below), simply use your username and password used to login to this computer.<br><br>
  <a href="<?=$co_webmail_url?>" class="btn btn-danger btn-lg" target="_blank"><i class="glyphicon glyphicon-envelope"></i> <?=$co_webmail_title?></a>&nbsp;<a href="<?=$co_website_url?>" class="btn btn-info btn-lg" target="_blank"><i class="glyphicon glyphicon-globe"></i> <?=$co_website_title?></a></p>
  
  <form class="well span4 pull-right form-signin form-horizontal" target="login_target" onsubmit="checkLogin(); return false;" role="form">
                            <h2 class="form-signin-heading"><img src="images/CMS_logo.png" />&nbsp;Login</h2>
                            <div class="form-group">
                            <input type="text" id="username_login" name="username_login" class="form-control" placeholder="Username..." style="font-weight:bold; font-size:25px; color:#666; height:40px" autocomplete="off" required autofocus>
                            </div>
						<div class="form-group"><input type="password" id="pwd" name="pwd" class="form-control" placeholder="Password..." style="font-weight:bold; font-size:25px; color:#666; height:40px"> </div>
                            <button class="btn btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-lock"></i> Login</button>
                            
                        </form>
                        <div class="alert alert-danger" style="visibility:hidden" id="login_response"></div>
  
</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
			
        	<tr>
         		<td width="550" valign="top">
                	
         		</td>
            	<td valign="top" align="right">
            	
                    <table style="border:1px solid #EEEEEE" width="100%" height="100" cellpadding="0" cellspacing="0" background="images/bgz/trans_white_bg.png" class="span5 pull-right well">
                     <tr>
                      <td bgcolor="#DDDDDD" height="10" class="light_bg">
                         <font size="1"><b>Employee Blogs</b> (Requires Login)</font>
                      </td>
                     </tr>
                     <tr>
                      <td valign="top">
                      	<table width="100%">
                        	                           
                            <tr>
                            	<td align="center">
                                	<!-------------------->
                                    	<?php

@session_start();
$session_user = @unserialize($_SESSION['USER']);
$username = $session_user->username;
open_db();

if(!empty($_REQUEST['filter']))
{
	$friend = $_REQUEST['filter'];
	$res = mysqli_query($db,"SELECT * FROM blog_tab order by blog_date DESC limit 0,3");
	if(mysqli_num_rows($res) == 0)
	{
		die("<center>No Blogs :(</center>");
	}
}
else
{
	$res = mysqli_query($db,"SELECT * FROM blog_tab where (blog_recv ='' or blog_recv ='$username') order by blog_date DESC limit 0,3");
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

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" class="table-hover table-striped">
	<tr>
    	<td id="myBlog" bgcolor="#EEEEEE"></td>
    </tr>
    <?php
    while($row = mysqli_fetch_array($res))
	{
	?>
    <tr>
    	<td>
    		<table style="border-bottom:dotted; border-bottom-color:#333333; border-bottom-width:1px;font-size:10px; background-repeat:repeat-x;" width="100%" border="0" <?php if($row['blog_type'] == "system"){ ?> bgcolor="#FFFFFF"<?php } ?>>
    		<tr>
    			<td rowspan="4" height="70" width="70" title="" valign="top">
        			<img src="php/findDefaultProfileImg.php?username=<?=$row['blog_sender']?>&dim=70x70" width="70"  class="profilePhoto"/>
        		</td>
    		</tr>
    		<tr>
    			<td style="word-wrap: break-word;" valign="top" align="left">
        			<img src="images/blog.png"> &raquo; <?=stripslashes($row['blog'])?>
        		</td>
    		</tr>
    		<tr>
    			<td style="font-size:9px" height="1" align="left"><i class="icon-user"></i>&nbsp;<span style="font-weight:1900"><?=getUserFullName($row['blog_sender'])?></span>&nbsp;<i><span style="font-size:9px; color:#666666">
            <i class="icon-time"></i>
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
   		 	
    </table>
    </td>
    </tr>
    <?php } ?>
</table>
                                    
                                </td>
                            </tr>
                        </table>
                      </td>
                     </tr>
                     <tr>
                     	<td height="5">&nbsp;
                        </td>
                     </tr>
                     <tr>
                     	<td>&nbsp;</td>
                     </tr>
                    </table>
                </td>
        	</tr>
        </table>
        </div>
        <div id="login_msg" style="visibility:visible"></div>
        <iframe id="login_target" name="login_target" style="width:0;height:0; visibility:hidden" width="0px" height="0px"></iframe>
        <div id="debug_div"></div>
        