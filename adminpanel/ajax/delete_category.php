<?php
include("../init.php");




    $cat_id= $_POST["cat_id"];
    $where_clause = " where cat_id = '$cat_id'";
    $execute= array();
    $delete= delete("category", $where_clause, $execute); //delete($table, $where_clause, $execute)
    
   

 









?>