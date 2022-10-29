<?php
include("../init.php");

    $spec_id= $_POST["post_id"];
    $where_clause = " where post_id = '$post_id'";
    $execute= array();
    $delete= delete("post", $where_clause, $execute); //delete($table, $where_clause, $execute)
    
   
?>