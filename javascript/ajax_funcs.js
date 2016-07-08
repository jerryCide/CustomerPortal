
var httpObj = new Array();
var newsUrl = "php/getNewsPre.php?page="; // The server-side script
var suggURL = "php/suggestions_send.php";
var searchNews = "php/searchNews.php";
var searchLinks = "php/searchLinks.php";
var adv = "php/getNewsResults.php";
var searchNews2 = "php/simpleSearch.php"; //this can be deleted no longer using simple searchpage
var statsUrl = "php/getStats.php";
var commentsUrl = "php/comments_view.php"; // The server-side script
var deleteImgUrl = "php/deleteImg.php";
var imgUrl = "php/getImages.php";
var loadImage = "<table align=center><tr><td align=\"center\"><img src=\"images/loading_images/loading.gif\" border=\"0\"></td></tr><tr><td align=\"center\"><font size=\"-6\"><b>loading...</b></font></td></tr></table>"; //loading image url
var pg = 0;

var timeoutID = 0;
var timeoutID_out = 0;


$(function(){
$( ".username_input" ).autocomplete({
      				source: "php/search.username.json.php",
      				minLength: 2,
      				select: function( event, ui ){
		 								 
						if(ui.item)
						{
							if(document.getElementById('fName'))
							{
								document.getElementById('fName').value = ui.item.fName
							}
							if(document.getElementById('lName'))
							{
								document.getElementById('lName').value = ui.item.lName	
							}	
							if(document.getElementById('email'))
							{
								document.getElementById('email').value = ui.item.email	
							}					
						}
      				}
    				});	

$( ".mailCorrSender_input" ).autocomplete({
      				source: "php/search.mailCor_sender.json.php",
      				minLength: 2,
      				select: function( event, ui ){
		 								 
		  			/*if(ui.item)
		 	 		{
		  				if(document.getElementById('fName'))
						{
							document.getElementById('fName').value = ui.item.fName
						}
						if(document.getElementById('lName'))
						{
							document.getElementById('lName').value = ui.item.lName	
						}	
						if(document.getElementById('email'))
						{
							document.getElementById('email').value = ui.item.email	
						}					
		  			}*/
      			}
    				});	

$('.date_picker').datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]});

$( ".filenumber_input" ).autocomplete({
      				source: "php/search.filetracker_fileNumber.json.php",
      				minLength: 1,
      				select: function( event, ui ){
		 								 
						if(ui.item)
						{
							if(document.getElementById('filename'))
							{
								document.getElementById('filename').value = ui.item.filename
							}
						}						
      				}
    				});	

				$( ".filenumber_input" ).autocomplete( "option", "appendTo", ".eventInsForm" );
				
				
				$(".force_allcaps").bind('keyup', function (e) {
    				if (e.which >= 97 && e.which <= 122) {
        			var newKey = e.which - 32;
        			// I have tried setting those
        			e.keyCode = newKey;
        			e.charCode = newKey;
    			}

    			$(".force_allcaps").val(($(".force_allcaps").val()).toUpperCase());
				});


});


function showSystemMessage(message_type,title,message)
{
	message_type = message_type.toLowerCase();
	
	if(message_type == 'error')
	{
		toastr.error(message,title,
				{
					/*onclick: function() {showIMForm(sender_username)},*/
					positionClass: 'toast-bottom-right',
					/*closeButton: true,*/
					timeOut:5000
				});	
	}
	else if(message_type == 'info')
	{
		toastr.info(message,title,
				{
					/*onclick: function() {showIMForm(sender_username)},*/
					positionClass: 'toast-bottom-right',
					/*closeButton: true,*/
					timeOut:5000
				});	
	}
	else if(message_type == 'warning')
	{
		toastr.warning(message,title,
				{
					/*onclick: function() {showIMForm(sender_username)},*/
					positionClass: 'toast-bottom-right',
					/*closeButton: true,*/
					timeOut:5000
				});	
	}
	else
	{
		toastr.success(message,title,
				{
					/*onclick: function() {showIMForm(sender_username)},*/
					positionClass: 'toast-bottom-right',
					/*closeButton: true,*/
					timeOut:5000
				});	
	}
		
}

//fades layer in
ie5 = (document.all && document.getElementById);
ns6 = (!document.all && document.getElementById);
opac = 0;


function createObject()
{
	var httpObj;
	//will call on this block for every other browser except IE
	try
	{
		httpObj = new XMLHttpRequest();
	}
	catch(e)
	{
	//Internet Explorer
		try 
		{
			httpObj = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				httpObj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e)
			{
				alert ("Your browser does not support AJAX, Please upgrade your browser");
			}
		}
	}
	return httpObj;

}




function getScreenCenterY() 
{
	var y = 0;
	 
	y = getScrollOffset()+(getInnerHeight()/2);
	 
	return(y);
}
	 
function getScreenCenterX() 
{
	return(document.body.clientWidth/2);
}
	 
function getInnerHeight() 
{
	var y;
	if (self.innerHeight) // all except Explorer
	{
		y = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	// Explorer 6 Strict Mode
	{
		y = document.documentElement.clientHeight;
	}
	else if (document.body) // other Explorers
	{
		y = document.body.clientHeight;
	}
	return(y);
}
	 
function getScrollOffset() 
{
	var y;
	if (self.pageYOffset) // all except Explorer
	{
		y = self.pageYOffset;
	}
	else if (document.documentElement && document.documentElement.scrollTop)
	// Explorer 6 Strict
	{
		y = document.documentElement.scrollTop;
	}
	else if (document.body) // all other Explorers
	{
		y = document.body.scrollTop;
	}
	return(y);
}







////////////////////////////////////////////////////////////////////////////////////////////////////////////





function requestUserInfo() 
{ 
	var fname, lname,ext,pos,dept;
	var fnameObj, lnameObj,extObj,posObj,deptObj;
		 
	userUrl = "php/getUser.php";
		 
	fnameObj = document.getElementById('txtFName');
	lnameObj = document.getElementById('txtLName');
	extObj = document.getElementById('txtExt');
	posObj = document.getElementById('txtPos');
	deptObj = document.getElementById('txtDept');
		 
	userUrl += "?fname="+fnameObj.value;
	userUrl += "&lname="+lnameObj.value;
	userUrl += "&ext="+extObj.value;
	userUrl += "&pos="+posObj.value;
	userUrl += "&dept="+deptObj.value;
		 
		 
		
    //var sId = document.getElementById("txtCustomerId").value;
	httpobj['edir'] = getHTTPObject();
    httpobj['edir'].open("GET", userUrl, true);
	httpobj['edir'].onreadystatechange = handleHttpResponse;
    httpobj['edir'].send(null);
}


function handleHttpResponse() 
{   
	if (httpobj['edir'].readyState == 4) 
	{
		if(httpobj['edir'].status==200) 
		{
         	var results=httpobj['edir'].responseText;
				
            document.getElementById('resDiv').innerHTML = results;
         }
     }
	 else
	 {
		document.getElementById('resDiv').innerHTML = "Please wait...";	 
	 }
}


function getHTTPObject() 
{
	var xmlhttp;

	if(window.XMLHttpRequest)
	{
   		xmlhttp = new XMLHttpRequest();
  	}
  	else if (window.ActiveXObject)
  	{
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    	if (!xmlhttp)
		{
        	xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    	}
   
	}
  return xmlhttp;

 
}








	function handleSuggResponse() 
	   {   
        if (http.readyState == 4) 
		{
         	if(http.status==200) 
			{
            	var results=http.responseText;
              	document.getElementById('suggdiv').innerHTML = results;
				callLinks();
             }
         }
		 else
		 {
			document.getElementById('suggdiv').innerHTML = loadImage;
		  }
        }



       function handleNewsResponse() 
	   {   
        if (httpObj['news'].readyState == 4) 
		{
         	if(httpObj['news'].status == 200) 
			{
            	var results = httpObj['news'].responseText;
				document.getElementById('newsdiv').innerHTML = results;
				//callLinks();
             }
         }
		 else
		 {
			document.getElementById('newsdiv').innerHTML = loadImage; 
			
		  }
		  
		  
        }
       
        function requestNewsInfo(page) 
		{     
			httpObj['news'] = getHTTPObject();
			httpObj['news'].open("GET", newsUrl + escape(page), true);
			httpObj['news'].onreadystatechange = handleNewsResponse;
            httpObj['news'].send(null);
        }
		
		function getHTTPObject() 
		{
  			var xmlhttp;
			var browser=navigator.appName;
			var b_version=navigator.appVersion;
			var version=parseFloat(b_version);
			
		
  			if(browser == "Netscape")
			{
				xmlhttp = new XMLHttpRequest();
  			}
  			else
			{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    			if (!xmlhttp)
				{
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    			}
   			}
			return xmlhttp;
}
 
 function callLinks()
 {
    httpObj['links'] = getHTTPObject();
 	httpObj['links'].open("GET",searchLinks,true);
	httpObj['links'].onreadystatechange = linkHandler;
	httpObj['links'].send(null);
 }
 
 function linkHandler()
 {
 	if(httpObj['links'].readyState == 4)
	{
		if(httpObj['links'].status == 200)
		{
		var results = httpObj['links'].responseText;
		document.getElementById('searchdiv').innerHTML = results;
		}
		else
		 {
		 document.getElementById('searchdiv').innerHTML = loadImage;
		 }
	}	
 }



function advancedSearch()
 {
	httpObj['as'] = getHTTPObject();
 	httpObj['as'].open("GET",adv,true);
	httpObj['as'].onreadystatechange = advHandler;
	httpObj['as'].send(null);
 }
 
function advHandler()
 {
 	if(httpObj['as'].readyState == 4)
	{
		if(httpObj['as'].status == 200)
		{
		var results = httpObj['as'].responseText;
		document.getElementById('searchdiv').innerHTML = results;
		}
		else
		 {
		 document.getElementById('searchdiv').innerHTML = loadImage;
		 }
	}	
 }

function searchResponse() 
{   
        if (httpObj['search'].readyState == 4) 
		{
         	if(httpObj['search'].status==200) 
			{
            	var results = httpObj['search'].responseText;
              	document.getElementById('newsdiv').innerHTML = results;
             }
         }
		 else
		 {
			document.getElementById('newsdiv').innerHTML = loadImage;
		  }
}

function searchLink() //this function can be deleted no longer using the page simple search
{
	http.open("GET",searchNews2,true);
	http.onreadystatechange = srchSimpHand;
	http.send(null);
}


function srchSimpHand() //this function can be deleted no longer using the page simple search
{
  if(http.readyState == 4)
  {
  	if(http.status == 200)
	{
	var results=http.responseText;
    document.getElementById('searchdiv').innerHTML = results;
	//document.getElementById('newsdiv').innerHTML = "";
    }
    else
	{
	document.getElementById('searchdiv').innerHTML = loadImage;
	}
  }
}
	
function searchInfoSimp() //function for the simple search
{
 //var srchIndex = document.getElementbyId('searchSite').value;
// var srchSite = searchSite.options[searchSite.Index].value;
	 var srchNews = document.getElementById('searchP').value;
	 if(srchNews.length == 0)
	 {
	 alert("Please input search values");
	 }
	 else
	 {
	 http.open("GET",searchNews + "?search=" + srchNews+"&ms=" + new Date().getTime() ,true);
	 http.onreadystatechange = srchInfoHand;
	 http.send(null);
	}
}

function srchInfoHand() //handler for the simple search
{
  if(http.readyState == 4)
  {
  	if(http.status == 200)
	{
	var results=http.responseText;
    document.getElementById('newsdiv').innerHTML = results;
	//document.getElementById('newsdiv').innerHTML = "";
    }
    else
	{
	document.getElementById('newsdiv').innerHTML = loadImage;
	}
  }
}

		
function searchInfo()  //handler for the advanced search
{     
	var searchN = document.getElementById('searchParam').value;
	var titleN     = document.getElementById('title').value;
	var authorN    = document.getElementById('author').value;
	var yearObj = document.getElementById('year');
	var yearVal = yearObj.options[yearObj.selectedIndex].value;
	var monthObj = document.getElementById('month');
	var monthVal = monthObj.options[monthObj.selectedIndex].value;
	var dayObj = document.getElementById('day');
	var dayVal = dayObj.options[dayObj.selectedIndex].value;
	var dateN = yearVal + "-" + monthVal + "-" + dayVal;
    
	if (searchN.length == 0 && titleN.length == 0 && authorN.length ==0 && dateN.length != 10)
	{
		alert("Please enter search values");
	}
	else
	{ 
		if(isNaN(searchN))
		{
			var searchVal = searchN;
		}
		else
		{
			var searchVal ="";
		}
		if(isNaN(titleN))
		{
			var title = titleN;
		}
		else
		{
			var title ="";
		}
		if(isNaN(authorN))
		{
			var author = authorN;
		}
		else
		{
			var author ="";
		}
		if(dateN.length == 11)
		{
			var date = "";
		}
		else
		{
			var date = dateN;
		}
	
			httpObj['search'] = getHTTPObject();
			httpObj['search'].open("GET", searchNews + "?search=" + escape(searchVal) + "&author=" + escape(author) + "&title=" + escape(title) + "&date=" + escape(date)+"&ms=" + new Date().getTime(), true);
			httpObj['search'].onreadystatechange = searchResponse;
            httpObj['search'].send(null);
		}
}		
	
function validDate()
{
	var yearObj = document.getElementById('year');
	var yearVal = yearObj.options[yearObj.selectedIndex].value;
	var monthObj = document.getElementById('month');
	var monthVal = monthObj.options[monthObj.selectedIndex].value;
	var dayObj = document.getElementById('day');
	var dayVal = dayObj.options[dayObj.selectedIndex].value;
	
	if(yearVal == "sel" && monthVal == "sel" && dayVal == "sel")
	{
		searchInfo();
	}
	else
	{
		if(yearVal != "sel" && monthVal != "sel" && dayVal != "sel") 
		{
			if(monthVal == "04" || monthVal == "06" || monthVal == "09" || monthVal == "11")
			{ 
		   		if(dayVal > 30)
		   		{
		   			alert("Please select an appropriate value for day");
		   		}
		   		else
		   		{
		   			searchInfo();
		   		}
			}
			else
			{
				if(monthVal == "02")
				{
			   		if(dayVal >28)
			   		{
			   			alert("Please select an appropriate value for day");
			   		}
			   		else
			   		{
			   			searchInfo();
			   		}
				}
				else
				{
					if(monthVal != "sel" && yearVal != "sel" && dayVal != "sel")
					{
						searchInfo();
					}
				}
	   		}
		}
		else
		{
			alert("Please select a value for all date fields")
		}
	}
}	



function checkLogin()
{	
	showSystemMessage('warning','One Moment Please','Authenticating Credentials');		
 	var username = document.getElementById('username_login').value;
 	var password = document.getElementById('pwd').value;
 
 
 if(username.length == 0)
 {
    document.getElementById('login_msg').style.color = "#ff0000";
	document.getElementById('login_msg').innerHTML = "Please Enter Username";
	return;
 }
 
 if(password.length == 0)
 {
	 password='';
 }
 

 var httpOb = getHTTPObject();		
 httpOb.open("GET", "php/check_login.php?username_login="+escape(username)+"&password="+escape(password)+"&ms=" + new Date().getTime(), true);
 httpOb.onreadystatechange = function(){
	 
	  if (httpOb.readyState == 4) 
		{
        	if(httpOb.status == 200) 
			{	
                //console.log(httpOb.responseText)
                console.log('wait for it')
				var results = JSON.parse(httpOb.responseText);
                console.log(results)
				 
				if(results['authenticate'] == 1)
				{
					showSystemMessage('success','Access Granted','One Moment Please');					 
					
					if(results['isPasswordReset'] == 1)
					{
						showSystemMessage('info','Your password was reset by the administrator, Please set new one','Password Reset');
						showPopup3('php/login.reset.php','username='+username,'');						
					}
					else
					{
						document.location.reload(true);		
					}
				}
				 else
				 {
					document.getElementById('pwd').value = "";
					showSystemMessage('error','Could not log you in, Re-Check credentials and try again','Login Failed');					
				 }
			}
         }	 
	 };
 httpOb.send(null);
}


function doLogout()
{
	if(document.getElementById('session_user'))
	{
		var username = document.getElementById('session_user').value;
	}
	else if(document.getElementById('username'))
	{
		var username = document.getElementById('username').value;	
	}
	else
	{
		showSystemMessage('error','Cannot Perform Action At This Time','Logout Error');
		return;	
	}	
			
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/logout.php?username="+escape(username)+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('session_ind').innerHTML = results;
				 document.location='?disp_page=home&redir=logout';
			}
         }
		 else
		 {
					
		  }		
	};
 	httpO.send(null);
}


function refreshSession()
{
	if(!document.getElementById('session_user'))
	{
		return;	
	}
	
	var username = document.getElementById('session_user').value;
	httpObj['refreshS'] = getHTTPObject();		
	httpObj['refreshS'].open("GET", "php/checkSession.php?username="+username+"&ms=" + new Date().getTime(), true);
 	httpObj['refreshS'].onreadystatechange = function()
	{
		if (httpObj['refreshS'].readyState == 4) 
		{
        	if(httpObj['refreshS'].status==200) 
			{				
            	 var results = httpObj['refreshS'].responseText;
              	 document.getElementById('session_stuff').innerHTML = results;
				 
				 if(document.getElementById('terminate'))
				 {
				 	if(document.getElementById('terminate').value == 1)
				 	{
						
						alert("Your Session Was Terminated By The Adminnistrator");
						window.location = '?disp_page=home'
				 	}
					
				 }
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('session_ind').innerHTML = "Logging Out...";
			
		 }		
	};
 	httpObj['refreshS'].send(null);	
}


function pingMail()
{
	if(!document.getElementById('mailResponse'))
	{
		return;
	}
	
	if(!document.getElementById('session_user'))
	{
		return;
	}
		
	var username = document.getElementById('session_user').value;
	httpObj['pingMail'] = getHTTPObject();		
	httpObj['pingMail'].open("GET", "php/mail.check.php?username="+username+"&ms=" + new Date().getTime(), true);
 	httpObj['pingMail'].onreadystatechange = function(){
		
		
		
		if (httpObj['pingMail'].readyState == 4) 
		{
        	if(httpObj['pingMail'].status==200) 
			{				
				 //document.getElementById('mailResponse').innerHTML = "<input type=\"hidden\" value\"0\" id\"isNewMail\">";
            	 var results = httpObj['pingMail'].responseText;
              	 document.getElementById('mailResponse').innerHTML = results;
				 
				 //showSystemMessage(document.getElementById('doAlert').value,"Test");
				 if(document.getElementById('doAlert').value == 1)
				 {
				 	if(document.getElementById('isNewMail').value == 1)
				 	{
						showSystemMessage('info',"You have new mail","New Mail Awaiting");	 
				 	}
				 }
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('check_alert').innerHTML = "Checking Mail...";
			
		  }
		
		
		
		
		
		};
 	httpObj['pingMail'].send(null);	
}



function getNewMail()
{
	var username = document.getElementById('session_user').value;
	httpObj['newMail'] = getHTTPObject();		
	httpObj['newMail'].open("GET", "php/mail.php?username="+username+"&ms=" + new Date().getTime(), true);
 	httpObj['newMail'].onreadystatechange = function(){
		
		
		
		if (httpObj['newMail'].readyState == 4) 
		{
        	if(httpObj['newMail'].status==200) 
			{				
				 document.getElementById('check_alert').innerHTML = "";
            	 var results = httpObj['newMail'].responseText;
              	 document.getElementById('msg_inbox').innerHTML = results;
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			document.getElementById('check_alert').innerHTML = "Checking Mail...";
			
		  }
		
		
		
		
		
		};
 	httpObj['newMail'].send(null);	
}

function getOnlineUsers()
{
	
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/system.usersOnline.list.php?ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
				var results = httpO.responseText;
              	document.getElementById('onlineListDiv').innerHTML = results;
				 
				if(document.getElementById('online_list_current').value != document.getElementById('online_list_new').value || document.getElementById('online_list_new').value.length == 0)
				{
					document.getElementById('online_list_current').value = document.getElementById('online_list_new').value
					
					if(document.getElementById('online_list_current').value != document.getElementById('online_list_new').value)
					{
						showSystemMessage('info','User Just Logged In','Users Online');
					}
					getOnlineUsersDisplay(); //refresh list
				 }
				 else
				 {
					//toastr.error('Nope')	 
				 }
				 
			}
         }
		else
		{
			//document.getElementById('session_ind').style.color = "#ff0000";
			
		}
	};
 	httpO.send(null);	
}

function getOnlineUsersDisplay()
{
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/system.usersOnline.php?ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
				 //document.getElementById('check_alert').innerHTML = "";
            	 var results = httpO.responseText;
              	 document.getElementById('onlineDiv').innerHTML = results;				 
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			
		  }
		};
 	httpO.send(null);	
}

function handleSendMailResponse()
{
	if (httpObj['sendMail'].readyState == 4) 
		{
        	if(httpObj['sendMail'].status==200) 
			{				
            	 var results = httpObj['sendMail'].responseText;
              	 document.getElementById('mail_msg').innerHTML = results;
				 
				 if(document.getElementById('server_res').value == 1)
				 {
					 var username = document.getElementById('session_user').value;
					document.location="?disp_page=mail.inbox&username="+username+"&ms=" + new Date().getTime();
				 }
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('session_ind').innerHTML = "Logging Out...";
			
		  }
}

function sendMail()
{
	var username = document.getElementById('session_user').value;
	var toList = document.getElementById('toList').value;
	var subject = document.getElementById('subject').value;
	var message = document.getElementById('message_body').value;
	//var message = document.getElementsByName('message_body')[0].value;
	
	alert(message);
	httpObj['sendMail'] = getHTTPObject();		
	httpObj['sendMail'].open("GET", "php/mail.send.php?username="+username+"&toList="+toList+"&subject="+subject+"&message="+message+"&ms=" + new Date().getTime(), true);
 	httpObj['sendMail'].onreadystatechange = handleSendMailResponse;
 	httpObj['sendMail'].send(null);	
}


function handleDelMailResponse()
{
	if (httpObj['delMail'].readyState == 4) 
		{
        	if(httpObj['delMail'].status==200) 
			{				
            	 var results = httpObj['delMail'].responseText;
              	 document.getElementById('msg_alert').innerHTML = results;
				 var username = document.getElementById('session_user').value;
				 document.location = '?disp_page=mail.inbox&username='+username+"&ms=" + new Date().getTime();
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('session_ind').innerHTML = "Logging Out...";
			
		  }
}



function deleteMail()
{
	var i=0;
	var messagesToDelete = document.getElementsByName('msg_check[]');
	var deleteList="";
	
	for(i=0;i<messagesToDelete.length;i++)
	{	
		if(messagesToDelete[i].checked)
		{
			deleteList += messagesToDelete[i].value+";";
		}
	}
	
	
	httpObj['delMail'] = getHTTPObject();		
	httpObj['delMail'].open("GET", "php/mail.delete.php?deleteList="+deleteList+"&ms=" + new Date().getTime(), true);
 	httpObj['delMail'].onreadystatechange = handleDelMailResponse;
 	httpObj['delMail'].send(null);	
}



function checkBlog()
{
	var filter = document.getElementById('filter_feed').value;

	if(filter.length > 0)
	{
		var page = 	"php/blog.feed.php?filter="+filter+"&ms=" + new Date().getTime();		
	 	//alert(filter);
	}
	else
	{
		var page = 	"php/blog.feed2.php?ms=" + new Date().getTime();
	}
	
	var httpO = getHTTPObject();		
	httpO.open("GET",page,true);
 	httpO.onreadystatechange = function(){
				
			if (httpO.readyState == 4) 
			{
        		if(httpO.status == 200) 
				{				
            		var results = httpO.responseText;
					
              	 	document.getElementById('blog_feed').innerHTML = results;				 
				}
         	}
		 	else
		 	{
			
			
		  	}
		};
 	httpO.send(null);		
}


function pingBlogs()
{
	
}


function refreshBlog(blog_id)
{
	var httpO = getHTTPObject();		
	httpO.open("GET",'php/blog.get.php?blog_id='+blog_id+'&ms='+new Date().getTime(),true);
 	httpO.onreadystatechange = function(){
				
			if (httpO.readyState == 4) 
			{
        		if(httpO.status == 200) 
				{				
            		var results = httpO.responseText;
					
					var div = document.createElement("DIV");
					div.id = 'blog_'+blog_id;	
					div.className = "media";				
					
              	 	document.getElementById('blog_temp_div').innerHTML = results;
					document.getElementById('all_blogs_div').insertBefore(div,document.getElementById('all_blogs_div').childNodes[0]);
					document.getElementById('blog_'+blog_id).innerHTML = document.getElementById('new_blog_'+blog_id).innerHTML					
					//						 
				}
         	}
		 	else
		 	{
			
			
		  	}
		};
 	httpO.send(null);			
}

function getBlogs()
{
	if(!document.getElementById('last_refresh'))
	{
		return;	
	}
	
	
	var date_refresh = document.getElementById('last_refresh').value;
	
	var httpO = getHTTPObject();		
	httpO.open("GET",'php/blog.check.php?last_refresh='+date_refresh+'&ms='+new Date().getTime(),true);
 	httpO.onreadystatechange = function(){
				
			if (httpO.readyState == 4) 
			{
        		if(httpO.status == 200) 
				{				
            		var results = httpO.responseText;
					
              	 	document.getElementById('blog_precheck_div').innerHTML = results;	
					
					if(document.getElementById('doGetBlogs').value == 1)
					{
						document.getElementById('last_refresh').value = document.getElementById('last_refresh_new').value;
						
						var update_blog_ids = document.getElementById('blog_id_list').value.split(',')
						
						update_blog_ids.forEach(function(entry) {
    						//console.log(entry);
							refreshBlog(entry)
						});
					}			 
				}
         	}
		 	else
		 	{
			
			
		  	}
		};
 	httpO.send(null);	
}

function handleSearchUsersdReponse()
{
	
}

function searchUsers()
{
	var httpO;
	var username = document.getElementById('search_str').value;
	httpO = getHTTPObject();		
	httpO.open("GET", "search.users.php?username="+username+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){		
			if (httpO.readyState == 4) 
			{
        		if(httpO.status==200) 
				{				
            		var results = httpO.responseText;
              		document.getElementById('search_results').innerHTML = results;				 
				}
         	}
		 	else
		 	{
			//document.getElementById('session_ind').style.color = "#ff0000";
				document.getElementById('search_results').innerHTML = "Searching...";
			}	
		};
 	httpO.send(null);		
}



function handleAddBlogReponse()
{
	if (httpObj['addBlog'].readyState == 4) 
		{
        	if(httpObj['addBlog'].status==200) 
			{				
            	 var results = httpObj['addBlog'].responseText;
              	 //document.getElementById('search_results').innerHTML = results;				 
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('search_results').innerHTML = "Searching...";
			checkBlog();
		  }	
}


function addBlog(source,recv)
{
	if(document.getElementById(source).value.length == 0)
	{
		document.getElementById(source).focus();
		return;	
	}
	
	var blog = document.getElementById(source).value;
	
	//lostFocus(document.getElementById('"user_status'));
	document.getElementById(source).value = "";
	document.getElementById(source).blur();
	httpObj['addBlog'] = getHTTPObject();		
	httpObj['addBlog'].open("GET", "php/blog.add.php?blog="+blog+"&recv="+recv+"&ms=" + new Date().getTime(), true);
 	httpObj['addBlog'].onreadystatechange = handleAddBlogReponse;
 	httpObj['addBlog'].send(null);		
}


function handleDelBlogReponse()
{
	if (httpObj['delBlog'].readyState == 4) 
		{
        	if(httpObj['delBlog'].status==200) 
			{				
            	 var results = httpObj['delBlog'].responseText;
              	 //document.getElementById('search_results').innerHTML = results;				 
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			//document.getElementById('search_results').innerHTML = "Searching...";
			checkBlog();
		  }	
}


function delBlog(blog_id)
{
	//var blog = document.getElementById(source).value;
	//document.getElementById(source).value = "";
	httpObj['delBlog'] = getHTTPObject();		
	httpObj['delBlog'].open("GET", "php/blog.delete.php?blog_id="+blog_id+"&ms=" + new Date().getTime(), true);
 	httpObj['delBlog'].onreadystatechange = handleDelBlogReponse;
 	httpObj['delBlog'].send(null);		
}





function saveProfile()
{
	
	var username = document.getElementById('session_user').value;
	var fName = document.getElementById('fName').value;
	var lName = document.getElementById('lName').value;
	var gender = "";
	var job_title = document.getElementById('job_title').value;
	var ext = document.getElementById('ext').value;
	var cugNo = document.getElementById('cugNo').value;
	var dept_id = document.getElementById('dept_id').value;
	var empNo = document.getElementById('empNo').value;
	
	if(document.getElementById('gender_F').checked)
	{
		gender = "F";
	}
	else if(document.getElementById('gender_M').checked)
	{
		gender = "M";
	}
	

	var httpO = getHTTPObject();		
	httpO.open("GET", "php/profile.save.php?username="+username+"&fName="+fName+"&lName="+lName+"&gender="+gender+"&job_title="+job_title+"&ext="+ext+"&cugNo="+cugNo+"&dept_id="+dept_id+"&empNo="+empNo+"&ms=" + new Date().getTime(), true);
	
 	httpO.onreadystatechange = function(){		
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('profile_msg').innerHTML = results;				 
			}
         }
		 else
		 {
			//document.getElementById('session_ind').style.color = "#ff0000";
			document.getElementById('profile_msg').innerHTML = "Saving...";
			
		  }			
	};
 	httpO.send(null);		
}



function getAudioVideo(download_id)
{
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/video.php?download_id="+download_id+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('av_div').innerHTML = results;				 
			}
         }
		 else
		 {
			document.getElementById('profile_msg').innerHTML = loadImage;
		 }		
	};
 	httpO.send(null);			
}


function getDateTime()
{
	httpObj['dateTime'] = getHTTPObject();		
	httpObj['dateTime'].open("GET", "php/getDateTime.php?"+"&ms=" + new Date().getTime(), true);
 	httpObj['dateTime'].onreadystatechange = function(){
		
		
		
		if (httpObj['dateTime'].readyState == 4) 
		{
        	if(httpObj['dateTime'].status==200) 
			{				
            	 var results = httpObj['dateTime'].responseText;
              	 document.getElementById('divClock').innerHTML = results;				 
			}
         }
		 else
		 {
			//document.getElementById('divClock').innerHTML = "loading..";
		 }
	};
 	httpObj['dateTime'].send(null);			
}



function showAddComment(blog_id,blog,owner_id)
{
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/blog.comment.php?ms="+new Date().getTime()+"&blog="+escape(blog)+"&blog_id="+blog_id+"&owner_id="+owner_id, true);
 	httpO.onreadystatechange = function(){		
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
				 document.getElementById('new_comment_'+blog_id).innerHTML = results;				 
				 document.getElementById('new_comment_value_'+blog_id).focus();
			}
         }
		 else
		 {
			document.getElementById(blog).innerHTML = "One Moment Please...";
		 }
		
		
		
		
		
		
		};
 	httpO.send(null);			
}



function addBlogComment(blog_id,blog,owner_id)
{
	var comment = document.getElementById('new_comment_value_'+blog_id).value;
	
	if(comment == "")
	{
		showSystemMessage('error',"You must write something","Comment field empty");
		return;	
	}
	
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/blog.comment.write.php?ms="+new Date().getTime()+"&comment="+comment+"&blog_id="+blog_id, true);
 	httpO.onreadystatechange = function(){		
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById(blog).innerHTML = results;
				 				 
				 refreshBlog(blog_id)
				 //refreshComments(blog_id,blog);
				 
				if(document.getElementById('isError').value == 0)
				{
					var address = document.getElementById('owner_email').value;
					var name = "";
					var subject = "Comment Posted on your blog";
					var message = "Someone has posted a comment on your blog <a href=\"http://intranet\">click here</a> to check";
				 	//sendEmail(address,name,subject,message);					
				}	
				else
				{
					showSystemMessage('error','Could Not Post Comment at this time, Please try again later','Error Adding Comment')	
				}			 
			}
         }
		 else
		 {
			document.getElementById(blog).innerHTML = "Adding Comment..";
		 }
	};
 	httpO.send(null);			
}



function refreshComments(blog_id,blog)
{

	
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/blog.comments.get.php?"+"&ms=" + new Date().getTime()+"&blog_id="+blog_id, true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('comments_'+blog_id).innerHTML = results;
				 checkBlog();
				 blogIntervalID = self.setInterval("checkBlog()",5000);
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }
	};
 	httpO.send(null);			
}

function commentLoseFocus(commentBox)
{
	
}


function getUserCount()
{
	if(!document.getElementById('user_count'))
	{
		return;
	}
	
	httpObj['getUserCount'] = getHTTPObject();		
	httpObj['getUserCount'].open("GET", "php/onlineusers.count.php?"+"&ms=" + new Date().getTime(), true);
 	httpObj['getUserCount'].onreadystatechange = function(){
		
		
		
		if (httpObj['getUserCount'].readyState == 4) 
		{
        	if(httpObj['getUserCount'].status==200) 
			{				
            	 var results = httpObj['getUserCount'].responseText;
				 
              	 	document.getElementById('user_count').innerHTML = results;				
				 
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }
		
		
		
		
		
		
		};
 	httpObj['getUserCount'].send(null);	
	
	
}



function addArtComment(article_id)
{
	var comment = document.getElementById('comment').value;
	if(comment == "") return;
	
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/articles.comment.add.php?"+"&ms=" + new Date().getTime()+"&article_id="+article_id+"&comment="+comment, true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('msg').innerHTML = results;	
				 if(document.getElementById('isError').value == 1)
				 {
					alert('Error Adding Comment');
				 }
				 else
				 {
					 document.getElementById('comment').value = "";
					 document.getElementById('addComment').value = "Please Wait...";
					 document.getElementById('addComment').disabled = true;
					setTimeout("document.getElementById('addComment').disabled = false; document.getElementById('addComment').value = \"comment\"",10000);	 
					
					var date_added = document.getElementById('date_added').value;
					var username = document.getElementById('author').value;
					
					var content = "<img src=\"images/site_icons/user.gif\" />&nbsp; <b>|</b> <b><font color=green>"+username+"</font></b> :: " + date_added + "<br>"+comment;
					
					addToTable('comments',content,"newComm");
				 }
			}
         }
		 else
		 {
			 
			
		 }
		};
 	httpO.send(null);			
}



function checkIM()
{
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/im.check.php?ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('imMsgDiv').innerHTML = results;				
				 
				 if(document.getElementById('isNewIM'))
				 {
				 	if(document.getElementById('isNewIM').value != 0)
				 	{
						showIMPop(document.getElementById('isNewIM').value);
									
						var newMsgDiv = document.createElement('input');
						newMsgDiv.id = 'IMmsg_'+document.getElementById('isNewIM').value
						newMsgDiv.value = document.getElementById('isNewIM').value;
				 	}
				 	else
				 	{
						//toastr.warning('Nothing New') 
					}
				 }
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }		
	};
 	httpO.send(null);			
}

function showIMPop(msg_id)
{
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/im.get.php?msg_id="+msg_id+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('newMsg').innerHTML = results;	
				 
				 
				 			
				var message = document.getElementById('im_msg_'+msg_id).innerHTML;
				var sender = document.getElementById('im_sender_'+msg_id).innerHTML;
				var sender_username = document.getElementById('im_sender_username_'+msg_id).innerHTML;
				
				
				if(document.getElementById('msg_user_div')) //if the chat is open dont bother to popup message
				{
					imRefreshIMSession(sender_username);
					document.getElementById('msg_text').focus();
				}
				
				toastr.warning('<img src=\'php/findDefaultProfileImg.php?username='+sender_username+'&dim=40x40\'><br>'+message,sender+' Says:',
				{
					onclick: function() {showIMForm(sender_username)},
					positionClass: 'toast-bottom-left',
					closeButton: true,
					timeOut:0,
					extendedTimeOut:0,
					tapToDismiss:false,
					progressBar:true
					
					
					/******/
					
  
					/******/
				});	
				
				window.focus();	
									
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }		
	};
 	httpO.send(null);	
	
	//////////
	

}

function imSend()
{
	//if(document.getElementById('msg_text').value.length == 0 && document.getElementById('recvr').value.length == 0) return;
	
	//alert(document.getElementById('msg_text').value.length)

	if(document.getElementById('msg_text').value.length == 0)
	{
		showSystemMessage('error','Cannot Send Empty Message, Obviously','Action Not Allowed')
		document.getElementById('msg_text').focus();
		return;	
	}
	
	var message = document.getElementById('msg_text').value;
	var recvr = document.getElementById('recvr').value;
	document.getElementById('msg_text').value = ""; //clear message string, obviously
	
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/im.send.php?msg="+escape(message)+"&recvr="+recvr+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('system_response').innerHTML = results;	
				 imRefreshIMSession(recvr)				 
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }		
	};
 	httpO.send(null);	
}

function imRefreshIMSession(recvr)
{
	//recvr = document.getElementById('recvr').value;
	var httpO = getHTTPObject();		
	httpO.open("GET", "php/im.session.php?recvr="+recvr+"&ms=" + new Date().getTime(), true);
 	httpO.onreadystatechange = function(){
		
		if (httpO.readyState == 4) 
		{
        	if(httpO.status==200) 
			{				
            	 var results = httpO.responseText;
              	 document.getElementById('msg_user_div').innerHTML = results;
				 document.getElementById('msg_user_div').scrollTop = document.getElementById('msg_user_div').scrollHeight	
				 
				 
				 $("#msg_user_div").animate({
        			scrollTop: $("#msg_user_div").scrollHeight
    				}, 500);
			}
         }
		 else
		 {
			//document.getElementById(blog).innerHTML = "Adding Comment..";
		 }		
	};
 	httpO.send(null);
}

function addToTable(id,content,newId)
{
	var table = document.getElementById(id);
	
	var newRow = document.createElement("tr");
	var newCol = document.createElement("td");
	
	newRow.appendChild(newCol);
	
	table.appendChild(newRow);
	
	newCol.id = newId;
	newCol.innerHTML = content;
}



function requestStats()
{
	var http = getHTTPObject();
	var article_id = document.getElementById('article_id').value;
	
	http.open("GET", statsUrl+"?news_id="+article_id, true);
	http.onreadystatechange = function()
	{
		
		if (http.readyState == 4) 
		{
        	if(http.status==200) 
			{				
           		var results = http.responseText;
            	document.getElementById('controlPanel').innerHTML = results;			
			}
         }
		 else
		 {
			document.getElementById('controlPanel').innerHTML = loadImage;
		 }	
	};
    http.send(null);		
}


        
		
function requestDeleteImage(img_id) 
{     
	var http = getHTTPObject();
	var choice = confirm("Are you sure you want to delete?");
			
	if(!choice)
	{
		return;
	}
			
	http.open("GET", deleteImgUrl+"?img_id="+escape(img_id)+"&ms=" + new Date().getTime(), true);
	http.onreadystatechange = function()
	{
		if (http.readyState == 4) 
		{
    		if(http.status==200) 
			{
				var results=http.responseText;
            	document.getElementById('message').innerHTML = results;				 
				requestImages(document.getElementById('id_num').value);				 
			}
		}
		else
		{
			document.getElementById('message').innerHTML = loadImage;
		}	
	};
    http.send(null);
}
	   
	   
function requestComment(art_id) 
{     
	var http = getHTTPObject();
	http.open("GET", commentsUrl+"?art_id="+escape(art_id)+"&ms=" + new Date().getTime(), true);
	http.onreadystatechange = function()
	{
		if (http.readyState == 4) 
		{
    		if(http.status==200) 
			{
				var results=http.responseText;
            	document.getElementById('controlPanel').innerHTML = results;
			}
     	}
	 	else
	 	{
			document.getElementById('controlPanel').innerHTML = loadImage;
	 	}
	};
    http.send(null);
}
		
function requestImages(art_id) 
{     
	var http = getHTTPObject();

	http.open("GET", imgUrl+"?art_id="+escape(art_id)+"&ms=" + new Date().getTime(), true);
	http.onreadystatechange = function()
	{
		if (http.readyState == 4) 
		{
     		if(http.status==200) 
			{
				var results=http.responseText;
            	document.getElementById('controlPanel').innerHTML = results;
			}
   		}
		else
		{
			document.getElementById('controlPanel').innerHTML = loadImage;
		}			
	};
    http.send(null);
}


function getUserList(obj,onclick)
{
	if(obj.value.length == 0){ hideUserList();  return;}
	var httpO = getHTTPObject();
	httpO.open("GET", "php/search.username.php?username="+obj.value+"&ms=" + new Date().getTime()+"&onclick="+onclick,true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
								
				document.getElementById('userListDiv').style.visibility = "visible";
				document.getElementById('userListDiv').innerHTML = results;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
				
		
	};
	httpO.send(null);
}

function hideUserList()
{
	document.getElementById('userListDiv').style.visibility = "hidden";
}


function searchEDirectory(page)
{
	var fName = document.getElementById('txtFName').value;
	var lName = document.getElementById('txtLName').value;
	var ext = document.getElementById('txtExt').value;
	var dept = document.getElementById('department').value;
	
	httpObj['searchEDirectory'] = getHTTPObject();
	httpObj['searchEDirectory'].open("GET", "php/search.profile.php?fName="+fName+"&lName="+lName+"&ext="+ext+"&dept="+dept+"&page="+page+"&ms=" + new Date().getTime(),true);
	
	httpObj['searchEDirectory'].onreadystatechange = function()
	{
		if(httpObj['searchEDirectory'].readyState ==4)
		{
			if(httpObj['searchEDirectory'].status == 200)
			{
				var results = httpObj['searchEDirectory'].responseText;
								
				//document.getElementById('userListDiv').style.visibility = "visible";
				document.getElementById('search_results').innerHTML = results;
				document.getElementById('res_count').innerHTML = document.getElementById('resCount').value;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
				
		
	};
	httpObj['searchEDirectory'].send(null);
}


function purge(d) 
{
    var a = d.attributes, i, l, n;
    if (a) 
	{
        l = a.length;
        for (i = 0; i < l; i += 1) 
		{
            n = a[i].name;
            if (typeof d[n] === 'function') 
			{
                d[n] = null;
            }
        }
    }
    a = d.childNodes;
    if (a) 
	{
        l = a.length;
        for (i = 0; i < l; i += 1) 
		{
            purge(d.childNodes[i]);
        }
    }
}

function addNotification(notice_title,notice,date_exp,app_id,require_confirm)
{
	var httpO = getHTTPObject();
	httpO.open("GET", "php/notification.send.php?notice_title="+notice_title+"&notice="+notice+"&date_exp="+date_exp+"&app_id="+app_id+"&require_confirm="+page+"&ms=" + new Date().getTime(),true);
	
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
								
				//document.getElementById('userListDiv').style.visibility = "visible";
				document.getElementById('search_results').innerHTML = results;
				document.getElementById('res_count').innerHTML = document.getElementById('resCount').value;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
				
		
	};
	httpO.send(null);		
}

function checkNotification()
{
	//alert('test');
	var httpO = getHTTPObject();
	httpO.open("GET", "php/notification.check.php?ms=" + new Date().getTime(),true);
	
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				
				document.getElementById('notificationResponse').innerHTML = results;
				
				if(!document.getElementById('notification_count'))
				{ 
					return; 
				}
				
				
				if(document.getElementById('notification_count').value > 0)
				{
					showSystemMessage('info',document.getElementById('notification_title').innerHTML,'New Notification')
				}
				
			}
			else
			{
				//alert("A problem has occured. Contact your database administrator");
			}
		}
				
		
	};
	httpO.send(null);	
}

function checkNotificationEmails()
{
	
	var httpO = getHTTPObject();
	
	httpO.open("GET", "php/notification.email.check.php?ms=" + new Date().getTime(),true);
	
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;					
				
			}
			else
			{
				//alert("A problem has occured. Contact your database administrator");
			}
		}	
		
	};
	httpO.send(null);	
}

function confirmNotice(confirmUrl,choice)
{
	var httpO = getHTTPObject();
	httpO.open("GET", confirmUrl+"&ms=" + new Date().getTime(),true);
	
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				showSystemMessage('info',results,"Notification System");
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
	};
	httpO.send(null);	
}


function sendEmail(address,name,subject,message)
{
	var httpO = getHTTPObject();
	httpO.open("GET", "php/sendMail.xmailer.php?ms=" + new Date().getTime()+"&address="+address+"&name="+name+"&subject="+subject+"&message="+message,true);
	
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState ==4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
	};
	httpO.send(null);	
}


function showPopup3(page,params,exec)
{
	params = params.replace(',','&');
	var httpO = createObject();
	httpO.open("GET", page+"?"+params+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				
				/*$('#systemModal').on('show', function () 
				{
					alert('works')
					//$(this).find('.modal-body').css({width:'auto',height:'auto','max-height':'100%'});
				});*/
				
				$('#systemModal').modal('show')
										
				document.getElementById('systemModalBody').innerHTML = results;	
				document.getElementById('current_url').value = page;		
				document.getElementById('current_params').value = params;	
				document.getElementById('current_exec').value = exec;	
								
				
				//setTimeout(exec,100);
				if(exec.length > 0)
				{
					//alert(exec.length)
					setTimeout(exec,600);
				}
				
				if(document.getElementById('deadline'))
				{
					$('#deadline').datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]});
				}
				
				$('.date_picker').datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]});
				$('.date_picker').css({'z-index':2001});
				
				
				if(document.getElementById('username_input'))
				{
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
					$( ".username_input" ).autocomplete( "option", "appendTo", ".eventInsForm" );
				}
				
				
				$( ".filenumber_input" ).autocomplete({
      				source: "php/search.filetracker_fileNumber.json.php",
      				minLength: 1,
      				select: function( event, ui ){
		 								 
		  			/*if(ui.item)
		 	 		{
		  				if(document.getElementById('fName'))
						{
							document.getElementById('fName').value = ui.item.fName
						}
						if(document.getElementById('lName'))
						{
							document.getElementById('lName').value = ui.item.lName	
						}	
						if(document.getElementById('email'))
						{
							document.getElementById('email').value = ui.item.email	
						}					
		  			}*/
      			}
    				});	

				$( ".filenumber_input" ).autocomplete( "option", "appendTo", ".eventInsForm" );
						
				$( ".username_input" ).autocomplete({
      				source: "php/search.username.json.php",
      				minLength: 2,
      				select: function( event, ui ){
		 								 
		  			if(ui.item)
		 	 		{
		  				if(document.getElementById('fName'))
						{
							document.getElementById('fName').value = ui.item.fName
						}
						if(document.getElementById('lName'))
						{
							document.getElementById('lName').value = ui.item.lName	
						}	
						if(document.getElementById('email'))
						{
							document.getElementById('email').value = ui.item.email	
						}					
		  			}
      			}
    				});	
					
					$( ".username_input" ).autocomplete( "option", "appendTo", ".eventInsForm" );
					$('.username_input').css({'z-index':2005});
				
				if(document.getElementById('category_sub_search'))
				{
					$( "#category_sub_search" ).autocomplete({
      				source: "applications/inventory/php/search.categorySub.json.php",
      				minLength: 2,
      				select: function( event, ui ) {
		
		  			if(ui.item)
		  			{
		  				//showSystemMessage('info','User Selected: '+ui.item.value,'Action Missing')
						if(document.getElementById('cat'))
						{
							document.getElementById('cat').value = ui.item.category_id
						}
						if(document.getElementById('subCat_2'))
						{
							document.getElementById('subCat_2').value = ui.item.category_sub_id
						}
						if(document.getElementById('selected_sub_category'))
						{
							document.getElementById('selected_sub_category').innerHTML = 'Category: '+ui.item.category_sub
						}					
		  			}
      				}
    				});	
				}
				
				
				
				if(document.getElementById('datetimepicker2'))
				{
					$(function(){$('#datetimepicker2').datetimepicker({language: 'en',pick12HourFormat: true});});	
				}
				
				$("[data-toggle=tooltip").tooltip();
			}
			else
			{
				showSystemMessage("error","A problem has occured. Contact your database administrator","System Error!");
				//alert("A problem has occured. Contact your database administrator");
			}
		}
		else
		{
			document.getElementById('systemModalBody').innerHTML = "Getting Content...";
		}		
	};
	httpO.send(null);
	
	
}

function hidebox()
{
	$('#systemModal').modal('hide')
}


function injectPage(page,params,exec,target_dom)
{
	
	if(!document.getElementById(target_dom))
	{
		showSystemMessage('error','No such target','Target was not found, contact Programmer');
		return;				
	}
	target = document.getElementById(target_dom);
	
	
	params = params.replace(',','&');
	var httpO = createObject();
	httpO.open("GET", page+"?"+params+"&ms=" + new Date().getTime(),true);
		
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;
								
				if(target.nodeName == 'DIV' || target.nodeName == 'SPAN' || target.nodeName == 'TD' || target.nodeName == 'TEXTAREA')
				{
					target.innerHTML =  results; 	
				}
				else
				{
					target = results;	
				}	
				if(exec.length > 0)
				{
					setTimeout(exec,600);
				}
				
				$( ".username_input" ).autocomplete({
      				source: "php/search.username.json.php",
      				minLength: 2,
      				select: function( event, ui ){
		 								 
		  			if(ui.item)
		 	 		{
		  				if(document.getElementById('fName'))
						{
							document.getElementById('fName').value = ui.item.fName
						}
						if(document.getElementById('lName'))
						{
							document.getElementById('lName').value = ui.item.lName	
						}	
						if(document.getElementById('email'))
						{
							document.getElementById('email').value = ui.item.email	
						}					
		  			}
      			}
    				});	
					
					$( ".username_input" ).autocomplete( "option", "appendTo", ".eventInsForm" );
					$('.username_input').css({'z-index':2005});		
         	}
     	}
	};
    httpO.send(null);		
}

function performDBAction(page,params,exec)
{
	
	params = params.replace(',','&');
	
	var httpO = createObject();
	httpO.open("GET", page+"?"+params+"&ms=" + new Date().getTime(),true);
	
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
				try
				{
				var results = JSON.parse(httpO.responseText);
				console.log(results)
				
				if(results[0].isError ==  0)
				{
					showSystemMessage('success',results[0].success_msg_title,results[0].success_msg);
					eval(exec);	
				}					
				else
				{
					showSystemMessage('error',results[0].error_msg_title,results[0].error_msg)	
				}
				}
				catch(err)
				{
					//showSystemMessage('error','Error','There was a problem with JSON results, Contact Administrator')		
				}
         	}
     	}
	};
    httpO.send(null);
}

function showPopupReload()
{
	showPopup3(document.getElementById('current_url').value,document.getElementById('current_params').value,document.getElementById('current_exec').value);	
}

function showIMForm(recvr)
{
	showPopup3('php/im.form.php','recvr='+recvr,'document.getElementById(\'msg_text\').focus();imRefreshIMSession(\''+recvr+'\');');
	//document.getElementById(\'now_chatting\').innerHTML = recvr;
}

function getProfilePhotos(container)
{
	var httpO = createObject();
	httpO.open("GET", "php/profile.getphotos.php?ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				
				document.getElementById(container).innerHTML = results;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
		else
		{
			document.getElementById(container).innerHTML = "Getting Content...";
		}
				
		
	};
	httpO.send(null);
}

function deletePhoto(img_id,container)
{
	if(!confirm("Are You Sure You Want To Delete this Photo?"))
	{
		return;	
	}
	
	var httpO = createObject();
	httpO.open("GET", "php/profile.photo.delete.php?img_id="+img_id+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				//document.getElementById(container).innerHTML = results;
				getProfilePhotos(container);
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
		else
		{
			//document.getElementById(container).innerHTML = "Getting Content...";
		}
				
		
	};
	httpO.send(null);
}

function selectDefaultPhoto(img_id,container)
{
	var httpO = createObject();
	httpO.open("GET", "php/profile.selectdefaultphoto.php?img_id="+img_id+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
				
				getProfilePhotos(container);
				refreshDefaultPhoto('default_pic');
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
		else
		{
			//document.getElementById(container).innerHTML = "Getting Content...";
		}
				
		
	};
	httpO.send(null);
}

function refreshDefaultPhoto(container)
{
	document.getElementById(container).src = "#";
	document.getElementById(container).src = 'php/findDefaultProfileImg.php?username='+document.getElementById('session_user').value+'&dim=150x150&ms='+ new Date().getTime();
}

function closePopup()
{
	hidebox();	
	$('#systemModal').modal('hide')
}

function startUpload()
{
	if(document.getElementById('download_type').value == 0)
	{
		return;	
	}
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      //document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success)
{
       
	  document.getElementById('f1_upload_process').style.visibility = "hidden";
	  
	 	if(success)
	  	{	 
			showSystemMessage("success","Upload Complete","Upload Complete") 
	  		//alert("Upload Complete");
			hidebox();
	  	}
	  	else
	  	{
			showSystemMessage("error","Sorry Upload Failed, Please Try Again, If Error persists Contact ICT Unit","Upload Failed") 
			//alert("Sorry Upload Failed, Please Try Again, If Error persists Contact ICT Unit");
	   	}
	  
      return true;   
}


function getDownloadsList()
{
	var httpO = createObject();
	httpO.open("GET", "php/downloads.get.list.php?ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				//var results = httpO.responseText;
				document.getElementById('downloadListDiv').innerHTML = httpO.responseText;
				
				
				if(document.getElementById('download_list_current').value != document.getElementById('download_list_new').value)
				{
					document.getElementById('download_list_current').value = document.getElementById('download_list_new').value;
					//refresh download list	
					getDownloadsDisplay();
					showSystemMessage('info','A User has Uploaded a File','New Downloads Detected')
				}
				
			}
			else
			{
				
			}
		}
		else
		{
			//document.getElementById(container).innerHTML = "Getting Content...";
		}
	};
	httpO.send(null);
}

function getDownloadsDisplay()
{
	var httpO = createObject();
	httpO.open("GET", "php/downloads.get.php?ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				document.getElementById('downloadDisplayDiv').innerHTML = httpO.responseText;
			}
			else
			{
				
			}
		}
		else
		{
			//document.getElementById(container).innerHTML = "Getting Content...";
		}
	};
	httpO.send(null);
}

function searchFiles()
{
	if(document.getElementById('search_str').value.length == 0)
	{
		showSystemMessage("error","Cannot Search with Blank Search","Blank Search");
		return;	
	}
	var search_str = document.getElementById('search_str').value;
	var httpO = createObject();
	httpO.open("GET", "php/download.search.php?ms=" + new Date().getTime()+"&search_str="+search_str,true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				document.getElementById('search_div').innerHTML = httpO.responseText;
				
				$(function () {$('#myTab li:eq(3) a').tab('show');});
			}			
		}
		else
		{
			//document.getElementById(container).innerHTML = "Getting Content...";
		}
	};
	httpO.send(null);		
}

function submitQuickST()
{
	var httpObj;

	var problem = document.getElementById('problem').value;
	
	if(problem.length == 0)
	{
		document.getElementById('problem').focus();		
	}
	
	var category = 8;
	var owner = document.getElementById('current_user').value;
	
    httpObj = getHTTPObject();
    httpObj.open("GET", "applications/service_ticket/php/service_ticket.add.php?desc="+problem+"&category="+category+"&owner="+owner, true);
	httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('system_msg').innerHTML = results;
				
				if(document.getElementById('isError').value == 0)
				{
					document.getElementById('submitButton').disabled = true;	
				}
         	}
     	}
	};
    httpObj.send(null);	
}

function registerDatePickerInput(input)
{
	$('#deadline').datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]});	
}

function addDownloadPermission(source)
{
	if(document.getElementById(source).value.length == 0)
	{
		document.getElementById(source).focus();
		return;		
	}
	
	var option = document.createElement('option');
	var i;
	var userList = document.getElementById('permissions_list');
	var listStr = document.getElementById('ListStr');
	option.text = document.getElementById(source).value;
	option.value = document.getElementById(source).value;

	if(userList.options[0].value == 0)
	{
		userList.remove(0);		
	}
		
	for(i=0;i < userList.length;i++)
	{
		if(userList.options[i].value == document.getElementById(source).value)
		{
			showSystemMessage("error","Username Already Exists","Duplicate User");
			return;
		}
	}
	listStr.value = "";
	
	try 
	{
    	userList.add(option, null); // standards compliant; doesn't work in IE		
  	}
  	catch(ex) 
	{
    	document.getElementById('permissions_list').add(option); // IE only		
  	}
	
	for(i=0;i < userList.length;i++)
	{
		if(userList.options[i].value != 0)
		{
			if(listStr.value.length > 0)
			{
				listStr.value +=";";
			}
			listStr.value += userList.options[i].value;			
		}
	}
	document.getElementById(source).value = ''	
}

function deleteFile(download_id)
{
	if(!confirm('Are You Sure You Want to Delete this File?'))	
	{
		showSystemMessage('info','Pheew, File is NOT Deleted','That was Close!')
		return;	
	}	
	
	httpObj = getHTTPObject();
    httpObj.open("GET", "php/download.delete.php?download_id="+download_id, true);
	httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				//document.getElementById('system_msg').innerHTML = results;
				
				showSystemMessage('success','File was Deleted Successfully!','File Deleted!');
				$('#systemModal').modal('hide');
         	}
     	}
	};
    httpObj.send(null);		
}

