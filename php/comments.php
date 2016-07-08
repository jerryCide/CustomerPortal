<?php

if(!empty($_REQUEST['edit']))
{
 if($_REQUEST['edit']=="add")
 {
  
 	///////////////////---------------------////////////////////
		
	
	if (isset($_REQUEST["security_try"])) 
	{
     
   		//Set variables, and call checkSecurityImage
   		$security_refid = $_REQUEST["security_refid"];
   		$security_try = $_REQUEST["security_try"];
   		$checkSecurity = checkSecurityImage($security_refid, $security_try);
   
   //Depending on result, tell user entered value was correct or incorrect
   if ($checkSecurity) 
   {
      $validnot = "correct";
	  
	  ////////////////////////
	  
	  $comment = addslashes($_REQUEST['comm']);
  	  $author = $_REQUEST['author'];
      $article_id = $_REQUEST['news_id'];
    
 if(mysqli_query($db,"INSERT INTO press_comment_tab VALUES(0,'$author','$comment','$today',$article_id)"))
  {   
 	log_event("User Comment : art_id : ".$article_id,"-1",$present_datetime)
   ?>
    
    <script>
	 alert('Your comment was successfully added')
	</script>
   <?php
   
   	unset($_REQUEST['edit']);
   	unset($_REQUEST['comm']);
  }
  else
  {
   ?>
    <script>
	 alert('Adding your comment failed,try again later')
	</script>
   <?php
  }
	  
	  ///////////------------------/////////////
	  
   } 
   else 
   {
      ?>
	   <script>
	    alert('The Code you typed was wrong, please try again!')
	   </script>
	  <?
	  $failed = true;
   }
   
   
}
	
	
	/////////////////||||||||--------------------||||||||||||||\\\\\\\\\\\\\\\\\\\
	 
 
 
 
 
 
  
 }
 }



if(!empty($_REQUEST['article_id']))
{
 $article_id = $_REQUEST['article_id'];
}


if(!empty($_REQUEST['display']))
{
 if($_REQUEST['display']=="show_all")
 {
  $comm_rest = mysqli_query($db,"SELECT * FROM press_comment_tab WHERE article_id=$article_id ORDER BY date_posted DESC limit 0,6");
  while($comm_r = mysqli_fetch_array($com_rest,MYSQL_ASSOC))
  {
   echo $comm_r['comment']."<br>-------------------<br>";
  }
 }
 
 if($_REQUEST['display']=="show_full")
 {
  $comm_rest = mysqli_query($db,"SELECT * FROM press_comment_tab WHERE article_id=$article_id ORDER BY date_posted");
  while($comm_r = mysqli_fetch_array($com_rest,MYSQL_ASSOC))
  {
   echo $comm_r['comment']."<br>-------------------<br>";
  }
 }
}
?>