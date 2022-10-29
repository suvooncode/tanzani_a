<?php
include("../init.php");




    $u_id= $_POST["user_id"];
    $where_clause = " where user_id = '$u_id'";
    $execute= array();
    $delete= delete("user", $where_clause, $execute); //delete($table, $where_clause, $execute)
    
   

 









?>