<p><img src="images/Ebox Logo.png"></p>

<?php
//include("vars.php");
open_db();

?>

<p><table>
            	<tr>
                	<td>
                    	<a href="?disp_page=ebox.faq" class="slink" title="EBox Frequently Asked Questions"><img src="images/site_icons/asterisk_orange.png" border="0">&nbsp;FAQ</a>
                    </td>
                   
                </tr>
            </table> 
            </p> 
            

<table width="926px" background="images/page_bgs/downloads0.jpg" style="background-repeat:no-repeat; background-position:top left">
<tr>
<td>

<table cellpadding="0" cellspacing="0" width="400px" background="images/transparent_bg_white.png">

<tr> 
	<td height="10">&nbsp;
     
    </td>
</tr>
<tr> 
	<td>
     <table class="adTable" width="100%" background="images/transparent_bg_white.png">
          	<tr>
           		
                <td align="center" valign="top" class="lightbg" background="images/transparent_bg_white.png">
                 <?php
                 	$download_res = mysqli_query($db,"select * from download_tab as dt,download_category_tab as dct where (dct.category_id=19 OR dct.category_id=20) AND dt.category_id = dct.category_id and dt.active = 1 and (dt.date_expire > '$today' or dt.date_expire = '0000-00-00 00:00:00') order by dt.date_added DESC",$db);
					echo "<center><font size=1>";
					echo(mysqli_num_rows($download_res)==0?"No Downloads":"<b>".mysqli_num_rows($download_res)."</b> Download(s) Below");
					echo "</font></center><br>";
					$category = "";
					while($download_row = mysqli_fetch_array($download_res,MYSQL_ASSOC))
					{
					
						?>                    
						<table width="100%" align="center">
                       
                        <?php if($category!= $download_row['category_name']){ ?>
                        	<tr>
                        		<td height="10" colspan="100%">&nbsp;
                            	</td>
                        	</tr>
                        	<tr>
                            	<td colspan="100%">
									<font color="#000000"><b><?=ucfirst($download_row['category_name'])?></b></font>
                                </td>
                            </tr>
                            <?php 
							$category = $download_row['category_name'];
							} ?>
                        	<tr>
                            	<td width="32" valign="top">
                                	<a href="?disp_page=download.view&download_id=<?=$download_row['download_id']?>" title="<?=$download_row['description']?> [click to download]"><img src="images/site_icons/46.png" border="0"/></a>
                                </td>
                            	<td width="251" valign="top" align="justify">
									<font size="1" color="#000000"><b><a href="?disp_page=share.view&download_id=<?=$download_row['download_id']?>" title="<?=$download_row['description']?> [click to download]"><?=$download_row['download_name']!=null?$download_row['download_name']:"[No Name Entered]"?></a></b></font><br><font size="1" color="#000000"><?=$download_row['description']?></font>
                                </td>
                                <td width="91" valign="top">
                               		<font size="1" color="#000000"><i>Added: <?=date("M d, Y",strtotime($download_row['date_added']))?></i></font>
                                </td>
                            </tr>
                        </table>
                        <?php
					}
				 ?>
                </td>
           </tr>
          </table>
    </td>
</tr>
</table>

</td>
</tr>
</table>

<a href="mailto:jodi.munroe@mwlecc.gov.jm?subject=PMAS Question">Email a Question</a>

<?php close_db(); ?>