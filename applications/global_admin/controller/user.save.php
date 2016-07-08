<?php
include("../../../php/vars.php");
$username = $_REQUEST['new_username'];
$name = $_REQUEST['new_name'];
$user_type = $_REQUEST['user_type'];
$email = $_REQUEST['new_email'];
$isUserReset = $_REQUEST['isUserReset'];

if(getLDAPUser($username))
{
	?>
    <script>
    	window.top.window.showSystemMessage('error','Username Invalid','Username found on Domain Server, Cannot use Username')
	</script>
    <?php
	die();	
}

if(str_word_count($name) != 2)
{
	?>
    <script>
		window.top.window.showSystemMessage('error','Too Few Names','User Must Have a First and Last Name, Only Two Names Required')
		window.top.document.getElementById('new_name').focus()
	</script>
    <?php
	die();	
}

if($user_type == 0)
{
	?>
    <script>
		window.top.window.showSystemMessage('error','No User Type Selected','You Must Select User Type')
		window.top.document.getElementById('user_type').focus()
	</script>
    <?php
	die();	
}

$names = explode(" ",$name);
$fName = $names[0];
$lName = $names[1];
$password = md5("");
open_db();

mysqli_query($db,"UPDATE user_tab SET user_id = '$username',user_email = '$email',user_type_id = $user_type,password = '$password'");

close_db();
?>

<script>
window.top.document.getElementById('new_username').value = ''
window.top.document.getElementById('new_name').value = ''
window.top.document.getElementById('new_email').value = ''
window.top.document.getElementById('user_type').selectedIndex = 0;
window.top.window.showSystemMessage('success','User Added','User Added Successfully')
</script>