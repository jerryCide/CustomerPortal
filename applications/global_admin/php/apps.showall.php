<?php
include("../../../php/vars.php");
open_db();

$path = "../../";

//using the opendir function
$dir_handle = @opendir($path) or die("Unable to open $path");


?>
<center>
<table class="table table-condensed table-responsive table-hover">
<tr>
	<td colspan="2"> 
    	<form><div class="form-inline well"><b>Add External App Link:</b> <input type="text" id="app_link" class="form-control"><a class="btn btn-success" href="#" onclick=" installExternalApp(); return false;"><span class="glyphicon glyphicon-plus"></span> Add App Link</a></div></form>
    </td>
</tr>

<?php

//running the while loop
while ($file = readdir($dir_handle)) 
{
	if($file=="." || $file=="..")
	{
		continue;	
	}
	?>
    <tr>
    	<td>
	<i class="icon-qrcode"></i> <a href='<?=$file?>'><?=$file?></a>
	<?php
   //echo "<a href='$file'>$file</a>";
   ?>
   </td>
   <td><?php
   $all_res = mysqli_query($db,"SELECT * FROM app_tab WHERE app_dir = '$file'");
   if(mysqli_num_rows($all_res) != 0)
   {
		?><b><font color=green>Installed</font></b><?php
	}
	else
	{
		?><a href="#" onclick="installApp('<?=$file?>'); return false;" class="btn btn-primary btn-small">Install App</a><?php
	}
	?>
    </td>
  </tr><?php
}
?>
</table>
</center>
<?php
close_db();

//closing the directory
closedir($dir_handle);

?>