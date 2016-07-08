<script>
if(self.opener !=null)   
{
	
    parentWindow = self.opener;

	//parentWindow.getElementById('test1').innerHTML = "Works!";
	
} 

self.focus();

</script>

<?php 
session_start();
include("vars.php");


$item_id = $_REQUEST['item_id'];

if(!empty($_REQUEST['img_num']))
{
 $_SESSION['img_num'] = $_REQUEST['img_num'];
}
else
{
 $_SESSION['img_num'] = 1;
}


if(!empty($_REQUEST['table_name']))
{
 $table_name =  $_REQUEST['table_name'];
 $_SESSION['table_name'] = $_REQUEST['table_name'];
}
else if(isset($_SESSION['table_name']))
{
 $table_name = $_SESSION['table_name'];
}
else
{
 die("Must select table");
}

 //include("../php/vars.php"); 
 $MAX_IMG = 20;
  
 if(empty($_SESSION['img_num']))
 {
  $_SESSION['img_num'] = 1;
 }
 open_db();
 $action="none";
 
 if(!empty($_REQUEST['mode']))
 {
  if($_REQUEST['mode']=="upload")
  {
   $IMG_NUM = $_SESSION['img_num'];
   for($i=0;$i<$IMG_NUM;$i++)
   {
    if(isset($_FILES['img_data']['tmp_name'][$i]))
    {
     $img = addslashes(fread(fopen($_FILES['img_data']['tmp_name'][$i], "r"), filesize($_FILES['img_data']['tmp_name'][$i])));
	 //$img = $_FILES['img_data']['tmp_name'][$i];
	 //$img = addslashes(file_get_contents($_FILES['img_data']['tmp_name'][$i]));
	 
	 $pic_note = $_REQUEST['pic_note'][$i];
    }
    
    //$pic_name = $_REQUEST['pic_name'];
    
     
    if($_FILES['img_data']['size'][$i] > 500000)
    { 
     $errors[] = "Image: ".$_FILES['img_data']['name'][$i]." is too large, please resize and try again";
	 continue;
	}
	else
	{
	 $owner_id = 0;
	 
	 $res_counter = mysqli_query($db,"SELECT * FROM $table_name WHERE album_id=".$album_id);
	 
	 $next_pos = mysqli_num_rows($res_counter);
	 $next_pos++;
	 
	 $img_name = $_FILES['img_data']['name'][$i];
	 
	 if(mysqli_query($db,"INSERT INTO $table_name(name,image_slide, note,owner_id) VALUES('$img_name','$img','$pic_note',$item_id)"))
	 {
	 	?>
        <script>
			parentWindow.requestImages(<?=$item_id?>);
		</script>
        <?php 
	 }
	 else
	 {
	  $errors[] = "Image: ".$_FILES['img_data']['tmp_name'][$i]."<br>".mysql_errno($db) . ": " . mysql_error($db);
	 }
	}
   }
   
   if(empty($errors))
   {
    ?>
	 <script>
	  alert('Images uploaded Successfully')
	 </script>
	<?php
	$_SESSION['img_num'] = 1;
   }
   else
   {
    ?>
	 <script>
	  alert('Only some images were upload, view error')
	 </script>
	<?php
    $_SESSION['errors'] = $errors;
   }
  }
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<script language="JavaScript" type="text/JavaScript">
var showAlbums = false;
//var self = null;



 function loadAlbums(obj)
 {
  window.location='imageUploader.php?action=album&ID='+obj.value
 }
 
 function setAlbumText(obj)
 {
  window.location='imageUploader.php?action=album&albums='+obj.value
 }
 
 function changeNum(obj)
 {
  window.location='imageUploader.php?img_num='+obj.value+"&table_name=news_img_tab";
 }
 
 function getFocus()
 {
  document.focus()
 }
</script>
<title>mwh.INTRANET | Image Uploader</title></head>

<body>
<center>
<b>IMage Uploader V1</b>
<table cellspacing="3" width="150" bgcolor="#FFFFCC" style="border:dashed; border-left:thin; border-right:thin; border-top:thin; border-bottom:thin; border-color:#000000" onload="javascript:getFocus()">
 <form name="gallery_form" method="post" enctype="multipart/form-data">
  <?php
    
 if(!empty($_SESSION['errors']))
 {
  $errors = $_SESSION['errors'];
  ?><tr><td colspan="100%"><?php
  foreach($errors as $value)
  {
   echo "<font color=\"red\">".$value."</font><br>";
  }
  
  ?></td></tr><?php
  unset($_SESSION['errors']);
 }

   
  ?>
  
  <tr>
   <td height="8" colspan="100%">&nbsp;
    Image Uploader for table: <b><?=$table_name?></b>
   </td>
  </tr>
  <tr>
   <td colspan="100%"> 
    <font color="#000000"><b>Images to upload: </b></font>
	
	<select name="img_num" onChange="JavaScript:changeNum(this)">
	<?php 
	 for($i=0;$i < $MAX_IMG;$i++)
	 {
	 ?>
	  <option value="<?=($i+1)?>" <?php if(!empty($_SESSION['img_num'])){ if($_SESSION['img_num']==($i+1)){ echo "selected"; }}  ?> ><?=($i+1)?></option>
	 <?php 
	 }  ?>
	</select>
   </td>
  </tr>
   <?php 
   $img_amt = $_SESSION['img_num'];
   
   for($i=0;$i<$img_amt;$i++)
   {
    ?>
   <tr>
   <td>
    <strong><font color="#000000">source:</font></strong> 
   </td>
   <td align="left" colspan="100%">
   <input type="hidden" value="<?=$table_name?>" name="tablename" />
   <input name="img_data[]" type="file" size="50" /> 
     </td>
  </tr>
  
  <tr>
   <td>
     <strong><font color="#000000">note:</font></strong> 
   </td>
    <td colspan="100%" align="left">
	 
   <input type="text" name="pic_note[]" size="50" />
   <font color="#333333">&nbsp;(optional) </font></td>
   </tr>
  <?php } ?> 
  
  
  <tr>
   <td align="center" colspan="100%">
     <input type="submit" value="upload" name="mode"/><input type="submit" value="done" name="mode"/>
   </td>
  </tr>
 </form>
 </table>
 
</center>
</body>
</html>
