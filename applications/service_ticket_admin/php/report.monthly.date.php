<?php

?>
<table class="table">
	
	<tr>
    	<td>
        	
        
    <div class="row">
    <div class="col-md-2"><strong>Search Date: </strong></div>
    <div class="col-md-2">
       	  <select name="month_p" id="month_p" class="form-control">
    <? for($i = 0;$i< 12;$i++) 
	{?>
		<option value="<?=$i+1?>" <?php if(!$isSub){ if(date("m",mktime(0,0,0,($i+2),0,0))==date("m")){ echo "selected=\"selected\""; } }else{ if($master_start[1]==date("m",mktime(0,0,0,($i+2),0,0))){ echo "selected=\"selected\""; } } ?>>
			<?=date("F",mktime(0,0,0,($i+2),0,0))?> (<?=date("n",mktime(0,0,0,($i+2),0,0))?>)
        </option>
	<? } ?>
   </select>
   </div>
   <div class="col-md-4">
       	  <select name="year_p" id="year_p" class="form-control">
       	    <?php 
	for($i = 0,$year = date('Y');$i< 10;$i++,$year--) 
	{
		?>
       	    <option value="<?=$year?>" <?php if(!$isSub){ if($year==date("Y")){ echo "selected=\"selected\""; } }else{ if($master_start[0]==$year){ echo "selected=\"selected\""; } } ?>><?=$year?></option>
        	  <?php 
	} ?>
      	  </select>
          </div>
          <div class="col-md-2">
          <button type="button" onclick="getMonthlyReport()" class="btn btn-danger">SHOW REPORT</button>
          </div>
          </div>
   	    </td>
       
    </tr>
    </table>