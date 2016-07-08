/****   JQuery    ****/


$(function () {
    $('#ou_department_table').bootstrapTable({
       	url: 'applications/global_admin/controller/ou.getAllDepartments.json.php',
		method: 'get',		
		pagination:true,
		clickToSelect:true,
		pageList:[10,20,30],
		pageSize: 10,
		striped:true,
		showRefresh: true,
		search: true
    });	
});

$(function () {
    $('#ldap_users_table').bootstrapTable({
       	url: 'applications/global_admin/controller/users.getAllLDAPUsers.php',
		method: 'get',		
		pagination:false,
		clickToSelect:true,
		striped:true,
		showRefresh: true,
		search: true
    });	
});

$(function () {
    $('#external_users_table').bootstrapTable({
       	url: 'applications/global_admin/controller/users.getList.php',
		method: 'get',		
		pagination:false,
		clickToSelect:true,
		striped:true,
		showRefresh: true,
		search: true
    });	
});


function dept_formatter(id,row, index) {
        return [            
			
            '<a href="#" onClick="showPopup3(\'applications/global_admin/modals/app.ouMap.modify.php\',\'dept_id='+row.dept_id+'\',\'\'); return false;">'+row.dept_name+'</a>'
            
        ].join('');
    }

function external_user_formatter(id,row, index) {
        return [            
			
            '<a href="#" onClick="showPopup3(\'applications/global_admin/php/user.edit.php\',\'username='+row.user_id+'\',\'\'); return false;">'+id+'</a>'
            
        ].join('');
    }


/*********   END JQuery  ***********/


var httpObj = new Array();




////////////////////////////


function checkScope()
{
	//alert(document.getElementById('private').checked);
	if(!document.getElementById('private').checked)	
	{
		document.getElementById('userList').disabled = true;
		document.getElementById('new_user').disabled = true;
		document.getElementById('add_button').disabled = true;
		document.getElementById('del_button').disabled = true;
	}
	else
	{
		document.getElementById('userList').disabled = false;
		document.getElementById('new_user').disabled = false;
		document.getElementById('add_button').disabled = false;
		document.getElementById('del_button').disabled = false;
	}
}


function getApps()
{	

		httpObj['getApps'] = createObject();
		httpObj['getApps'].open("GET", "applications/global_admin/php/apps.get.php"+"?ms=" + new Date().getTime(),true);
		httpObj['getApps'].onreadystatechange = function(){
			
			
			if(httpObj['getApps'].readyState == 4)
			{
				if(httpObj['getApps'].status == 200)
				{
					var results = httpObj['getApps'].responseText;
			
					document.getElementById('body').innerHTML = results;					
				}
				else
				{
					showSystemMessage('error','Error','Page Does Not Exist')					
				}
			}
			
			
															};
		httpObj['getApps'].send(null);
	
}

function lockApp(lock_val,app_id)
{	

		httpObj['lockApp'] = createObject();
		httpObj['lockApp'].open("GET", "applications/global_admin/php/apps.lock.php?ms=" + new Date().getTime()+"&lock_val="+lock_val+"&app_id="+app_id,true);
		httpObj['lockApp'].onreadystatechange = function(){
			
			
			if(httpObj['lockApp'].readyState == 4)
			{
				if(httpObj['lockApp'].status == 200)
				{
					var results = httpObj['lockApp'].responseText;
					getApps();
					//document.getElementById('body').innerHTML = results;					
				}
				else
				{
					showSystemMessage('error','Error','Page Does Not Exist');
				}
			}
			
			
															};
		httpObj['lockApp'].send(null);
	
}


function createObject()
{
var httpO;
//will call on this block for every other browser except IE
try
	{
	httpO = new XMLHttpRequest();
	
	}
catch(e)
	{
	//Internet Explorer
		try 
		{
		httpO = new ActiveXObject("Msxml2.XMLHTTP");
		
		}
		catch(e)
		{
			try
			{
			httpO = new ActiveXObject("Microsoft.XMLHTTP");
			
			}
			catch(e)
			{
				showSystemMessage('error','Error','Your browser does not support AJAX, Please upgrade your browser');			
			}
		}
	}
	return httpO;

}


function showEditApp(app_id)
{	

	
		httpObj['showEditApp'] = createObject();
		httpObj['showEditApp'].open("GET", "applications/global_admin/php/apps.edit.php?app_id="+app_id+"&ms=" + new Date().getTime(),true);
		httpObj['showEditApp'].onreadystatechange = function(){
			
			
			if(httpObj['showEditApp'].readyState == 4)
			{
				if(httpObj['showEditApp'].status == 200)
				{
					var results = httpObj['showEditApp'].responseText;
			
					document.getElementById('edit_popup').style.visibility = "visible";
					document.getElementById('edit_div').innerHTML = results;
					getAppUsers(app_id);
					
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}
			
			
		};
		httpObj['showEditApp'].send(null);
	
}

/*function getAppUsers(app_id)
{	

	
		httpObj['showEditApp'] = createObject();
		httpObj['showEditApp'].open("GET", "applications/global_admin/php/apps.users.php?app_id="+escape(app_id)+"&ms=" + new Date().getTime(),true);
		httpObj['showEditApp'].onreadystatechange = function(){
			
			
			if(httpObj['showEditApp'].readyState == 4)
			{
				if(httpObj['showEditApp'].status == 200)
				{
					var results = httpObj['showEditApp'].responseText;
			
					document.getElementById('app_users').innerHTML = results;					
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}
			
			
															};
		httpObj['showEditApp'].send(null);
	
}*/


function getAppUsers(app_id)
{
	var userList = document.getElementById('userList');
	
	var httpO = createObject();
 	httpO.open("GET", "applications/global_admin/php/apps.users.php?app_id="+app_id+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function()
	{
	
			if(httpO.readyState ==4)
			{
	 			if(httpO.status == 200)
	 			{
					var results = httpO.responseText;
					document.getElementById('userListResults').innerHTML = results;
					var ui = document.getElementById('userListDB');
					var list = ui.getElementsByTagName('li');
					
					userList.options.length = 0;
					
					for(var i=0;i < list.length;i++)
					{
						option = document.createElement('option');
						option.value = list[i].value;
						option.innerHTML = list[i].innerHTML;
						userList.appendChild(option);								
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


function addUser(app_id)
{	
		if(document.getElementById('app_users').disabled)
		{
			return;
		}
		
		var application_name = document.getElementById('app_name').value;
		
		var username = document.getElementById('username_input').value;
		var isSupervisor = document.getElementById('isSupervisor').checked?1:0;
		
		var httpO = createObject();
		httpO.open("GET", "applications/global_admin/php/apps.users.add.php?app_id="+app_id+"&username="+username+"&isSupervisor="+isSupervisor+"&app_name="+application_name+"&ms=" + new Date().getTime(),true);
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					document.getElementById('addu_msg').innerHTML = results;
					document.getElementById('username_input').value = '';
					document.getElementById('isSupervisor').checked = false;
					getAppUsers(app_id);
					getApps();					
					
					var address = username+"@MWLECC.gov.jm";
					var name = username;
					var subject = "Access given to Intranet application";
					var message = "You have been added to Intranet Application: <b>\""+application_name+"\"</b>, login to <a href=\"http://intranet\">MWH Intranet</a> view applications to see application you have been added to";
					sendEmail(address,name,subject,message);
				}
				else
				{
					showSystemMessage("error","Fatal Error Occured, Contact ICT Division","Fatal Error")
				}
			}
		};
		httpO.send(null);	
}



function deleteUser(app_id)
{	

		var app_map_id = document.getElementById('userList').value;
		var httpO = createObject();
		httpO.open("GET", "applications/global_admin/php/apps.users.delete.php?app_id="+app_id+"&app_map_id="+app_map_id+"&ms=" + new Date().getTime(),true);
		
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					document.getElementById('addu_msg').innerHTML = results;	
					getAppUsers(app_id);
					getApps();
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}
			
		};
		httpO.send(null);
	
}

function saveApp(app_id)
{	

		var app_name = document.getElementById('app_name').value;
		var app_dir = document.getElementById('app_dir').value;
		var app_isonline = document.getElementById('app_isonline').checked?1:0;
		var app_isprivate = document.getElementById('private').checked?1:0;
				
		var httpO = createObject();
		httpO.open("GET", "applications/global_admin/php/apps.save.php?app_id="+app_id+"&app_isprivate="+app_isprivate+"&ms=" + new Date().getTime()+"&app_name="+app_name+"&app_dir="+app_dir+"&app_isonline="+app_isonline,true);
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					document.getElementById('addu_msg').innerHTML = results;	
					getAppUsers(app_id);
					getApps();
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}
		};
		httpO.send(null);
	
}

function showAllApp()
{	
	var httpO = createObject();
	httpO.open("GET", "applications/global_admin/php/apps.showall.php?"+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function(){
			
	if(httpO.readyState == 4)
	{
		if(httpO.status == 200)
		{
			var results = httpO.responseText;
			
			document.getElementById('edit_popup').style.visibility = "visible";
			document.getElementById('edit_div').innerHTML = results;

		}
		else
		{
			alert("Page Does Not Exist");
		}
	}
	};
	httpO.send(null);	
}

function installApp(app_dir)
{
	var httpO = createObject();
	httpO.open("GET", "applications/global_admin/php/apps.install.php?"+"ms=" + new Date().getTime()+"&app_dir="+app_dir,true);
	httpO.onreadystatechange = function()
	{
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
			
				document.getElementById('edit_popup').style.visibility = "visible";
				document.getElementById('edit_div').innerHTML = results;
					//getAppUsers(app_id);
				showAllApp();
				getApps();
			}
			else
			{
				alert("Page Does Not Exist");
			}
		}
	};
			
	httpO.send(null);	
}

function installExternalApp()
{
	if(document.getElementById('app_link').value.length == 0)
	{
		document.getElementById('app_link').focus();
		return;			
	}
	
	installApp('external');
		
	var app_dir = document.getElementById('app_link').value;
	var httpO = createObject();
	httpO.open("GET", "applications/global_admin/php/apps.install.php?"+"&ms=" + new Date().getTime()+"&app_dir="+app_dir,true);
	httpO.onreadystatechange = function()
	{			
		if(httpO.readyState == 4)
		{
			if(httpO.status == 200)
			{
				var results = httpO.responseText;
			
				document.getElementById('edit_popup').style.visibility = "visible";
				document.getElementById('edit_div').innerHTML = results;
					//getAppUsers(app_id);
				showAllApp();
				getApps();
			}
			else
			{
				alert("Page Does Not Exist");
			}
		}
	};
			
	httpO.send(null);		
}

function uninstallApp(app_id)
{	
		if(!confirm("Are you sure you want to Uninstall?"))
		{
			return;	
		}
	
		var httpO = createObject();
		httpO.open("GET", "applications/global_admin/php/apps.uninstall.php?"+"&ms=" + new Date().getTime()+"&app_id="+app_id,true);
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					//document.getElementById('edit_popup').style.visibility = "visible";
					document.getElementById('system_response').innerHTML = results;
					//getAppUsers(app_id);
					showAllApp();
					getApps();
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}			
		};
		httpO.send(null);	
}


function getSessions()
{	
		var httpO = createObject();
		httpO.open("GET", "applications/global_admin/php/sessions.get.php"+"?ms=" + new Date().getTime(),true);
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					document.getElementById('body').innerHTML = results;
					document.getElementById('sessionStat').innerHTML = "";
				}
				else
				{
					alert("Page Does Not Exist");
				}
			}
			else
			{
				document.getElementById('sessionStat').innerHTML = "Updating...";
			}
			
		};
		httpO.send(null);	
}

function killSession(ip,username)
{	
		var httpO = createObject();
		httpO.open("GET", "php/session.kill.php?"+"ip="+ip+"&username="+username+"&ms=" + new Date().getTime(),true);
		httpO.onreadystatechange = function(){
			
			
			if(httpO.readyState == 4)
			{
				if(httpO.status == 200)
				{
					var results = httpO.responseText;
			
					document.getElementById('kill_response').innerHTML = results;					
				}
			}
		};
		httpO.send(null);	
}

function getUserList()
{
	var httpO = createObject();
	httpO.open("GET", "applications/global_admin/php/users.getList.php?ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function(){
				
	if(httpO.readyState == 4)
	{
		if(httpO.status == 200)
		{
			var results = httpO.responseText;
			
			document.getElementById('user_list').innerHTML = results;
		}
	}
	};
	httpO.send(null);		
}


function deleteUser()
{
	if(!confirm('Are You Sure You Want To Delete User?'))
	{
		return;	
	}
 	var app_map_id = document.getElementById('userList').value;
	var httpO = createObject();
	httpO.open("GET", "applications/global_admin/php/app.user.delete.php?app_map_id="+app_map_id+"&ms=" + new Date().getTime(),true);
	httpO.onreadystatechange = function(){
			
			
	if(httpO.readyState == 4)
	{
		if(httpO.status == 200)
		{
			var results = httpO.responseText;
			document.getElementById('test_div').innerHTML = results
			showPopupReload();
			//getUserList();
		}
	}
	};
	httpO.send(null);
}

