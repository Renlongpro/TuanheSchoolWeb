<?php
//Connect to database
//Database address:location
//         loginname:bvhgujkxbb6cd
//         password:17815616629qQ
$sql = mysqli_connect("127.0.0.1", "bvhgujkxbb6cd", "17815616629qQ");
if (!$sql) {
   die("Could not connect error");
}
if (isset($_GET['visit'])) {
   RecordVisit($sql);
   mysqli_close($sql);
}
//记录访问
function RecordVisit($sql)
{  
   $nowDate = date("Y-m-d");
   mysqli_select_db($sql, "bvhgujkxbb6cd");
   //set utf-8
   mysqli_query($sql, "set names utf8");
   //检查表是否存在
   /*$result = mysqli_query($sql, "SHOW TABLES LIKE 'VISIT'");
      if(mysqli_num_rows($result) == 0){
         //表不存在，创建表
         $sql_create = "CREATE TABLE VISIT(
            Num INT NOT NULL,
            Date VARCHAR(20) NOT NULL,
            PRIMARY KEY(Date)
         )";
         mysqli_query($sql, $sql_create);
      }
      注释此段因为表不会被删除
      */
   //检查表中的Date是否有今天
   $result = mysqli_query($sql, "SELECT * FROM VISIT WHERE Date = '" . date("Y-m-d") . "'");
   if (mysqli_num_rows($result) == 0) {
      //表中没有今天的记录，插入记录
      $sql_insert = "INSERT INTO VISIT(Num, Date) VALUES(1, '" . date("Y-m-d") . "')";
      mysqli_query($sql, $sql_insert);
      mysqli_query($sql, "INSERT INTO VISIT (visitnumber,Date) VALUES (0," . $nowDate . ")");
   } else {
      //今天的Num(访问量)加1
      $sql_update = "UPDATE VISIT SET Num = Num + 1 WHERE Date = '" . date("Y-m-d") . "'";
      mysqli_query($sql, $sql_update);
      echo "OK";
   }
}
//获取访问量
function CheckTodayVisit($sql)
{
   mysqli_select_db($sql, "bvhgujkxbb6cd");
   //set utf-8
   mysqli_query($sql, "set names utf8");
   //检查表中的Date是否有今天
   $result = mysqli_query($sql, "SELECT * FROM VISIT WHERE Date = '" . date("Y-m-d") . "'");
   //如果没有今天的记录，输出0
   if (mysqli_num_rows($result) == 0) {
      echo "0";
   } else {
      //如果有今天的记录，输出今天的Num(访问量)
      $row = mysqli_fetch_array($result);
      echo $row['Num'];
   }
}
//检查是否登录
function CheckLogin($sql, $Perm)
{
   mysqli_select_db($sql, "bvhgujkxbb6cd");
   //set utf-8
   mysqli_query($sql, "set names utf8");
   session_start();
   if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
      return 1;
   }
   if($_SESSION['time']<time()){
      return 1;
   }
   $username = $_SESSION['username'];
   $password = $_SESSION['password'];
   if ($Perm == -1) {
      $sql_select = "SELECT * FROM USER WHERE Password='$password' AND Username='$username'";
   } else {
      $sql_select = "SELECT * FROM USER WHERE Password='$password' AND Username='$username' AND Perm=$Perm";
   }
   $result = mysqli_query($sql, $sql_select);
   //查询用户Ban的时间
   $row = mysqli_fetch_array($result);
   if (mysqli_num_rows($result) == 0) {
      //账号密码不正确
      return 1;
   } else if($row['Ban']>time()){
      //账号被封
      return 2;
   } else {
      return 0;
   }
}
//发送邮件
function SendEmail($subject, $content, $to, $Name)
{
   require($_SERVER['DOCUMENT_ROOT'] . "/Data/PHP/PHPM/src/PHPMailer.php");
   require($_SERVER['DOCUMENT_ROOT'] . "/Data/PHP/PHPM/src/SMTP.php");
   $mail = new PHPMailer\PHPMailer\PHPMailer();
   $mail->IsSMTP();
   $mail->SMTPDebug = 1;
   $mail->isSMTP();
   $mail->SMTPAuth = true;
   $mail->Host = "smtp.qq.com";
   $mail->SMTPSecure = "ssl";
   $mail->Port = 465;
   $mail->CharSet = "utf-8";
   $mail->Username = "3489056763@qq.com";
   $mail->Password = "amapzgdygopbchga";
   $mail->FromName = $Name;
   $mail->From = "3489056763@qq.com";
   $mail->isHTML(true);
   $mail->Subject = $subject;
   $mail->Body = $content;
   $mail->addAddress($to);
   if (!$mail->send()) {
      echo "Mailer Error:" . $mail->ErrorInfo;
   }
}
?>