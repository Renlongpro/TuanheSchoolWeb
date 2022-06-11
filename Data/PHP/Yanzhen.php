<?php
    session_start();
    require($_SERVER['DOCUMENT_ROOT'] . "/Data/PHP/Base.php");
    //校验邮箱格式
    function CheckEmail($email)
    {
        if (preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/", $email)) {
            return true;
        } else {
            return false;
        }
    }
    if(!CheckEmail($_GET['to'])){
        return -1;
    }
    echo "OK";
    header("Content-Type: text/html;charset=utf-8");
    header("Connection: close");
    header('Content-Length: '. ob_get_length());
    //发送验证码
    $to=$_GET['to'];
    $subject="[TuanheSchool]验证码";
    //set session
    $_SESSION['code']=rand(100000,999999);
    $content="你的验证码是".$_SESSION['code'];
    SendEmail($subject,$content,$to,"龙子");
    
?>