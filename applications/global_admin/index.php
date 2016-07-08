<script type="text/javascript" src="applications/global_admin/javascript/ajax_vars.js"></script>

<table width="100%">
	
    <tr>
    	<td width="84%" align="center" valign="top">
        
        <?php
	if(empty($_REQUEST['page']))
	{
		include("php/notifications.php");
	}
	
	$page = $_REQUEST['page']; 
	$file = "php/$page.php";
	if(isset($page))
	{
		if(!(@include($file)))
		{
			echo $page . " does not exist";	
		}
	}	
?>
        
        </td>
        <td width="16%" valign="top">
        
        <div class="list-group">
        	<a href="?app=global_admin&page=company" class="list-group-item"><span class="glyphicon glyphicon-tower"></span> Company Details</a>
  			<a href="?app=global_admin&page=apps" class="list-group-item"><span class="glyphicon glyphicon-cog"></span> Applications</a>
  			<a href="?app=global_admin&page=sessions" class="list-group-item"><span class="glyphicon glyphicon-link"></span> Sessions</a>
            <a href="?app=global_admin&page=users" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Users</a>
            <a href="?app=global_admin&page=files" class="list-group-item"><span class="glyphicon glyphicon-file"></span> Files</a>
            <a href="?app=global_admin&page=blogs" class="list-group-item"><span class="glyphicon glyphicon-pencil"></span> Blogs</a>
            <a href="?app=global_admin&page=logs" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span> Logs</a>
        </div>
        
        	
        </td>
    </tr>
</table>
<div id="userListResults" style="height:0px; width:0px"></div>
<div id="system_response" style="height:0px; width:0px; visibility:hidden"></div>