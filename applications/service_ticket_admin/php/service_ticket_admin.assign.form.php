<?php
@include("../../../php/vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM app_permission_tab WHERE app_id = 11");
close_db();

?>

<table>
	<tr>
    	<td>
        	<h1>Assign This Ticket Now</h1>
        </td>
    </tr>
    <tr>
    	<td>
        	<font color="#999999">Ticket is not yet assigned, assign someone to this ticket or leave it unassigned</font>
        </td>
    </tr>
    <tr>
    	<td>
        <div class="input-group">
        	<select id="assign_user" class="form-control">
            	<option selected value="0">-- Leave Ticket Unassigned --</option>
            <?php
            while($row = mysqli_fetch_array($res))
			{
				$thisUser = getLDAPUser($row['app_user_id']);
			?>
            	<option value="<?=$row['app_user_id']?>"><?=getCurrentUsername()==$row['app_user_id']?"Me":$thisUser['fName']." ".$thisUser['lName']?></option>
                <?php
			}
				?>
            </select>
            <span class="input-group-btn">
            <button type="button" class="btn btn-success" onClick="confirmStartTicket()"><span class="glyphicon glyphicon-ok"></span> Confirm Start Ticket</button>
            </span>
            </div>
        </td>
    </tr>
    <tr>
    <td>
        	</td>
    </tr>
</table>