<?php 
include("../../../php/vars.php");
open_db();
$user_res = mysqli_query($db,"SELECT * FROM user_tab");
close_db();
/*
showPopup3('applications/global_admin/php/user.edit.php','username=<?=$user_row['user_id']?>','')
deleteUser('<?=$user_row['user_id']?>')
*/

$data = array();

while($user_row = mysqli_fetch_array($user_res)){ 

	array_push($data,array("user_id"=>$user_row['user_id'],"user_email" => $user_row['user_email']));
 } 
 echo json_encode($data);
 ?>