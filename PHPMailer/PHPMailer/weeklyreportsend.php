<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $to =$_POST["mailto"];
    $message = $_POST["message"];
    $subject = $_POST["subject"];
    $name= $_POST["fullname"];
    $fromname= $_POST["fromname"];
    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
    $mail->Host = "smtp.hostinger.com";
    $mail->Port = 465;
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->IsHTML(true);
    $mail->Username = "sendmail@devenv-tdtl.online";
    $mail->Password = "Tdtl@23081984.";
    $mail->SetFrom("sendmail@devenv-tdtl.online",$fromname);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($to,$name);
    
    $filename = $_POST['filename'];
    
    $fileattach = "../../hrmspra/ajaxcustom/PHPEXCEL/".$filename; // full path
    $mail->AddAttachment($fileattach);

    //$mail->addcc('sunnicse@gmail.com');
     if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }

?>