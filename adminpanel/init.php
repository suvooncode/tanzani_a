<?php session_start();
error_reporting(0);//E_ALL
date_default_timezone_set("Asia/Kolkata");
include_once('includes/config.php');
include_once('includes/constants.php');
include_once('includes/dbconnection.php');
include_once('includes/database_tables.php');
include_once('includes/common_function.php');
include_once('includes/library-function.php');
$link = Db_Connect();
//checklogin();
if(!$link)
{
	exit;
}
if(isset($_SESSION["user_id"]))
{
	if($_SESSION['is_admin']=="Y")
	{

	}
	else {
		redirectfn("index.php");
	}

}
else{
	redirectfn("index.php");
}

?>