<?php
$status_id = $_REQUEST['status_id'];

if(empty($_REQUEST['status_id']))
{
	$status_id = 1;		
}



if(empty($_REQUEST['scope']))
{
	$query = "SELECT * FROM service_ticket_tab as stt, service_ticket_status_type_tab as sts WHERE stt.service_ticket_status = $status_id AND stt.service_ticket_status = sts.service_ticket_status_type_id";

}
else if($_REQUEST['scope'] == "user")
{
	" AND sta.username = '$username'";	
}
else if($_REQUEST['scope'] == "all")
{
	$query = "SELECT * FROM service_ticket_tab as stt, service_ticket_status_type_tab as sts WHERE stt.service_ticket_status = $status_id AND stt.service_ticket_status = sts.service_ticket_status_type_id";

}


include("../../../php/vars.php");
open_db();
$username = $session_user->username;


$open_res = mysqli_query($db,$query);

close_db();
?>
<center>
<table width="990px" class="well">
	<tr>
    	<td>
         	<h1>Tickets Search</h1>
        </td>
    </tr>
    <tr>
    	<td align="center">
        	<table width="800px">
            	<tr>
                	
                    <td>
                    <div class="row">
                    	<form action="#!" onsubmit="searchTickets(); return false;" target="searchMe" role="form" class="form-inline">
                    		<div class="col-md-3"><label for="search_str" class="control-label pull-left"><b>Problem Search:</b></label>&nbsp;</div>
                        	<input type="text" name="search_str" id="search_str" style="width:400px" class="form-control"/>
                        	<button type="submit" class="btn btn-primary"/>Search Tickets</button>
                        	<iframe name="searchMe" id="searchme" style="visibility:hidden; width:0px; height:0px"></iframe>
                        </form>
                       
                       </div>
                        
                    </td>
                </tr>
                <tr>
                	<td>
                    	<div class="row">
                        	
                    	<form class="form-inline">	
                        	<div class="col-md-3"><label for="filter_check">
                            	<input type="checkbox" id="filter_check" name="filter_check" onchange="checkFilter()">&nbsp;<strong>Filter:</strong>
                            </label> 
                            </div>
                            <select id="ticket_scope" disabled="disabled" class="form-control">
                        	<option value="all" selected="selected">All Tickets</option>
                        	<option value="current_user">My Tickets</option>
                            <option value="not_current_user">Other Tickets</option>                            
                        </select>
                        <select id="status" disabled="disabled" class="form-control">
                        <option selected="selected" value="0">All Status</option>
                        <?php 
						open_db();
						$status_res = mysqli_query($db,"SELECT * FROM service_ticket_status_type_tab");
						close_db();
						
						while($status_row = mysqli_fetch_array($status_res))
						{
						?>
                        	<option value="<?=$status_row['service_ticket_status_type_id']?>"><?=$status_row['service_ticket_status_type']?></option>
                            <?php } ?>
                        </select>
                                               
                        </form>
                        </div>
                        
                        <br>
                        <h2>Results Count: <span id="results_span" style="color:#900">0</span></h2>
                    </td>                	
                </tr>
            </table>
        </td>
    </tr>
   
</table>
</center>
<center>
<div id="search_results" style="width:800px" align="center"></div>
</center>