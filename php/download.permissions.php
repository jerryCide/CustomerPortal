<script>
if(self.opener !=null)   
{
    parentWindow = self.opener;
} 

self.focus();

function addToList(username)
{
	var option = document.createElement('option');
	var i;
	var userList = parentWindow.document.getElementById('permissions_list');
	var listStr = parentWindow.document.getElementById('ListStr');
	option.text = username;
	option.value = username;

	if(userList.options[0].value == 0)
	{
		userList.remove(0);		
	}
	
	
	for(i=0;i < userList.length;i++)
	{
		if(userList.options[i].value == username)
		{
			alert("Username Already Exists");
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
    	parentWindow.document.getElementById('permissions_list').add(option); // IE only
		
		
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
}
</script>
<script type="text/javascript" src="../javascript/ajax_funcs.js"></script>

<table width="100%">
	<tr>
    	<td width="56">
        Search:        </td>
      <td width="300" align="left">
        	<input type="text" id="search_str" onKeyUp="searchUsers(); return false;"/>
      </td>
    </tr>
    <tr>	
    	<td  colspan="2" >
        	<div id="search_results" height="100" style="overflow:auto; height:150px"></div>
        </td>
    </tr>
</table>