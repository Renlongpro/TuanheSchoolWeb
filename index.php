
<html lang=zh-CN>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>湍河二初中</title>
    <link rel="stylesheet" type="text/css" href="/Data/CSS/Index.css" />
    <script src="/Data/JS/JQ.js"></script>
</head>

<body id="main">
    <!--顶部菜单栏-->
    <div id="bar"></div>
    <!--绘制校徽-->
    <div class="logo">
        <img class="schoolsign" alt="校徽" style="height:100%;" src="/Data/Imagers/SchoolLogo.jpg" />
    </div>
    <div>
        <h2>简介</h2>
        <q>
&nbsp;&nbsp;湍河二初中，位于邓州市人民东路，毗邻南阳幼师。现有21个教学班，在校学生1800余人，教师96人，其中省地市级骨干教师和优秀教师42人，教师学历达标率100%，雄厚的师资为学校的长足发展和学生的学习成才提供了智力保障。
<br/>
&nbsp;&nbsp;学校实行全天候时段管理法，将校园划分为学习、生活、运动和忞园四个区域，每个工作日的各个时间段从早到晚由专人负责，做到了事事有人干、处处有人看、时时有人管。学校明晰了“以质量立校、凭质量兴校”的办学宗旨。以“品正、笃学、守纪、尚礼”为校训，加强学校管理，提升教学质量。从制度约束上、行为规范上整肃了教师队伍，保证了教师队伍的凝聚力和战斗力。学生从入学起，学校建立“个人成长日记”，对学生进行日日跟踪培养，周周查缺补漏，月月量化评价，期期总结表彰。同时，加强校园文化，打造书香校园，让学生时时受教育，处处受熏陶。
<br/>
&nbsp;&nbsp;十年来，湍河二初中在校长杨传鹏的带领下，全校师生勤奋求实，拼搏进取，取得了一项项骄人的成绩：连续七年被评为邓州市教学质量先进单位，
<br/>
&nbsp;&nbsp;2009年、2010年连续两年中招成绩位居全市第一名;五个学科均被评为“邓州市优秀教研组”，128人次被评为“邓州市培优补差先进个人”和“教学教研先进个人”。培养出大批的优秀学生和诸如全市第三名的李滨兵(2003年)、全市第九名的郭鹏(2009年)和全市第二名的周耿力(2010年)等特优生。
    </div>
    <script>
        $("#bar").load("/Data/PHP/bar.php");
        $.get("/Data/PHP/Base.php?visit",function(data){});
    </script>
<!--添加灰色访问量-->
    <p id="Hui">Today visit:<?php
        require($_SERVER['DOCUMENT_ROOT']."/Data/PHP/Base.php");
        CheckTodayVisit($sql);
        mysqli_close($sql);
    ?></p>
</body>

</html>