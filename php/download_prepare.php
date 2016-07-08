<?php

include("vars.php");
open_db();

$download_id = $_REQUEST['doownload_id'];
$download_res = mysqli_query($db,"select * from download_tab as dt,download_category_tab as dct where dt.category_id = dct.category_id and dt.active = 1");

$download_row = mysql_fetch_row($download_res,MYSQL_ASSOC);


?>

<table width="90%">
	<tr>
     <td>
      
     </td>
    </tr>
</table>




<?php

close_db();

?>