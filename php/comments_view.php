

<? 

if(empty($_REQUEST['art_id']))
{
 die("please provide article id");
}

$news_id = $_REQUEST['art_id'];


include("vars.php");

?>

<table width="100%" bgcolor="#EEEEEE" style="background-position:center" title="Tell Us Whats on your mind" align="center">
		 <tr>
		  <td background="images/table_top.gif" style="background-position:center">
		   <font size="-2"><b>Your Comments :: Tell us what you think!</b></font> 
		  </td>
		 </tr>
		 <tr>
		  <td>
		   
		   <?php		 
		   $comments = getCommentRange(0,100,$news_id);
		 echo "Found: ".count($comments)." Comments<br><br>";
		 $i=0;
		 foreach($comments as $value)
		 {
		  $da_arr = explode(" ",$value['date_posted']);
		  ?>
		   <img src="../images/site_icons/People_034.gif" />&nbsp; <b>|</b> <b><font color=green><?=ucfirst($value['author'])?></font></b> :: <?=getDateStr($da_arr[0])?><br><font size="-2"><?=stripslashes($value['comment'])?></font><br><br><center>---------------------</center>
		   <?
		 }
		 
		 ?>
		   
		   
		  </td>
		 </tr>
		 <tr>
		  <td colspan="100%" bgcolor="#CCCCCC" align="center">
		  	<!----comments start----->
		 	<font size="-6">www.mwh.gov.jm</font>
		 
	
		 <!--Comment end--->
		  
		  </td>
		 </tr>
		 </table>