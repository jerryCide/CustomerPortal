<?php
include('vars.php');
?>
<h4>Chatting with: <?=getUserFullName($_REQUEST['recvr'])?></h4>
<div style="width:570px; height:400px; overflow-y: scroll;" id="msg_user_div"></div>
<hr>
<center>
<form style="padding:0px" onSubmit="imSend(); return false;" target="inside">
<div class="input-group"><input type="input" id="msg_text" placeholder="Enter New Message Here..." class="form-control" autocomplete="off"><span class="input-group-btn"><button class="btn btn-success" type="submit">Send</button></span></div>
<iframe id="inside" name="inside" style="visibility:hidden; width:0px; height:0px; padding:0px;"></iframe>
<input id="recvr" type="hidden" value="<?=$_REQUEST['recvr']?>">
</form>
<div id="img_div" style="visibility:hidden;height:0px;width:0px;"></div>
</center>
