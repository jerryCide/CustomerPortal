<?php 



?>

<table width="90%">
<tr>
	<td>
    	<img src="images/sub_banners/hiv_aids_programme.jpg"/>
    </td>
</tr>
<tr>
<td height="10">

	<table width="100%">
		<tr> 
        	<td width="350">
            	<table class="glow" onclick="window.location='?disp_page=hiv_workplace.info'">
                <tr>
                	<td width="80" height="80" rowspan="100%"><img src="images/hiv_aids_thumbs/1.jpg" class="newsImg"/></td>
                    <td class="smalltext">
            	Check out general information on our Health Corner Information 
                	</td>
                </tr>
                <tr>
                	<td class="smalltext">
                    	<a href="?disp_page=hiv_workplace.info">click here</a>&nbsp;
                    </td>
                </tr>
            	</table>
            </td>
        	<td rowspan="100%" valign="top">
            	<table width="100%" class="smalltext">
                	<tr>
                    	<td width="100%" background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF">Downloads</font>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        
                        
                        
                        <?php
open_db();
$res = mysqli_query($db,"select * from download_tab");
?>

<table cellpadding="0" cellspacing="0" width="100%">

<tr> 
	<td height="10">&nbsp;
     
    </td>
</tr>
<tr> 
	<td>
     <table class="adTable" width="100%">
          	<tr>
           		
                <td align="center" valign="top" class="lightbg">
                 <?php
                 	$download_res = mysqli_query($db,"select * from download_tab as dt,download_category_tab as dct where dt.category_id = dct.category_id and dt.category_id = 5 order by dt.date_added");
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
									<b><?=ucfirst($download_row['category_name'])?></b>
                                </td>
                            </tr>
                            <?php 
							$category = $download_row['category_name'];
							} ?>
                        	<tr>
                            	<td width="16" valign="top">
                                	<a href="<?=$download_row['location']?>" title="<?=$download_row['description']?> [click to download]" target="_blank"><img src="images/site_icons/46.png" border="0"/></a>
                                </td>
                            	<td width="200">
									<font size="1"><a href="<?=$download_row['location']?>" title="<?=$download_row['description']?> [click to download]" target="_blank"><?=$download_row['description']?></a></font>
                                </td>
                                <td>
                               		<font size="1" color="#CCCCCC"><i>Added: <?=getDateStr2($download_row['date_added'])?></i></font>
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

<?php close_db(); ?>
                        
                        
                        
                        
                        		
                        </td>
                    </tr>
                </table>
                <table width="100%">
                	<tr>
                    	<td background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF">Other Links</font>
                        </td>
                    </tr>
                    <tr>
                    	<td height="50">
                        </td>
                    </tr>
                </table>
                <table width="100%" class="smalltext">
                	<tr>
                    	<td background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF">Gallery</font>
                        </td>
                    </tr>
                    <tr>
                    	<td height="50" align="center">
                        	No Photos
                        </td>
                    </tr>
                </table>
                <table width="100%" class="smalltext">
                	<tr>
                    	<td background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF">Useful Contacts</font>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	 <strong>Monica Dystant</strong><br>
 Workplace Programme Officer HIV/AIDS<br>
 Ministry of Water & Housing<br>
telephone: 1-876-501-2926, 1-876-926-5700, 1-876-449-0643<br>
Email: <a href="mailto:monica.dystant@mtw.gov.jm">monica.dystant@mtw.gov.jm</a>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	<hr class="dotted_light" width="100%"/>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	 <strong>Authrine Scarlett </strong><br>
Focal Point, HIV/AIDS <br>
 Ministry of Water & Housing<br>
telephone: 1-876-501-2928, 1-876-926-5700 <br>
Email: <a href="mailto:authrine.scarlett@mhtww.gov.jm">authrine.scarlett@mtw.gov.jm</a>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	<hr class="dotted_light" width="100%"/>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	<img src="images/sub_banners/coordinator_banner_small.jpg" />
                        </td>
                        
                    </tr>
                    
                </table>
                <table width="100%">
                	<tr>
                    	<td background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF">Other Resources</font>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	<font size="1"><a href="http://www.mtw.gov.jm/HIV/safe.aspx">Ministry of Tranport</a></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td width="350">
            	<table class="glow" onclick="window.location='?disp_page=hiv_workplace.faq'">
                	<tr>
                		<td width="80" height="80" rowspan="100%"><img src="images/hiv_aids_thumbs/2.jpg" class="newsImg"/></td>
                    	<td class="smalltext">
            	Some facts and fictions you need to know about HIV/AIDS.</td>
                    </tr>
                    <tr>
                	<td class="smalltext">
                    	<a href="#">click here</a>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        
        <tr>
        	<td width="350" valign="top">
            	<table class="glow">
                	<tr>
                		<td width="80" height="80" rowspan="100%"><img src="images/hiv_aids_thumbs/3.jpg" class="newsImg"/></td>
                    	<td class="smalltext">
            	Where to get tested for HIV/AIDS and finally know where you stand. </td>
                    </tr>
                    <tr>
                	<td class="smalltext">
                    	<a href="#">click here</a>
                    </td>
                </tr>
                </table>
                <hr class="dotted_light" width="100%"/>
                <table width="100%" >
                	<tr>
                    	<td background="images/topLink_bg_hover.jpg">
                        	<font size="1" color="#FFFFFF"> 2008 Calendar of Major Events </font></td>
                            </tr>
                            <tr>
                            <td>
                    	  <table border="0" bgcolor="#EEEEEE" width="100%" class="small_text">
                            <tbody>
                              <tr>
                                <td width="100"><strong>Date</strong></td>
                                <td width="150"><strong>Event</strong></td>
                                <td width="150"><strong>Parish</strong></td>
                              </tr>
                              <tr>
                                <td width="100">February      11 -15</td>
                                <td width="150"> Safer Sex Week </td>
                                <td width="150"> All parishes-- main, regional offices and agencies </td>
                              </tr>
                              <tr>
                                <td width="100">March 31 st </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Kingston </td>
                              </tr>
                              <tr>
                                <td width="100">April 25th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> St. Ann </td>
                              </tr>
                              <tr>
                                <td width="100">May 9th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Kingston </td>
                              </tr>
                              <tr>
                                <td width="100">May 14th -16th </td>
                                <td width="150"> Residential Workshop</td>
                                <td width="150"><p> St. Ann</p></td>
                              </tr>
                              <tr>
                                <td width="100">May 28th - 30th </td>
                                <td width="150"> Residential Workshop </td>
                                <td width="150"><p> St. Ann</p></td>
                              </tr>
                              <tr>
                                <td width="100">June 12th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Manchester </td>
                              </tr>
                              <tr>
                                <td width="100">July 11th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Kingston </td>
                              </tr>
                              <tr>
                                <td width="100">August 26th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"><p> St. Ann</p></td>
                              </tr>
                              <tr>
                                <td width="100">October 17th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Manchester </td>
                              </tr>
                              <tr>
                                <td width="100">November 7th </td>
                                <td width="150"> Sensitization Workshop </td>
                                <td width="150"> Kingston </td>
                              </tr>
                              <tr>
                                <td width="100">December 5th </td>
                                <td width="150">&nbsp;</td>
                                <td width="150"> Kingston </td>
                              </tr>
                            </tbody>
                  	    </table>                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</td>
</tr></table>