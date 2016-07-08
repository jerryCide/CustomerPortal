<?php
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

<div class="container" style="padding:0px;">
	<div class="alert alert-danger" style="visibility:hidden" id="login_response"></div>
</div>