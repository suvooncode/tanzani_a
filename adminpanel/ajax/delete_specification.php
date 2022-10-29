<?php
include("../init.php");

    $spec_id= $_POST["spec_id"];
    $where_clause = " where spec_id = '$spec_id'";
    $execute= array();
    $delete= delete("specification", $where_clause, $execute); //delete($table, $where_clause, $execute)
    
   
?>