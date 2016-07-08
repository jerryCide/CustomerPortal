<?php 
$owner_id = $_REQUEST['owner_id'];
$blog_id = $_REQUEST['blog_id'];
$blog = $_REQUEST['blog'];
?>
<div class="col-md-4">
<table class="table">
	<tr>
    	<td>
			<textarea id="new_comment_value_<?=$blog_id?>" style="width:450px; height:100px" class="form-control" placeholder="Post New Comment Here..."></textarea>
        </td>        
    </tr>
    <tr>
    	<td align="right">
        	<button class="btn btn-warning btn-xs" onClick="addBlogComment(<?=$blog_id?>,'<?=$blog?>','<?=$owner_id?>')"><span class="glyphicon glyphicon-comment"></span> Comment</button>
        	
        </td>
    </tr>
</table>
</div>