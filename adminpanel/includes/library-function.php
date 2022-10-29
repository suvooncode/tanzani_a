<?php
if(isset($_SESSION["user_id"]))
{
	 $user_id = $_SESSION["user_id"];
}
function setsessioncookie($id)
{
	if(isset($_SESSION["user_login_id"]))
	{
		$user_login_id= $_SESSION["user_login_id"];
		setcookie("user_login_id", $user_login_id, time() + (86400 * 30), "/");
	}
}

function findmyuser($user_id)
{
	$find= find("first","users","*"," where user_id='$user_id'",array());
	$parent_id= $find["parent_id"];
	$parent_idarray= find("all","parent_table","*"," where user_parent_id ='$user_id'",array());
	foreach($parent_idarray as $key=>$val)
	{
		$storeid= $val["user_id"];
		array_push($_SESSION["myuser"],$storeid);

		$findtobeparent =  find("all","parent_table","*"," where user_parent_id ='$storeid'",array());
		if($findtobeparent)
		{
			findmyuser($storeid);
		}

	}
}

function myreporthead($user_id)
{
	$findparenttable= find("first","users","parent_id"," where user_id='$user_id'",array());
	$parent_id = $findparenttable["parent_id"];

	$parent_idarray= find("all","parent_table","*"," where parent_id ='$parent_id'",array());
	foreach($parent_idarray as $key=>$val)
	{
		$storeid= $val["user_parent_id"];
		array_push($_SESSION["reportuser"],$storeid);
		myreporthead($storeid);
	}

}

function findleaddetails($lead_id)
{
	$leadtable= " lead as l inner join company as c on c.company_id=l.lead_company_id inner join company_contactdetails as con on con.con_det_id= l.lead_contact_id ";
	$_SESSION["myuser"]=array($_SESSION["user_id"]);
	$findmyusercall=findmyuser($_SESSION["user_id"]);
	$idarray = implode(",",$_SESSION["myuser"]);
	unset($_SESSION["myuser"]);
	$findlead= find("first",$leadtable,"*","where l.lead_id='$lead_id' and l.assigned_user_id IN ($idarray)",array());
	return $findlead;
}

function findrequirmentdetails($req_id)
{
	$rqtype_arr = array("1"=>"ELS","2"=>"SHTD","3"=>"Solutions","4"=>"Staff Agumentation");
	$trainingfor= array("1"=>"People","2"=>"Process","3"=>"Technology");
	$requirementtable= "requirements as r inner join lead as l on r.lead_id=l.lead_id inner join company as c on c.company_id=l.lead_company_id inner join company_contactdetails as con on con.con_det_id= l.lead_contact_id ";
	$_SESSION["myuser"]=array($_SESSION["user_id"]);
	$findmyusercall=findmyuser($_SESSION["user_id"]);
	$idarray = implode(",",$_SESSION["myuser"]);
	unset($_SESSION["myuser"]);
	$findreq= find("first",$requirementtable,"*","where r.requirement_id='$req_id' and l.assigned_user_id IN ($idarray)",array());

	$req_meta_arr= array();
	$requirement_meta = "requirement_meta";
	$findreqmeta= find("all",$requirement_meta,"*"," where requirement_id='$req_id' ",array());
	foreach($findreqmeta as $key=>$val)
	{
		$arr= array($val["meta_key"]=>$val["meta_value"]);
		$req_meta_arr=array_merge($req_meta_arr,$arr);

	}
	if($findreq["requirement_type"]==1)
	{
		$req_meta_arr["trainingtype"]=$trainingfor[$req_meta_arr["trainingtype"]];
	}

	$rq_type= $rqtype_arr[$findreq["requirement_type"]];

	if($findreq["requirement_type"]==2)
	{
		$req_meta_arr["candidatejddetails"]=find("all","shtdcandidatedetails","*"," where requirement_id=$req_id",array());
	}



	return array("req_det"=>$findreq , "req_meta"=>$req_meta_arr , "req_type"=>$rq_type);
}
function requirement_stage_save($data)
{

}

function fetch_requirement_stage($data)
{
	//$current_stage=0;
	$req_id= $data['req_id'];
	$send_all_stage_history = "";
	$findcurrentstage= find("first","requirement_stage","*"," where requirement_id='$req_id' order by requirement_stage_id desc",array());
	$current_stage= $findcurrentstage["requirement_stage_no"];
	
	if($current_stage=="")
	{
		$current_stage=0;
	}

	$complete_percent= (100/REQUIREMENTSTAGE)*$current_stage;
	$complete_percent = $complete_percent." %";


	if(isset($data["send_all_stage_history"]))
	{
		if($data["send_all_stage_history"]=="yes")
		{
			$send_all_stage_history= find("all","requirement_stage","*"," where requirement_id='$req_id' order by requirement_stage_id desc",array());
			
		}

	}

	$response = array("current_stage"=>$current_stage, "complete_percent"=>$complete_percent , "all_stage_history"=>$send_all_stage_history);

	return $response;
	

}

function save_requirement_stage($requestdata,$files)
{
	$response = array( "new_stage"=>$requestdata["req_force_stage"],"status"=>"error");
	$created_stage_date= date("Y-m-d H:i:s a");
	$req_id= $requestdata['req_id'];
	$req_force_stage=$requestdata["req_force_stage"] +1;
	$comments = $requestdata["comments"];
	$table= "requirement_stage";
	$fld="requirement_id,requirement_stage_no,requirement_stage_remark,	requirement_stage_date,created_user_id,requirement_stage_file_link,created_stage_date";
	$vl=":requirement_id,:requirement_stage_no,:requirement_stage_remark,	:requirement_stage_date,:created_user_id,:requirement_stage_file_link,:created_stage_date";

	if($req_force_stage==1)
	{
		if($requestdata["is_client_res"]=='y')
		{
			$arr=array(
			":requirement_id"=>$req_id,
			":requirement_stage_no"=>$req_force_stage,
			":requirement_stage_remark"=>$comments,
			":requirement_stage_date"=>$created_stage_date,
			":created_user_id"=>$_SESSION["user_id"],
			":requirement_stage_file_link"=>"",
			":created_stage_date"=>$created_stage_date
			);
			$save= save($table,$fld,$vl,$arr);
			$response= array("new_stage"=>$req_force_stage,"status"=>"success");
		}

		
	}
	if($req_force_stage==2)
	{
		if($requestdata["is_client_res"]=='y')
		{
			$arr=array(
			":requirement_id"=>$req_id,
			":requirement_stage_no"=>$req_force_stage,
			":requirement_stage_remark"=>$comments,
			":requirement_stage_date"=>$created_stage_date,
			":created_user_id"=>$_SESSION["user_id"],
			":requirement_stage_file_link"=>"",
			":created_stage_date"=>$created_stage_date
			);
			$save= save($table,$fld,$vl,$arr);
			$response= array("new_stage"=>$req_force_stage,"status"=>"success");
		}

		
	}

	if($req_force_stage==3)
	{
		if($requestdata["is_client_res"]=='y')
		{
			$arr=array(
			":requirement_id"=>$req_id,
			":requirement_stage_no"=>$req_force_stage,
			":requirement_stage_remark"=>$comments,
			":requirement_stage_date"=>$created_stage_date,
			":created_user_id"=>$_SESSION["user_id"],
			":requirement_stage_file_link"=>"",
			":created_stage_date"=>$created_stage_date
			);
			$save= save($table,$fld,$vl,$arr);
			$response= array("new_stage"=>$req_force_stage,"status"=>"success");
		}

		
	}

	if($req_force_stage==4)
	{
		if($requestdata["is_client_res"]=='y')
		{
			$arr=array(
			":requirement_id"=>$req_id,
			":requirement_stage_no"=>$req_force_stage,
			":requirement_stage_remark"=>$comments,
			":requirement_stage_date"=>$created_stage_date,
			":created_user_id"=>$_SESSION["user_id"],
			":requirement_stage_file_link"=>"",
			":created_stage_date"=>$created_stage_date
			);
			$save= save($table,$fld,$vl,$arr);
			$response= array("new_stage"=>$req_force_stage,"status"=>"success");
		}

		
	}

	if($req_force_stage==4)
	{
		if($requestdata["is_client_res"]=='y')
		{
			$nameFile= strtotime(date("Y m d H:i:s a")).$files['proposalfile']['name'];
			$targetPath = 'proposals/'.$nameFile;
			move_uploaded_file($files['proposalfile']['tmp_name'], $targetPath);

			$Fileurl =  $targetPath;
			$linkFilearray = array($Fileurl);
			$jsonlinkFilearray = json_encode($linkFilearray);

			$arr=array(
			":requirement_id"=>$req_id,
			":requirement_stage_no"=>$req_force_stage,
			":requirement_stage_remark"=>$comments,
			":requirement_stage_date"=>$created_stage_date,
			":created_user_id"=>$_SESSION["user_id"],
			":requirement_stage_file_link"=>$jsonlinkFilearray,
			":created_stage_date"=>$created_stage_date
			);

			$save= save($table,$fld,$vl,$arr);
			$response= array("new_stage"=>$req_force_stage,"status"=>"success");
		}

		
	}
	return $response;
}

?>
