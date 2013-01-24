<?php
include("db_conn/mysql_settings.php");
$database_down = false;

$mysql_connection= mysql_connect($mysql_url, $mysql_user, $mysql_password);
if (!$mysql_connection) {
	$database_down = true;    
}

$db_selected = mysql_select_db($mysql_dbname, $mysql_connection);
if (!$db_selected) {
	$database_down = true;
}


?>