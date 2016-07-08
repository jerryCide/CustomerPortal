<?php
if(empty($_REQUEST['dept_id']))exit;

include("../../../php/vars.php");

$allOUs = getAllOUs();
$dept_id = $_REQUEST['dept_id'];
open_db();
$res = mysqli_query($db,"SELECT * FROM dept_tab WHERE dept_id = $dept_id");
close_db();
$row = mysqli_fetch_array($res);
?>

<form class="form-horizontal" target="submit_iframe"  action="applications/global_admin/controller/dept.mapOU.php">
<fieldset>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selected_ou">Select Basic</label>
  <div class="col-md-8">
    <select id="selected_ou" name="selected_ou" class="form-control">
    	<option value="0">-- NO MAPPING FOUND --</option>
    	<?php  foreach($allOUs as $value){ ?>
      <option value="<?=$value['ou']?>" <?=$value['ou']==$row['ou_map']?" selected":"" ?>><?=$value['ou']?></option>
      <?php  } ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-primary">Map</button>
  </div>
</div>
<input type="hidden" value="<?=$dept_id?>" name="dept_id">
</fieldset>
</form>

<iframe name="submit_iframe" style="width:0px; height:0px;"></iframe>
