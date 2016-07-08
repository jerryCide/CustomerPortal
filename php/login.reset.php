<?php
include("vars.php");
destroySession();
?>

<form class="well form-signin form-horizontal" target="new_password_frame"  action="php/login.setPassword.php" role="form">
<input type="hidden" value="<?=$_REQUEST['username']?>" id="username" name="username">
                       <img src="images/CMS_logo.png" />
                            <h2 class="form-signin-heading">Password Set</h2>
                            <div class="form-group">
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password..." style="font-weight:bold; font-size:25px; color:#666; height:40px" autocomplete="off" autofocus>
                            </div>
                            <div class="form-group">
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password..." style="font-weight:bold; font-size:25px; color:#666; height:40px" autocomplete="off" required>
                            </div>
						<div class="form-group"><input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" placeholder="Confirm Password..." style="font-weight:bold; font-size:25px; color:#666; height:40px" required> </div>
                            <button class="btn btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-lock"></i> Submit</button>
                             
                        </form>
                        <iframe id="new_password_frame" name="new_password_frame" style="width:0px; height:0px; visibility:hidden"></iframe>