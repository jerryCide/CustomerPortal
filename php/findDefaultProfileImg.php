<?php

   include("vars.php");
   
   header("Content-type: image/jpeg");
   //header("Content-Disposition: attachment; filename=\"mwh_image\"".$today);
   
	
	$table_name = null;
	
	$username = $_REQUEST['username'];
	
	if(!empty($_REQUEST['dim']))
	{
		$dimensions  =  explode("x",$_REQUEST['dim']);
		$dim_height  =  $dimensions[0];
		$dim_width  =  $dimensions[1];
	}
	
    
	if(!empty($_REQUEST['pic_size'])){ $pic_size = $_REQUEST['pic_size'];	}
		
	//if(!isset($table_name)){ $sql = "SELECT image_slide FROM gallery_tab WHERE img_id = $img_id"; }
	$sql = "SELECT img as image_slide FROM profile_img_tab as pit, profile_img_default_tab as pidt WHERE pidt.username = '$username' AND pit.username = pidt.username AND pit.profile_img_id = pidt.img_id";
	
	open_db();
	$result = mysqli_query($db,$sql);
	$nrows = mysqli_num_rows($result);
	close_db();
	
	if($nrows == 0)
	{
		$sql = "SELECT img as image_slide FROM profile_img_tab WHERE profile_img_id = 1";
		open_db();
		$result = mysqli_query($db,$sql);
		$nrows = mysqli_num_rows($result);
		close_db();
	}
	
	
	
		$row = mysqli_fetch_array($result);
		 
		 
		$data = $row['image_slide']; //Grab image raw data
		  
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
		
			$new_h = $height;
			$new_w =  $width;	
			
			$offset_x  = 0;
			$offset_y = 0;
					
			if($width > $dim_width && $height >  $dim_height) //resize any dimension
			{
				$new_w = $dim_width;
				$new_h = ceil(($dim_width/$width)*$height); 				
				
				if($new_h < $dim_height) //increase height and trim width
				{
					$new_w += $dim_height - $new_h;
					$new_h = $dim_height;
				}
				$offset_x -= ($new_w-$dim_width)/2;
			}
			
			
			else if($height > $dim_height && $width < $dim_width) //increasse width and increase height
			{
				$new_w = $dim_width;
				$new_h +=  $dim_width - $width;
			}
			else if($width > $dim_width && $height < $dim_height) //increasse width and increase height
			{
				$new_h = $dim_height;
				$new_w +=  $dim_height - $height;
			}	
		
			
		
		// echo "both: $height x $width => ".$new_h."x".$new_w;
		  $img = imagecreatetruecolor($dim_width,$dim_height);
		  imagecopyresampled($img,$src,$offset_x,$offset_y,0,0,$new_w,$new_h,$width,$height);
		 
						
				  
		  imagejpeg($img);
		 
	
	
	imagedestroy($img);
	
?>

