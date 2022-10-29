<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Kolkata");
include_once('includes/config.php');
include_once('includes/constants.php');
include_once('includes/dbconnection.php');
include_once('includes/database_tables.php');
include_once('includes/common_function.php');
include_once('includes/library-function.php');
$link = Db_Connect();
//
if(!$link)
{
	exit;
}
// check_login();

	// $pagename =  basename($_SERVER['PHP_SELF']); 
	// $name = str_replace('.php'," ",$pagename);
	
	// if($_SESSION["user_id"]=="")
	// {
	// 	redirectfn("index.php");
	// }
	// else{

	// } 

?>