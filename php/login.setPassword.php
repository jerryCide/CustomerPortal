<?php
$username = $_REQUEST['username'];

$password = md5($_REQUEST['current_password']);

if($_REQUEST['new_password'] != $_REQUEST['new_password_confirm'])
{
	?>
    <script>
	window.top.window.showSystemMessage('error','Passwords Do Not Match','Password Mismatch')
	</script>
    <?php
	die();	
}

include("vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM user_tab WHERE user_id LIKE '$username' AND `password` = '$password'");
close_db();
$row = mysqli_fetch_array($res);


if(mysqli_num_rows($res) == 1)
{
	if($_REQUEST['new_password'] == $_REQUEST['new_password_confirm'])
	{
		open_db();
		
		if(mysqli_query($db,"UPDATE user_tab SET `password` = '".md5($_REQUEST['new_password'])."',isReset = 0 WHERE user_id LIKE '$username'"))
		{
			?>
			<script>
				window.top.window.$('#systemModal').modal('hide');
				window.top.document.location.reload()
			</script>
			<?php	
		}
		close_db();
	}
	else
	{
	?>
		<script>
		window.top.window.showSystemMessage('error','Passwords Do Not Match','Password Mismatch')
		</script>
<?php	
	}
}
else
{
?>
		<script>
		window.top.window.showSystemMessage('error','The password entered is Incorrect','Incorrect Current Password')
		window.top.document.getElementById('current_password').focus();
		</script>
<?php	
}
?>