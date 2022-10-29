<?php  
include("../init.php");
  if(isset($_POST['location_id']))
  {
	  	$branch = $_POST["location_id"];
		$class = $_POST["class_id"];
		$batch = $_POST["batch_id"];
		$student_id = $_POST["student_id"];
		$teacher_id = $_POST["teacher_id"];

		$notice_date = $_POST["notice_date"];
		$notice_exp_date = $_POST["notice_exp_date"];
		$notice_area = $_POST["noticearea"];
		$status= "Y";
		$date = date('Y-m-d H:i:s');

		
		$target_dir = "../uploads/";
	    $filename = $_FILES["fileToUpload"]["name"];
        $target_file = $target_dir . basename($filename);
	    $file_type = $_FILES['fileToUpload']['type'];
	    
	    if ($file_type=="application/pdf") {
    	    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
    	         $attachment = $filename;
            }
            else {
                echo "Problem uploading file";
            }
	    }

		
		
		$fileds= "notice_text,notice_date,notice_exp_date,teacher_id,class_id,batch_id,location_id,student_id,created_date,status,attachment";
		$values= ":notice_text,:notice_date,:notice_exp_date,:teacher_id,:class_id,:batch_id,:location_id,:student_id,:created_date,:status,:attachment";
		$exe= array(":notice_text"=>$notice_area,":notice_date"=>$notice_date,":notice_exp_date"=>$notice_exp_date,":teacher_id"=>$teacher_id,":class_id"=>$class,":batch_id"=>$batch,":location_id"=>$branch,":student_id"=>$student_id,":created_date"=>$date,":status"=>$status,":attachment"=>$attachment);

		if($branch && $class && $teacher_id ){
			$exe= array(":notice_text"=>$notice_area,":notice_date"=>$notice_date,":notice_exp_date"=>$notice_exp_date,":teacher_id"=>$teacher_id,":class_id"=>$class,":batch_id"=>'0',":location_id"=>$branch,":student_id"=>'0',":created_date"=>$date,":status"=>$status,":attachment"=>$attachment);
			
		}
		if($branch && $class && $teacher_id && $student_id){
			$exe= array(":notice_text"=>$notice_area,":notice_date"=>$notice_date,":notice_exp_date"=>$notice_exp_date,":teacher_id"=>$teacher_id,":class_id"=>$class,":batch_id"=>'0',":location_id"=>$branch,":student_id"=>$student_id,":created_date"=>$date,":status"=>$status,":attachment"=>$attachment);
			
		}
		
		$save= save("notice",$fileds,$values,$exe);

		// if($_SESSION['usertype'] == "Student") {
		// 	$where = "where student_id = '".$_SESSION['user_id']."' ";
		// }

		// $findcustomertablex = find("first","student","*",$where,array());

		// $loggedid = $_SESSION["user_id"];
        // $assigned_to = $findcustomertablex["student_id"];
        // $subject = "Dear Sir/Ma'am, Your got new notice";
        // $content = " Demo Testing ";
        // createnotification($assigned_to ,$loggedid, $subject, $content);

		if($save)
		  {
			$response = array("message"=>"You have successfully add notice","action_status"=>"success");
			}
			else
		  {
			$response = array("message"=>"sorry","action_status"=>"error");
			}
		 
  echo json_encode($response);
  }
?>