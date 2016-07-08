<table width="100%">
	<tr>
    	<td align="center">
        	<h2>Sessions</h2>
        </td>
    </tr>
    <tr>
    	<td id="body" height="100%">
        	
        </td>
    </tr>
</table>
<div id="sessionStat"></div>
<div id="kill_response"></div>
<script>
	getSessions();
	var int = self.setInterval("getSessions()",10000);
</script>