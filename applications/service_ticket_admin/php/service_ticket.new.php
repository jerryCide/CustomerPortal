
<table align="center" class="well table-responsive table-condensed">
	<tr>
    	<td colspan="2">
        	<h1>New Service Ticket</h1>
        </td>
    </tr>
    <tr>
                	<td>
                    	<b>Category:</b>
                    </td>
                    <td>
                    	<a name="category_mark"></a>
                    	<?php 
						include("../../../php/vars.php");
						open_db();
						$cat_res = mysqli_query($db,"SELECT * FROM service_ticket_type_tab ORDER BY service_ticket_type");
						
						?>                        
                    	<select id="category_id" style="font-size:18px;" class="span4 form-control">
                        	<option value="0" selected="selected">[SELECT PROBLEM CATEGORY]</option>
                        	<?php
							$i = 0;
                            while($cat_row = mysqli_fetch_array($cat_res))
							{
								?>
							<option value="<?=$cat_row['service_ticket_type_id']?>" style="width:400px" <?php if($index == $cat_row['service_ticket_type_id']){ ?> selected="selected" <? } ?>><?=$cat_row['service_ticket_type']?></option>
							<?php
							}
							?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td>
                    	
                    </td>
                    <td valign="top"><input type="text" id="short_desc" class="span4 form-control" placeholder="Enter Short Description..."/></td>
                </tr>
    <tr>
    	<td width="134">
    <strong>Client Search: </strong></td>
        <td width="430" valign="top">
        	<input type="text" id="ticket_username" class="span4 form-control username_input" placeholder="Search Employees List...">
        </td>
    </tr>
    <tr>
                    	<td>
                        </td>
                    	<td>
                        	
                        </td>
                    </tr>
                    
    <tr>
    	<td width="134" valign="top">
    <strong>Client&nbsp;Details</strong>: </td>
        <td width="430" valign="top">
        <a name="client_mark"></a>
        	<table>
            	<tr>
                	
                    <td>
                    	<input type="hidden" id="domain_username" />
                    	<input type="text" id="fName" placeholder="First Name..." class="span4 form-control">
                    </td>
                </tr>
				<tr> 
                	
                    <td>
                    	<input type="text" id="lName" placeholder="Last Name..." class="span4 form-control">
                    </td>
                </tr>
                <tr> 
                	
                    <td>
                    	<input type="text" id="ext" placeholder="Telephone, Cell, Extension..." class="span4 form-control">
                    </td>
                </tr>
                <tr> 
                	
                    <td>
                    	<input type="text" id="email" placeholder="email@example.com,email2@example.com,..." class="span4 form-control">
                    </td>
                </tr>
                <tr> 
                	
                    <td>
                    <?php
                    $location_res = mysqli_query($db,"SELECT `name`,`ID` FROM location ORDER BY `name`");
					?>
                    	<select id="location" class="span4 form-control">
                        	<option value="0">Client Location</option>
                        	<?php while($location_row = mysqli_fetch_array($location_res))
							{ ?>
                        	<option value="<?=$location_row['ID']?>">
                            <?=$location_row['name']?>
                            </option>
                            <?php
							}
							?>
                        </select>
                    </td>
                </tr>
                </table>
        	 

        </td>
    </tr>
    <tr>
                            	<td colspan="2">
                            	<div id="userListDiv" style="position:absolute; width:220px;visibility:hidden; overflow:auto; overflow-x:hidden; border:1px #999999 solid"></div>
                                </td>
                            </tr>
                            <tr>
                            	<td valign="top" rowspan="3">
                                <a name="asset_mark"></a>
                                	<b>Asset(s):</b>
                                </td>
                                <td>
                                	<table>
                                    	
                                        <tr>
                                        	<td>
                                            	<em>Serial:</em>
                                            </td>
                                            <td>
                                            	<input type="text" id="inventory_serial" onkeyup="getInventoryList_st(this); return false;" class="form-control">
                                            </td>
                                        </tr>
                                        
                                        <tr style="height:0px">
                    	<td>
                        </td>
                    	<td>
                        	<div id="invListDiv_st" style="position:absolute; width:220px;visibility:hidden; overflow:auto; overflow-x:hidden; border:1px #999999 solid"></div>
                        </td>
                    </tr>
    <tr>
                                        <tr>
                                        	<td>
                                            	<em>Ministry Serial (optional):</em>
                                            </td>
                                            <td>
                                            	<input type="text" id="inventory_ministry_serial" disabled="disabled" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            	<em>Desc:</em>
                                            </td>
                                            <td>
                                            	<input type="text" id="inventory_desc" disabled="disabled" class="form-control">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<input type="button" value="Add Asset" class="btn btn-xs btn-primary" onclick="addAsset();">&nbsp;<input type="button" value="Remove Asset" onclick="removeAsset()" class="btn btn-xs btn-primary">
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<select size="3" id="asset_list" style="width:430px" class="form-control"></select>
                                </td>
                            </tr>
    
            	<tr>
                	<td valign="top">
                    	<a name="problem_mark"></a>
                    	<b>Description:</b></td>
                    <td valign="top">
                    	<textarea cols="70" rows="10" id="problem" style="width:430px" placeholder="Enter Description, be as detailed as possible..." class="form-control"><?=$problem?></textarea>
                    </td>
                </tr>
                <tr>
                	<td>
                    <b>Deadline:</b>
                    </td>
                    <td>
                    	<div class="input-group" style="float:left"><input type="text" id="deadline" readonly="readonly" placeholder="No Deadline Attached..." class="form-control"><a href="#" class="btn btn-danger input-group-addon" onclick="document.getElementById('deadline').value=''; return false;">Clear Deadline</a>
                        </div>
              			<script>
              			$('#deadline').datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]
						
						});
			  			</script>
                    </td>
                </tr>
                <tr>	
                	<td colspan="2" style="border-top:#999">
                    		<button onclick="startTicket()" class="btn btn-success btn-large btn-block"><span class="glyphicon glyphicon-fire"></span> Start Ticket</button>
                    		
                    </td>
                </tr>
</table>

<?php
close_db();
?>