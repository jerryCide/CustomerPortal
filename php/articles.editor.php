<?php 
session_start();
if(empty($_SESSION['USER']))
{
	die("Access Denied"); 
}
 open_db();
 $body_text = "";
 $allowed_tags = "<p><br><a><b><u><i><strong><embed><object><img>";

 if(empty($_REQUEST['pub_date']))
 {
  $_REQUEST['pub_date'] = $today;
 }
 
 $r=null;

 if(!empty($_REQUEST['mode']))
 {
  if($_REQUEST['mode']=="Add")
  {
   $article_name = addslashes($_REQUEST['article_name']);
   $content = strip_tags($_REQUEST['cont'],$allowed_tags);
   $content = addslashes($content);

   if(mysqli_query($db,"INSERT INTO press_tab values(0,'$article_name','$content','".date("Y-m-d")."','".$_REQUEST['author_name']."','UA','".$_REQUEST['pub_date']."',0,0,'$username')"))
   {
    $u_res = mysqli_query($db,"select * from email_list_tab");
	$news_id = mysql_insert_id();
	$err = 1;
	
	while($u_row = mysqli_fetch_array($u_res,MYSQL_ASSOC))
	{
	 /*$err = userMail("","",$u_row['email'],"A new article has been posted click link below to go directly to the article<br><a href=\"http://www.verandahtalk.com/?disp_page=articles&news_id=".$news_id."\">".$_REQUEST['article_name']."</a>");*/
	}
	
	if($err == 0)
	{
	 ?>
	  <script>
	   alert('There was a error sending one or more mail notication(s)');
	  </script>
	 <?
	}
	
    ?>
	 <script>
	  alert('Article Added, Now you can add a photo')
	  MM_openBrWindow('imageUploader.php?table_name=news_img_tab&item_id=<?=$_REQUEST['articles']?>','ImageUploader','location=1,status=1,scrollbars=1,menubar=1,width=600,height=600')
	 </script>
	 
	<?
	
   }
   else
   {
    echo "<script>alert('Add Failed')</script>";
   }
  }
  else if($_REQUEST['mode']=="New")
  {
   echo "<font color='red'>New Entry</font>";
  }
  else if($_REQUEST['mode']=="Back")
  {
   ?>
   <script>
    window.location='?disp_page=home'
   </script>
   <?
  }
  
  else if($_REQUEST['mode']=="Save")
  {
   $content = strip_tags($_REQUEST['cont'],$allowed_tags);
   $content = strip_tags($_REQUEST['cont'],$allowed_tags);
   $content = addslashes($content);
   if(mysqli_query($db,"UPDATE press_tab SET title='".addslashes($_REQUEST['article_name'])."',author='".addslashes($_REQUEST['author_name'])."',body='$content', pub_date='".$_REQUEST['pub_date']."', type='".$_REQUEST['mat_type']."' WHERE id=".$_REQUEST['id_num']))
   {
    echo "<script>alert('Article Saved')</script>";
   }
   else
   {
    echo "<script>alert('Save Failed')</script>";
   }
   $_REQUEST['articles'] = $_SESSION['articles'];
   $_REQUEST['mode'] = "view";
  }
  
  else if($_REQUEST['mode']=="del_art")
  {
   mysqli_query($db,"DELETE FROM press_tab WHERE id = ".$_REQUEST['articles']);
   $_REQUEST['mode'] = "view";
  }
 }
 
 
 $result = mysqli_query($db,"select * from press_tab");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Press Composer</title>
<link rel="stylesheet" type="text/css" href="../../css/jStyle.css">


<script language="javascript" type="text/javascript">
var body_text = null;

function delImage(img_id)
{
 window.location='index.php?disp_page=articles_editor&mode=del_img&del_id='+img_id;
}
</script>



</head>

<body>


  <?php  
   $found_rec = true;
 if(!empty($_REQUEST['mode']))
 {
  $_SESSION['articles'] = $_REQUEST['articles'];
  if($_REQUEST['mode']=="view")
  { 
   if($res = mysqli_query($db,"select * from press_tab where id = ".$_REQUEST['articles']))
   {  
    $a_id = $r['id'];
    $r = mysqli_fetch_array($res,MYSQL_ASSOC); 
	$body_text = $r['body'];
   } 
   else
   {
    $found_rec = false;
   }
  }
 }
 
 open_db();
 
 $article_res = mysqli_query($db,"select * from press_tab WHERE addedby = '$username' order by date_sub DESC");
 close_db();
?>


<form method="post" name="form1" >
  <table border="0" width="100%" height="600" cellspacing="0" cellpadding="0" background="images/bgz/general.jpg"/images/bgz/journal_bg.jpg" style="background-repeat:repeat-x">
	<tr>
    	<td height="200" colspan="2">
        </td>
    </tr>
<tr bgcolor="#999999">
<td align="center" colspan="100%" valign="middle" height="1">
 <p>   
   My Articles: <select name="articles" onChange="submit_form()" style="width:400px">
     <option value="">--- SELECT ARTICLE ---</option>
     <?php
  while($row = mysqli_fetch_array($article_res,MYSQL_ASSOC))
  {
   ?>
     <option value="<?=$row['id']?>" title="<?=stripslashes($row['title'])?>">
       <?=stripslashes($row['title'])?>
       </option>
     <?php
  }
  ?>
   </select>
   <input name="mode" type="submit" value="view"/>
 </p>
 <table>
 	<tr>
    	<td>
        	Title:    
        </td>
        <td>
        	<input name="article_name" style="font-size:9px; width:300px" type="text" value="<?php if($found_rec){ echo stripslashes($r['title']); } else{ echo $_REQUEST['article_name']; } ?>"> 
        </td>
    </tr>
    <tr>
    	<td>
        	Author: 
        </td>
        <td>
        	<input name="author_name" type="text" value="<?=$session_user->fName?> <?=$session_user->lName?>" style="font-size:9px; width:300px">
        </td>
    </tr>
 </table>
 <p>
   <?php
     if(!empty($_REQUEST['mode'])) 
	 {
       if($_REQUEST['mode']=="view")
	   { ?>
   <input name="id_num" id="id_num" type="hidden" value="<?=$_REQUEST['articles']?>">
   <?php }
   
   	 } ?>
   
   Publish Date [yyyy-mm-dd hh:mm:ss] 
   <input name="pub_date" type="text" value="<?php if($_REQUEST['mode']=="view"){ echo $r['pub_date']; } else{ echo $present_datetime; }?>"/>
   
   <? if($_REQUEST['mode']=="view"){ ?>
   
    <b>Article ID:</b> 
    <?=$r['id']?>
 </p>
 <? } ?></td>
</tr>
<tr>
 <td valign="top" align="left" bgcolor="#FFFFFF" width="350">
   <textarea id="cont" name="cont">
    <? 
	  if($_REQUEST['mode']=="view")
	  {
	   echo stripslashes($body_text);
	  }
	  else
	  {
	   if(!empty($_REQUEST['cont']))
	   {
	    echo stripslashes($_REQUEST['cont']);
	   }
	  }
	
	 ?>
   </textarea>
   	<script language="JavaScript" type="text/javascript">
  		generate_wysiwyg('cont')
	</script> 
    </td>
 <td valign="top">
 <table width="100%" cellpadding="0" cellspacing="0">
 <tr>
  <td> 
  	<div id="message" style="font-weight:bolder; color:#FF0000;"></div>
  </td>
 </tr>
 <?php if($_REQUEST['mode']=="view") { ?>
 	<tr>
     	<td>
     	<a href="#" onClick="requestImages(<?=$_REQUEST['articles']?>); return false;" class="toggle">Images</a> | <a href="#" onClick="requestComment(<?=$_REQUEST['articles']?>); return false;" class="toggle">Comments</a> | <a href="#" onClick="requestStats(<?=$_REQUEST['articles']?>); return false;" class="toggle">Stats</a>
    	</td>
    </tr>
    <?php } ?>
 	<tr>
    	<td>
 <?php 
	open_db();
	$p_res = mysqli_query($db,"SELECT * FROM news_img_tab WHERE owner_id = ".$_REQUEST['articles']); 
	$res_amt = mysqli_num_rows($p_res);
	?>

    <?php  
	
	//$ajaxFileUploader->showFileUploader('id4');
	if($_REQUEST['mode']=="view"){ ?><div style="position:static; left:785px; top:177px; width:190px;height:300px;overflow:auto;background-repeat:repeat-x;" id="controlPanel"></div>
        <script>requestImages(<?=$_REQUEST['articles']?>)</script>
   <input type="hidden" id="article_id" value="<?=$_REQUEST['articles']?>" />
  		</td>
  		</tr>
        <tr><td></td></tr>
      <?php } ?>
     <tr>
      <td>
	  	
      </td>
     </tr>
  </table> 
  </td>
</tr>
<tr>
 <td colspan="100%">
 <?php  
 
 /*$uploadDirectory = "uploaded";
	//include("AjaxFileUploader.inc.php");
	$ajaxFileUploader = new AjaxFileuploader($uploadDirectory);	
 echo $ajaxFileUploader->showFileUploader('id1');  */
 
 ?>
 </td>
</tr>
<tr bgcolor="#999999">
 <td align="center" colspan="100%">
   <input type="submit" name="mode" value="<?php if(!empty($_REQUEST['mode'])){ if($_REQUEST['mode']=='view'){ echo "Save"; }else{ echo "Add"; }}else{ echo "Add"; }?>">
   <input type="submit" name="mode" value="New">
   <input type="submit" name="mode" value="Back"> 
   </td>
</tr>
<tr>
 <td>
   <table>
   </table> </td>
</tr>
</table>
</form>
<?php 
close_db();
?>
</body>
</html>
