<!DOCTYPE HTML>
<HTML lang="en">
<HEAD>
<?php

include("php/vars.php");

ini_set('session.gc_maxlifetime', 60*60);

$username = getCurrentUsername();

open_db();

$profile_res = mysqli_query($db,"SELECT * FROM profile_tab WHERE username = '$username'");
$profile_row = mysqli_fetch_array($profile_res);

$last_login = $profile_row['last_login'];
//close_db();

$default_cpage = "home"; 

if(empty($_REQUEST['disp_page']) && empty($_REQUEST['app']))
{
	$_REQUEST['disp_page'] = $default_cpage;
}

?>
<TITLE><?=$main_title?></TITLE>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-lightbox.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css" />
<link rel="stylesheet" type="text/css" href="css/toastr.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="css/jquery-ui.css">
<link type="text/css" href="css/bootstrap.min.css" />
<link type="text/css" href="css/bootstrap-timepicker.min.css" />

<script type="text/javascript" src="<?=$root_dir?>javascript/md5.js"></script>
<script type="text/javascript" src="<?=$root_dir?>javascript/jquery-2.0.3.js"></script>
<script type="text/javascript" src="<?=$root_dir?>js/bootstrap.js"></script>
<script type="text/javascript" src="<?=$root_dir?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?=$root_dir?>js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$root_dir?>javascript/toastr.js"></script>

<script src="<?=$root_dir?>javascript/jquery-ui.js"></script>
<script type="text/javascript" src="<?=$root_dir?>js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?=$root_dir?>js/bootstrap-table.min.js"></script>
<script type="text/javascript" src="<?=$root_dir?>javascript/popup.js"></script>
<script defer type="text/javascript" src="<?=$root_dir?>javascript/pngfix.js"></script>
<script type="text/javascript" src="<?=$root_dir?>javascript/dropdown.js"></script>
<script type="text/javascript" src="<?=$root_dir?>javascript/ajax_funcs.js"></script>
<script language="JavaScript" src="<?=$root_dir?>javascript/text_editor/wysiwyg.js" type="text/javascript"></script>
<script language="JavaScript" src="<?=$root_dir?>js/jquery.twbsPagination.min.js" type="text/javascript"></script>
<script language="JavaScript" src="<?=$root_dir?>js/canvasjs.min.js" type="text/javascript"></script>
<script language="JavaScript" src="<?=$root_dir?>js/jquery.canvasjs.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!------AJAX------->

function clearResults()
{
 document.getElementById('resDiv').innerHTML = "[waiting...]";
}

var userUrl = "php/getUser.php"; // The server-side script
var pg = 0;

<!---END OF AJAX--->

<!-------mouse over effects-------->

toastr.options.showMethod = 'slideDown';
toastr.options.hideMethod = 'slideUp';

</script>
<?php
@include_once("php/modals.php");
?>
<script>
  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#username_input" ).autocomplete({
      source: "php/search.username.json.php",
      minLength: 2,
      select: function( event, ui ) {
		  //when item is selected perform action here
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
      }
    });
	
	$( "#new_user" ).autocomplete({
      source: "php/search.username.json.php",
      minLength: 2,
      select: function( event, ui ) {
		  //when item is selected perform action here
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
      }
    });
	
	$( "#username_input_search" ).autocomplete({
      source: "php/search.username.json.php",
      minLength: 2,
      select: function( event, ui ) {
		  //when item is selected perform action here
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
		  if(ui.item)
		  {
		  	//showSystemMessage('info','User Selected: '+ui.item.value,'Action Missing')
			if(document.getElementById('fName'))
			{
				document.getElementById('fName').value = ui.item.fName
			}
			else if(document.getElementById('lName'))
			{
				document.getElementById('lName').value = ui.item.lName	
			}
			
			showPopup3('php/profile.view.mini.php','user='+ui.item.value,'document.getElementById(\'username_input_search\').value = \'\'');
		  }
      }
    });
	
	$( "#s2Codes_input_search" ).autocomplete({
      source: "applications/budgetManager/controller/budgetman.getS2Content.php",
      minLength: 2,
      select: function( event, ui ) {
		  //when item is selected perform action here
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
		  if(ui.item)
		  {
		  	//showSystemMessage('info','User Selected: '+ui.item.value,'Action Missing')
			if(document.getElementById('fName'))
			{
				document.getElementById('fName').value = ui.item.fName
			}
			else if(document.getElementById('lName'))
			{
				document.getElementById('lName').value = ui.item.lName	
			}
			
			//showPopup3('php/profile.view.mini.php','user='+ui.item.value,'document.getElementById(\'username_input_search\').value = \'\'');
		  }
      }
    });
	
	
	$( "#username" ).autocomplete({
      source: "php/search.username.json.php",
      minLength: 2,
      select: function( event, ui ) {
		 
		  if(ui.item)
		  {
		  	//showSystemMessage('info','User Selected: '+ui.item.value,'Action Missing')
			if(document.getElementById('fName'))
			{
				document.getElementById('fName').value = ui.item.fName
			}
			if(document.getElementById('lName'))
			{
				document.getElementById('lName').value = ui.item.lName	
			}			
		  }
      }
    });
	
	
	
	
  });
  
 
  </script>
  
  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-54TKD6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-54TKD6');</script>
<!-- End Google Tag Manager -->

<!--------- Google Analysts ------------->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-74298267-1', 'auto');
  ga('send', 'pageview');

</script>
<!---------- End Google Analytics ---------->
 <style>

.navbar-inner {
  background-color: #2c2c2c; /* fallback color, place your own */

  /* Gradients for modern browsers, replace as you see fit */
  background-image: -moz-linear-gradient(top, #C00, #900);
  background-image: -ms-linear-gradient(top, #C00, #900);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#C00), to(#900));
  background-image: -webkit-linear-gradient(top, #C00, #900);
  background-image: -o-linear-gradient(top, #C00, #900);
  background-image: linear-gradient(top, #C00, #900);
  background-repeat: repeat-x;

  /* IE8-9 gradient filter */
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0);
}

.navbar .brand
{
	float: left;
	display: block;
	/*padding: 10px 20px 10px;*/
	margin-left: -20px;
	font-size: 20px;
	font-weight: 200;
	color: #FFF;
	text-shadow:none;
}
	
.navbar .nav > li > a 
{
	float: none;
	padding: 10px 15px 10px;
	color: #FFF;
	text-decoration: none;
	text-shadow: 0 1px 0 #333;
}
.navbar .nav > .active > a, .navbar .nav > .active > a:hover, .navbar .nav > .active >a:focus 
{
color: #FFF;
text-decoration: none;
background-color:#900;
-webkit-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
-moz-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
}

<!--- AutoComplete Modal Fix --->

.ui-autocomplete-input {
  border: none; 
  font-size: 14px;
  width: 300px;
  height: 24px;
  margin-bottom: 5px;
  padding-top: 2px;
  border: 1px solid #DDD !important;
  padding-top: 0px !important;
  z-index: 1511;
  position: relative;
}
.ui-menu .ui-menu-item a {
  font-size: 12px;
}
.ui-autocomplete {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1510 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 0;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}
.ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
}
#modalIns{
    width: 500px;
}

<!--- END AutoComplete Modal Fix -->
</style>
</HEAD>


<BODY>
<input type="hidden"  id="current_user" value="<?=getCurrentUsername()?>"/>
<?php
if(!empty($_REQUEST['redir']))
{
	if($_REQUEST['redir'] == "noaccess")
	{
	?>
    	<script>
			showSystemMessage('error','You Were Redirected because you were not allowed Access by System, Contact Administrator','Access Denied');
		</script>
    <?php
	}
	else if($_REQUEST['redir'] == "logout")
	{
		?>
    	<script>
			showSystemMessage('info','You Were Logged Out Successfully','Logout Complete');
		</script>
    <?php
	}
	else if($_REQUEST['redir'] == "nosession")
	{
		?>
    	<script>
			showSystemMessage('error','Error Occured Logging You In','Login Failed');
		</script>
    <?php
	}
}
?>
<!---  TOP MENU BAR  ---->

<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="?disp_page=home" style="padding-bottom:0"><span class="glyphicon glyphicon-cloud"></span> <?=$main_title?></a>      
    </div>
<?php if(getCurrentUsername()){ ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
            
        <li class="dropdown <?=!empty($_REQUEST['app'])?"active":""?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-compressed"></span> Apps <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li role="presentation" class="dropdown-header">Intranet Apps</li>
             <?php 
				open_db();
				$username = getCurrentUsername();
				$app_res = mysqli_query($db,"SELECT * FROM app_tab `AT` LEFT JOIN app_permission_tab APT ON `AT`.app_id = APT.app_id WHERE (APT.app_user_id = '$username' OR `AT`.app_isPrivate = 0) GROUP BY `AT`.app_name");
				close_db();

				$isAppExists = false;
	
				while($app_row = mysqli_fetch_array($app_res,MYSQL_ASSOC))
				{
					$isAppExists = true;
	 		?>            
              <li role="presentation" class="<?=$app_row['app_isonline']==0?"disabled":""?> <?=$_REQUEST['app']==$app_row['app_dir']?"active":""?>"><a href="<?=$app_row['app_isonline']==1?"?app=".$app_row['app_dir']:"#"?>"><?=$app_row['app_name']?><?php if(!$app_row['app_isonline']){ ?> (Offline) <?php  } ?></a></li>
              
              <?php 
	
	} 
	
			if(!$isAppExists)
			{
		?>	
				<li><h2>No Applications</h2></li>
    	<?php
		}
	?>
          </ul>
        </li>
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
        
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="php/findDefaultProfileImg.php?username=<?=$username?>&dim=30x30" class="img-circle img-retina"/>&nbsp;<?=getUserFullName(getCurrentUsername())?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onClick="showSystemMessage('warning','Under Construction, Check back in a few days','Section Not Ready')"><span class="glyphicon glyphicon-bell"></span> Notifications</a>								</li>
                      	<li role="presentation" class="divider"></li>
                      	<li role="presentation"><a role="menuitem" tabindex="-1" href="?disp_page=profile.edit"><span class="glyphicon glyphicon-cog"></span> Profile</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation">
                        <?php 
					  	if(isset($_SESSION['USER']))
						{
							$session_user = unserialize($_SESSION['USER']);
						?>
				  <input type="hidden" id="session_user" value="<?=getCurrentUsername()?>"> <a href="#" onClick="doLogout(); return false;"><span class="glyphicon glyphicon-log-out"></span> Logout</a>                                                                                        
							<?php
						}
						else
						{
							?>You Are Not Logged In <?php if($_REQUEST['disp_page'] != "home"){ ?><a href="#" id="login_parent" onClick="document.getElementById('login_child').style.visibility='visible'"><img src="images/site_icons/login_bw.gif" border="0"> Login</a><?php } ?>
							
                      <input type="hidden" id="session_user" value="-">
                            <?php
						}
					  ?>
                        
                        </li>
          </ul>
        </li>
      </ul>
      
      <?php } ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- /.navbar -->
<!---  END TOP MENU BAR  ---->

<center>

  <table width="1200" border="0" cellpadding="0" cellspacing="0" class="table-responsive">
   	
    <tr>
    	
     <td colspan="2" height="30" align="right">
     	<table cellpadding="0" cellspacing="0" width="100%" height="250px" class="table-responsive">
        
    
    
    
    <tr>
     <td valign="top" bgcolor="#FFFFFF" style="background-repeat:repeat-x; background-position:bottom;">
     		    <?php
				if(!getCurrentUsername())
				{
					?>
                    <script>
						$(function(){
							
							$('#login_modal').modal('show')							
						});						

					</script>
                    <?php
				}
				if(!empty($_REQUEST['disp_page']))
				{
					if(include("php/".$_REQUEST['disp_page'].".php"))
			   		{ 							
			    		$_SESSION['disp_page'] = $_REQUEST['disp_page']; 						
			   		} 
			   		else
			   		{ 
						//unset($_SESSION['USER']);
						//@header("php/home.php");	
                        @header("applications/service_ticket_admin/home.php");
			  		} 
			  	} 
			  	else if(!empty($_REQUEST['app']) && isset($_SESSION['USER']))
				{
					if(!getCurrentUsername())
					{
						echo "No Login";	
					}
					open_db();
					$app_res1 = mysqli_query($db,"SELECT distinct `at`.app_id,`at`.app_name,`at`.app_dir FROM app_tab `at`, app_permission_tab apt WHERE (apt.app_user_id = '$username' or `at`.app_isPrivate = 0) and apt.app_id = `at`.app_id");
					close_db();
					
					if(mysqli_num_rows($app_res1) > 0)
					{
						$app_row1 = mysqli_fetch_array($app_res1);
						open_db();
						$current_app_res = mysqli_query($db,"SELECT `at`.app_id,`at`.app_name,`at`.app_dir FROM app_tab `at` WHERE app_dir = '".$_REQUEST['app']."'");
						$current_app_row = mysqli_fetch_array($current_app_res);
							
						$_SESSION['app_name'] = $current_app_row['app_name'];
						$_SESSION['app_id'] = $current_app_row['app_id'];
						$_SESSION['app_dir'] = $current_app_row['app_dir'];
							
						$perm_res = mysqli_query($db,"SELECT * FROM app_tab A LEFT JOIN app_permission_tab AP 
													ON AP.app_id = A.app_id 
													WHERE (AP.app_id = ".$current_app_row['app_id']." AND AP.app_user_id LIKE '".getCurrentUsername()."') OR (A.app_isPrivate = 0 AND A.app_id = ".$current_app_row['app_id'].")");
						$perm_row = mysqli_fetch_array($perm_res);
						
						if(mysqli_num_rows($perm_res) == 0)
						{								
							@header("location:?disp_page=home.user&redir=noaccess");	
						}
							
							close_db(); 
							@include("php/app.header.php"); //place app header page at the top of the screen when user is in an app
						
							if(include("applications/".$_REQUEST['app']."/index.php"))
			   				{	
								$_SESSION['disp_page'] = $_REQUEST['app']; 
							} 
			   				else
			   				{ 								
							?>
			    				<div class="container">
									<div class="jumbotron">
  										<h1><?=$main_title?> <?=$_REQUEST['app']?> | Opps!</h1>
  										<h3>The "<?=$_REQUEST['page']?>" page you requested does not seem to exist on <?=$main_title?>. </h3>
                                    </div>
								</div>
			  <?php 		} 
			  ?>
     		<?php 
					}
					else
					{
						//TODO: report error and log username and ip address of who attempted
						
						
						}
			
			
			} 
			else
			{
				//echo "User Not Logged In--";
				//@header("'Location: http://intranet/?disp_page=home'");
				//TODO: report error and log username and ip address of who attempted
				?>
                
                <?php
				//@header("php/home.php");
                @header("applications/service_ticket_admin/home.php");
				//include("php/home.php");
			}
			
			?>
     
     </td>
    </tr>
    <tr>
     <td colspan="100%" align="left" valign="top" height="50px"></td>
    </tr>
  </table>
        
        
        
     </td>
    </tr>
  </table>
<!--  Twitter Bootstrap Modal  --->

<!-- Button trigger modal -->

</center>

<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="mailResponse"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="systemResponse"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="blogResponse"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="session_ind"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="session_vars"></div>

<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="session_stuff"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="notificationResponse"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="imMsgDiv"></div>
<div style="visibility:hidden; width:0px; height:0px; padding:0px;" id="newMsg"></div>

<SCRIPT language="javascript" type="text/javascript">
	var int = self.setInterval("checkNotificationEmails()",5000);
	var int = self.setInterval("checkNotification()",3000);
	var int = self.setInterval("refreshSession()",10000);
	var int = self.setInterval("checkIM()",1000);
	var int = self.setInterval("getUserCount()",2000);
		
	checkNotificationEmails();
	checkNotification();
	refreshSession();
	checkIM();
	getUserCount();	
	
	$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	});
	
	 //$("[data-toggle=tooltip]").tooltip();
</SCRIPT>
</BODY>
</HTML>





