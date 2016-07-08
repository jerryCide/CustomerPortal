<?php
$search_str = $_REQUEST['search_str'];
include("vars.php");
open_db();
$res = mysqli_query($db,"SELECT * FROM download_tab D, download_groups_tab DC WHERE (D.filename LIKE '%$search_str%' OR D.download_name LIKE '%$search_str%') AND DC.ID = D.category_id");
close_db();


?>

<div class="list-group">
	<p class="list-group-header"><i>Searching for</i> <b>"<?=$search_str?>"</b></p>
    
<?php
if(mysqli_num_rows($row) > 0)
{
	?>
    <p class="list-group-header"><b>No Results</b></p>
    <?php
}

while($row = mysqli_fetch_array($res))
{
	?>
    <a href="#!" class="list-group-item" onclick="showPopup3('php/share.view.php','download_id=<?=$row['download_id']?>','')">
		<h4 class="list-group-item-heading" align="left"><i class="icon-file"></i> <?=ucwords($row['download_name'])?></h4>
    	<p class="list-group-item-text" align="left">
    		<span class="glyphicon glyphicon-user"></span> <?=getUserFullName($row['user_id'])?><br>
        	<span class="glyphicon glyphicon-th-large"></span> <?=$row['group_name']?><br>
    		<span class="glyphicon glyphicon-calendar"></span> <?=date("M d Y G:i a",strtotime($row['date_added']))?>
    	</p>
    </a>
    <?php
}
?>

</div>