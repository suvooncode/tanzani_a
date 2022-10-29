<?php

include("../init.php");

if(isset($_POST["userid"]) && $_POST["userid"]!='')
{
    $userid= $_POST["userid"];

    $find = find('first','user','*','where user_id="'.$userid.'" ',array());
    
    echo json_encode(array('name'=>$find['fullname'],'email'=>$find['user_name'],'phone'=>$find['phone_number']));

}

?>