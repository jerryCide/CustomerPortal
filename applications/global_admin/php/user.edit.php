<?php
include("../../../php/vars.php");
$username = $_REQUEST['username'];
open_db();
$user_type_res = mysqli_query($db,"SELECT * FROM user_type_tab");
$user_res = mysqli_query($db,"SELECT * FROM user_tab UT LEFT JOIN profile_tab PT ON UT.user_id = PT.username WHERE UT.user_id = '$username'");
close_db();

$user_row = mysqli_fetch_array($user_res);
?>

<h1><span class="glyphicon glyphicon-user"></span> Add User</h1>
<form class="form-horizontal" role="form" action="applications/global_admin/controller/user.save.php" target="inside_frame">

<div class="form-group">
	
		<label for="new_username" class="col-sm-3 control-label">Username:</label>
   
    <div class="col-sm-5">
		<input name="new_username" id="new_username" type="text" class="form-control" placeholder="New Username..." value="<?=$user_row['username']?>" required>
    </div>
</div>

<div class="form-group">
	
		<label for="new_name" class="col-sm-3 control-label">Name:</label>
   
    <div class="col-sm-5">
		<input name="new_name" id="new_name" type="text" class="form-control" placeholder="Enter First and Last Name..." value="<?=$user_row['fName']?> <?=$user_row['lName']?>" required>
    </div>
</div>

<div class="form-group">
	
		<label for="new_email" class="col-sm-3 control-label">Email:</label>
   
    <div class="col-sm-5">
		<input name="new_email" id="new_email" type="text" class="form-control" placeholder="Enter Email..." value="<?=$user_row['email']?>" required>
    </div>
</div>


<div class="form-group">
	
    	<label for="user_type" class="col-sm-3 control-label">User Type:</label>
    
    <div class="col-sm-5">
    	<select class="form-control" name="user_type" id="user_type" placeholder="User Type">
    	<option value="0">-- User Type --</option>
        <?php while($user_type_row = mysqli_fetch_array($user_type_res)){ ?>
        	<option value="<?=$user_type_row['user_type_id']?>" <?php if($user_type_row['user_type_id'] == $user_row['user_type_id']){ ?> selected<?php } ?> ><?=ucwords($user_type_row['user_type'])?></option>
        <?php } ?>
  	</select>
    </div>
</div>

<div class="form-group">
	<div class="checkbox col-sm-10">
    	<label class="control-label">
    		<input type="checkbox" value="1" id="isUserReset" name="isUserReset">
        	Reset User Password
        </label>
    </div>
</div>

<button type="submit" class="btn btn-success">Save User</button>

</form>
<iframe id="inside_frame" name="inside_frame" style="height:0px; width:0px; visibility:hidden"></iframe>
