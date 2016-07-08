
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#domain" data-toggle="tab" >Domain Users  <span class="glyphicon glyphicon-tower"></span></a></li>
  <li><a href="#external" data-toggle="tab">External Users <span class="glyphicon glyphicon-phone"></span></a></li>
  <li><a href="#oulist" data-toggle="tab">OUs / Departments  <span class="glyphicon glyphicon-eye-close"></span></a></li>  
  <li><a href="#search" data-toggle="tab">Search  <span class="glyphicon glyphicon-search"></span></a>  </li>
  <li>
  
  	<form role="form" class="form-inline" target="search_hidden" onsubmit="searchFiles(); return false;">
    	<div class="span4 input-group">
  		<input type="text" class="form-control" placeholder="Search Users..." name="search_str" id="search_str">
  		<span class="input-group-btn">
        	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button> 
        </span>
   		</div>
	</form>
     
    </li>
</ul>



<div class="tab-content">
  <div class="tab-pane fade in active" id="domain">
  	<!-- Upload Section Here --->
    
    
    <div class="hero-unit">
  		<h1><?=$main_title?> Domain Users</h1>
  		<p>Domain Users - This is currently connected to: <b><?=$ldap_server?></b></p>
        
        <table id="ldap_users_table" class="bootstrapTable table table-no-bordered">
    <thead>
        <tr>
        	<th data-field="full_name" data-sortable="true">User</th>
            <th data-field="email" data-sortable="true">Email</th>                             
        </tr>
    </thead>
</table>
        
  	</div>
    
  	<!---- Domain users End --->  
  </div>
  <div class="tab-pane fade in" id="external">
  	<!--- External Section Here --->
     
    
    <div class="hero-unit">
  		<h1>External Users</h1>
  		<p>Add Users not currently on domain</p>
  	</div>
    <p><button class="btn btn-success" onclick="showPopup3('applications/global_admin/php/user.add.php','','')"><span class="glyphicon glyphicon-user"></span> Add User</button></p>
    <table id="external_users_table" class="bootstrapTable table table-no-bordered">
    <thead>
        <tr>
        	<th  data-formatter="external_user_formatter" data-field="user_id" data-sortable="true">User</th>
            <th data-field="user_email" data-sortable="true">Email</th>
            <th></th>

                             
        </tr>
    </thead>
</table>
    <!--  External Users Section End --->
  </div>
  <div class="tab-pane fade in" id="oulist">
  	
    
    <div class="hero-unit">
  <h1>OU - Department Mapping</h1>
  
  
  <table id="ou_department_table" class="bootstrapTable table table-no-bordered">
    <thead>
        <tr>
        	<th data-formatter="dept_formatter" data-field="dept_name" data-sortable="true">Department/Division</th>
            <th data-field="ou_map" data-sortable="true">OU Container</th>

                             
        </tr>
    </thead>
</table>
	</div>
	
    
    
   </div>
   <div class="tab-pane fade in" id="search">
   <div class="hero-unit pull-left">
  <h1>Groups</h1>
  <p>User Search</p>
	</div>
  	<!--  Search Section Here --->
    <div id="search_div" align="center">
    	<b>Enter Search String Above and Click 'Search' button</b>
    </div>
   </div>    
</div>

<script>
getUserList();
</script>