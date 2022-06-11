<?php
    require($_SERVER['DOCUMENT_ROOT'].'Data/PHP/Base.php');
    //检查POST参数password,username是否存在,不存在输出0并退出
    if(isset($_GET["exit"])){
        session_start();
        $_SESSION['time']=0;
        echo "ok";
        exit();
    }
    if(!isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['remember'])){
        echo "0";
        exit();
    }
    $password=$_POST['password'];
    $username=$_POST['username'];
    mysqli_select_db($sql, "bvhgujkxbb6cd");
    //set utf-8
    mysqli_query($sql,"set names utf8");
    //检查账号密码是否正确
    $sql_select = "SELECT * FROM USER WHERE Password='$password' AND Username='$username'";
    $result = mysqli_query($sql, $sql_select);
    if(mysqli_num_rows($result) == 0){
        //账号密码不正确
        echo "0";
        exit();
    }else{
        //set session
        session_start();
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;
        if($_POST['remember']=="1"){
            $_SESSION['time']=time()+3600*24*7;
        }else{
            $_SESSION['time']=time()+3600;
        }
        //查询邮箱
        $sql_select = "SELECT * FROM USER WHERE Username='$username'";
        $result = mysqli_query($sql, $sql_select);
        $row = mysqli_fetch_array($result);
        ignore_user_abort(true);
        if(!function_exists('fastcgi_finish_request')) {
            ob_end_flush();
            ob_start();
        }
        if($result){
            if($row['Ban']>time()){
                echo $row['Ban'];
                exit();
            }
            echo "1";
        }
        session_write_close();
        if(!function_exists('fastcgi_finish_request')) {
            header("Content-Type: text/html;charset=utf-8");
            header("Connection: close");
            header('Content-Length: '. ob_get_length());
            ob_flush();
            flush();
        } else {
            fastcgi_finish_request();
        }
        //发送邮件通知用户账号被登陆
        require($_SERVER['DOCUMENT_ROOT'].'Data/PHP/Server.php');
        $Bro=getBrowser();
        $to=$row['Emall'];
        $subject="[TuanHeSchool]登陆通知";
        $content="
        <html>
        <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <title>登陆通知</title>
        </head>
        <body>
        <style type=\"text/css\">
        .main {
            background-color: #79bd54;
            font-weight: 900;
        }
        li {
            background-color: #00fff5;
            margin-bottom: 20px;
        }
    </style>
    <div class=\"main\">
        <h1 style=\"text-align: center;\">登陆提醒</h1>
        <h3>尊敬的:".$username."</h3>
        <br/>
        <p>&nbsp&nbsp您的账户已被登陆</p>
        <br/>
        <ul>
            <li>登录时间:".date('Y-m-d H:i:s')."</li>
            <li>登陆ip:".$_SERVER['REMOTE_ADDR']."</li>
            <li>登陆地址:".GetIpFrom($_SERVER['REMOTE_ADDR'])."</li>
            <li>登陆浏览器:".$Bro['name']."</li>
            <li>登陆浏览器版本:".$Bro['version']."</li>
            <li>登陆平台:".$Bro['platform']."</li>
            <li>登陆UA:".$Bro['userAgent']."</li>
            <li>登陆方式:密码登陆</li>
        </ul>
        <br/>
        <p>&nbsp&nbsp如果非本人登陆请<a href=\"http://www.tuanheschool.xyz\">修改密码</p>
    </div>
    </body>
    </html>";
        SendEmail($subject,$content,$to,"笼子");

    }
    mysqli_close($sql);
?>