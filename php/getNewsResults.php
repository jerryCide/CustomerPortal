<?php 

include("vars.php");


?>

 
<form name="searchNews" method="post" enctype="multipart/form-data"> 



<table width="100%" cellpadding="3" cellspacing="0">
    
     <tr>
    	<td > &nbsp;&nbsp;
        <font size="1">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
 <select id="day"><option value="sel">Day</option><option value="01">1</option><option value="02">2</option> <option value="03">3</option> <option value="04">4</option> <option value="05">5</option><option value="06">6</option> <option value="07">7</option> <option value="08">8</option> <option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option> <option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>          
 &nbsp;
<select id="month"><option value="sel">Month</option><option value="01">Jan</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option><option value="05">May</option><option value="06">Jun</option><option value="07">Jul</option><option value="08">Aug</option><option value="09">Sept</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select>
 &nbsp;
 
 <?php 
 
 open_db();
 
 $y_res = mysqli_query($db,"SELECT * FROM press_tab order by pub_date desc limit 0,1");
 $y_row = mysqli_fetch_array($y_res,MYSQL_ASSOC); 
 $latest_year = explode("-",$y_row['pub_date']);
 
  close_db();
 ?>
 
 <select name="year" id="year2">
 	<option value="sel">Year</option>
 <?php
 
 for($i=0;$i<10;$i++,$latest_year[0]--)
 { ?> 
 	<option value="<?=$latest_year[0]?>"><?=$latest_year[0]?></option>
 <?php
 }
 ?>
 </select>
 <br />
 		</td>
    </tr>
    <tr>
    	<td> &nbsp;&nbsp; 
        <font size="1">Title</font> &nbsp;&nbsp; &nbsp;&nbsp;
        <input size="36" type="text" id="title" />
        <br />        </td>
    </tr>
    <tr>
    	<td> &nbsp;&nbsp;
        <font size="1">Author</font> &nbsp;&nbsp; 
        <input size="36" type="text" id="author" />
        <br />        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;
        <font size="1">News</font>
        &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="searchParam" size="36" id="searchParam"/>
          &nbsp;&nbsp;
        <table width="69%" align="center" cellpadding="0">
        <tr>
        <td align ="left">
         <font size="1.5"><strong>
        <a href="#" onClick="return callLinks()">Simple Search</a>
        </strong></font>         </td>
        </tr>
        </table>        </td>
     </tr>
     </table>
 <table width="86%" cellpadding="0">
     <tr>
     	<td align="right">
         <input type="button" name="search" value="Search" onClick="validDate()" style="font-size:xx-small;padding:0px;"/><!--DONT CHANGE THIS FUNCTION-->
         </td>
        </td>
    </table>
  </form>
<!--
<table width="100%" cellpadding="8">
	<tr>
    	<td align="left">&nbsp&nbsp
       <a href="?disp_page=home">Back To News</a> 
        </td>
    </tr>
</table>-->
        
