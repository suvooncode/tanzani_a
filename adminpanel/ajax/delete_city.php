<?php
include("../init.php");




    $city_id= $_POST["city_id"];
    $where_clause = " where city_id = '$city_id'";
    $execute= array();
    $delete= delete("city", $where_clause, $execute); //delete($table, $where_clause, $execute)
    
   


?>