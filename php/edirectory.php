<?php
open_db();
$dept_res = mysqli_query($db,"select * from dept_tab"); 
close_db();
?>
<table background="images/bgz/directory_bg.jpg" style="background-repeat:repeat-x" width="100%">
<tr>
	<td height="200">
    </td>
</tr>
<tr>
	<td>

<table cellpadding="0" cellspacing="0">
 <tr>
    <td height="166"></td>
    <td valign="top" align="center">
      <p class="style1">Type the First Name, Last Name or Extension of persons you wish to search for. Or leave fields blank to list the entire e-directory. </p>

      <table width="347" border="0" align="center">
        <tr>
          <th width="135" scope="col"><div align="left">First Name:</div></th>
          <th width="202" scope="col"><div align="left">
            <input type="text" id="txtFName"></div></th>
        </tr>
        <tr>
          <th scope="row"><div align="left">Last Name:</div></th>
          <td>
            <input type="text" id="txtLName">
          </td>
        </tr>
        <tr>
          <th scope="row"><div align="left">Extension:</div></th>
          <td>
            <input type="text" id="txtExt">
          </td>
        </tr>
        
        <tr>
          <th class="style1" scope="row"><div align="left">Department:</div></th>
          <td>
            <select id="department"  style="width:150px">
               			  <option style="font-weight:bold" value="0">Department:</option>
                            
                          <?php
                            while($dept_row = mysqli_fetch_array($dept_res,MYSQL_ASSOC))
							{ ?>
               			  <option value="<?=$dept_row['dept_id']?>" <?php if($dept_row['dept_id']==$row['dept_id']){ echo "selected=\"selected\""; } ?>><?=$dept_row['dept_name']?></option>
                          <?php } ?>
                        </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th scope="row" align="left">
            <input type="button" id="SUBMIT" value="Search" onClick="searchEDirectory(1)"></th>
          <td>
            <input type="reset" name="reset" value="Reset">
          </td>
        </tr>
      </table>

<hr style="border:1px dotted #EEEEEE">

      <p class="style1">
          <label></label>
          <label></label>
          List all Numbers:  </p>
        
    </td>
    
  </tr>
  
  
  
  <tr> 
    <td colspan="100%">
    Results:<span id="res_count"></span>
    <div id="search_results" style="width:790; height:200; position:static"></div>	
    </td>
    
  </tr>
  <tr>
   <td colspan="3">
   	<input type="button" onClick="clearResults()" value="Clear Results">
   </td>
  </tr>
  <tr>
  	<td colspan="3">
   	 
    </td>
  </tr>
  </table>
  
  
  </td>
  </tr>
  </table>