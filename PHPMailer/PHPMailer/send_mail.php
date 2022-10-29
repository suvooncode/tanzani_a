<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $to =$_POST["mailto"];
    $message = "";
    $subject = "Change Password";
    $name= "Demo";
    $fromname= "Admin";
    require 'PHPMailerAutoload.php';
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
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }

?>