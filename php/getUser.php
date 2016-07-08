<table width="50" border="1">
<tr><td colspan="100%">Testing Mode</td></tr>
<?php 

	echo "<tr><td>".$_REQUEST['fname']."</td><td>".$_REQUEST['lname']."</td></tr>";
	print_r("<script>alert(\"Found\")</script>");
?>
<tr><td colspan="100%">Found <b>X</b> Matches</td></tr>
</table>

