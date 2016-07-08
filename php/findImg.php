<?php
   include("vars.php");
   
   header("Content-type: image/jpeg");
   //header("Content-Disposition: attachment; filename=\"mwh_image\"".$today);
   open_db();
	
	$table_name = null;
	
    if(!empty($_REQUEST['mode'])){ $mode = $_REQUEST['mode']; }
	if(!empty($_REQUEST['img_id'])){ $img_id = $_REQUEST['img_id']; }
	if(!empty($_REQUEST['table_name'])){ $table_name = $_REQUEST['table_name']; $table_field = $_REQUEST['table_field']; }
	if(!empty($_REQUEST['pic_size'])){ $pic_size = $_REQUEST['pic_size'];	}
		
	if(!isset($table_name)){ $sql = "SELECT image_slide FROM gallery_tab WHERE img_id = $img_id"; }
	else { $sql = "SELECT image_slide FROM $table_name WHERE $table_field = $img_id"; }
	$result = mysqli_query($db,$sql);
	$nrows = mysqli_num_rows($result);
	
	if($nrows == 1)
	{
		$row = mysqli_fetch_array($result,MYSQL_ASSOC);
		 if($mode=='thumb')
          {
                  $data = $row['image_slide'];
				  				 				  
				  $size = 160;
                  $src = imagecreatefromstring($data);

				  $width = imagesx($src);
				  $height = imagesy($src);
			 	  $aspect_ratio = $height/$width;
				
				  if ($width <= $size) 
				  {
				   $new_w = $width;
				   $new_h = $height;
				  } 
				 else 
				 {
				  $new_w = $size;
				  $new_h = abs($new_w * $aspect_ratio);
				 }
				
				 $img = imagecreatetruecolor($new_w,$new_h);
				 //imagecopyresized($img,$src,0,0,0,0,$new_w,$new_h,$width,$height);
				imagecopyresampled($img,$src,0,0,0,0,$new_w,$new_h,$width,$height);
                		  
				  imagejpeg($img);
				  
                 }
                 else
                 {
                  $data = $row['image_slide'];
				  
				  if(isset($pic_size))
				  { 
				   $size = $pic_size; 
				  }				 				  
				  else 
				  { 
				   $size = 200; 
				  }
				  				  
                  $src = imagecreatefromstring($data);

				  $width = imagesx($src);
				  $height = imagesy($src);
			 	  $aspect_ratio = $height/$width;
				
				  if ($width <= $size) 
				  {
				   $new_w = $width;
				   $new_h = $height;
				  } 
				 else 
				 {
				  $new_w = $size;
				  $new_h = abs($new_w * $aspect_ratio);
				 }			
				 
				 
				 if(!empty($_REQUEST['crop']))
				 {
				  $img = imagecreatetruecolor(80,80);
				  imagecopyresampled($img,$src,-40,-10,0,0,$new_w,$new_h,$width,$height);
				 }
				 else
				 {
				  $img = imagecreatetruecolor($new_w,$new_h);
				  imagecopyresampled($img,$src,0,0,0,0,$new_w,$new_h,$width,$height);
				 }
				 				
                		  
				  imagejpeg($img);
                 }
		
	}
	imagedestroy($img);
	close_db();
?>

