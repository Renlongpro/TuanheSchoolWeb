<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>湍河二初中</title>
    <link rel="stylesheet" type="text/css" href="/Data/CSS/Index.css" />
    <script src="/Data/JS/JQ.js"></script>
</head>

<body id="main">
    <div id="bar"></div>
    <br/>
    <br/>
    <?php
    require($_SERVER['DOCUMENT_ROOT'] . 'Data/PHP/Base.php');
    function printUserinfo($sql)
    {
        session_start();
        //set utf-8
        mysqli_query($sql, "set names utf8");
        mysqli_select_db($sql, "bvhgujkxbb6cd");
        //获取用户信息并打印
        $sql_select = "SELECT * FROM USER WHERE Username='" . $_SESSION['username'] . "'";
        $result = mysqli_query($sql, $sql_select);
        $row = mysqli_fetch_array($result);
        echo "<div id=\"userinfo\">";
        echo "<h1>" . $row['Username'] . "</h1>";
        echo "<script>var exp=".$row['Exps']."</script>";
        echo "邮箱：" . $row['Emall'] . "<br>";
    }
    if (!CheckLogin($sql, -1)) {
        printUserinfo($sql);
    } else {
        echo "你还没有登录，请登录后再查看个人信息";
    }
    mysqli_close($sql);
    ?>
    <div id="exp">

    </div>
    <div id="expLine"></div>
</div>
    <!--退出账号按钮-->
    <div id="exit">
        <button onclick="ExitK()">退出账号</button>
    </div>
    <script>
       var level,max;
        if(exp==0){
            level=0;
            max=0;
        } else if(exp<=100){
            level=1;
            max=100;
        } else if(exp<=500){
            level=2;
            max=500;
        } else if(exp<=2200){
            level=3;
            max=2200;
        } else if(exp<=10000){
            level=4;
            max=10000;
        } else if(exp<=32768){
            level=5;
            max=32768;
        } else if(exp<=65536){
            level=6;
            max=65536;
        }
        var exps=document.getElementById("exp");
        exps.innerText="等级:"+level+" 经验:"+exp+"/"+max;
        //设置经验条
        var expLine=document.getElementById("expLine");
        expLine.style.width=(exp/max)*100+"px";
        $("#bar").load("/Data/PHP/bar.php");
        $.get("/Data/PHP/Base.php?visit", function(data) {});
        function ExitK()
        {
            $.get("/Data/PHP/login.php?exit", function(data) {
                window.location.href = "/";
            });
        }
    </script>
</body>

</html>