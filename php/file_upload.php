
<?php
		@session_start();
		if(!isset($_SESSION['USER']))
		{
			?>
            <script>
			window.top.document.getElementById('download_msg').innerHTML = "User Not Logged In";
			</script>
            <?php
			die("User Not Logged In");
			
		}
		
		if(empty($_FILES['uploadedfile']['name']))
		{
			?>
            <script>
				window.top.window.showSystemMessage("error","You Must Choose File","No File Selected")
				//alert("You Must Choose File");
				window.top.document.getElementById('uploadedfile').focus();
			</script>
            <?php
			die();	
		}
		
		if($_REQUEST['download_group_public'] == 0 && $_REQUEST['download_group_private'] == 0)
		{
			?>
            <script>
				window.top.window.showSystemMessage("error","Please Select Discussion Group","No Discussion Group")
			</script>
            <?php
				die();
		}	
		
		$result = 0;
		include("vars.php");
 	 	$username = getCurrentUsername();
				
		$base_dir = "../uploads/";
		
		if($_FILES['uploadedfile']['type'] == "image/jpeg" || $_FILES['uploadedfile']['type'] == "image/gif" || $_FILES['uploadedfile']['type'] == "image/png" || $_FILES["uploadedfile"]["type"] == "image/pjpeg")
		{
			$target_path = $base_dir."photos/".time();
		}
		else if($_FILES['uploadedfile']['type'] == "application/msword" || $_FILES['uploadedfile']['type'] == "text/plain" || $_FILES['uploadedfile']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		{
			$target_path = $base_dir."documents/".time();
		}
		else if($_FILES['uploadedfile']['type'] == "application/pdf")
		{
			$target_path = $base_dir."pdf/".time();
		}
		else if($_FILES['uploadedfile']['type'] == "audio/mpeg")
		{
			//mkdir($base_dir."audio/$today/",0777);
			$target_path = $base_dir."audio/".time();
		}
		else
		{
			$target_path = $base_dir."misc/".time();
		
		}		
		
		
		if(!file_exists($target_path)) 
		{	
			?>
            <script>
			window.top.document.getElementById('download_msg').innerHTML += "<p>Uploading File to: <?=$target_path?> [<?=$username?>]</p>";
			</script>
            <?php
		
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$target_path))
			{
				chmod($target_path, 0755);			
			?>
            <script>
			window.top.document.getElementById('download_msg').innerHTML += "<p>Moving File to: <?=$target_path?> [<?=$username?>]</p>";
			window.top.document.getElementById('download_msg').innerHTML += "<p>Blog: <?=$blog?> [<?=$username?>]</p>";
			</script>
            <?php
			
			$filename = basename($_FILES['uploadedfile']['name']);
			$location = /*$target_path;*/str_replace("../","",$target_path);
			?>
            <script>
				window.top.document.getElementById('testDiv').innerHTML += "<p><?=str_replace("../","",$target_path)?></p>";
			</script>
            <?php
			$extension = $_FILES['uploadedfile']['type'];
			$download_count = 0;
			$description = addslashes($_REQUEST['description']);
			if($_REQUEST['group_radio'] == "public_radio")
			{
				if($_REQUEST['download_group_public'] != 0)
				{
					$category_id = $_REQUEST['download_group_public'];
				}
				else
				{
					?>
            		<script>
						window.top.window.showSystemMessage("error","Please Select Discussion Group","No Discussion Group");
						window.top.document.getElementById('download_group_public').focus();
					</script>
            		<?php
				}
			}
			else
			{
				if($_REQUEST['download_group_private'] != 0)
				{
					$category_id = $_REQUEST['download_group_private'];	
				}
				else
				{?>
            		<script>
						window.top.window.showSystemMessage("error","Please Select Discussion Group","No Discussion Group");
						window.top.document.getElementById('download_group_private').focus();
					</script>
            		<?php	
				}
			}
			$active = 1;
			$date_expire = $_REQUEST['firstinput'];
			$download_name = addslashes($_REQUEST['download_name']);
			
			$users = explode(";",$_REQUEST['ListStr']);
			
			open_db();
			
			if(empty($_REQUEST['download_name']))
			{
				$download_name = basename($_FILES['uploadedfile']['name']);	
			}
			
			if(mysqli_query($db,"INSERT INTO download_tab(user_id,filename,extension,location,download_count,download_name,description,category_id,date_added,date_expire,active) VALUES('$username','$filename','$extension','$location',$download_count,'$download_name','$description',$category_id,'$today','$date_expire',$active)"))
			{
				$result = 1;
			 
			 $download_id = mysql_insert_id();
			 
			 foreach($users as $value)
			 {
			 	echo "<br>".$users." added";
			 	mysqli_query($db,"INSERT INTO download_permission_tab(download_id,username) VALUES($download_id,'$value')");
				$blog = $username. " has uploaded a file, check the <a href=\"#\" onclick=\"showPopup3('php/download.view.php','download_id=$download_id',''); return false;\">download</a> section to view";
				
				mysqli_query($db,"INSERT INTO blog_tab(blog_sender,blog,blog_date,blog_recv,blog_type) VALUES('$username','$blog','$today','$value','system')");
				?>
				
				<?php
			 }
			 
			 $all_attachments = mysqli_query($db,"SELECT * FROM event_attachment as ea,download_tab as d WHERE ea.event_id = $event_id and d.download_id = ea.download_id");
			 
			 $line_count = 0;
			 while($all_attachments_row = mysqli_fetch_array($all_attachments,MYSQL_ASSOC))
			 {
			 	$location = $all_attachments_row['location'];
			  $all_str .= "<img src='../$location' width='50'>";
			  
			  if($line_count%3 == 0 && $line_count!=0)
			  {
			   	$all_str .="<br>";
			  }
			  
			  $line_count++;			  
			 }
			 
			 
			if($download_id!=0)
			{
				?>

 				<script>
			 		window.top.document.getElementById('download_msg').innerHTML += "<?=$all_str?>";					
			 	</script>
             
		<?php } 
			 
			 unset($_REQUEST['description']);
			 unset($_REQUEST['uploadedfile']);
			}
			else
			{
				?>
                <script>
					window.top.window.showSystemMessage("error","Database Update Failed, Contact ICT Division","Upload Failed")
					//alert('Database Update Failed, Contact ICT Unit');
                
                </script>
                <?php	
			}
		
   		 	echo "The file ".basename($_FILES['uploadedfile']['name'])." of type ".$_FILES['uploadedfile']['type']." has been uploaded";			
		}
		else
		{
			?>
			<script>
				window.top.document.getElementById('download_msg').innerHTML += <?="<p>\"Cannot Upload File: <b>".basename($_FILES['uploadedfile']['name'])."</b> <br>Type: <b>".$_FILES['uploadedfile']['type']."</b><br>Error Code: ".$_FILES['uploadedfile']['error']." <br>Dir: <b>".$target_path."</b>\"</p>"?>
			</script>
			<?
		}
	} 
	else
	{
		?>
		<script>
			window.top.document.getElementById('download_msg').innerHTML +=  <?="<p>\"Cannot Overwrite file ".basename($_FILES['uploadedfile']['name'])."\"</p>"?>
		</script>
		<?php
	}
	

close_db();

sleep(1);
?>

<script language="javascript" type="text/javascript">
	//window.top.document.getElementById('download_msg').innerHTML = ''
	//window.top.document.getElementById('testDiv').innerHTML = ''
	
	window.top.window.stopUpload(<?=$result?>);
</script>  