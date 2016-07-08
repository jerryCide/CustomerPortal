<?php
include("../../../php/vars.php");
$username = $_REQUEST['new_username'];
$name = $_REQUEST['new_name'];
$user_type = $_REQUEST['user_type'];
$email = $_REQUEST['new_email'];

if(getLDAPUser($username))
{
	?>
    <script>
    	window.top.window.showSystemMessage('error','Username found on Domain Server, Cannot use Username','Username Invalid')
	</script>
    <?php
	die();	
}

if(str_word_count($name) != 2)
{
	?>
    <script>
		window.top.window.showSystemMessage('error','User Must Have a First and Last Name, Only Two Names Required','Too Few Names')
		window.top.document.getElementById('new_name').focus()
	</script>
    <?php
	die();	
}

if($user_type == 0)
{
	?>
    <script>
		window.top.window.showSystemMessage('error','You Must Select User Type','No User Type Selected')
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
$user_res = mysqli_query($db,"SELECT * FROM user_tab WHERE user_id = '$username'");
$profile_res = mysqli_query($db,"SELECT * FROM profile_tab WHERE username = '$username'");

if(mysqli_num_rows($user_res) > 0)
{
	?>
    <script>
		window.top.window.showSystemMessage('error','No Duplicates Allowed','Username Already Added')
	</script>
    <?php
	die();
}
if(mysqli_num_rows($profile_res) == 0)
{
	mysqli_query($db,"INSERT INTO profile_tab(username,fName,lName,email) VALUES('$username','$fName','$lName','$email')");	
}

mysqli_query($db,"INSERT INTO user_tab(user_id,user_email,user_type_id,password) VALUES('$username','$email',$user_type,'$password')");

close_db();
?>

<script>
window.top.document.getElementById('new_username').value = ''
window.top.document.getElementById('new_name').value = ''
window.top.document.getElementById('new_email').value = ''
window.top.document.getElementById('user_type').selectedIndex = 0;
window.top.window.showSystemMessage('success','User Added Successfully','User Added')
</script>