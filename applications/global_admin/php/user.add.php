<?php
include("../../../php/vars.php");
open_db();
$user_type_res = mysqli_query($db,"SELECT * FROM user_type_tab");
close_db();
?>

<h1><span class="glyphicon glyphicon-user"></span> Add User</h1>
<form class="form-horizontal" role="form" action="applications/global_admin/controller/user.insert.php" target="inside_frame">

<div class="form-group">
	
		<label for="new_username" class="col-sm-3 control-label">Username:</label>
   
    <div class="col-sm-5">
		<input name="new_username" id="new_username" type="text" class="form-control" placeholder="New Username..." required>
    </div>
</div>

<div class="form-group">
	
		<label for="new_name" class="col-sm-3 control-label">Name:</label>
   
    <div class="col-sm-5">
		<input name="new_name" id="new_name" type="text" class="form-control" placeholder="Enter First and Last Name..." required>
    </div>
</div>

<div class="form-group">
	
		<label for="new_email" class="col-sm-3 control-label">Email:</label>
   
    <div class="col-sm-5">
		<input name="new_email" id="new_email" type="text" class="form-control" placeholder="Enter Email..." required>
    </div>
</div>


<div class="form-group">
	
    	<label for="user_type" class="col-sm-3 control-label">User Type:</label>
    
    <div class="col-sm-5">
    	<select class="form-control" name="user_type" id="user_type" placeholder="User Type">
    	<option value="0">-- User Type --</option>
        <?php while($user_type_row = mysqli_fetch_array($user_type_res)){ ?>
        	<option value="<?=$user_type_row['user_type_id']?>"><?=ucwords($user_type_row['user_type'])?></option>
        <?php } ?>
  	</select>
    </div>
</div>

<button type="submit" class="btn btn-success">Add User</button>

</form>
<iframe id="inside_frame" name="inside_frame" style="height:0px; width:0px; visibility:hidden"></iframe>
