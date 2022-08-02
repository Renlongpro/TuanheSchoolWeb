<?php
    $Type=$_GET['api'];
    switch($Type){
        case 10001:   //收发邮件
            $subject=$_GET['subject'];
            $content=$_GET['content'];
            $to=$_GET['to'];
            $name=$_GET['name'];
            if($subject=='' or $content=='' or $to=='' or $name==''){
                echo "10001";    //arg error参数错误
                exit();
            }
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
            $mail->FromName=$name;
            $mail->From="3489056763@qq.com";
            $mail->isHTML(true);
            $mail->Subject=$subject;
            $mail->Body=$content;
            $mail->addAddress($to);
            if(!$mail->send()){
                echo "10002";   //send failed发送失败
                exit();
                //$mail->ErrorInfo;
            }
            echo "OK";
            exit();
    }
    echo "10000";   //api error api 错误
?>