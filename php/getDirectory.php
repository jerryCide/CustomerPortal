<?php
echo "e-Dir --2";
include("vars.php");

$db = open_sql_db();

if(!$db)
{
 echo "Connection Failed";
}
else
{
 echo "Connected";
}

$sql_res = mssql_query("select * from NumPlan");

while($row = mssql_fetch_row($sql_res))
{
 echo $row['AlertingName'];
}

/*
sample query::

SELECT     DNOrPattern, AlertingName
FROM         NumPlan
WHERE     (isCallable = 1) AND (AlertingName LIKE '%sha%')

*/

?>