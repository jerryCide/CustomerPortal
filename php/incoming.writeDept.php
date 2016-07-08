<?php
include("vars.php");
open_db();

$res = mysqli_query($db,"SELECT * FROM mail_corr_incoming WHERE isNull(sender_address)");

while($row = mysqli_fetch_array($res))
{
	$incoming_id = $row['incoming_id'];
	$username = $row['recv'];
	$dept_name = addslashes(getUserDept($username));
	echo "<p>".$username. ": <b>WROTE</b> :".$dept_name."</p>";
	mysqli_query($db,"UPDATE mail_corr_incoming SET department_name = '$dept_name' WHERE incoming_id = $incoming_id");
}
echo "<p>Write Complete</p>";
?>