<?php
    if(empty($_GET['api'])){
        echo "4001"; //API was empty.
        exit(0);
    }
    require($_SERVER['DOCUMENT_ROOT'].'/Data/PHP/Base.php');
    mysqli_select_db($sql, "bvhgujkxbb6cd");
    mysqli_query($sql, "set names utf8");
    //检查是否登录
    if(CheckLogin($sql,-1)!=0){
        $Logined=0;
    }else{
        $Logined=1;
        session_start();
    }
    switch($_GET['api']){
        case 1001:  //登陆账号
            if($Logined==1){
                echo "1005";    //用户已登录账号,要求用户先退出
                exit();
            }
            setcookie("Accept","1",time()+999999999,"/");   //用户肯定同意了用户条约,缓存等用户下次自动勾选
            if($_GET['password']=='' || $_GET['username']=='' || $_GET['remember']==''){
                echo "1006";    //信息为空
                exit();
            }
            $WaitToCheck=$_GET['password'].$_GET['username'];
            if($_GET['isEmail']==1){
                if(!preg_match("/^[a-zA-Z0-9_]{1,}@[a-zA-Z0-9]{1,}.[a-zA-Z0-9]{1,}$/",$WaitToCheck)){
                    echo "1003";
                    exit();
                }
            }else{
                    if(preg_match('#[{}:"<>|,./;\'\\,./@\#\$%\^&\*()]#u',$WaitToCheck)){
                    echo "1008";    //过滤特殊字符
                    exit();
                }
            }
            if($_GET['isEmail']==1){
                $sql_select = "SELECT * FROM USER WHERE Password='".$_GET['password']."' AND Emall='".$_GET['username']."';";
            }
            else{
                $sql_select = "SELECT * FROM USER WHERE Password='".$_GET['password']."' AND Username='".$_GET['username']."';";
            }
            $result = mysqli_query($sql, $sql_select);
            $row=mysqli_fetch_array($result);
            if($row['Id']==''){
                echo "1007";    //账号或密码错误
                exit();
            }
            if($row['Ban']>time()){
                echo "INFOUserApiShowBan(".$row['Ban'].");";    //用户被封号
                exit();
            }
            //成功登录,下面是设置参数
            //SetSession
            session_start();
            $_SESSION['username']=$row['Username'];
            $_SESSION['password']=$_GET['password'];
            $_SESSION['email']=$row['Emall'];
            $_SESSION['UID']=$row['Id'];
            //设置过期日期
            if($_GET['remember']=="1"){
                setcookie(session_name(),session_id(),time()+3600*24*7,'/');
                $_SESSION['time']=time()+3600*24*7;
            }else{
                $_SESSION['time']=time()+3600;
                setcookie(session_name(),session_id(),time()+3600,'/');
            }
            //这里原本应该发送邮件
            echo "OK";
            exit();
        case 1002: //退出账号
            UserAPI_Logined($Logined);
            $_SESSION['time']=0;
            echo "OK";
            exit();
        case 2001://查询是否签到
            UserAPI_Logined($Logined);
            $result = mysqli_query($sql,"SELECT * from USER WHERE Id=".$_SESSION['UID']);
            $row = mysqli_fetch_array($result);
            if($row['Hi']==""){
                echo "4000";
                exit();    //未知错误
            }
            echo "OK".$row['Hi'];
            exit();
        case 2002: //查询经验
            UserAPI_Logined($Logined);
            $result=mysqli_query($sql,"SELECT Exps from USER WHERE Id=".$_SESSION['UID']);
            $row=mysqli_fetch_array($result);
            if($row['Exps']==""){
                echo "4000";    //未知错误
                exit();
            }else{
                echo "OK".$row['Exps'];
                exit();
            }
        case 3001: //签到
            UserAPI_Logined($Logined);
            $result = mysqli_query($sql,"SELECT Hi from USER WHERE Id=".$_SESSION['UID']);
            $row = mysqli_fetch_array($result);
            if($row['Hi']==""){
                echo "4000";
                exit();    //未知错误
            }
            if($row['Hi']==1){
                echo "4101";  //签到过
                exit();
            }
            if(mysqli_query($sql,"UPDATE USER SET Hi=1 WHERE Id=".$_SESSION['UID'])==0 or mysqli_query($sql,"UPDATE USER SET Exps=Exps+10 WHERE Id=".$_SESSION['UID'])==0){
                echo "4000";
                exit();    //未知错误
            }else{
                echo "OK";
                exit();
            }
        case 4001:  //发送验证码
            if (!preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/", $_GET['email'])) {
                echo "4004";
                exit();
            }
            $Ver=rand(100000,999999);
            $_SESSION['Ver']=$Ver;
            $_SESSION['VerTime']=time()+60*10;  //设置有效期10分钟
            $subject="[TuanHeSchool]验证码";
            $to=$_GET['email'];
            $content="你的验证码是:".$Ver."请在10分钟内输入。";
            $name="TuanHeSchool";
            $result=file_get_contents("http://www.tuanheschool.xyz/Data/PHP/EventApi.php?api=10001&subject=".$subject."&name=".$name."&to=".$to."&content=".$content);
            if(!preg_match("/\bOK\b/i", $result)){
                echo "4000";
                exit();
            }
            echo "OK";
            exit();
    }
    echo "4003";    //API信息错误
    //用户未登录提示错误,减少代码复用||(($Logined)是否登录)
    function UserAPI_Logined($Logined){
        if($Logined!=1){
            echo "4002";    //用户未登录
            exit();
        }
    }
?>