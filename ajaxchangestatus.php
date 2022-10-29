<?php include("init.php");
if(isset($_REQUEST["chnstatus"]))
{
    if(isset($_REQUEST["post_id"]))
    {
        $post_id= $_REQUEST["post_id"];
        $status= $_REQUEST["chnstatus"];
        $set= "status=:status";
        $w= " where post_id='".$post_id."' ";
        $array = array(":status"=>$status);
        $update = update("post",$set, $w, $array);
    }
}
?>