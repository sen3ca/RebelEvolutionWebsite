<?php
include("mysql_connect.php");
include("variables/vars.php");

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

if(!$database_down){
	$message = "";
	$error = array();
	
	$sql ="select 1 from mailing_list where email = '".mysql_real_escape_string($_REQUEST["emailAddress"])."'";
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result) > 0){
		$error[] = "emailExists";
	}
	
	if(preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $_REQUEST["emailAddress"]) < 1){
  		$error[] = "invalidEmailFormat";
	} 
	
	if(count($error) == 0){
		$sql ="insert into mailing_list (email, from_site) values ".
			  "('".mysql_real_escape_string($_REQUEST["emailAddress"])."','".$VARS_theSite."')";
		//print $sql;
		mysql_query($sql);
		$message = "Thank you for signing up. Updates as events warrant.";
	}
	
	$success = "true";
	
	foreach($error as $errorType){
		if($errorType == "emailExists"){
			$message= "We already have your email address.  Thanks for signing up!";
		}
		if($errorType == "invalidEmailFormat"){
			$message= "That does not appear to be a valid email address.";
		}
		$success = "false";
	}
	
}else{
	$success = "false";
}

print '{
	"success": '.$success.',
	"message": "'.$message.'"';
	
print '}';


?>
