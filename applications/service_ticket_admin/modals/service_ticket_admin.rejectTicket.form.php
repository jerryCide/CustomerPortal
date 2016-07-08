<?php
if(empty($_REQUEST['service_ticket_id'])) die("No Service Ticket ID provided");

$service_ticket_id = $_REQUEST['service_ticket_id'];

include("../../../php/vars.php");

?>


<form class="form-horizontal" id="reject_ticket_form">
<fieldset>
<input type="hidden" id="service_ticket_id" value="<?=$service_ticket_id?>">
<input type="hidden" id="current_user" value="<?=getCurrentUsername()?>">
<!-- Textarea -->
<div class="form-group">
  
  <div class="col-md-12">                     
    <textarea class="form-control" style="min-height:100px" id="note" name="textarea" placeholder="Why are you rejecting Ticket # <?=$service_ticket_id?>?" autofocus></textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  
  <div class="col-md-8">
    <button class="btn btn-warning" onClick="setReject(<?=$service_ticket_id?>); return false;">Reject Ticket</button>
    <button class="btn btn-success" data-dismiss="modal">Nevermind</button>
  </div>
</div>

</fieldset>
</form>
