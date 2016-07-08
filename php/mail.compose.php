
<center>
<table width="300" align="center">
	<tr>
    	<td height="50" colspan="2">
        </td>
    </tr>
	<tr>
    	<td width="80" align="right">
        	<input type="button" id="to_button" value="to:" onClick="javascript:document.open('php/mail.getUsers.php','Search','location=0,status=1,scrollbars=1,menubar=1,width=300,height=300'); return false;">
        </td>
        <td id="to_list">
        	<input size="80" type="text" id="toList" <?php if(!empty($_REQUEST['replyTo'])){ ?>value="<?=$_REQUEST['replyTo']?>"<?php } ?>>
        </td>
    </tr>
    <tr>
    	<td>
        	<b>Subject:</b>
        </td>
        <td>
        	<input size="80" type="text" id="subject" <?php if(!empty($_REQUEST['replyTo'])){ ?>value="RE: <?=$_REQUEST['subject']?>"<?php } ?>>
        </td>
    </tr>
<tr>
	<td valign="top">
    	<b>Message:</b>
    </td>
	<td>
    	
    	<textarea id="message_body" cols="80" rows="10"><?php if(!empty($_REQUEST['forward'])){ ?><?=$_REQUEST['forward']?><?php } ?></textarea>
       
    </td>
</tr>
<tr>
	<td colspan="2" align="right">
    	<input type="button" value="send" onClick="sendMail()"><input type="button" value="Inbox" onClick="gL('?disp_page=mail.inbox&username=<?=$session_user->username?>')">
    </td>
</tr>
<tr>
	<td colspan="2" id="mail_msg">

    </td>
</tr>

</table>
</center>

 <script>
  			//generate_wysiwyg('message_body');
		</script> 