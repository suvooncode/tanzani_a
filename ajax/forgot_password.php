<?php 
    include("../init.php");

    if(isset($_POST["forgot_email"]) && $_POST["forgot_email"]!='')
    {
        $email= $_POST["forgot_email"];

        $gen_password = password_generate(8);
    
        $update_pass = update('user','password=:password','where user_name="'.$email.'" ',array(':password'=>$gen_password));
    
        if($update_pass)
        {
            $response= "Password updated Successfull";
            $response_status = "success";
    
            /*
            require '../PHPMailer/PHPMailerAutoload.php';
            $message = "Your new password is:-".$gen_password;
            $subject = "Change Password";
            $name= "Demo";
            $fromname= "Admin";
            
            $mail = new PHPMailer(); 
            $mail->IsSMTP(); 
            $mail->SMTPDebug = 2; 
            $mail->Host = "smtp.demo.com";
            $mail->Port = 465;
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->IsHTML(true);
            $mail->Username = "demo@demo.online";
            $mail->Password = "demo123456";
            $mail->SetFrom("demo@demo.online",$fromname);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AddAddress($to,$name);
            
            if(!$mail->Send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                //echo "Message has been sent";
            }
            */
        }
        else
        {
            $response= " This credential is not found";
            $response_status = "error";
        }

        echo json_encode(array('response'=>$response,'status'=>$response_status));
    }
    
?>