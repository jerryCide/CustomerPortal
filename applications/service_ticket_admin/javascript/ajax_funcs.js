/**************************************/

$(function () {	
	
        $('#systemModal').on('shown.bs.modal', function () {
			$(this).find('[autofocus]').focus();				
			
		});		
		
});

/***************************************/

var loadImage = "<table align=center><tr><td align=\"center\"><img src=\"/images/loading_images/ajax-loader.gif/\" border=\"0\"></td></tr><tr><td align=\"center\"><font size=\"-6\"><b>loading...</b></font></td></tr></table>"; //loading image url
var pg = 0;



function assignTicket(service_ticket_id,assign_user)
{
	
	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.assign.php?service_ticket_id="+service_ticket_id+"&assign_user="+assign_user, true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('system_response').innerHTML = results;
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id='+service_ticket_id,'getTasks();getNote(\'\')');
				if(document.getElementById('isError').value == 0)				
				{
					resetNewTicketForm();
					showSystemMessage('success',"New Service Ticket Assigned to User: "+assign_user)
				}
				else
				{
					showSystemMessage('error','Assigning Ticket Failed, Try Again: <br>'+document.getElementById('errorDesc').value)
				}
         	}
     	}
	};
    httpObj.send(null);
}

function rejectTicket(service_ticket_id)
{
	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket.rejectTicket.php?service_ticket_id="+service_ticket_id, true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('system_response').innerHTML = results;
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id='+service_ticket_id,'getTasks();getNote(\'\')');
				
				if(document.getElementById('isError').value == 0)				
				{					
					showSystemMessage('success',"Ticket was REJECTED, Ticket is Toast",'REJECTED')
					document.getElementById('ticket_'+service_ticket_id).innerHTML = "Get that ticket outta here! <span class='glyphicon glyphicon-hand-right'></span>...Ticket Rejected";
				}
				else
				{
					showSystemMessage('error',"Rejection of Ticket Failed!",'Reject Failed')
				}
         	}
     	}
	};
    httpObj.send(null);
}

function setReject(service_ticket_id)
{
	if(document.getElementById('note').value == "")
	{
		document.getElementById('note').focus();
		return;	
	}
		
	if(!confirm("Are You Sure You Want to Reject Ticket?"))
	{
		showSystemMessage('warning','Pheeew THAT was close, Ticket OK','Ticket OK')
		return;	
	}
	
	var note = document.getElementById('note').value;
//	service_ticket_id = document.getElementById('service_ticket_id').value;
	
	performDBAction('applications/service_ticket_admin/php/service_ticket_admin.note.add.php','service_ticket_id='+service_ticket_id+'&note='+escape(note),'');
	rejectTicket(service_ticket_id);
}

function resolveTicket(service_ticket_id,assign_user)
{
	if(!confirm("Are You Sure You Want to Resolve Ticket?"))
	{
		showSystemMessage('warning','Pheeew THAT was close, Ticket OK','Ticket OK')
		return;	
	}	

	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket.resolveTicket.php?service_ticket_id="+service_ticket_id, true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('system_response').innerHTML = results;
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id='+service_ticket_id,'getTasks();getNote(\'\')');
				
				if(document.getElementById('isError').value == 0)				
				{					
					//alert("Ticket was tagged RESOLVED");
					showSystemMessage('success',"Ticket was RESOLVED",'Ticket RESOLVED')
					document.getElementById('ticket_'+service_ticket_id).innerHTML = "OK, we're done here <span class='glyphicon glyphicon-ok'></span>...Ticket resolved ";
				}
				else
				{
					showSystemMessage('error',"Resolve Failed",'Failed')
					//alert("Resolve Failed");
				}
         	}
     	}
	};
    httpObj.send(null);
}

function unresolveTicket()
{
	if(!confirm("Are You Sure You Want to UnResolve Ticket?"))
	{
		showSystemMessage('warning','Pheeew That was Close, Ticket OK','Ticket OK')
		return;	
	}	

	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket.unresolveTicket.php?service_ticket_id="+service_ticket_id, true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('system_response').innerHTML = results;
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id='+service_ticket_id,'getTasks();getNote(\'\')');
				
				if(document.getElementById('isError').value == 0)				
				{					
					//alert("Ticket was tagged UNRESOLVED");
					showSystemMessage('success','Ticket was tagged UNRESOLVED','Ticket Status Set')
					document.getElementById('ticket_'+service_ticket_id).innerHTML = "";
				}
				else
				{
					showSystemMessage('error','Unresolved Failed','Failed')
					//alert("Unresolved Failed");
				}
         	}
     	}
	};
    httpObj.send(null);
}


function getAssignedCount()
{
	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/count.assigned.php?ms=" + new Date().getTime(), true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('count_results').innerHTML = results;	
				if(document.getElementById('countAssignDiv').innerHTML != document.getElementById('countAssigned').value && document.getElementById('countAssignDiv').innerHTML != '-' && document.getElementById('countAssignDiv').innerHTML < document.getElementById('countAssigned').value)
				{
					showSystemMessage('warning','You Were Assigned A Ticket, Please Check','Ticket Assigned')
					
				}
				if(document.getElementById('countAssigned').value > 0)
				{
					document.getElementById('assigned_nav').className = "btn btn-danger";	
				}
				else
				{
					document.getElementById('assigned_nav').className = "btn btn-info";
				}
				document.getElementById('countAssignDiv').innerHTML = document.getElementById('countAssigned').value;
				
         	}
     	}
	};
    httpObj.send(null);
}

function getUnassignedCount()
{
	 var httpObj = getHTTPObject();
     httpObj.open("GET", "applications/service_ticket_admin/php/count.unassigned.php?ms=" + new Date().getTime(), true);
	 httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				
				document.getElementById('count_results').innerHTML = results;	
				
				if(document.getElementById('countUnassignDiv').innerHTML != document.getElementById('countUnassigned').value && document.getElementById('countUnassignDiv').innerHTML != '-' && document.getElementById('countUnassignDiv').innerHTML < document.getElementById('countUnassigned').value)
				{
					showSystemMessage('warning','You Were Assigned A Ticket, Please Check','Ticket Assigned')
					
				}
				if(document.getElementById('countUnassigned').value > 0)
				{
					document.getElementById('unassigned_nav').className += "btn btn-danger";
				}
										
				document.getElementById('countUnassignDiv').innerHTML = document.getElementById('countUnassigned').value;
         	}
     	}
	};
    httpObj.send(null);
}


function getUser(username)
{
	alert(username);
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

function getUserList_st(obj)
{
	if(obj.value.length == 0){ document.getElementById('userListDiv_st').style.visibility = "hidden";  return;}
	httpObj = createObject();
	httpObj.open("GET", "applications/service_ticket_admin/php/search.username.php?username="+obj.value+"&ms=" + new Date().getTime(),true);
	httpObj.onreadystatechange = function()
	{
		if(httpObj.readyState ==4)
		{
			if(httpObj.status == 200)
			{
				var results = httpObj.responseText;
								
				document.getElementById('userListDiv_st').style.visibility = "visible";
				document.getElementById('userListDiv_st').innerHTML = results;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
	};
	httpObj.send(null);	
}

function insertInfo_st(id)
{

	document.getElementById('fName').value = document.getElementById('fName_pick_'+id).value; 
	document.getElementById('lName').value = document.getElementById('lName_pick_'+id).value;
	document.getElementById('ticket_username').value = document.getElementById('username_pick_'+id).value;
	document.getElementById('domain_username').value = document.getElementById('username_pick_'+id).value;
	document.getElementById('email').value = document.getElementById('email_pick_'+id).value;
	hideUserList_st();	

}

function hideUserList_st()
{
	document.getElementById('userListDiv_st').style.visibility = "hidden";
	document.getElementById('fName').disabled = false;
	document.getElementById('lName').disabled = false;
	document.getElementById('email').disabled = false;
//	document.getElementById('warning_div').style.visibility = "hidden";
}


function getInventoryList_st(obj)
{
	if(obj.value.length == 0){ document.getElementById('invListDiv_st').style.visibility = "hidden"; return;}
	httpObj = createObject();
	httpObj.open("GET", "applications/service_ticket_admin/php/search.inventory.php?serial="+obj.value+"&ms=" + new Date().getTime(),true);
	httpObj.onreadystatechange = function()
	{
		if(httpObj.readyState ==4)
		{
			if(httpObj.status == 200)
			{
				var results = httpObj.responseText;
								
				document.getElementById('invListDiv_st').style.visibility = "visible";
				document.getElementById('invListDiv_st').innerHTML = results;
			}
			else
			{
				alert("A problem has occured. Contact your database administrator");
			}
		}
	};
	httpObj.send(null);

/*
	document.getElementById('inventory_ministry_serial').disabled = true;
	document.getElementById('inventory_desc').disabled = true;*/
}

function insertInv_st(id)
{

	document.getElementById('inventory_serial').value = document.getElementById('serial_pick_'+id).value; 
	document.getElementById('inventory_ministry_serial').value = document.getElementById('mwh_serial_pick_'+id).value;
	document.getElementById('inventory_desc').value = document.getElementById('desc_pick_'+id).value;

	hideInventoryList_st();	

}

function hideInventoryList_st()
{
	document.getElementById('invListDiv_st').style.visibility = "hidden";	
}


function addAsset()
{
	if(document.getElementById('inventory_serial').value.length < 1 || document.getElementById('inventory_desc').value.length < 1)
	{
		alert("Cannot Add Without Description and Serial");
		return;
	}
	
	for(var i=0;i < document.getElementById('asset_list').options.length;i++)
	{
		if(document.getElementById('asset_list').options[i].value == document.getElementById('inventory_serial').value)
		{
			alert("Item Already Added");
			return;
		}
		
	}
	
		
	
	var option;
	 //create options and add to select DOM
	 
	option = document.createElement('option');
	option.value = document.getElementById('inventory_serial').value;
	option.title = document.getElementById('inventory_desc').value;
	option.innerHTML = document.getElementById('inventory_desc').value + " [" + document.getElementById('inventory_serial').value + "]";
	document.getElementById('asset_list').appendChild(option);
	
	document.getElementById('inventory_serial').value = '';
	document.getElementById('inventory_ministry_serial').value = '';
	document.getElementById('inventory_desc').value = '';
	 
	 //clear fields for next asset
}

function removeAsset()
{
	if(document.getElementById('asset_list').selectedIndex > -1)
	{
		document.getElementById('asset_list').remove(document.getElementById('asset_list').selectedIndex);
	}
	else
	{
		alert("No Asset Selected");
	}
}

function resetNewTicketForm()
{
	if(document.getElementById('st_system_msg'))
	{
	
		//document.getElementById('st_system_msg').innerHTML = '';
	
		if(document.getElementById('category_id'))
		{
			document.getElementById('category_id').selectedIndex = 0;	
		}
	
		document.getElementById('ticket_username').value = ''
		document.getElementById('problem').value = '';
		document.getElementById('fName').value = '';
		document.getElementById('lName').value = '';
		document.getElementById('ext').value = '';
		document.getElementById('email').value = '';
		document.getElementById('short_desc').value = '';
		document.getElementById('asset_list').options = 0;
		document.getElementById('location').selectedIndex = 0;	
	}
}

function submitST() 
{ 
	
	var problem = escape(document.getElementById('problem').value);
	var category = document.getElementById('category_id').value;
	var owner = document.getElementById('ticket_username').value;
	var fName = escape(document.getElementById('fName').value);
	var lName = escape(document.getElementById('lName').value);
	var tel = escape(document.getElementById('ext').value);
	var email = escape(document.getElementById('email').value);
		
	var deadline = document.getElementById('deadline').value;
	var location = escape(document.getElementById('location').value);
	var short_desc = escape(document.getElementById('short_desc').value);
	
    var httpO = getHTTPObject();
    httpO.open("GET", "applications/service_ticket_admin/php/service_ticket.add.php?desc="+problem+"&category="+category+"&owner="+owner+"&fName="+fName+"&lName="+lName+"&deadline="+deadline+"&location="+location+"&tel="+tel+"&email="+email+"&short_desc="+short_desc+"&ms="+new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;
				
				document.getElementById('st_system_msg').innerHTML = results;
				
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.assign.form.php','param=1','');	
							
					if(document.getElementById('isError').value == 0)
					{
						showSystemMessage('success','New Service Added Successfully','Ticket Created');
						resetNewTicketForm();
					} 
					else
					{
						showSystemMessage('error','Error Adding Service Ticket','Error Adding Ticket')
					}				

     		}
		}
	};
    httpO.send(null);	
}



function startTicket()
{
	
	//check if form is valid
	if(document.getElementById('category_id').selectedIndex == 0)
	{
		document.getElementById('category_id').focus();
		showSystemMessage('error','Category Not Selected','Select appropriate Ticket Category');
		return;	
	}
	
	if(document.getElementById('short_desc').value.length == 0)
	{
		showSystemMessage('error','No Description','Must Enter A Short Description');
		document.getElementById('short_desc').focus();
		return;
	}
	
	if(document.getElementById('problem').value.length == 0)
	{
		document.getElementById('problem').focus();
		showSystemMessage('error','No Description','Please Enter Description of Problem');
		return;
	}
	
	if(document.getElementById('fName').value.length == 0)
	{
		document.getElementById('fName').focus();
		showSystemMessage('error','No First Name','Must Enter First Name');
		return;
	}
	
	if(document.getElementById('lName').value.length == 0)
	{
		document.getElementById('lName').focus();
		showSystemMessage('error','No Last Name','Must Enter Last Name');
		return;
	}
	
	
	
	if(document.getElementById('ext').value.length == 0 && document.getElementById('email').value.length == 0)
	{
		document.getElementById('ext').focus();
		showSystemMessage('error','No EMail Address','You must enter either Email Address or Extension/Phone Number');
		return;
	}
	
	if(document.getElementById('location').selectedIndex == 0)
	{
		document.getElementById('location').focus();
		showSystemMessage('error','No Location','No Location for the Client Selected');
		return;
	}
	
	
	//assign ticket
	submitST();
	
}

function confirmStartTicket()
{
	//validate form before submit	
	
	if(document.getElementById('assign_user').value != 0)	
	{
		var service_ticket_id = document.getElementById('new_service_ticket_id').value;
		assignTicket(service_ticket_id,document.getElementById('assign_user').value); 				
	}	
	
	closePopup();
	resetNewTicketForm();
}

function isEffective(task_id)
{
	if(document.getElementById('task_list'))
	{
		if(document.getElementById('task_list').selectedIndex > -1)
		{
			task_id = document.getElementById('task_list').value;	
		}
		else
		{
			//alert('No Task Selected');
			showSystemMessage('error','No Task Select','Select Task to flag it as effective')
			return;	
		}
	}
	else
	{
		if(!task_id)
		{
			showSystemMessage('error','No Task ID','There was no Task ID sent with request, cannot proceed')
			return;	
		}
	}
	
	var httpObj = getHTTPObject();
    httpObj.open("GET", "applications/service_ticket_admin/controller/service_ticket_admin.task.setEffective.php?task_id="+task_id, true);
	
	httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = JSON.parse(httpObj.responseText);
				
				console.log(results);
				
				if(results['isError'] == 0)
				{
					getTasks();	
					
				}
				
				//document.getElementById('st_system_msg').innerHTML = results;

				/*if(document.getElementById('isError').value == 0)
				{
					//getTasks();
				}
				else
				{
					
				}*/
				
         	}
     	}
	};
    httpObj.send(null);		
}

function addTask()
{
	if(!document.getElementById('current_service_id'))
	{
		alert("No Service Ticket ID Provided");
		return;
	}
	
	
	if( document.getElementById('current_task').value.length == 0)
	{
		alert("Please Enter Task");
		return;
	}
	
	service_ticket_id = document.getElementById('current_service_id').value;
	task = document.getElementById('current_task').value;
	
	var httpObj = getHTTPObject();
    httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.task.add.php?service_ticket_id="+service_ticket_id+"&task="+escape(task), true);
	
	httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				document.getElementById('st_system_msg').innerHTML = results;

				if(document.getElementById('isError').value == 0)
				{
					getTasks();
					
					document.getElementById('current_task').value = '';
				}
				
         	}
     	}
	};
    httpObj.send(null);	
}


function removeTask()
{
	if(document.getElementById('task_list').selectedIndex > -1)
	{
		task_id = document.getElementById('task_list').value;	
	}
	else
	{
		//alert('No Task Selected');
		showSystemMessage('error','No Task Select','Select Task to remove it')
		return;	
	}
	
	
	
	var httpObj = getHTTPObject();
    httpObj.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.task.remove.php?task_id="+task_id, true);
	
	httpObj.onreadystatechange = function() 
	{   
		if (httpObj.readyState == 4) 
		{
			if(httpObj.status == 200) 
			{
         		var results = httpObj.responseText;
				document.getElementById('st_system_msg').innerHTML = results;

				if(document.getElementById('isError').value == 0)
				{
					getTasks();
				}
				else
				{
					alert(document.getElementById('errorMsg').value);	
				}
				
         	}
     	}
	};
    httpObj.send(null);	
}



function getTasks()
{
	if(!document.getElementById('current_service_id'))	
	{
		alert('No Service Ticket ID Provided');
		return;
	}
	else
	{
		service_ticket_id = document.getElementById('current_service_id').value;	
	}
		
	var tasksList = document.getElementById('task_list');
			
	var httpO = createObject();
 	httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.task.get.php?service_ticket_id="+service_ticket_id+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{	
			if(httpO.readyState ==4)
			{
	 			if(httpO.status == 200)
	 			{
					
					var results = httpO.responseText;
					document.getElementById('st_system_msg').innerHTML = results;
					var ui = document.getElementById('tasks_list'); //remote list
					var list = ui.getElementsByTagName('li');
					
					tasksList.options.length = 0;
									
					var option;
					var selected = 0;
					
					for(var i=0;i < list.length;i++)
					{
						option = document.createElement('option');
						option.value = list[i].value;
						option.title = list[i].title;
						option.innerHTML = list[i].innerHTML;
						tasksList.appendChild(option);
					}
				}
				else
				{
					alert("A problem has occured. Contact your database administrator");
				}
			}
	};
	httpO.send(null);
	
}

function addNote()
{
	if(document.getElementById('note_new').value.length == 0)
	{
		document.getElementById('note_new').focus();
		return;	
	}
	
	var service_ticket_id = document.getElementById('current_service_id').value;
	var from = document.getElementById('current_username').value;
	var note = document.getElementById('note_new').value;
	
	
	
	var httpO = getHTTPObject();
    httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.note.add.php?service_ticket_id="+service_ticket_id+"&note="+note+"&from="+from+"&ms=" + new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;
				
				document.getElementById('system_response').innerHTML = results;
				
				
				if(document.getElementById('isError').value == 0)
				{
					showSystemMessage('success',document.getElementById('errorMessage').value,'Response')
					document.getElementById('note_new').value = '';
					getNote('');
				}
				else
				{
					showSystemMessage('error',document.getElementById('errorMessage').value,'Error')
				}
         	}
     	}
	};
    httpO.send(null);
	
}

function getNote(note_id)
{
	if(!document.getElementById('notes_view'))
	{
		return;	
	}
	
	var service_ticket_id = document.getElementById('current_service_id').value;
	
	document.getElementById('notes_view').innerHTML = "Getting Note, Please Wait...";	
		
	var httpO = getHTTPObject();
    httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.note.get.php?note_id="+note_id+"&service_ticket_id="+service_ticket_id+"&ms="+new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;
				
				document.getElementById('notes_view').innerHTML = results;
         	}
     	}
	};
    httpO.send(null);	
}

function nextNote()
{
	var currentPos = 0;
	var note_ids = document.getElementsByName('note_id_nums');	
	var current_note_id = document.getElementById('current').value;	
	
	note_count = note_ids.length;
		
	for(var i=0;i<note_count;i++,currentPos++)
	{
		if(note_ids[i].value == current_note_id)	
		{
			currentPos = i; 
			break;		
		}
	}
	
	
	if(currentPos == (note_count-1))
	{
		return;
	}
	
	getNote(note_ids[currentPos + 1].value);
	
	return false;
}

function prevNote()
{
	var currentPos = 0;
	var note_ids = document.getElementsByName('note_id_nums');	
	var current_note_id = document.getElementById('current').value;	
	
	note_count = note_ids.length;
	
	for(var i=0;i<note_count;i++,currentPos++)
	{
		if(note_ids[i].value == current_note_id)	
		{
			currentPos = i;
			break; 
		}
	}
	
	if(currentPos == 0)
	{
		return;
	}
	
	
	getNote(note_ids[currentPos - 1].value);
}

function moveTaskItem(direction)
{
	taskList = document.getElementById('task_list');
		
	if(taskList.selectedIndex < 0)
	{
		return;
	}
	
	itemCount = taskList.options.length;
	
	if((taskList.selectedIndex == itemCount-1 && direction == "down") || (taskList.selectedIndex == 0 && direction == "up"))
	{
		return;	
	}
	
		
	var currentOption = document.createElement('option');
	currentOption = taskList.options[taskList.selectedIndex];
	
	if(direction == "down")
	{
		taskList.insertBefore(currentOption,taskList.options[taskList.selectedIndex+2]);
	}
	else if(direction == "up")
	{
		taskList.insertBefore(currentOption,taskList.options[taskList.selectedIndex-1]);
	}
}

function updateTasks()
{
	var listString="";
	
	var taskList = document.getElementById('task_list');
	
	for(var i=0;i<taskList.options.length;i++)
	{
		listString += taskList.options[i].index+1+":"+taskList.options[i].value+":"+taskList.options[i].innerHTML+";";
	}
	
	var httpO = getHTTPObject();
	httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.task.update.php?task_list_string="+listString+"&ms=" + new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;			
				document.getElementById('system_response').innerHTML = results;
         	}
     	}
	};
    httpO.send(null);
}

function saveTicket()
{
	if(document.getElementById('current_task'))
	{
		if(document.getElementById('current_task').value.length > 0)
		{
			alert("Cannot Save Without Adding the Current Task! Either clear the task textbox or Click 'Add Task' Button");
			document.getElementById('current_task').focus();
			return false;	
		}
	}
	
	if(document.getElementById('note_new'))
	{
		if(document.getElementById('note_new').value.length > 0)
	 	{
			alert("Cannot Save Without Adding the New Note! Either clear the note textbox or Click 'Add Note' Button");
			document.getElementById('note_new').focus();
			return false;	
	 	}
	}
	
	var service_ticket_id = document.getElementById('current_service_id').value;
	var service_ticket_desc = document.getElementById('service_ticket_desc').value;
		
	var deadline = document.getElementById('deadline').value;
	
	var httpO = getHTTPObject();
	httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.ticket.update.php?service_ticket_id="+service_ticket_id+"&deadline="+deadline+"&service_ticket_desc="+service_ticket_desc+"&ms=" + new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;			
				
				document.getElementById('st_system_msg').innerHTML = results;
				showSystemMessage('success','Ticket Updated','Changes To Ticket Saved!');
				
				updateTasks();
				
				//alert('Changes To Ticket Saved!');
				
         	}
     	}
	};
    httpO.send(null);
	
	
		
}

function searchTickets()
{
	var search_str = document.getElementById('search_str').value;
	var status_id = document.getElementById('status').value;
	var scope = document.getElementById('ticket_scope').value;
	var isFilter = document.getElementById('filter_check').checked;
	
	document.getElementById('results_span').innerHTML = "Please Be Patient...";
	
	document.getElementById('search_results').innerHTML = "<div class=\"progress progress-striped active\"><div class=\"bar\" style=\"width: 100%;\"></div></div>";
	var httpO = getHTTPObject();
	httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.issues.get.php?search_str="+escape(search_str)+"&status_id="+status_id+"&ticket_scope="+scope+"&isFilter="+isFilter+"&ms=" + new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
         		var results = httpO.responseText;			
				document.getElementById('search_results').innerHTML = results;
				document.getElementById('results_span').innerHTML = document.getElementById('results_count').value;
         	}			
     	}
		else
		{
			//document.getElementById('search_results').innerHTML = "Done!...";
			//showSystemMessage('info','Search Complete, Please see results','Done')
		}
	};
    httpO.send(null);		
}

function checkFilter()
{
	document.getElementById('ticket_scope').disabled = !document.getElementById('filter_check').checked;
	document.getElementById('status').disabled = !document.getElementById('filter_check').checked;
}

function printThis()
{
	var currentReport = document.getElementById('currentReport').value;
	var currentWindow;
	
	var report_date = document.getElementById('report_date').value;
	var date_end = document.getElementById('date_end').value;
	currentWindow = window.open('applications/service_ticket_admin/php/'+currentReport+".php?print=1&search_date="+report_date+'&date_end='+date_end, 'print_um','location=0,status=0,scrollbars=0,menubar=0,width=800px,titlebar=0,resizable=0,toolbar=0');	
	//currentWindow.print();
	print_um.doPrint();
	//currentWindow.close();
	
}

function getMonthlyReport()
{
	//alert(document.getElementById('month_p').value);
	var date_report = document.getElementById('year_p').value+"-"+document.getElementById('month_p').value+"-01";	
	
	
	window.location = '?app=service_ticket_admin&page=report.monthly&search_date='+date_report;
}

function findChart()
{
	showPopup3('applications/service_ticket_admin/php/report.chart.top_recv.php','','')	
}

function getReport()
{
	var date_report = document.getElementById('year_p').value+"-"+document.getElementById('month_p').value+"-"+document.getElementById('day_p').value;	
	
	window.location = '?app=service_ticket_admin&page=report.undelivered&search_date='+date_report;
}

function registerDatePickerInput(inputName)
{
	$('#'+inputName).datepicker({format: 'yyyy-mm-dd',daysOfWeekDisabled:[0,6]});		
}

function removeAdmin(username)
{
	if(!confirm('Are you Sure You Want To Remove Admin From Ticket?'))
	{
		return;	
	}
	var service_ticket_id = document.getElementById('current_service_id').value;
	var httpO = getHTTPObject();
	httpO.open("GET", "applications/service_ticket_admin/php/service_ticket_admin.removeAdmin.php?username="+username+"&service_ticket_id="+service_ticket_id+"&ms=" + new Date().getTime(), true);
	httpO.onreadystatechange = function() 
	{   
		if (httpO.readyState == 4) 
		{
			if(httpO.status == 200) 
			{
				showPopup3('applications/service_ticket_admin/php/service_ticket_admin.issue.edit.php','ticket_id='+service_ticket_id,'getTasks();getNote(\'\')');							
				
				//registerDatePickerInput('deadline');
         		///var results = httpO.responseText;			
				//document.getElementById('search_results').innerHTML = results;
				//document.getElementById('results_span').innerHTML = document.getElementById('results_count').value;
         	}			
     	}
		else
		{
			//document.getElementById('search_results').innerHTML = "Done!...";
			//showSystemMessage('info','Search Complete, Please see results','Done')
		}
	};
    httpO.send(null);	
}