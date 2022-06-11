<?php
    session_start();
    //检查验证码
    if(!isset($_SESSION['code']) || strtolower($_POST['code'])!=$_SESSION['code']){
        echo "-2";
        exit();
    }
    require($_SERVER['DOCUMENT_ROOT']."Data/PHP/Base.php");
    //检查POST参数emall,password,username是否存在,不存在输出0并退出
    if(!isset($_POST['emall']) || !isset($_POST['password']) || !isset($_POST['username'])){
        echo "0";
        exit();
    }
    $emall=$_POST['emall'];
    $password=$_POST['password'];
    $username=$_POST['username'];
    //检查emall是否合法
    if(!preg_match("/^[a-zA-Z0-9_]{1,}@[a-zA-Z0-9]{1,}.[a-zA-Z0-9]{1,}$/",$emall)){
        echo "-1";
        exit();
    }
    //检查password是否合法，长度不能超过20
    if(!preg_match("/^[a-zA-Z0-9_]{1,}$/",$password) || strlen($password)>20){
        echo "-1";
        exit();
    }
    //检查username是否合法，长度不能超过20
    if(!preg_match("/^[a-zA-Z0-9_]{1,}$/",$username) || strlen($username)>20){
        echo "-1";
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
    $sql_select = "SELECT * FROM USER WHERE Emall='$emall'";
    $result = mysqli_query($sql, $sql_select);
    if(mysqli_num_rows($result) != 0){
        //表中有相同的emall
        echo "3";
        exit();
    }
    //检查表中是否有相同的username
    $sql_select = "SELECT * FROM USER WHERE Username='$username'";
    $result = mysqli_query($sql, $sql_select);
    if(mysqli_num_rows($result) != 0){
        //表中有相同的username
        echo "2";
        exit();
    }
    //插入数据
    $sql_insert = "INSERT INTO USER(Emall,Password,Username,Exps,Perm,Date,Ban) VALUES('$emall','$password','$username',0,0,NOW(),0)";
    mysqli_query($sql, $sql_insert);
    echo "1";
    mysqli_close($sql);
?>
    
