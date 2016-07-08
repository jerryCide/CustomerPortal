
<div style="background-image:url(images/bgz/apps_bg.jpg); background-repeat:repeat-x; background-position:top; width:auto; height:240px; color:#CCC; text-align:left; padding:5px;">
<?php
if(!empty($_SESSION['app_name']))
{?>
	<h1 style="color:#FFF" class="shadow-text">// <?=$_SESSION['app_name']?></h1>
	<?php   
    }
?>

<b><span class="glyphicon glyphicon-user"></span> <a href="#" class="shadow-text"><?=getUserDept(getCurrentUsername())?></a></b><br>

<?php
					
					open_db();
					$online_res = mysqli_query($db,"SELECT * FROM app_permission_tab as apt, session_tab as st WHERE app_id = ".$_SESSION['app_id']." AND apt.app_user_id = st.username");	
					$user_res = mysqli_query($db,"SELECT * FROM app_permission_tab WHERE app_user_id = '".getCurrentUsername()."' AND app_id = ".$_SESSION['app_id']);
					close_db();
					
					//$current_dept_id = $_SESSION['dept_id'];
										
					$user_row = mysqli_fetch_array($user_res);
					$isSupervisor = $user_row['isSupervisor'];
				
					?>
                    
                    <b class="shadow-text">Who's Viewing:</b><br>
                    <?php 
					while($online_row = mysqli_fetch_array($online_res))
					{
						$b_user = getLDAPUser($online_row['username']);
					?>
                    	<a href="#" onclick="<?php if($online_row['username'] != getCurrentUsername()){ ?>showIMForm('<?=$online_row['username']?>'); <?php } ?> return false;" data-toggle="tooltip" data-placement="top" title="<?=$b_user['fullName']?>"><img src="php/findDefaultProfileImg.php?username=<?=$online_row['username']?>&dim=50x50" width="50" style="border:1px solid #ccc" class="img-circle img-retina"/></a>&nbsp;
                    <?php 
					}
					?>
</div>

<?php
getAllDepts();
?>
<!----  System Response Containers   --->

<input type="hidden" id="systemmsgdiv">