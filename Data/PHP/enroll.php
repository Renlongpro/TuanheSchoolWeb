<?php
    session_start();
    //检查验证码
    if(!isset($_SESSION['Ver']) || strtolower($_POST['Ver'])!=$_SESSION['Ver']){
        echo "1001";
        exit();
    }
    require($_SERVER['DOCUMENT_ROOT']."/Data/PHP/Base.php");
    //检查POST参数emall,password,username是否存在,不存在输出0并退出
    if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['username'])){
        echo "1002";
        exit();
    }
    $email=$_POST['email'];
    $password=$_POST['password'];
    $username=$_POST['username'];
    //检查email是否合法
    if(!preg_match("/^[a-zA-Z0-9_]{1,}@[a-zA-Z0-9]{1,}.[a-zA-Z0-9]{1,}$/",$email)){
        echo "1003";
        exit();
    }
    //检查password是否合法，长度不能超过20
    if(!preg_match("/^[a-zA-Z0-9_]{1,}$/",$password) || strlen($password)>20){
        echo "1003";
        exit();
    }
    //检查username是否合法，长度不能超过20
    if(!preg_match("/^[a-zA-Z0-9_]{1,}$/",$username) || strlen($username)>20){
        echo "1003";
        exit();
    }
    mysqli_select_db($sql, "bvhgujkxbb6cd");
    //set utf-8
    mysqli_query($sql,"set names utf8");
    //检查表是否存在
    $result = mysqli_query($sql, "SHOW TABLES LIKE 'USER'");
    if(mysqli_num_rows($result) == 0){
        //表不存在，创建表
        $sql_create = "CREATE TABLE USER(
            Id INT NOT NULL AUTO_INCREMENT,
            Emall VARCHAR(40) NOT NULL,
            Password VARCHAR(20) NOT NULL,
            Username VARCHAR(20) NOT NULL,
            Exps INT NOT NULL,
            Perm INT NOT NULL,
            Date VARCHAR(20) NOT NULL,
            Ban INT NOT NULL,
            PRIMARY KEY(Id)
        )";
        mysqli_query($sql, $sql_create);
    }
    //检查表中是否有相同的emall
    $sql_select = "SELECT * FROM USER WHERE Emall='$email'";
    $result = mysqli_query($sql, $sql_select);
    if(mysqli_num_rows($result) != 0){
        //表中有相同的emall
        echo "1004";
        exit();
    }
    //插入数据
    $sql_insert = "INSERT INTO USER(Emall,Password,Username,Exps,Perm,Date,Ban) VALUES('$email','$password','$username',0,0,NOW(),0)";
    mysqli_query($sql, $sql_insert);
    $_SESSION['Ver']=0;
    echo "OK";
    mysqli_close($sql);
?>
    
