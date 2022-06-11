<?php
    $subject=$_GET['subject'];
    $content=$_GET['content'];
    $to=$_GET['to'];
    $Name=$_GET['Name'];
      require($_SERVER['DOCUMENT_ROOT']."/Data/PHP/PHPM/src/PHPMailer.php");
      require($_SERVER['DOCUMENT_ROOT']."/Data/PHP/PHPM/src/SMTP.php");
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPDebug=1;
      $mail->isSMTP();
      $mail->SMTPAuth=true;
      $mail->Host="smtp.qq.com";
      $mail->SMTPSecure="ssl";
      $mail->Port=465;
      $mail->CharSet="utf-8";
      $mail->Username="3489056763@qq.com";
      $mail->Password="amapzgdygopbchga";
      $mail->FromName=$Name;
      $mail->From="3489056763@qq.com";
      $mail->isHTML(true);
      $mail->Subject=$subject;
      $mail->Body=$content;
      $mail->addAddress($to);
      if(!$mail->send()){
         echo "Mailer Error:".$mail->ErrorInfo;
      }
?>