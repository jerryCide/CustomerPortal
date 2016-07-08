<?php
include("vars.php");

$recvr = $_REQUEST['recvr'];
$sender = getCurrentUsername();

open_db();
$res = mysqli_query($db,"SELECT * FROM im_tab WHERE (recvr = '$recvr' AND sender = '$sender') OR (sender = '$recvr' AND recvr = '$sender') ORDER BY date_sent ASC");
close_db();

?>

<ul class="media-list">

<?php

while($row = mysqli_fetch_array($res))
{
	?>
    <li class="media">
    <a class="<?=$row['sender'] == getCurrentUsername()?"pull-left":"pull-right"?>" href="#">
      <img class="media-object" src="php/findDefaultProfileImg.php?username=<?=$row['sender']?>&dim=50x50" alt="<?=getUserFullName($row['sender'])?>">
    </a>
    <div class="media-body" align="<?=$row['sender'] == getCurrentUsername()?"left":"right"?>">
      <h4 class="media-heading"><?=getUserFullName($row['sender'])?> Says: </h4> <font size="1" color="#999999">[<?=date("F d, Y H:i:s",strtotime($row['date_sent']))?>]</font>
      <?=stripslashes($row['msg'])?>
      <hr>
    </div>
  </li>
    <?php	
}
?>
</ul>

